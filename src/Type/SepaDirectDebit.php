<?php
/**
 * BezahlCode SEPA Debit Type
 *
 * PHP version 5
 *
 * @category  BezahlCode
 * @package   Type
 * @author    Marcus Jaschen <mail@marcusjaschen.de>
 * @copyright 2013 r03.org
 * @license   http://www.opensource.org/licenses/mit-license MIT License
 * @link      http://r03.org/
 */

namespace MarcusJaschen\BezahlCode\Type;

/**
 * BezahlCode SEPA Debit Type
 *
 * @category BezahlCode
 * @package  Type
 * @author   Marcus Jaschen <mail@marcusjaschen.de>
 * @license  http://www.opensource.org/licenses/mit-license MIT License
 * @link     http://r03.org/
 */
class SepaDirectDebit extends AbstractType
{
    /**
     * @var array
     */
    protected $params = array(
        'name'            => null,
        'iban'            => null,
        'bic'             => null,
        'amount'          => null,
        'reason'          => null,
        'reason1'         => null,
        'reason2'         => null,
        'reason3'         => null,
        'reason4'         => null,
        'reason5'         => null,
        'reason6'         => null,
        'reason7'         => null,
        'reason8'         => null,
        'reason9'         => null,
        'reason10'        => null,
        'reason11'        => null,
        'reason12'        => null,
        'reason13'        => null,
        'reason14'        => null,
        'reason15'        => null,
        'currency'        => null,
        'executiondate'   => null,
        'separeference'   => null,
        'creditorid'      => null,
        'mandateid'       => null,
        'dateofsignature' => null,
    );

    /**
     *
     */
    public function __construct()
    {
        $this->authority = 'singledirectdebitsepa';
    }
}