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
    public function testSuccessfulSetParam()
    {
        $name = 'Marcus Jaschen';

        $this->bezahlCode->setParam('name', $name);

        $this->assertEquals($name, $this->bezahlCode->getParam('name'));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testFailSetParamInvalid()
    {
        $this->bezahlCode->setParam('invalid_param_name', 'x');
    }

    public function testSuccessfulSetQrSetting()
    {
        $this->bezahlCode->setQrSetting('level', 'H');
        $this->assertEquals('H', $this->bezahlCode->getQrSetting('level'));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testFailSetInvalidQrSetting()
    {
        $this->bezahlCode->setQrSetting('invalid_param_name', 'x');
    }

    /**
     *
     */
    public function testGetBezahlCodeURI()
    {
        $this->bezahlCode->setTransferData(
            'Marcus Jaschen',
            "1234567890",
            "10050000",
            99.99,
            "Test Transfer"
        );

        $expected = "bank://singlepayment?name=Marcus+Jaschen&account=1234567890&bnc=10050000&amount=99%2C99&reason=Test+Transfer";

        $this->assertEquals($expected, $this->bezahlCode->getBezahlCodeURI());
    }
}