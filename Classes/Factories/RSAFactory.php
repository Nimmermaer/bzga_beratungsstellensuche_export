<?php

namespace BZgA\BzgaBeratungsstellensucheExport\Factories;

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

use phpseclib\Crypt\RSA;
use BZgA\BzgaBeratungsstellensucheExport\Exception\FileNotFoundException;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * @package TYPO3
 * @subpackage bzga_beratungsstellensuche_exporter
 * @author Sebastian Schreiber
 */
class RSAFactory
{

    /**
     * @param string $pathToPrivateKeyFile
     * @param string $pathToPublicKeyFile
     * @throws FileNotFoundException
     * @return RSA
     */
    public static function createInstance($pathToPrivateKeyFile, $pathToPublicKeyFile)
    {
        if (false === file_exists($pathToPublicKeyFile)) {
            throw FileNotFoundException::publicKeyFileNotFound();
        }
        if (false === file_exists($pathToPrivateKeyFile)) {
            throw FileNotFoundException::privateKeyFileNotFound();
        }

        $privateKey = GeneralUtility::getUrl($pathToPublicKeyFile);
        $publicKey = GeneralUtility::getUrl($pathToPrivateKeyFile);

        $rsa = new RSA();
        $rsa->setPublicKey($publicKey);
        $rsa->loadKey($privateKey);

        return $rsa;
    }

}