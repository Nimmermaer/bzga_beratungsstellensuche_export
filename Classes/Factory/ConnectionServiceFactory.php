<?php

/*
 * This file is part of the "bzga_beratungsstellensuche_export" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Bzga\BzgaBeratungsstellensucheExport\Factory;

use Bzga\BzgaBeratungsstellensucheExport\Configuration\Manager;
use Bzga\BzgaBeratungsstellensucheExport\Service\ConnectionService;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * @author Sebastian Schreiber
 */
class ConnectionServiceFactory
{
    public static function createInstance(): ConnectionService
    {
        $configurationManager = GeneralUtility::makeInstance(Manager::class);
        /** @var $configurationManager Manager */
        $configuration = $configurationManager->getConfiguration();

        $rsa = RSAFactory::createInstance(
            $configuration->getPathToPrivateKeyFile(),
            $configuration->getPathToPublicKeyFile()
        );
        $sftp = SFTPFactory::createInstance($configuration->getHost());

        return new ConnectionService($rsa, $sftp, $configuration->getUsernames());
    }
}
