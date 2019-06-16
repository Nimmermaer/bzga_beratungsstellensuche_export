<?php


namespace Bzga\BzgaBeratungsstellensucheExport\Domain\Model;

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
