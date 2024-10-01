<?php

declare(strict_types=1);

/*
 * This file is part of the "bzga_beratungsstellensuche_export" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Bzga\BzgaBeratungsstellensucheExport\Domain\Serializer\Normalizer;

use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

final class EtbNormalizer extends AbstractObjectNormalizer
{
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

    protected function extractAttributes(object $object, ?string $format = null, array $context = []): array
    {
        return [];
    }

    protected function getAttributeValue(object $object, string $attribute, ?string $format = null, array $context = []): mixed
    {
        return null;
    }

    protected function setAttributeValue(object $object, string $attribute, mixed $value, ?string $format = null, array $context = []): void
    {
        // TODO: Implement setAttributeValue() method.
    }

    public function getSupportedTypes(?string $format): array
    {
        return [];
    }
}
