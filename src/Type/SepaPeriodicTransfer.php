<?php
declare(strict_types=1);

namespace MarcusJaschen\BezahlCode\Type;

/**
 * BezahlCode SEPA Standing Order Type.
 *
 * @author Marcus Jaschen <mail@marcusjaschen.de>
 */
class SepaPeriodicTransfer extends AbstractType
{
    /**
     * @var array
     */
    protected $params = array(
        'name'                       => null,
        'iban'                       => null,
        'bic'                        => null,
        'amount'                     => null,
        'reason'                     => null,
        'reason1'                    => null,
        'reason2'                    => null,
        'reason3'                    => null,
        'reason4'                    => null,
        'reason5'                    => null,
        'reason6'                    => null,
        'reason7'                    => null,
        'reason8'                    => null,
        'reason9'                    => null,
        'reason10'                   => null,
        'reason11'                   => null,
        'reason12'                   => null,
        'reason13'                   => null,
        'reason14'                   => null,
        'reason15'                   => null,
        'currency'                   => null,
        'executiondate'              => null,
        'separeference'              => null,
        'periodictimeunit'           => null,
        'periodictimeunitrotation'   => null,
        'periodicfirstexecutiondate' => null,
        'periodiclastexecutiondate'  => null,
    );

    /**
     *
     */
    public function __construct()
    {
        $this->authority = 'periodicsinglepaymentsepa';
    }

    /**
     * Shortcut method to set basic transfer options at once
     *
     * @param string $name Account Owner
     * @param string $iban
     * @param string $bic
     * @param float $amount
     * @param string $reason
     */
    public function setTransferData($name, $iban, $bic, $amount, $reason)
    {
        $this->setParam('name', trim($name));
        $this->setParam('iban', trim($iban));
        $this->setParam('bic', trim($bic));
        $this->setParam('amount', number_format($amount, 2, ',', ''));
        $this->setParam('reason', trim($reason));
    }
}
