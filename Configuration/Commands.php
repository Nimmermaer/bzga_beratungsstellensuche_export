<?php

/*
 * This file is part of the "bzga_beratungsstellensuche_export" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

return [
    'bzga:beratungsstellensuche:export' => [
        'class' => \Bzga\BzgaBeratungsstellensucheExport\Command\ExportCommand::class,
        'schedulable' => true
    ],
    'bzga:beratungsstellensuche:export-to-file' => [
        'class' => \Bzga\BzgaBeratungsstellensucheExport\Command\ExportToFileCommand::class,
        'schedulable' => true
    ]
];
