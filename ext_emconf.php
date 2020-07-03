<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Beratungsstellensuche Export',
    'description' => 'Beratungsstellensuche der BZgA - Export',
    'category' => 'misc',
    'author' => 'Sebastian Schreiber',
    'author_email' => 'ssch@hauptweg-nebenwege.de',
    'author_company' => 'Hauptweg Nebenwege GmbH',
    'state' => 'beta',
    'clearCacheOnLoad' => 0,
    'version' => '9.5.0',
    'constraints' => [
        'depends' => [
            'typo3' => '9.5.0-9.5.99',
            'bzga_beratungsstellensuche' => '9.5.0',
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
