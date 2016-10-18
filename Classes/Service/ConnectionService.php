<?php


namespace BZgA\BzgaBeratungsstellensucheExport\Service;

use phpseclib\Crypt\RSA;
use phpseclib\Net\SFTP;
use BZgA\BzgaBeratungsstellensucheExport\Exception\AccessDeniedException;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class ConnectionService
{
    /**
     * @var RSA
     */
    private $key;
    /**
     * @var SFTP
     */
    private $sftp;
    /**
     * @var array
     */
    private $usernames;


    /**
     * ConnectionService constructor.
     * @param RSA $key
     * @param SFTP $sftp
     * @param array|string $usernames
     */
    public function __construct(RSA $key, SFTP $sftp, $usernames)
    {
        $this->key = $key;
        $this->sftp = $sftp;
        if (is_string($usernames)) {
            $usernames = GeneralUtility::trimExplode(',', $usernames);
        }
        $this->usernames = $usernames;
    }

    /**
     * @param string $filename
     * @param string $data
     * @param string $remoteDirectory
     */
    public function upload($filename, $data, $remoteDirectory = 'home')
    {
        $connectionEstablished = false;
        foreach ($this->usernames as $username) {
            if (true === $this->sftp->login($username, $this->key)) {
                $connectionEstablished = true;
                break;
            }
        }

        if (false === $connectionEstablished) {
            throw new AccessDeniedException();
        }

        $this->sftp->chdir($remoteDirectory);
        $this->sftp->put($filename, $data);
        $this->sftp->disconnect();
    }
}
