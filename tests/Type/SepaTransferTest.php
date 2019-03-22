<?php

namespace MarcusJaschen\BezahlCode\Type;

use PHPUnit\Framework\TestCase;

class SepaTransferTest extends TestCase
{
    /**
     * @var SepaTransfer
     */
    protected $bezahlCode;

    protected function setUp()
    {
        $this->bezahlCode = new SepaTransfer();
    }

    /**
     *
     */
    public function testGetBezahlCodeURIWorksAsExpected(): void
    {
        $this->bezahlCode->setTransferData(
            'Marcus Jaschen',
            'DE12345678901234567890',
            'SPARDEFFXXX',
            99.99,
            'Test SEPA Transfer'
        );

        $expected = 'bank://singlepaymentsepa?name=Marcus%20Jaschen&iban=DE12345678901234567890';
        $expected .= '&bic=SPARDEFFXXX&amount=99%2C99&reason=Test%20SEPA%20Transfer';

        self::assertEquals($expected, $this->bezahlCode->getBezahlCodeURI());
    }
}
