<?php

namespace BZgA\BzgaBeratungsstellensucheExport\Tests\Unit\Factories;

use BZgA\BzgaBeratungsstellensucheExport\Factories\SFTPFactory;
use phpseclib\Net\SFTP;

class SFTPFactoryTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function createInstanceWrongHost()
    {
        $sftp = SFTPFactory::createInstance('thisisnotvalid');
    }

    /**
     * @test
     */
    public function createInstanceWithIp()
    {
        $sftp = SFTPFactory::createInstance('192.168.0.1');
        $this->assertInstanceOf(SFTP::class, $sftp);
    }

    /**
     * @test
     */
    public function createInstanceWithTelnetUrl()
    {
        $sftp = SFTPFactory::createInstance('telnet://melvyl.ucop.edu/');
        $this->assertInstanceOf(SFTP::class, $sftp);
    }

}
