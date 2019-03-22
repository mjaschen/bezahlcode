<?php

namespace MarcusJaschen\BezahlCode\Type;

use PHPUnit\Framework\TestCase;

class TransferTest extends TestCase
{
    /**
     * @var Transfer
     */
    protected $bezahlCode;

    protected function setUp()
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

    /**
     * @expectedException \MarcusJaschen\BezahlCode\Type\Exception\InvalidParameterException
     */
    public function testSetParamThrowsExceptionAsExpected(): void
    {
        $this->bezahlCode->setParam('notExistingParameter', true);
    }

    /**
     * @expectedException \MarcusJaschen\BezahlCode\Type\Exception\InvalidParameterException
     */
    public function testGetParamThrowsExceptionAsExpected(): void
    {
        $this->bezahlCode->getParam('notExistingParameter');
    }

    /**
     * @expectedException \MarcusJaschen\BezahlCode\Type\Exception\InvalidQRCodeParameterException
     */
    public function testSetQRCodeParamThrowsExceptionAsExpected(): void
    {
        $this->bezahlCode->setQrSetting('notExistingQRCodeParameter', true);
    }

    /**
     * @expectedException \MarcusJaschen\BezahlCode\Type\Exception\InvalidQRCodeParameterException
     */
    public function testGetQRCodeParamThrowsExceptionAsExpected(): void
    {
        $this->bezahlCode->getQrSetting('notExistingQRCodeParameter');
    }
}
