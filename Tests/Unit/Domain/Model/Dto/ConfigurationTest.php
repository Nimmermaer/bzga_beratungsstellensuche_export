<?php


namespace BZgA\BzgaBeratungsstellensucheExport\Tests\Unit;


use BZga\BzgaBeratungsstellensucheExport\Domain\Model\Dto\Configuration;


class ConfigurationTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function setConfiguration()
    {
        $params = [
            'host' => 'host',
            'usernames' => 'usernames',
            'path_to_private_key_file' => 'pathToPrivateKeyFile',
            'path_to_public_key_file' => 'pathToPublicKeyFile',
        ];
        $configuration = new Configuration($params);
        $this->assertSame('host', $configuration->getHost());
        $this->assertSame('pathToPrivateKeyFile', $configuration->getPathToPrivateKeyFile());
        $this->assertSame('pathToPublicKeyFile', $configuration->getPathToPublicKeyFile());
        $this->assertSame('usernames', $configuration->getUsernames());
    }


}
