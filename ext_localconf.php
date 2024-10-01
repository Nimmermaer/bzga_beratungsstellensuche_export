<?php


defined('TYPO3') || die('Access denied.');

call_user_func(function ($packageKey) {
    \Bzga\BzgaBeratungsstellensuche\Utility\ExtensionManagementUtility::registerExtensionKey($packageKey, 10);

    // Upgrade wizards
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/install']['update'][\Bzga\BzgaBeratungsstellensucheExport\Updates\ImportEtbCountryZonesUpdate::class] = \Bzga\BzgaBeratungsstellensucheExport\Updates\ImportEtbCountryZonesUpdate::class;

}, 'bzga_beratungsstellensuche_export');
