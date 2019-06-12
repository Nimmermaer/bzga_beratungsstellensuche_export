<?php

namespace Bzga\BzgaBeratungsstellensucheExport\Service;

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
use Bzga\BzgaBeratungsstellensucheExport\Exception\AccessDeniedException;
use phpseclib\Crypt\RSA;
use phpseclib\Net\SFTP;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * @author Sebastian Schreiber
 */
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
    private $userNames;

    /**
     * ConnectionService constructor.
     *
     * @param RSA $key
     * @param SFTP $sftp
     * @param array|string $userNames
     */
    public function __construct(RSA $key, SFTP $sftp, $userNames)
    {
        $this->key = $key;
        $this->sftp = $sftp;
        if (is_string($userNames)) {
            $userNames = GeneralUtility::trimExplode(',', $userNames);
        }
        $this->userNames = (array)$userNames;
    }

    /**
     * @param string $data
     * @param string $filenamePrefix
     * @param string $remoteDirectory
     */
    public function upload($data, $filenamePrefix = 'bzga_beratungsstellen_', $remoteDirectory = 'home')
    {
        $filename = $filenamePrefix . date('Ymd');
        $connectionEstablished = false;
        foreach ($this->userNames as $username) {
            if (true === $this->sftp->login($username, $this->key)) {
                $connectionEstablished = true;
                break;
            }
        }

        if (false === $connectionEstablished) {
            throw new AccessDeniedException('Connection could not be established. Wrong credentials given.');
        }

        $this->sftp->chdir($remoteDirectory);
        $this->sftp->put($filename, $data);
        $this->sftp->disconnect();
    }
}
