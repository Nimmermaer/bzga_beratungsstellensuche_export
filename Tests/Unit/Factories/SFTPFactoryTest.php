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
use Bzga\BzgaBeratungsstellensucheExport\Factory\SFTPFactory;
use phpseclib\Net\SFTP;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class SFTPFactoryTest extends UnitTestCase
{

    /**
     * @test
     */
    public function createInstanceWrongHost(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        SFTPFactory::createInstance('thisisnotvalid');
    }

    /**
     * @test
     */
    public function createInstanceWithIp(): void
    {
        $sftp = SFTPFactory::createInstance('192.168.0.1');
        $this->assertInstanceOf(SFTP::class, $sftp);
    }

    /**
     * @test
     */
    public function createInstanceWithTelnetUrl(): void
    {
        $sftp = SFTPFactory::createInstance('telnet://melvyl.ucop.edu/');
        $this->assertInstanceOf(SFTP::class, $sftp);
    }
}
