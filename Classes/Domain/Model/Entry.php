<?php

/*
 * This file is part of the "bzga_beratungsstellensuche_export" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Bzga\BzgaBeratungsstellensucheExport\Domain\Model;

/**
 * @author Sebastian Schreiber
 */
class Entry extends \Bzga\BzgaBeratungsstellensuche\Domain\Model\Entry
{

    /**
     * @var string
     */
    const ETB_COUNTRY_ID = 1;

    /**
     * @var
     */
    const ETB_TYPE = 142;

    /**
     * Get type of entry. This is static. All entries are of type 142.
     *
     * @return int
     */
    public function getEtbType(): int
    {
        return self::ETB_TYPE;
    }

    public function getEtbAdditionalAddress(): string
    {
        return $this->returnEmpty();
    }

    public function getEtbContactPersonTelephone(): string
    {
        return $this->returnEmpty();
    }

    public function getEtbCountry(): string
    {
        return self::ETB_COUNTRY_ID;
    }

    public function getEtbDistrict(): string
    {
        return $this->returnEmpty();
    }

    public function getEtbEmailClient(): string
    {
        return $this->returnEmpty();
    }

    public function getEtbCompetence(): string
    {
        return $this->returnEmpty();
    }

    public function getEtbQuarter(): string
    {
        return $this->returnEmpty();
    }

    public function getEtbDirections(): string
    {
        return $this->returnEmpty();
    }

    public function getEtbAvailability(): string
    {
        return $this->returnEmpty();
    }

    public function getEtbCategories(): string
    {
        $categoryUids = [];
        if ($this->categories->count() > 0) {
            $categories = $this->categories->toArray();
            foreach ($categories as $category) {
                /** @var $category Category */
                $categoryUids[] = $category->getEtbId();
            }
        }

        return implode(',', $categoryUids);
    }

    public function getEtbState()
    {
        if ($this->state instanceof \SJBR\StaticInfoTables\Domain\Model\CountryZone) {
            return $this->state->getEtbId();
        }

        return $this->returnEmpty();
    }

    private function returnEmpty(): string
    {
        return '';
    }
}
