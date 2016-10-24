<?php


namespace BZgA\BzgaBeratungsstellensucheExport\Domain\Serializer;

use Symfony\Component\Serializer\SerializerInterface;
use TYPO3\CMS\Extbase\Reflection\ObjectAccess;
use BZgA\BzgaBeratungsstellensucheExport\Domain\Serializer\NameConverter\SorgenTelefonNameConverter;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use BZgA\BzgaBeratungsstellensucheExport\Domain\Model\Entry;

class EtbSerializer implements SerializerInterface
{

    /**
     * @var Serializer;
     */
    private $serializer;

    /**
     * EtbSerializer constructor.
     */
    public function __construct()
    {
        $entry = new Entry();
        $properties = ObjectAccess::getGettablePropertyNames($entry);
        $nameConverter = new SorgenTelefonNameConverter();
        $exposedProperties = $nameConverter->getProperties();
        $ignoredAttributes = array_diff($properties, $exposedProperties);
        $normalizer = new ObjectNormalizer(null, $nameConverter);
        $normalizer->setIgnoredAttributes($ignoredAttributes);
        $this->serializer = new Serializer(
            array(
                $normalizer,
            ),
            array(
                new CsvEncoder('|'),
            )
        );
    }


    /**
     * @param mixed $data
     * @param string $format
     * @param array $context
     * @return string
     */
    public function serialize($data, $format, array $context = array())
    {
        return $this->serializer->serialize($data, 'csv');
    }

    /**
     * @param mixed $data
     * @param string $type
     * @param string $format
     * @param array $context
     * @throws \BadMethodCallException
     */
    public function deserialize($data, $type, $format, array $context = array())
    {
        throw new \BadMethodCallException('This method is not implemented yet');
    }


}