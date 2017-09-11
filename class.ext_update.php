<?php

/*
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

use SJBR\StaticInfoTables\Utility\DatabaseUpdateUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/**
 * Class for updating the db
 */
class ext_update
{
    /**
     * Main function, returning the HTML content
     *
     * @return string HTML
     */
    public function main()
    {
        $content = '';

        /** @var ObjectManager $objectManager */
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);

        /** @var DatabaseUpdateUtility $databaseUpdateUtility */
        $databaseUpdateUtility = $objectManager->get(DatabaseUpdateUtility::class);
        $databaseUpdateUtility->doUpdate('bzga_beratungsstellensuche_export');

        $content .= '<p>' . LocalizationUtility::translate('updateLanguageLabels',
                'StaticInfoTables') . ' bzga_beratungsstellensuche_export.</p>';

        return $content;
    }

    /**
     * @return bool
     */
    public function access()
    {
        return true;
    }
}
