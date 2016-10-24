<?php


namespace BZgA\BzgaBeratungsstellensucheExport\Tests\Unit\Factories;


use BZgA\BzgaBeratungsstellensucheExport\Factories\RSAFactory;
use \org\bovigo\vfs\vfsStream;
use phpseclib\Crypt\RSA;

class RSAFactoryTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     * @expectedException \BZgA\BzgaBeratungsstellensucheExport\Exception\FileNotFoundException
     */
    public function createInstanceWithNonExistingPrivateKeyFile()
    {
        $rsa = RSAFactory::createInstance(null, null);
    }

    /**
     * @test
     */
    public function createInstanceWithCorrectFiles()
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
