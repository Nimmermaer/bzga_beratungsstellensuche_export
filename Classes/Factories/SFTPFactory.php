<?php


namespace BZgA\BzgaBeratungsstellensucheExport\Factories;

use phpseclib\Net\SFTP;

class SFTPFactory
{

    /**
     * @param $host
     * @return SFTP
     */
    public static function createInstance($host)
    {
        if (false === filter_var($host, FILTER_VALIDATE_IP | FILTER_VALIDATE_URL)) {
            throw new \InvalidArgumentException('This is not a valid host or ip');
        }

        $connection = new SFTP($host);

        return $connection;
    }

}