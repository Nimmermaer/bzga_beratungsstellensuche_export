<?php


if ( ! defined('TYPO3_MODE')) {
    die('Access denied.');
}


call_user_func(function ($packageKey) {
    \Bzga\BzgaBeratungsstellensuche\Utility\ExtensionManagementUtility::registerExtensionKey($packageKey, 10);

# Composer autoloader for vendors
    require_once \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($packageKey).'/Libraries/autoload.php';

# Command controllers for scheduler
    if (TYPO3_MODE === 'BE') {
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['extbase']['commandControllers'][] = \Bzga\BzgaBeratungsstellensucheExport\Command\ExportCommandController::class;
    }
}, 'bzga_beratungsstellensuche_export');

