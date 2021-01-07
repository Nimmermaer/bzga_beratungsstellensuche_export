<?php

/*
 * This file is part of the "bzga_beratungsstellensuche_export" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Bzga\BzgaBeratungsstellensucheExport\Configuration;

use Bzga\BzgaBeratungsstellensucheExport\Domain\Model\Dto\Configuration;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * @author Sebastian Schreiber
 */
class Manager implements SingletonInterface
{

    /**
     * @var Configuration|null
     */
    private static $configuration;

    public function getConfiguration(): Configuration
    {
        if (null === self::$configuration) {
            self::$configuration = GeneralUtility::makeInstance(Configuration::class, $this->getSettings());
        }

        return self::$configuration;
    }

    public function getSettings(): array
    {
        if (!isset($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['bzga_beratungsstellensuche_export'])) {
            return [];
        }

        $settings = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['bzga_beratungsstellensuche_export']);

        if (!is_array($settings)) {
            $settings = [];
        }

        return $settings;
    }
}
