<?php
/**
 * Abstract BezahlCode Type Class
 *
 * PHP version 5.3
 *
 * @category  BezahlCode
 * @package   Type
 * @author    Marcus Jaschen <mail@marcusjaschen.de>
 * @copyright 1999-2013 MTB-News.de
 * @license   http://www.opensource.org/licenses/mit-license MIT License
 * @link      http://www.mtb-news.de/
 */

namespace MarcusJaschen\BezahlCode\Type;

use MarcusJaschen\BezahlCode\Type\Exception\InvalidParameterException;
use MarcusJaschen\BezahlCode\Type\Exception\InvalidQRCodeParameterException;
use PHPQRCode\QRcode;

/**
 * Abstract BezahlCode Type Class
 *
 * @category BezahlCode
 * @package  Type
 * @author   Marcus Jaschen <mail@marcusjaschen.de>
 * @license  http://www.opensource.org/licenses/mit-license MIT License
 * @link     http://www.mtb-news.de/
 */
abstract class AbstractType
{
    /**
     * @var array
     */
    protected $qrSettings = array(
        'level'  => 'L',
        'size'   => 4,
        'margin' => 4,
    );

    /**
     * @var string
     */
    protected $scheme = 'bank';

    /**
     * @var string
     */
    protected $authority;

    /**
     * @var array
     */
    protected $params = array();

    /**
     * Sets a query parameter
     *
     * @param string $param
     * @param mixed $value
     *
     * @throws \InvalidArgumentException
     */
    public function setParam($param, $value)
    {
        if (! array_key_exists($param, $this->params)) {
            throw new InvalidParameterException("Param {$param} not exist");
        }

        $this->params[$param] = $value;
    }

    /**
     * Returns a query parameter
     *
     * @param string $param
     *
     * @return mixed
     *
     * @throws \InvalidArgumentException
     */
    public function getParam($param)
    {
        if (! array_key_exists($param, $this->params)) {
            throw new InvalidParameterException("Param {$param} not exist");
        }

        return $this->params[$param];
    }

    /**
     * Change a QR code setting
     *
     * Supported settings:
     *
     * - `level` (default: "L")
     * - `size` (default "4")
     * - `margin` (default "4")
     *
     * @param string $param
     * @param mixed $value
     *
     * @throws \InvalidArgumentException
     */
    public function setQrSetting($param, $value)
    {
        if (! array_key_exists($param, $this->qrSettings)) {
            throw new InvalidQRCodeParameterException("Param {$param} not exist");
        }

        $this->qrSettings[$param] = $value;
    }

    /**
     * Returns a QR code setting
     *
     * @param string $param
     *
     * @return mixed
     *
     * @throws \InvalidArgumentException
     */
    public function getQrSetting($param)
    {
        if (! array_key_exists($param, $this->qrSettings)) {
            throw new InvalidQRCodeParameterException("Param {$param} not exist");
        }

        return $this->qrSettings[$param];
    }

    /**
     * Creates URI from transfer data
     *
     * @return string
     */
    public function getBezahlCodeURI()
    {
        $data = array();

        foreach ($this->params as $key => $value) {
            if (! is_null($value)) {
                $data[$key] = $value;
            }
        }

        return sprintf("%s://%s?%s", $this->scheme, $this->authority, str_replace('+', '%20', http_build_query($data, '', '&')));
    }

    /**
     * Saves the BezahlCode QR-Code as PNG image
     *
     * @param string $file
     */
    public function saveBezahlCode($file)
    {
        QRcode::png($this->getBezahlCodeURI(), $file, $this->qrSettings['level'], $this->qrSettings['size'], $this->qrSettings['margin'], false);
    }

    /**
     * Returns the BezahlCode QR-Code as PNG image data.
     *
     * @return string Binary PNG image data
     */
    public function getBezahlCode()
    {
        ob_start();
        QRcode::png($this->getBezahlCodeURI(), false, $this->qrSettings['level'], $this->qrSettings['size'], $this->qrSettings['margin'], false);
        return ob_get_clean();
    }

}
