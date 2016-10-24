<?php

namespace BZga\BzgaBeratungsstellensucheExport\Command;

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

use TYPO3\CMS\Extbase\Mvc\Controller\CommandController;
use BZgA\BzgaBeratungsstellensucheExport\Domain\Serializer\EtbSerializer;
use BZgA\BzgaBeratungsstellensucheExport\Factories\RSAFactory;
use BZgA\BzgaBeratungsstellensucheExport\Factories\SFTPFactory;
use BZgA\BzgaBeratungsstellensucheExport\Service\ConnectionService;

/**
 * @package TYPO3
 * @subpackage bzga_beratungsstellensuche_exporter
 * @author Sebastian Schreiber
 */
class ExportCommandController extends CommandController
{

    /**
     * @var \BZgA\BzgaBeratungsstellensuche\Domain\Repository\EntryRepository
     * @inject
     */
    protected $entryRepository;

    /**
     * @var \BZga\BzgaBeratungsstellensucheExport\Configuration\Manager
     * @inject
     */
    protected $configurationManager;

    /**
     * Export entries to defined format
     *
     * @param string $type
     */
    public function exportCommand($type = 'csv')
    {
        $entries = $this->entryRepository->findAll();
        if (!empty($entries)) {
            $serializer = $this->objectManager->get(EtbSerializer::class);

            $data = $serializer->serialize($entries->toArray(), $type);

            $configuration = $this->configurationManager->getConfiguration();

            $rsa = RSAFactory::createInstance($configuration->getPathToPrivateKeyFile(),
                $configuration->getPathToPublicKeyFile());

            $sftp = SFTPFactory::createInstance($configuration->getHost());

            $connectionService = $this->objectManager->get(ConnectionService::class, $rsa, $sftp,
                $configuration->getUsernames());

            /* @var $connectionService ConnectionService */
            $connectionService->upload($data);

        }
    }

}