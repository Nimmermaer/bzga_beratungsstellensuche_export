<?php


namespace BZga\BzgaBeratungsstellensucheExport\Tests\Unit\Configuration;

use BZga\BzgaBeratungsstellensucheExport\Configuration\Manager;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class ManagerTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Manager
     */
    private $subject;

    /**
     * @return void
     */
    protected function setUp()
    {
        $this->subject = GeneralUtility::makeInstance(Manager::class);
        $this->setGlobalState();
    }

    /**
     * @test
     */
    public function configurationSameInstances()
    {
        $configuration1 = $this->subject->getConfiguration();
        $configuration2 = $this->subject->getConfiguration();

        $this->assertSame($configuration1, $configuration2);
    }

    /**
     * @test
     */
    public function configurationHasCorrectSettings()
    {
        $configuration = $this->subject->getConfiguration();
        $this->assertSame('host', $configuration->getHost());
    }

    /**
     * @test
     */
    public function getSettings()
    {
        $settings = $this->subject->getSettings();
        $this->assertArrayHasKey('usernames', $settings);
    }

    /**
     * @return void
     */
    private function setGlobalState()
    {
        $params = ['usernames' => 'username', 'host' => 'host', 'path_to_private_key_file' => 'private'];
        $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['bzga_beratungsstellensuche_export'] = serialize($params);
    }

}
