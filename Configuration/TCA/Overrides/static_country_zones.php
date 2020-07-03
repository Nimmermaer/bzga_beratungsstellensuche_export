<?php

defined('TYPO3_MODE') || die('Access denied.');

$additionalFields = [
    'zn_name_en' => 'etb_id'
];

\Bzga\BzgaBeratungsstellensuche\Utility\ExtensionManagementUtility::addAdditionalFieldsToTable($additionalFields, 'static_country_zones');

unset($additionalFields);
