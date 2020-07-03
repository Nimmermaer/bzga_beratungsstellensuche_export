<?php


namespace Bzga\BzgaBeratungsstellensucheExport\Tests\Unit\Service;

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
        $this->sftp->expects($this->exactly(2))->method('login')->willReturn(false);
        $this->subject->upload('some');
    }

    /**
     * @test
     */
    public function uploadSuccessful(): void
    {
        $this->sftp->expects($this->once())->method('login')->willReturn(true);
        $this->sftp->expects($this->once())->method('chdir');
        $this->sftp->expects($this->once())->method('put');
        $this->sftp->expects($this->once())->method('disconnect');
        $this->subject->upload('some');
    }
}
