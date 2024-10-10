<?php


defined('TYPO3') || die('Access denied.');

call_user_func(function ($packageKey) {
    \Bzga\BzgaBeratungsstellensuche\Utility\ExtensionManagementUtility::registerExtensionKey($packageKey, 10);

}, 'bzga_beratungsstellensuche_export');
