<?php
/**
 * BezahlCode Standing Order Type
 *
 * PHP version 5
 *
 * @category  Bezahlcode
 * @package   Type
 * @author    Marcus Jaschen <mail@marcusjaschen.de>
 * @copyright 2013 r03.org
 * @license   http://www.opensource.org/licenses/mit-license MIT License
 * @link      http://r03.org/
 */

namespace MarcusJaschen\BezahlCode\Type;

/**
 * BezahlCode Standing Order Type
 *
 * @category Bezahlcode
 * @package  Type
 * @author   Marcus Jaschen <mail@marcusjaschen.de>
 * @license  http://www.opensource.org/licenses/mit-license MIT License
 * @link     http://r03.org/
 */
class PeriodicTransfer extends AbstractType
{
    /**
     * @var array
     */
    protected $params = array(
        'name'                       => null,
        'account'                    => null,
        'bnc'                        => null,
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
        'postingkey'                 => null,
        'postingkeyextension'        => null,
        'currency'                   => null,
        'executiondate'              => null,
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
        $this->authority = 'periodicsinglepayment';
    }

    /**
     * Shortcut method to set basic transfer options at once
     *
     * @param string $name Account Owner
     * @param int $account
     * @param int $bnc
     * @param float $amount
     * @param string $reason
     */
    public function setTransferData($name, $account, $bnc, $amount, $reason)
    {
        $this->setParam('name', trim($name));
        $this->setParam('account', trim($account));
        $this->setParam('bnc', trim($bnc));
        $this->setParam('amount', number_format($amount, 2, ',', ''));
        $this->setParam('reason', trim($reason));
    }
}