<?php

namespace MarcusJaschen\BezahlCode\Type;

use MarcusJaschen\BezahlCode\Type\Exception\InvalidParameterException;
use MarcusJaschen\BezahlCode\Type\Exception\InvalidQRCodeParameterException;
use PHPUnit\Framework\TestCase;

class TransferTest extends TestCase
{
    /**
     * @var Transfer
     */
    protected $bezahlCode;

    protected function setUp(): void
    {
        $this->bezahlCode = new Transfer();
    }

    /**
     *
     */
    public function testSetParamWorksAsExpected(): void
    {
        $name = 'Marcus Jaschen';

        $this->bezahlCode->setParam('name', $name);

        self::assertEquals($name, $this->bezahlCode->getParam('name'));
    }

    /**
     *
     */
    public function testSetQrSettingWorksAsExpected(): void
    {
        $this->bezahlCode->setQrSetting('level', 'H');
        self::assertEquals('H', $this->bezahlCode->getQrSetting('level'));
    }

    /**
     *
     */
    public function testGetBezahlCodeURIWorksAsExpected(): void
    {
        $this->bezahlCode->setTransferData(
            'Marcus Jaschen',
            '1234567890',
            '10050000',
            99.99,
            'Test Transfer'
        );

        $expected = 'bank://singlepayment?name=Marcus%20Jaschen&account=1234567890';
        $expected .= '&bnc=10050000&amount=99%2C99&reason=Test%20Transfer';

        self::assertEquals($expected, $this->bezahlCode->getBezahlCodeURI());
    }

    public function testSetParamThrowsExceptionAsExpected(): void
    {
        $this->expectException(InvalidParameterException::class);
        $this->bezahlCode->setParam('notExistingParameter', true);
    }

    public function testGetParamThrowsExceptionAsExpected(): void
    {
        $this->expectException(InvalidParameterException::class);
        $this->bezahlCode->getParam('notExistingParameter');
    }

    public function testSetQRCodeParamThrowsExceptionAsExpected(): void
    {
        $this->expectException(InvalidQRCodeParameterException::class);
        $this->bezahlCode->setQrSetting('notExistingQRCodeParameter', true);
    }

    public function testGetQRCodeParamThrowsExceptionAsExpected(): void
    {
        $this->expectException(InvalidQRCodeParameterException::class);
        $this->bezahlCode->getQrSetting('notExistingQRCodeParameter');
    }
}
