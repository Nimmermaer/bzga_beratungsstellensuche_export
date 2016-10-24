<?php


namespace BZgA\BzgaBeratungsstellensucheExport\Tests\Unit\Service;

use BZgA\BzgaBeratungsstellensucheExport\Service\ConnectionService;
use phpseclib\Crypt\RSA;
use phpseclib\Net\SFTP;

class ConnectionServiceTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var ConnectionService
     */
    private $subject;

    /**
     * @var SFTP|\PHPUnit_Framework_MockObject_MockObject
     */
    private $sftp;

    /**
     * @var RSA|\PHPUnit_Framework_MockObject_MockObject
     */
    private $rsa;

    /**
     * @return void
     */
    protected function setUp()
    {
        $this->rsa = $this->getMock(RSA::class);
        $this->sftp = $this->getMock(SFTP::class, array(), array(), '', false);
        $this->subject = new ConnectionService($this->rsa, $this->sftp, array('username', 'username'));
    }

    /**
     * @test
     * @expectedException \BZgA\BzgaBeratungsstellensucheExport\Exception\AccessDeniedException
     */
    public function uploadAccessDeniedException()
    {
        $this->sftp->expects($this->exactly(2))->method('login')->willReturn(false);
        $this->subject->upload('some');
    }

    /**
     * @test
     */
    public function uploadSuccessful()
    {
        $this->sftp->expects($this->once())->method('login')->willReturn(true);
        $this->sftp->expects($this->once())->method('chdir');
        $this->sftp->expects($this->once())->method('put');
        $this->sftp->expects($this->once())->method('disconnect');
        $this->subject->upload('some');


    }

}
