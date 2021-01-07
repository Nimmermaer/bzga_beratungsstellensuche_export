<?php

/*
 * This file is part of the "bzga_beratungsstellensuche_export" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Bzga\BzgaBeratungsstellensucheExport\Tests\Unit\Service;

use Bzga\BzgaBeratungsstellensucheExport\Exception\AccessDeniedException;
use Bzga\BzgaBeratungsstellensucheExport\Service\ConnectionService;
use phpseclib\Crypt\RSA;
use phpseclib\Net\SFTP;
use PHPUnit\Framework\MockObject\MockObject;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class ConnectionServiceTest extends UnitTestCase
{

    /**
     * @var ConnectionService
     */
    protected $subject;

    /**
     * @var MockObject|SFTP
     */
    protected $sftp;

    /**
     * @var MockObject|RSA
     */
    protected $rsa;

    protected function setUp(): void
    {
        $this->rsa = $this->getMockBuilder(RSA::class)->getMock();
        $this->sftp = $this->getMockBuilder(SFTP::class)->disableOriginalConstructor()->getMock();
        $this->subject = new ConnectionService($this->rsa, $this->sftp, ['username', 'username']);
    }

    /**
     * @test
     */
    public function uploadAccessDeniedException(): void
    {
        $this->expectException(AccessDeniedException::class);
        $this->sftp->expects(self::exactly(2))->method('login')->willReturn(false);
        $this->subject->upload('some');
    }

    /**
     * @test
     */
    public function uploadSuccessful(): void
    {
        $this->sftp->expects(self::once())->method('login')->willReturn(true);
        $this->sftp->expects(self::once())->method('chdir');
        $this->sftp->expects(self::once())->method('put');
        $this->sftp->expects(self::once())->method('disconnect');
        $this->subject->upload('some');
    }
}
