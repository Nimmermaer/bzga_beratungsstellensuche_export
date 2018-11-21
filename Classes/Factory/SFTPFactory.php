<?php

namespace Bzga\BzgaBeratungsstellensucheExport\Factory;

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
use phpseclib\Net\SFTP;

/**
 * @author Sebastian Schreiber
 */
class SFTPFactory
{

    /**
     * @param string $host
     * @throws \InvalidArgumentException
     * @return SFTP
     */
    public static function createInstance($host)
    {
        if (false === filter_var($host, FILTER_VALIDATE_IP) && false === filter_var($host, FILTER_VALIDATE_URL)) {
            throw new \InvalidArgumentException('This is not a valid host or ip');
        }

        return new SFTP($host);
    }
}
