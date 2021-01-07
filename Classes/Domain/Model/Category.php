<?php

/*
 * This file is part of the "bzga_beratungsstellensuche_export" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Bzga\BzgaBeratungsstellensucheExport\Domain\Model;

class Category extends \Bzga\BzgaBeratungsstellensuche\Domain\Model\Category
{

    /**
     * Static transformation of category uid for export.
     *
     * @return false|int|string
     */
    public function getEtbId()
    {
        return array_search($this->getExternalId(), [200 => 2, 210 => 1, 220 => 3], false);
    }
}
