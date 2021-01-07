<?php

declare(strict_types=1);

/*
 * This file is part of the "bzga_beratungsstellensuche_export" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Bzga\BzgaBeratungsstellensucheExport\Domain\Serializer\Normalizer;

use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

final class EtbNormalizer extends ObjectNormalizer
{
    /**
     * @inheritDoc
     */
    public function normalize($object, $format = null, array $context = [])
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
}
