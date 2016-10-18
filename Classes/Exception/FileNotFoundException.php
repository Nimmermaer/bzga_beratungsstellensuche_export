<?php


namespace BZgA\BzgaBeratungsstellensucheExport\Exception;


class FileNotFoundException extends \RuntimeException
{

    /**
     * @return static
     */
    public static function publicKeyFileNotFound()
    {
        return new static('The public key file could not be found');
    }

    /**
     * @return static
     */
    public static function privateKeyFileNotFound()
    {
        return new static('The private key file could not be found');
    }

}