<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Beratungsstellensuche Export',
    'description' => 'Beratungsstellensuche der BZgA - Export',
    'category' => 'misc',
    'author' => 'Sebastian Schreiber',
    'author_email' => 'ssch@hauptweg-nebenwege.de',
    'author_company' => 'Hauptweg Nebenwege GmbH',
    'state' => 'beta',
    'version' => '11.5.0',
    'constraints' => [
        'depends' => [
            'typo3' => '12.4.0-12.4.99',
            'bzga_beratungsstellensuche' => '10.4.0-',
        ],
        'conflicts' => [],
    ],
    'autoload' => [
        'psr-4' => ['Bzga\\BzgaBeratungsstellensucheExport\\' => 'Classes']
    ],
    'autoload-dev' => [
        'psr-4' => ['Bzga\\BzgaBeratungsstellensucheExport\\Tests\\' => 'Tests']
    ],
];
