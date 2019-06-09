<?php
namespace Thoulah\FontAwesomeInline;

use DOMDocument;
use Yii;
use yii\bootstrap4\Html;
use yii\helpers\ArrayHelper;

class Icon extends \yii\bootstrap4\Widget {
	public $fallbackIcon = '@bower/fontawesome/svgs/solid/question-circle.svg';
	public $prefix = 'svg-inline--fa';

    public function __construct()
    {
        FontAwesomeAsset::register($this->getView());
    }

	public function show(string $name, array $options = []): string
	{
		$style = ArrayHelper::remove($options, 'style', 'solid');
		$svg = $this->loadSvg("@bower/fontawesome/svgs/{$style}/{$name}.svg");
		return $this->processSvg($svg, $options);
	}

	protected function loadSvg(string $fileName): DOMDocument {
		if (!file_exists(Yii::getAlias($fileName)))
			$fileName = $this->fallbackIcon;

		$doc = new DOMDocument();
		$doc->load(Yii::getAlias($fileName));
		return $doc;
	}

	protected function processSvg(DOMDocument $doc, array $options): string
	{
		ArrayHelper::setValue($options, 'aria-hidden', 'true');
		ArrayHelper::setValue($options, 'role', 'img');

		$svg = $doc->getElementsByTagName('svg')->item(0);
		if ($title = ArrayHelper::remove($options, 'title'))
			$svg->appendChild($doc->createElement('title', $title));
		[,, $svgWidth, $svgHeight] = explode(' ', $svg->getAttribute('viewBox'));
		switch ($height = ArrayHelper::getValue($options, 'height', 0)) :
			case 0:
				Html::addCssClass($options, $this->prefix);
				Html::addCssClass($options, $this->prefix.'-w-'.ceil($svgWidth / $svgHeight * 16));
				break;
			default:
				ArrayHelper::setValue($options, 'width', round($height * $svgWidth / $svgHeight));
		endswitch;

		if (ArrayHelper::remove($options, 'target', 'web') !== 'pdf')
			foreach ($doc->getElementsByTagName('path') as $path)
				$path->setAttribute('fill', 'currentColor');

		foreach ($options as $key => $value)
			$svg->setAttribute($key, $value);
		return $doc->saveXML($svg);
	}
}
