<?php

namespace Bzga\BzgaBeratungsstellensucheExport\Command;

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
use Bzga\BzgaBeratungsstellensucheExport\Factories\ConnectionServiceFactory;
use TYPO3\CMS\Extbase\Mvc\Controller\CommandController;

/**
 * @author Sebastian Schreiber
 */
class ExportCommandController extends CommandController
{

    /**
     * @var \Bzga\BzgaBeratungsstellensuche\Domain\Repository\EntryRepository
     * @inject
     */
    protected $entryRepository;

    /**
     * @var \Bzga\BzgaBeratungsstellensucheExport\Configuration\Manager
     * @inject
     */
    protected $configurationManager;

    /**
     * @var \Bzga\BzgaBeratungsstellensucheExport\Domain\Serializer\EtbSerializer
     */
    protected $serializer;

    /**
     * Export entries to defined format
     *
     * @param string $type
     */
    public function exportCommand($type = 'csv')
    {
        $entries = $this->entryRepository->findAll();
        if (!empty($entries)) {
            $data = $this->serializer->serialize($entries->toArray(), $type);
            $connectionService = ConnectionServiceFactory::createInstance();
            $connectionService->upload($data);
        }
    }
}
