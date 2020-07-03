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

        $this->assertInstanceOf(RSA::class, $rsa);
    }
}
