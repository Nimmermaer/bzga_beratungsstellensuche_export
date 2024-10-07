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
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;

final class ExportToFileCommand extends Command
{
    /**
     * @var EntryRepository
     */
    private EntryRepository $entryRepository;

    /**
     * @var EtbSerializer
     */
    private EtbSerializer $serializer;

    public function __construct(string $name = null, EntryRepository $entryRepository = null, EtbSerializer $serializer = null)
    {
        $this->entryRepository = $entryRepository;
        $this->serializer = $serializer;
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Export von Beratungsstellen in einen lokale Datei')
            ->addOption('file', 'f', InputOption::VALUE_REQUIRED, 'The file name');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $entries = $this->entryRepository->findAll();
        if (!empty($entries)) {
            $data = $this->serializer->serialize($entries->toArray(), 'csv');
            GeneralUtility::writeFile(GeneralUtility::getFileAbsFileName($input->getOption('file')), $data);
        }

        return 0;
    }
}
