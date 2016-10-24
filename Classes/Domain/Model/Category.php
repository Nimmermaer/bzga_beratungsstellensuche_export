<?php


namespace BZgA\BzgaBeratungsstellensucheExport\Domain\Model;


class Category extends \BZgA\BzgaBeratungsstellensuche\Domain\Model\Category
{

    /**
     * Static transformation of category uid for export.
     *
     * @return int
     */
    public function getEtbId()
    {
        return array_search($this->getExternalId(), array(200 => 2, 210 => 1, 220 => 3));
    }

}