<?php

/*
 * This file is part of the "bzga_beratungsstellensuche_export" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Bzga\BzgaBeratungsstellensucheExport\Factory;

use Bzga\BzgaBeratungsstellensucheExport\Exception\FileNotFoundException;
use phpseclib\Crypt\RSA;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * @author Sebastian Schreiber
 */
class RSAFactory
{
    public static function createInstance(string $pathToPrivateKeyFile, string $pathToPublicKeyFile): RSA
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
