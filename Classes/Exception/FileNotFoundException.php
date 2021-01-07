<?php

/*
 * This file is part of the "bzga_beratungsstellensuche_export" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Bzga\BzgaBeratungsstellensucheExport\Exception;

/**
 * @author Sebastian Schreiber
 */
class FileNotFoundException extends \RuntimeException
{
    public static function publicKeyFileNotFound(): self
    {
        return new static('The public key file could not be found');
    }

    public static function privateKeyFileNotFound(): self
    {
        return new static('The private key file could not be found');
    }
}
