<?php

namespace Bzga\BzgaBeratungsstellensucheExport\Configuration;

/**
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */
use BZga\BzgaBeratungsstellensucheExport\Domain\Model\Dto\Configuration;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * @author Sebastian Schreiber
 */
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
            self::$configuration = GeneralUtility::makeInstance(Configuration::class, $this->getSettings());
        }

        return self::$configuration;
    }

    /**
     * @return array
     */
    public function getSettings()
    {
        $settings = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['bzga_beratungsstellensuche_export']);

        if (!is_array($settings)) {
            $settings = [];
        }

        return $settings;
    }
}
