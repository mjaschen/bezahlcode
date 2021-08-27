<?php

declare(strict_types=1);

namespace MarcusJaschen\BezahlCode\Type;

class DirectDebit extends AbstractType
{
    /**
     * @var array<string, string>
     */
    protected $params = [
        'name' => null,
        'account' => null,
        'bnc' => null,
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
        'postingkey' => null,
        'postingkeyextension' => null,
        'currency' => null,
        'executiondate' => null,
    ];

    public function __construct()
    {
        parent::__construct();

        $this->authority = 'singledirectdebit';
    }
}
