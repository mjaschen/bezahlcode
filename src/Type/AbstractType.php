<?php
declare(strict_types=1);

namespace MarcusJaschen\BezahlCode\Type;

use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\QrCode;
use MarcusJaschen\BezahlCode\Type\Exception\InvalidParameterException;
use MarcusJaschen\BezahlCode\Type\Exception\InvalidQRCodeParameterException;

/**
 * Abstract BezahlCode Type Class
 *
 * @author Marcus Jaschen <mail@marcusjaschen.de>
 */
abstract class AbstractType
{
    /**
     * @var array
     */
    protected $qrSettings = [
        'level' => ErrorCorrectionLevel::LOW,
        'size' => 300,
        'margin' => 10,
    ];

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
    protected $params = [];

    /**
     * Sets a query parameter
     *
     * @param string $param
     * @param mixed $value
     *
     * @throws \InvalidArgumentException
     */
    public function setParam($param, $value): void
    {
        if (!array_key_exists($param, $this->params)) {
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
        if (!array_key_exists($param, $this->params)) {
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
    public function setQrSetting($param, $value): void
    {
        if (!array_key_exists($param, $this->qrSettings)) {
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
        if (!array_key_exists($param, $this->qrSettings)) {
            throw new InvalidQRCodeParameterException("Param {$param} not exist");
        }

        return $this->qrSettings[$param];
    }

    /**
     * Creates URI from transfer data
     *
     * @return string
     */
    public function getBezahlCodeURI(): string
    {
        $data = [];

        foreach ($this->params as $key => $value) {
            if (null !== $value) {
                $data[$key] = $value;
            }
        }

        return sprintf(
            '%s://%s?%s',
            $this->scheme,
            $this->authority,
            str_replace('+', '%20', http_build_query($data, '', '&'))
        );
    }

    /**
     * Saves the BezahlCode QR-Code as PNG image
     *
     * @param string $file
     */
    public function saveBezahlCode($file): void
    {
        $qrCode = new QRcode($this->getBezahlCodeURI());
        $qrCode->setErrorCorrectionLevel(new ErrorCorrectionLevel($this->qrSettings['level']));
        $qrCode->setSize($this->qrSettings['size']);
        $qrCode->setMargin($this->qrSettings['margin']);
        $qrCode->setWriterByName('png');
        $qrCode->writeFile($file);
    }

    /**
     * Returns the BezahlCode QR-Code as PNG image data.
     *
     * @return string Binary PNG image data
     */
    public function getBezahlCode(): string
    {
        $qrCode = new QRcode($this->getBezahlCodeURI());
        $qrCode->setErrorCorrectionLevel(new ErrorCorrectionLevel($this->qrSettings['level']));
        $qrCode->setSize($this->qrSettings['size']);
        $qrCode->setMargin($this->qrSettings['margin']);
        $qrCode->setWriterByName('png');

        return $qrCode->writeString();
    }
}
