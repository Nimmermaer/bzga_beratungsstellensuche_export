<?php

/*
 * This file is part of the "bzga_beratungsstellensuche_export" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Bzga\BzgaBeratungsstellensucheExport\Factory;

use InvalidArgumentException;
use phpseclib\Net\SFTP;

/**
 * @author Sebastian Schreiber
 */
class SFTPFactory
{
    public static function createInstance(string $host): SFTP
    {
        if (false === filter_var($host, FILTER_VALIDATE_IP) && false === filter_var($host, FILTER_VALIDATE_URL)) {
            throw new InvalidArgumentException('This is not a valid host or ip');
        }

        return new SFTP($host);
    }
}
