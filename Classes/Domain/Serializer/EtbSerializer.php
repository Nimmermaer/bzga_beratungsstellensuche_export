<?php

/*
 * This file is part of the "bzga_beratungsstellensuche_export" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Bzga\BzgaBeratungsstellensucheExport\Domain\Serializer;

use BadMethodCallException;
use Bzga\BzgaBeratungsstellensucheExport\Domain\Model\Entry;
use Bzga\BzgaBeratungsstellensucheExport\Domain\Serializer\NameConverter\SorgenTelefonNameConverter;
use Bzga\BzgaBeratungsstellensucheExport\Domain\Serializer\Normalizer\EtbNormalizer;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use TYPO3\CMS\Extbase\Reflection\ObjectAccess;

class EtbSerializer implements SerializerInterface
{

    /**
     * @var Serializer;
     */
    private $serializer;

    /**
     * @var array;
     */
    private $ignoredAttributes = [];

    public function __construct()
    {
        $entry = new Entry();
        $properties = ObjectAccess::getGettablePropertyNames($entry);
        $nameConverter = new SorgenTelefonNameConverter();
        $exposedProperties = $nameConverter->getProperties();
        $this->ignoredAttributes = array_diff($properties, $exposedProperties);
        $normalizer = new EtbNormalizer(null, $nameConverter);
        $this->serializer = new Serializer(
            [
                $normalizer,
            ],
            [
                new CsvEncoder([CsvEncoder::DELIMITER_KEY => '|'])
            ]
        );
    }

    /**
     * @inheritDoc
     */
    public function serialize($data, $format, array $context = []): string
    {
        return $this->serializer->serialize($data,
            'csv',
            [
                CsvEncoder::HEADERS_KEY => array_values(SorgenTelefonNameConverter::$mapNames),
                EtbNormalizer::IGNORED_ATTRIBUTES => $this->ignoredAttributes
            ]
        );
    }

    /**
     * @inheritDoc
     */
    public function deserialize($data, $type, $format, array $context = [])
    {
        throw new BadMethodCallException('This method is not implemented yet');
    }
}
