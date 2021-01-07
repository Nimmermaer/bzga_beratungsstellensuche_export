<?php

/*
 * This file is part of the "bzga_beratungsstellensuche_export" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Bzga\BzgaBeratungsstellensucheExport\Tests\Unit;

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
        self::assertSame('host', $configuration->getHost());
        self::assertSame('pathToPrivateKeyFile', $configuration->getPathToPrivateKeyFile());
        self::assertSame('pathToPublicKeyFile', $configuration->getPathToPublicKeyFile());
        self::assertSame('usernames', $configuration->getUsernames());
    }
}
