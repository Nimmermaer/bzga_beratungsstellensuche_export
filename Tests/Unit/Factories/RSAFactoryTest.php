<?php

/*
 * This file is part of the "bzga_beratungsstellensuche_export" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Bzga\BzgaBeratungsstellensucheExport\Tests\Unit\Factories;

use Bzga\BzgaBeratungsstellensucheExport\Exception\FileNotFoundException;
use Bzga\BzgaBeratungsstellensucheExport\Factory\RSAFactory;
use org\bovigo\vfs\vfsStream;
use phpseclib\Crypt\RSA;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class RSAFactoryTest extends UnitTestCase
{

    /**
     * @test
     */
    public function createInstanceWithNonExistingPrivateKeyFile(): void
    {
        $this->expectException(FileNotFoundException::class);
        $rsa = RSAFactory::createInstance('', '');
    }

    /**
     * @test
     */
    public function createInstanceWithCorrectFiles(): void
    {
        $rootDirectory = vfsStream::setup('root');
        $directory = vfsStream::newDirectory('files')->at($rootDirectory);
        vfsStream::newFile('privatekey.pub')->at($directory);
        vfsStream::newFile('publickey.pub')->at($directory);

        $privateKeyFile = vfsStream::url('root/files/privatekey.pub');
        $publikcKeyFile = vfsStream::url('root/files/publickey.pub');
        $rsa = RSAFactory::createInstance($privateKeyFile, $publikcKeyFile);

        self::assertInstanceOf(RSA::class, $rsa);
    }
}
