<?php


namespace Bzga\BzgaBeratungsstellensucheExport\Domain\Serializer;

/**
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */
use Bzga\BzgaBeratungsstellensucheExport\Domain\Model\Entry;
use Bzga\BzgaBeratungsstellensucheExport\Domain\Serializer\NameConverter\SorgenTelefonNameConverter;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
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
            [
                $normalizer,
            ],
            [
                new CsvEncoder('|'),
            ]
        );
    }

    /**
     * @param mixed $data
     * @param string $format
     * @param array $context
     * @return string
     */
    public function serialize($data, $format, array $context = [])
    {
        return $this->serializer->serialize($data, 'csv');
    }

    /**
     * @param mixed $data
     * @param string $type
     * @param string $format
     * @param array $context
     * @return void
     * @throws \BadMethodCallException
     */
    public function deserialize($data, $type, $format, array $context = [])
    {
        throw new \BadMethodCallException('This method is not implemented yet');
    }
}
