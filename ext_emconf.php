<?php

$EM_CONF[$_EXTKEY] = array(
    'title' => 'Beratungsstellensuche Export',
    'description' => 'Beratungsstellensuche der BZgA - Export',
    'category' => 'misc',
    'author' => 'Sebastian Schreiber',
    'author_email' => 'ssch@hauptweg-nebenwege.de',
    'author_company' => 'Hauptweg Nebenwege GmbH',
    'state' => 'beta',
    'clearCacheOnLoad' => 1,
    'version' => '6.2.0',
    'constraints' => array(
        'depends' => array(
            'typo3' => '6.2.10-6.99.99',
            'bzga_beratungsstellensuche' => '6.2.0-6.99.99',
        ),
        'conflicts' => array(),
    ),
);