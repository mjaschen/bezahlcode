<?php

namespace MarcusJaschen\BezahlCode\Type;

class TransferTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \MarcusJaschen\Bezahlcode\Type\Transfer
     */
    protected $bezahlCode;

    public function setUp()
    {
        $this->bezahlCode = new Transfer();
    }

    public function tearDown()
    {
        unset($this->bezahlCode);
    }

    /**
     *
     */
    public function testSetParamWorksAsExpected()
    {
        $name = 'Marcus Jaschen';

        $this->bezahlCode->setParam('name', $name);

        $this->assertEquals($name, $this->bezahlCode->getParam('name'));
    }

    /**
     *
     */
    public function testSetQrSettingWorksAsExpected()
    {
        $this->bezahlCode->setQrSetting('level', 'H');
        $this->assertEquals('H', $this->bezahlCode->getQrSetting('level'));
    }

    /**
     *
     */
    public function testGetBezahlCodeURIWorksAsExpected()
    {
        $this->bezahlCode->setTransferData(
            'Marcus Jaschen',
            "1234567890",
            "10050000",
            99.99,
            "Test Transfer"
        );

        $expected = "bank://singlepayment?name=Marcus%20Jaschen&account=1234567890&bnc=10050000&amount=99%2C99&reason=Test%20Transfer";

        $this->assertEquals($expected, $this->bezahlCode->getBezahlCodeURI());
    }

    /**
     * @expectedException \MarcusJaschen\BezahlCode\Type\Exception\InvalidParameterException
     */
    public function testSetParamThrowsExceptionAsExpected()
    {
        $this->bezahlCode->setParam('notExistingParameter', true);
    }

    /**
     * @expectedException \MarcusJaschen\BezahlCode\Type\Exception\InvalidParameterException
     */
    public function testGetParamThrowsExceptionAsExpected()
    {
        $this->bezahlCode->getParam('notExistingParameter');
    }

    /**
     * @expectedException \MarcusJaschen\BezahlCode\Type\Exception\InvalidQRCodeParameterException
     */
    public function testSetQRCodeParamThrowsExceptionAsExpected()
    {
        $this->bezahlCode->setQrSetting('notExistingQRCodeParameter', true);
    }

    /**
     * @expectedException \MarcusJaschen\BezahlCode\Type\Exception\InvalidQRCodeParameterException
     */
    public function testGetQRCodeParamThrowsExceptionAsExpected()
    {
        $this->bezahlCode->getQrSetting('notExistingQRCodeParameter');
    }
}