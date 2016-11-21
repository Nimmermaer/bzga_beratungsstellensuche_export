<?php

namespace Bzga\BzgaBeratungsstellensucheExport\Tests\Unit\Factories;

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

use Bzga\BzgaBeratungsstellensucheExport\Factories\SFTPFactory;
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
