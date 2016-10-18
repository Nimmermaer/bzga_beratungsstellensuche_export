<?php


namespace BZgA\BzgaBeratungsstellensucheExport\Factories;

use BZgA\BzgaBeratungsstellensucheExport\Service\ConnectionService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use BZga\BzgaBeratungsstellensucheExport\Configuration\Manager;

class ConnectionServiceFactory
{

    /**
     * @return ConnectionService
     */
    public static function createInstance()
    {
        $configurationManager = GeneralUtility::makeInstance(Manager::class);
        /* @var $configurationManager Manager */
        $configuration = $configurationManager->getConfiguration();

        $rsa = RSAFactory::createInstance($configuration->getPathToPrivateKeyFile(),
            $configuration->getPathToPublicKeyFile());
        $sftp = SFTPFactory::createInstance($configuration->getHost());
        $connectionService = new ConnectionService($rsa, $sftp, $configuration->getUsernames());

        return $connectionService;

    }

}