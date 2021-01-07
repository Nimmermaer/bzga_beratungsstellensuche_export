<?php

/*
 * This file is part of the "bzga_beratungsstellensuche_export" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Bzga\BzgaBeratungsstellensucheExport\Tests\Unit\Configuration;

use Bzga\BzgaBeratungsstellensucheExport\Configuration\Manager;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class ManagerTest extends UnitTestCase
{

    /**
     * @var Manager
     */
    protected $subject;

    protected function setUp(): void
    {
        $this->subject = new Manager();
        $this->setGlobalState();
    }

    /**
     * @test
     */
    public function configurationSameInstances(): void
    {
        $configuration1 = $this->subject->getConfiguration();
        $configuration2 = $this->subject->getConfiguration();

        self::assertSame($configuration1, $configuration2);
    }

    /**
     * @test
     */
    public function configurationHasCorrectSettings(): void
    {
        $configuration = $this->subject->getConfiguration();
        self::assertSame('host', $configuration->getHost());
    }

    /**
     * @test
     */
    public function getSettings(): void
    {
        $settings = $this->subject->getSettings();
        self::assertArrayHasKey('usernames', $settings);
    }

    private function setGlobalState(): void
    {
        $params = ['usernames' => 'username', 'host' => 'host', 'path_to_private_key_file' => 'private'];
        $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['bzga_beratungsstellensuche_export'] = serialize($params);
    }
}
