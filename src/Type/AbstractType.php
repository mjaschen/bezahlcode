<?php

declare(strict_types=1);

namespace MarcusJaschen\BezahlCode\Type;

use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelInterface;
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

abstract class AbstractType
{
    /**
     * @var array{level: ErrorCorrectionLevelInterface, size: int, margin: int, foreground: Color, background: Color}
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
     * @var array<string, string>
     */
    protected $params = [];

    public function __construct()
    {
        $this->qrSettings = [
            'level' => new ErrorCorrectionLevelLow(),
            'size' => 300,
            'margin' => 10,
            'foreground' => new Color(0, 0, 0),
            'background' => new Color(255, 255, 255),
        ];
    }

    /**
     * Sets a Bezahlcode parameter.
     *
     * @throws InvalidParameterException
     */
    public function setParam(string $param, string $value): void
    {
        if (!array_key_exists($param, $this->params)) {
            throw new InvalidParameterException('Parameter unknown: ' . $param, 1402429834);
        }

        $this->params[$param] = $value;
    }

    /**
     * Returns a Bezahlcode parameter.
     *
     * @throws InvalidParameterException
     */
    public function getParam(string $param): string
    {
        if (!array_key_exists($param, $this->params)) {
            throw new InvalidParameterException('Parameter unknown: ' . $param, 5413113740);
        }

        return $this->params[$param];
    }

    /**
     * Change a QR code setting.
     *
     * Supported settings:
     *
     * - `level` (default: "L")
     * - `size` (default "4")
     * - `margin` (default "4")
     * - `foreground`
     * - `background`
     *
     * @param int|Color|ErrorCorrectionLevelInterface $value
     *
     * @throws InvalidQRCodeParameterException
     */
    public function setQrSetting(string $param, $value): void
    {
        if (!array_key_exists($param, $this->qrSettings)) {
            throw new InvalidQRCodeParameterException('Parameter unknown: ' . $param, 6699321536);
        }

        $this->qrSettings[$param] = $value;
    }

    /**
     * Returns a QR code setting.
     *
     * @return int|Color|ErrorCorrectionLevelInterface
     *
     * @throws InvalidQRCodeParameterException
     */
    public function getQrSetting(string $param)
    {
        if (!array_key_exists($param, $this->qrSettings)) {
            throw new InvalidQRCodeParameterException('Parameter unknown: ' . $param, 5444009391);
        }

        return $this->qrSettings[$param];
    }

    /**
     * Creates URI from transfer data.
     */
    public function getBezahlCodeURI(): string
    {
        $data = [];

        foreach ($this->params as $key => $value) {
            if ($value !== null) {
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

    public function saveBezahlCode(string $file, string $type = 'png'): void
    {
        $this->getWriter($type)->write($this->generateBezahlCode())->saveToFile($file);
    }

    public function getBezahlCode(string $type = 'png'): string
    {
        return $this->getWriter($type)->write($this->generateBezahlCode())->getString();
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

    protected function getWriter(string $type): WriterInterface
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
}
