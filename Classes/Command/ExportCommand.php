<?php

declare(strict_types=1);

/*
 * This file is part of the "bzga_beratungsstellensuche_export" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Bzga\BzgaBeratungsstellensucheExport\Command;

use Bzga\BzgaBeratungsstellensuche\Domain\Repository\EntryRepository;
use Bzga\BzgaBeratungsstellensucheExport\Domain\Serializer\EtbSerializer;
use Bzga\BzgaBeratungsstellensucheExport\Factory\ConnectionServiceFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

final class ExportCommand extends Command
{
    /**
     * @var EntryRepository
     */
    private $entryRepository;

    /**
     * @var EtbSerializer
     */
    private $serializer;

    public function __construct(string $name = null, EntryRepository $entryRepository = null, EtbSerializer $serializer = null)
    {
        $this->entryRepository = $entryRepository ?? GeneralUtility::makeInstance(EntryRepository::class);
        $this->serializer = $serializer ?? GeneralUtility::makeInstance(EtbSerializer::class);
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Export von Beratungsstellen');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $entries = $this->entryRepository->findAll();
        if (!empty($entries)) {
            $data = $this->serializer->serialize($entries->toArray(), 'csv');
            $connectionService = ConnectionServiceFactory::createInstance();
            $connectionService->upload($data);
        }

        return 0;
    }

}
