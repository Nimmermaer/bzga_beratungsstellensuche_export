<?php

declare(strict_types=1);

/*
 * This file is part of the "bzga_beratungsstellensuche_export" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Bzga\BzgaBeratungsstellensucheExport\Domain\Serializer\Normalizer;

use Symfony\Component\PropertyAccess\Exception\NoSuchPropertyException;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Symfony\Component\PropertyInfo\PropertyTypeExtractorInterface;
use Symfony\Component\Serializer\Mapping\ClassDiscriminatorResolverInterface;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactoryInterface;
use Symfony\Component\Serializer\NameConverter\NameConverterInterface;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;

final class EtbNormalizer extends AbstractObjectNormalizer
{
    private readonly \Closure $objectClassResolver;
    protected PropertyAccessorInterface $propertyAccessor;

    public function __construct(?ClassMetadataFactoryInterface $classMetadataFactory = null, ?NameConverterInterface $nameConverter = null, ?PropertyTypeExtractorInterface $propertyTypeExtractor = null, ?ClassDiscriminatorResolverInterface $classDiscriminatorResolver = null, ?callable $objectClassResolver = null, array $defaultContext = [],  ?PropertyAccessorInterface $propertyAccessor = null,)
    {
        parent::__construct($classMetadataFactory, $nameConverter, $propertyTypeExtractor, $classDiscriminatorResolver, $objectClassResolver, $defaultContext);

        $this->propertyAccessor = $propertyAccessor ?: PropertyAccess::createPropertyAccessor();
        $this->objectClassResolver = ($objectClassResolver ?? static fn($class) => \is_object($class) ? $class::class : $class)(...);
    }

    /**
     * @inheritDoc
     */
    public function normalize($object, $format = null, array $context = []): float|int|bool|\ArrayObject|array|string|null
    {
        $data = parent::normalize($object, $format, $context);

        $cleanData = [];

        foreach ($data as $key => $value) {
            if (is_string($value)) {
                $cleanData[$key] = $this->cleanValue($value);
            } else {
                $cleanData[$key] = $value;
            }
        }

        return $cleanData;
    }

    private function cleanValue(string $value): string
    {
        $value = strip_tags($value, '<br><br />');
        $value = str_replace(['<br>', '<br />', "\r\n", "\r", "\n"], '+++br+++', $value);

        return trim($value);
    }

    public function getSupportedTypes(?string $format): array
    {
        return ['object' => true];
    }

    protected function extractAttributes(object $object, ?string $format = null, array $context = []): array
    {
        if (\stdClass::class === $object::class) {
            return array_keys((array)$object);
        }

        // If not using groups, detect manually
        $attributes = [];

        // methods
        $class = ($this->objectClassResolver)($object);
        $reflClass = new \ReflectionClass($class);

        foreach ($reflClass->getMethods(\ReflectionMethod::IS_PUBLIC) as $reflMethod) {
            if (
                0 !== $reflMethod->getNumberOfRequiredParameters()
                || $reflMethod->isStatic()
                || $reflMethod->isConstructor()
                || $reflMethod->isDestructor()
            ) {
                continue;
            }

            $name = $reflMethod->name;
            $attributeName = null;

            if (3 < \strlen($name) && match ($name[0]) {
                    'g' => str_starts_with($name, 'get'),
                    'h' => str_starts_with($name, 'has'),
                    'c' => str_starts_with($name, 'can'),
                    default => false,
                }) {
                // getters, hassers and canners
                $attributeName = substr($name, 3);

                if (!$reflClass->hasProperty($attributeName)) {
                    $attributeName = lcfirst($attributeName);
                }
            } elseif ('is' !== $name && str_starts_with($name, 'is')) {
                // issers
                $attributeName = substr($name, 2);

                if (!$reflClass->hasProperty($attributeName)) {
                    $attributeName = lcfirst($attributeName);
                }
            }

            if (null !== $attributeName && $this->isAllowedAttribute($object, $attributeName, $format, $context)) {
                $attributes[$attributeName] = true;
            }
        }

        foreach ($reflClass->getProperties() as $reflProperty) {
            if (!$reflProperty->isPublic()) {
                continue;
            }

            if ($reflProperty->isStatic() || !$this->isAllowedAttribute($object, $reflProperty->name, $format, $context)) {
                continue;
            }

            $attributes[$reflProperty->name] = true;
        }

        return array_keys($attributes);
    }

    protected function getAttributeValue(object $object, string $attribute, ?string $format = null, array $context = []): mixed
    {
        $mapping = $this->classDiscriminatorResolver?->getMappingForMappedObject($object);

        return $attribute === $mapping?->getTypeProperty()
            ? $mapping
            : $this->propertyAccessor->getValue($object, $attribute);
    }

    protected function setAttributeValue(object $object, string $attribute, mixed $value, ?string $format = null, array $context = []): void
    {
        try {
            $this->propertyAccessor->setValue($object, $attribute, $value);
        } catch (NoSuchPropertyException) {
            // Properties not found are ignored
        }
    }

}
