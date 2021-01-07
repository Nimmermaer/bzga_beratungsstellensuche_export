<?php

/*
 * This file is part of the "bzga_beratungsstellensuche_export" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Bzga\BzgaBeratungsstellensucheExport\Domain\Model\Dto;

use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * @author Sebastian Schreiber
 */
class Configuration
{

    /**
     * @var string
     */
    protected $host = '';

    /**
     * @var array|string
     */
    protected $usernames;

    /**
     * @var string
     */
    protected $pathToPrivateKeyFile = '';

    /**
     * @var string
     */
    protected $pathToPublicKeyFile = '';

    public function __construct(array $configuration = [])
    {
        foreach ($configuration as $key => $value) {
            $propertyKey = GeneralUtility::underscoredToLowerCamelCase($key);
            if (property_exists(__CLASS__, $propertyKey)) {
                $this->{$propertyKey} = $value;
            }
        }
    }

    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @return array|string
     */
    public function getUsernames()
    {
        return $this->usernames;
    }

    public function getPathToPrivateKeyFile(): string
    {
        return $this->pathToPrivateKeyFile;
    }

    public function getPathToPublicKeyFile(): string
    {
        return $this->pathToPublicKeyFile;
    }
}
