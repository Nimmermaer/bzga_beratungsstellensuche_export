<?php

/*
 * This file is part of the "bzga_beratungsstellensuche_export" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Bzga\BzgaBeratungsstellensucheExport\Tests\Unit\Factories;

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
        self::assertInstanceOf(SFTP::class, $sftp);
    }

    /**
     * @test
     */
    public function createInstanceWithTelnetUrl(): void
    {
        $sftp = SFTPFactory::createInstance('telnet://melvyl.ucop.edu/');
        self::assertInstanceOf(SFTP::class, $sftp);
    }
}
