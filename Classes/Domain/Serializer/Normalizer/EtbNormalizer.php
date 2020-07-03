<?php
declare(strict_types = 1);

namespace Bzga\BzgaBeratungsstellensucheExport\Domain\Serializer\Normalizer;

/*
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
