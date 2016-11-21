<?php

namespace Bzga\BzgaBeratungsstellensucheExport\Factories;

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

use Bzga\BzgaBeratungsstellensucheExport\Service\ConnectionService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use Bzga\BzgaBeratungsstellensucheExport\Configuration\Manager;

/**
 * @package TYPO3
 * @subpackage bzga_beratungsstellensuche_exporter
 * @author Sebastian Schreiber
 */
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