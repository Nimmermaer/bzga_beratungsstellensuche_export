<?php


namespace BZga\BzgaBeratungsstellensucheExport\Domain\Model\Dto;

use TYPO3\CMS\Core\Utility\GeneralUtility;

class Configuration
{

    /**
     * @var string
     */
    protected $host;

    /**
     * @var array
     */
    protected $usernames;

    /**
     * @var string
     */
    protected $pathToPrivateKeyFile;

    /**
     * @var string
     */
    protected $pathToPublicKeyFile;

    /**
     * Configuration constructor.
     * @param array $configuration
     */
    public function __construct(array $configuration = array())
    {
        foreach ($configuration as $key => $value) {
            $propertyKey = GeneralUtility::underscoredToLowerCamelCase($key);
            if (property_exists(__CLASS__, $propertyKey)) {
                $this->$propertyKey = $value;
            }
        }
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @param string $host
     */
    public function setHost($host)
    {
        $this->host = $host;
    }

    /**
     * @return array
     */
    public function getUsernames()
    {
        return $this->usernames;
    }

    /**
     * @param array $usernames
     */
    public function setUsernames($usernames)
    {
        $this->usernames = $usernames;
    }

    /**
     * @return string
     */
    public function getPathToPrivateKeyFile()
    {
        return $this->pathToPrivateKeyFile;
    }

    /**
     * @param string $pathToPrivateKeyFile
     */
    public function setPathToPrivateKeyFile($pathToPrivateKeyFile)
    {
        $this->pathToPrivateKeyFile = $pathToPrivateKeyFile;
    }

    /**
     * @return string
     */
    public function getPathToPublicKeyFile()
    {
        return $this->pathToPublicKeyFile;
    }

    /**
     * @param string $pathToPublicKeyFile
     */
    public function setPathToPublicKeyFile($pathToPublicKeyFile)
    {
        $this->pathToPublicKeyFile = $pathToPublicKeyFile;
    }


}