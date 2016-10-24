<?php

namespace BZgA\BzgaBeratungsstellensucheExport\Exception;

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

/**
 * @package TYPO3
 * @subpackage bzga_beratungsstellensuche_exporter
 * @author Sebastian Schreiber
 */
class FileNotFoundException extends \RuntimeException
{

    /**
     * @return static
     */
    public static function publicKeyFileNotFound()
    {
        return new static('The public key file could not be found');
    }

    /**
     * @return static
     */
    public static function privateKeyFileNotFound()
    {
        return new static('The private key file could not be found');
    }

}