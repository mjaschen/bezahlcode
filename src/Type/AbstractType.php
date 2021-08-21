<?php
declare(strict_types=1);

namespace MarcusJaschen\BezahlCode\Type;

use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\EpsWriter;
use Endroid\QrCode\Writer\PdfWriter;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Writer\SvgWriter;
use Endroid\QrCode\Writer\WriterInterface;
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
    protected $qrSettings;

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

    public function __construct()
    {
        $this->qrSettings  = [
            'level' => new ErrorCorrectionLevelLow(),
            'size' => 300,
            'margin' => 10,
            'foreground' => new Color(0, 0, 0),
            'background' => new Color(255, 255, 255),
        ];
    }

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

    protected function generateBezahlCode(): QrCode
    {
        return QrCode::create($this->getBezahlCodeURI())
            ->setEncoding(new Encoding('UTF-8'))
            ->setErrorCorrectionLevel($this->qrSettings['level'])
            ->setSize($this->qrSettings['size'])
            ->setMargin($this->qrSettings['margin'])
            ->setRoundBlockSizeMode(new RoundBlockSizeModeMargin())
            ->setForegroundColor($this->qrSettings['foreground'])
            ->setBackgroundColor($this->qrSettings['background']);
    }

    protected function getWriter($type): WriterInterface
    {
        switch (strtolower($type)) {
            case 'png':
                return new PngWriter();
            case 'eps':
                return new EpsWriter();
            case 'pdf':
                return new PdfWriter();
            case 'svg':
                return new SvgWriter();
            default:
                throw new \InvalidArgumentException("Writer {$type} does not exist");
        }
    }

    /**
     * Saves the BezahlCode QR-Code as PNG image
     *
     * @param string $file
     */
    public function saveBezahlCode($file, $type = 'png'): void
    {
        ($this->getWriter($type))->write($this->generateBezahlCode())->saveToFile($file);
    }

    /**
     * Returns the BezahlCode QR-Code as PNG image data.
     *
     * @return string Binary PNG image data
     */
    public function getBezahlCode($type = 'png'): string
    {
        return ($this->getWriter($type))->write($this->generateBezahlCode())->getString();
    }
}
