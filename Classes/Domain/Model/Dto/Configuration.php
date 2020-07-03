<?php

namespace Bzga\BzgaBeratungsstellensucheExport\Domain\Model\Dto;

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
