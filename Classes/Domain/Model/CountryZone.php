<?php

/*
 * This file is part of the "bzga_beratungsstellensuche_export" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Bzga\BzgaBeratungsstellensucheExport\Domain\Model;

use SJBR\StaticInfoTables\Domain\Model\AbstractEntity;

/**
 * @author Sebastian Schreiber
 */
class CountryZone extends AbstractEntity
{

    /**
     * @var int
     */
    protected $etbId;

    public function getEtbId(): int
    {
        return $this->etbId;
    }

    public function setEtbId(int $etbId): void
    {
        $this->etbId = $etbId;
    }
}
