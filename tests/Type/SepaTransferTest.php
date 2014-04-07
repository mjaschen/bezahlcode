<?php

namespace MarcusJaschen\BezahlCode\Type;

class SepaTransferTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var SepaTransfer
     */
    protected $bezahlCode;

    public function setUp()
    {
        $this->bezahlCode = new SepaTransfer();
    }

    public function tearDown()
    {
        unset($this->bezahlCode);
    }

    /**
     *
     */
    public function testGetBezahlCodeURIWorksAsExpected()
    {
        $this->bezahlCode->setTransferData(
            'Marcus Jaschen',
            "DE12345678901234567890",
            "SPARDEFFXXX",
            99.99,
            "Test SEPA Transfer"
        );

        $expected = "bank://singlepaymentsepa?name=Marcus%20Jaschen&iban=DE12345678901234567890&bic=SPARDEFFXXX&amount=99%2C99&reason=Test%20SEPA%20Transfer";

        $this->assertEquals($expected, $this->bezahlCode->getBezahlCodeURI());
    }
}