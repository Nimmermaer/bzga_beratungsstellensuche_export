<?php


namespace Bzga\BzgaBeratungsstellensucheExport\Tests\Unit;

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
use Bzga\BzgaBeratungsstellensucheExport\Domain\Model\Dto\Configuration;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class ConfigurationTest extends UnitTestCase
{

    /**
     * @test
     */
    public function setConfiguration(): void
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
