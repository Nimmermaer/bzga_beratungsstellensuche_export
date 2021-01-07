<?php

/*
 * This file is part of the "bzga_beratungsstellensuche_export" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Bzga\BzgaBeratungsstellensucheExport\Service;

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

    public function __construct(RSA $key, SFTP $sftp, $userNames)
    {
        $this->key = $key;
        $this->sftp = $sftp;
        if (is_string($userNames)) {
            $userNames = GeneralUtility::trimExplode(',', $userNames);
        }
        $this->userNames = (array)$userNames;
    }

    public function upload(string $data, string $filenamePrefix = 'bzga_beratungsstellen_', string $remoteDirectory = 'home'): void
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
