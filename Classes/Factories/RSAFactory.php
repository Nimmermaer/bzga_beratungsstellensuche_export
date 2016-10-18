<?php


namespace BZgA\BzgaBeratungsstellensucheExport\Factories;

use phpseclib\Crypt\RSA;
use BZgA\BzgaBeratungsstellensucheExport\Exception\FileNotFoundException;
use TYPO3\CMS\Core\Utility\GeneralUtility;

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