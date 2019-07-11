<?php
namespace thoulah\fontawesome\helpers;

use DOMElement;

/**
 * SVG helper
 */
class Svg
{
    /** @var DOMElement SVG */
    private $_svgElement;

    /**
     * Construct.
     *
     * @param DOMElement $svg
     */
    public function __construct(DOMElement $svgElement)
    {
        $this->_svgElement = $svgElement;
    }

    /**
     * Determines size of the SVG element
     *
     * @return array Width & height
     */
    public function getSize(): array
    {
        $width = $this->getPixelValue($this->_svgElement->getAttribute('width'));
        $height = $this->getPixelValue($this->_svgElement->getAttribute('height'));

        [$xStart, $yStart, $xEnd, $yEnd] = explode(' ', $this->_svgElement->getAttribute('viewBox') ?: '');
        $viewBoxWidth = isset($xStart, $xEnd) ? $xEnd - $xStart : 0;
        $viewBoxHeight = isset($yStart, $yEnd) ? $yEnd - $yStart : 0;

        if ($viewBoxWidth > 0 && $viewBoxHeight > 0) {
            return [$viewBoxWidth, $viewBoxHeight];
        } elseif ($width && $height) {
            return [$width, $height];
        } elseif ($width) {
            return [$width, round($width * $viewBoxHeight / $viewBoxWidth)];
        } elseif ($height) {
            return [round($height * $viewBoxWidth / $viewBoxHeight), $height];
        }

        return [1, 1];
    }

    /**
     * Converts various sizes to pixels.
     *
     * @param string $size
     * @return int
     */
    private function getPixelValue(string $size): int
    {
        $map = [
            'px' => 1,
            'em' => 16,
            'ex' => 16 / 2,
            'pt' => 16 / 12,
            'pc' => 16,
            'in' => 16 * 6,
            'cm' => 16 / (2.54 / 6),
            'mm' => 16 / (25.4 / 6),
        ];

        $size = trim($size);
        $value = substr($size, 0, -2);
        $unit = substr($size, -2);

        if (is_numeric($value) && isset($map[$unit])) {
            $size = $value * $map[$unit];
        }

        return (int) round($size);
    }
}
