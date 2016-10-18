<?php


namespace BZgA\BzgaBeratungsstellensucheExport\Domain\Serializer\Encoder;

use Symfony\Component\Serializer\Encoder\DecoderInterface;
use Symfony\Component\Serializer\Encoder\EncoderInterface;
use League\Csv\Writer;
use League\Csv\Reader;
use SplTempFileObject;

/**
 * Adds CSV encoder support for the Serialization API.
 */
class CsvEncoder implements EncoderInterface, DecoderInterface
{


    /**
     * Indicates the character used to delimit fields. Defaults to ",".
     *
     * @var string
     */
    protected $delimiter;

    /**
     * Indicates the character used for field enclosure. Defaults to '"'.
     *
     * @var string
     */
    protected $enclosure;

    /**
     * Indicates the character used for escaping. Defaults to "\".
     *
     * @var string
     */
    protected $escapeChar;

    /**
     * The format that this encoder supports.
     *
     * @var string
     */
    protected static $format = 'csv';
    /**
     * @var bool
     */
    private $sendOutput;

    /**
     * Constructs the class.
     *
     * @param string $delimiter
     *   Indicates the character used to delimit fields. Defaults to ",".
     *
     * @param string $enclosure
     *   Indicates the character used for field enclosure. Defaults to '"'.
     *
     * @param string $escape_char
     *   Indicates the character used for escaping. Defaults to "\"
     * @param bool $sendOutput
     */
    public function __construct($delimiter = ",", $enclosure = '"', $escape_char = "\\", $sendOutput = false)
    {
        $this->delimiter = $delimiter;
        $this->enclosure = $enclosure;
        $this->escapeChar = $escape_char;

        if (!ini_get("auto_detect_line_endings")) {
            ini_set("auto_detect_line_endings", '1');
        }
        $this->sendOutput = $sendOutput;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsEncoding($format)
    {
        return $format == static::$format;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDecoding($format)
    {
        return $format == static::$format;
    }

    /**
     * {@inheritdoc}
     *
     * Uses HTML-safe strings, with several characters escaped.
     */
    public function encode($data, $format, array $context = array())
    {
        switch (gettype($data)) {
            case "array":
                break;

            case 'object':
                $data = (array)$data;
                break;

            // May be bool, integer, double, string, resource, NULL, or unknown.
            default:
                $data = array($data);
                break;
        }

        try {
            // Instantiate CSV writer with options.
            $csv = Writer::createFromFileObject(new SplTempFileObject());
            $csv->setDelimiter($this->delimiter);
            $csv->setEnclosure($this->enclosure);
            $csv->setEscape($this->escapeChar);

            // Set data.
            $headers = $this->extractHeaders($data);
            $csv->insertOne($headers);
            $csv->addFormatter(array($this, 'formatRow'));
            foreach ($data as $row) {
                $csv->insertOne($row);
            }
            $output = $csv->__toString();

            return trim($output);
        } catch (\Exception $e) {
            throw new \InvalidArgumentException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Extracts the headers using the first row of values.
     *
     * @param array $data
     *   The array of data to be converted to a CSV.
     *
     * We must make the assumption that each row shares the same set of headers
     * will all other rows. This is inherent in the structure of a CSV.
     *
     * @return array
     *   An array of CSV headesr.
     */
    protected function extractHeaders($data)
    {
        if (!empty($data)) {
            $first_row = $data[0];
            $headers = array_keys($first_row);

            return $headers;
        } else {
            return array();
        }
    }

    /**
     * Formats all cells in a given CSV row.
     *
     * This flattens complex data structures into a string, and formats
     * the string.
     *
     * @param $row
     * @return array
     */
    public function formatRow($row)
    {
        $formatted_row = array();

        foreach ($row as $column_name => $cell_data) {
            if (is_array($cell_data)) {
                $cell_value = $this->flattenCell($cell_data);
            } else {
                $cell_value = $cell_data;
            }

            $formatted_row[] = $this->formatValue($cell_value);
        }

        return $formatted_row;
    }

    /**
     * Flattens a multi-dimensional array into a single level.
     *
     * @param array $data
     *   An array of data for be flattened into a cell string value.
     *
     * @return string
     *   The string value of the CSV cell, un-sanitized.
     */
    protected function flattenCell($data)
    {
        $depth = $this->arrayDepth($data);

        if ($depth == 1) {
            // @todo Allow customization of this in-cell separator.
            if (is_array($data)) {
                return implode('|', $data);
            }
        } else {
            $cell_value = "";
            foreach ($data as $item) {
                $cell_value .= '|'.$this->flattenCell($item);
            }

            return trim($cell_value, '|');
        }
    }

    /**
     * Formats a single value for a given CSV cell.
     *
     * @param string $value
     *   The raw value to be formatted.
     *
     * @return string
     *   The formatted value.
     *
     */
    protected function formatValue($value)
    {
        $value = html_entity_decode($value, ENT_QUOTES, 'UTF-8');
        $value = strip_tags($value);
        $value = trim($value);

        return $value;
    }

    /**
     * {@inheritdoc}
     */
    public function decode($data, $format, array $context = array())
    {
        $csv = Reader::createFromString($data);
        $csv->setDelimiter($this->delimiter);
        $csv->setEnclosure($this->enclosure);
        $csv->setEscape($this->escapeChar);

        return $csv->fetchAssoc(0, array($this, 'expandRow'));
    }

    /**
     * Explodes multiple, concatenated values for all cells in a row.
     *
     * @param array $row
     *   The row of CSV cells.
     *
     * @return array
     *   The same row of CSV cells, with each cell's contents exploded.
     */
    public function expandRow($row)
    {
        foreach ($row as $column_name => $cell_data) {
            // @todo Allow customization of this in-cell separator.
            if (strpos($cell_data, '|') !== false) {
                $row[$column_name] = explode('|', $cell_data);
            }
        }

        return $row;
    }

    /**
     * {@inheritdoc}
     */
    public static function getFileExtension()
    {
        return static::$format;
    }

    /**
     * Determine the depth of an array.
     *
     * This method determines array depth by analyzing the indentation of the
     * dumped array. This avoid potential issues with recursion.
     *
     * @param $array
     * @return float
     *
     * @see http://stackoverflow.com/a/263621
     */
    protected function arrayDepth($array)
    {
        $max_indentation = 1;

        $array_str = print_r($array, true);
        $lines = explode("\n", $array_str);

        foreach ($lines as $line) {
            $indentation = (strlen($line) - strlen(ltrim($line))) / 4;

            if ($indentation > $max_indentation) {
                $max_indentation = $indentation;
            }
        }

        return ceil(($max_indentation - 1) / 2) + 1;
    }

    /**
     * Set CSV settings from the Views settings array.
     *
     * If a tab character ('\t') is used for the delimiter, it will be properly
     * converted to "\t".
     */
    protected function setSettings(array $settings)
    {
        // Replace tab character with one that will be properly interpreted.
        $this->delimiter = str_replace('\t', "\t", $settings['delimiter']);
        $this->enclosure = $settings['enclosure'];
        $this->escapeChar = $settings['escape_char'];
    }

}
