<?php


namespace BZga\BzgaBeratungsstellensucheExport\Configuration;

use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use BZga\BzgaBeratungsstellensucheExport\Domain\Model\Dto\Configuration;

class Manager implements SingletonInterface
{

    /**
     * @var null|Configuration
     */
    private static $configuration = null;

    /**
     * @return Configuration
     */
    public function getConfiguration()
    {
        if (null === self::$configuration) {
            $configuration = GeneralUtility::makeInstance(Configuration::class, $this->getSettings());
        }

        return $configuration;
    }

    /**
     * @return array
     */
    public function getSettings()
    {
        $settings = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['bzga_beratungsstellensuche_export']);

        if (!is_array($settings)) {
            $settings = array();
        }

        return $settings;
    }
}