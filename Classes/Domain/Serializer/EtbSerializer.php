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

    public function __construct()
    {
        $entry = new Entry();
        $properties = ObjectAccess::getGettablePropertyNames($entry);
        $nameConverter = new SorgenTelefonNameConverter();
        $exposedProperties = $nameConverter->getProperties();
        $ignoredAttributes = array_diff($properties, $exposedProperties);
        $normalizer = new EtbNormalizer(null, $nameConverter);
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
     * @inheritDoc
     */
    public function serialize($data, $format, array $context = []): string
    {
        return $this->serializer->serialize($data, 'csv', [CsvEncoder::HEADERS_KEY => array_values(SorgenTelefonNameConverter::$mapNames)]);
    }

    /**
     * @inheritDoc
     */
    public function deserialize($data, $type, $format, array $context = [])
    {
        throw new BadMethodCallException('This method is not implemented yet');
    }
}
