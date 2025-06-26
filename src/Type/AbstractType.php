<?php

declare(strict_types=1);

namespace MarcusJaschen\BezahlCode\Type;

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Builder\BuilderInterface;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\RoundBlockSizeMode;
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
     * @var array{level: ErrorCorrectionLevel, size: int, margin: int, foreground: Color, background: Color}
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
            'level' => ErrorCorrectionLevel::Low,
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
     * @param int|Color|ErrorCorrectionLevel $value
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
     * @return int|Color|ErrorCorrectionLevel
     *
     * @throws InvalidQRCodeParameterException
     */
    public function getQrSetting(string $param): int|ErrorCorrectionLevel|Color
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
        $data = array_filter($this->params, fn($value) => $value !== null);

        return sprintf(
            '%s://%s?%s',
            $this->scheme,
            $this->authority,
            str_replace('+', '%20', http_build_query($data, '', '&'))
        );
    }

    public function saveBezahlCode(string $file, string $type = 'png'): void
    {
        $this->generateBezahlCode($this->getWriter($type))->build()->saveToFile($file);
    }

    public function getBezahlCode(string $type = 'png'): string
    {
        return $this->generateBezahlCode($this->getWriter($type))->build()->getString();
    }

    protected function generateBezahlCode(WriterInterface $writer): BuilderInterface
    {
        return new Builder(
            writer: $writer,
            encoding: new Encoding('UTF-8'),
            errorCorrectionLevel: $this->qrSettings['level'],
            size: $this->qrSettings['size'],
            margin: $this->qrSettings['margin'],
            roundBlockSizeMode: RoundBlockSizeMode::Margin,
            foregroundColor: $this->qrSettings['foreground'],
            backgroundColor: $this->qrSettings['background'],
        );
    }

    protected function getWriter(string $type): WriterInterface
    {
        return match (strtolower($type)) {
            'png' => new PngWriter(),
            'eps' => new EpsWriter(),
            'pdf' => new PdfWriter(),
            'svg' => new SvgWriter(),
            default => throw new \InvalidArgumentException("Writer {$type} does not exist"),
        };
    }
}
