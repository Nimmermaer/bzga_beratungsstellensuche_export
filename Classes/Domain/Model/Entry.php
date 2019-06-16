<?php

namespace Bzga\BzgaBeratungsstellensucheExport\Domain\Model;

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

    /**
     * @return string
     */
    public function getEtbAdditionalAddress(): string
    {
        return $this->returnEmpty();
    }

    /**
     * @return string
     */
    public function getEtbContactPersonTelephone(): string
    {
        return $this->returnEmpty();
    }

    /**
     * @return string
     */
    public function getEtbCountry(): string
    {
        return self::ETB_COUNTRY_ID;
    }

    /**
     * @return string
     */
    public function getEtbDistrict(): string
    {
        return $this->returnEmpty();
    }

    /**
     * @return string
     */
    public function getEtbEmailClient(): string
    {
        return $this->returnEmpty();
    }

    /**
     * @return string
     */
    public function getEtbCompetence(): string
    {
        return $this->returnEmpty();
    }

    /**
     * @return string
     */
    public function getEtbQuarter(): string
    {
        return $this->returnEmpty();
    }

    /**
     * @return string
     */
    public function getEtbDirections(): string
    {
        return $this->returnEmpty();
    }

    /**
     * @return string
     */
    public function getEtbAvailability(): string
    {
        return $this->returnEmpty();
    }

    /**
     * @return string
     */
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

    /**
     * @return int|string
     */
    public function getEtbState()
    {
        if ($this->state instanceof \SJBR\StaticInfoTables\Domain\Model\CountryZone) {
            return $this->state->getEtbId();
        }

        return $this->returnEmpty();
    }

    /**
     * @return string
     */
    private function returnEmpty(): string
    {
        return '';
    }
}
