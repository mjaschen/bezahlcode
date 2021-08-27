<?php

declare(strict_types=1);

namespace MarcusJaschen\BezahlCode\Type;

class SepaTransfer extends AbstractType
{
    /**
     * @var array<string, string>
     */
    protected $params = [
        'name' => null,
        'iban' => null,
        'bic' => null,
        'amount' => null,
        'reason' => null,
        'reason1' => null,
        'reason2' => null,
        'reason3' => null,
        'reason4' => null,
        'reason5' => null,
        'reason6' => null,
        'reason7' => null,
        'reason8' => null,
        'reason9' => null,
        'reason10' => null,
        'reason11' => null,
        'reason12' => null,
        'reason13' => null,
        'reason14' => null,
        'reason15' => null,
        'currency' => null,
        'executiondate' => null,
        'separeference' => null,
    ];

    public function __construct()
    {
        parent::__construct();

        $this->authority = 'singlepaymentsepa';
    }

    /**
     * Shortcut method to set basic transfer options at once.
     *
     * @todo use Money class instead of float for amount.
     */
    public function setTransferData(string $name, string $iban, string $bic, float $amount, string $reason): void
    {
        $this->setParam('name', trim($name));
        $this->setParam('iban', trim($iban));
        $this->setParam('bic', trim($bic));
        $this->setParam('amount', number_format($amount, 2, ',', ''));
        $this->setParam('reason', trim($reason));
    }
}
