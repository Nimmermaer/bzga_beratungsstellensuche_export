<?php
defined('TYPO3_MODE') or die();

$additionalFields = array(
	'zn_name_en' => 'etb_id'
);

\BZgA\BzgaBeratungsstellensuche\Utility\ExtensionManagementUtility::addAdditionalFieldsToTable($additionalFields, 'static_country_zones');

unset($additionalFields);