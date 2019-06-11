<?php
namespace thoulah\fontawesome;

use yii\bootstrap4\Html;
use yii\helpers\ArrayHelper;

class IconComponent extends \yii\base\Component {
	protected $icon = [];

	public $config;
	public $default;

	public function __construct($config = []) {
		$this->default = new Options();

		if ($config)
			foreach (reset($config) as $key => $value)
				$this->default->$key = $value;

		parent::__construct($config);
	}

	public function name(string $name, ?string $style = null): self {
		$this->icon['name'] = $name;
		$this->icon['style'] = $style ?? $this->default->defaultStyle;
		return $this;
	}

	public function class(string $class): self {
		$this->icon['class'] = $class;
		return $this;
	}

	public function append(string $append): self {
		$this->icon['append'] = $append;
		return $this;
	}

	public function fill(string $fill): self {
		$this->icon['fill'] = $fill;
		return $this;
	}

	public function fixedWidth(bool $fixedWidth): self {
		$this->icon['fixedWidth'] = $fixedWidth;
		return $this;
	}

	public function groupSize(string $groupSize): self {
		$this->icon['groupSize'] = $groupSize;
		return $this;
	}

	public function height(int $height): self {
		$this->icon['height'] = $height;
		return $this;
	}

	public function title(string $title): self {
		$this->icon['title'] = $title;
		return $this;
	}

	public function show(): string {
		$options = new Options();
		$validationOutput = $options->validate($this->icon);

		$name = ArrayHelper::remove($this->icon, 'name');
		$style = ArrayHelper::remove($this->icon, 'style');

		$svg = new Svg();
		$svg->default = $this->default;
		$iconString = $svg->load("{$this->default->fontAwesomeFolder}/{$style}/{$name}.svg");
		$image = $svg->process($iconString, $this->icon);
		$this->icon = [];
		return $validationOutput.$image;
	}

	/*
	 *  Return the complete ActiveField inputTemplate
	 */
	public function activeFieldAddon(): string {
		$inputGroupClass = ['input-group'];
		$groupSize = ArrayHelper::remove($this->icon, 'groupSize', $this->default->defaultGroupSize);
		if ($groupSize)
			Html::addCssClass($inputGroupClass, "input-group-{$groupSize}");

		return Html::tag('div',
			(ArrayHelper::getValue($this->icon, 'append', $this->default->defaultAppend))
				? '{input}'.$this->activeFieldIcon()
				: $this->activeFieldIcon().'{input}'
		, ['class' => $inputGroupClass]);
	}

	/*
	 *  Return the partial ActiveField inputTemplate for manual use
	 */
	public function activeFieldIcon(): string {
		if (!isset($this->icon['fixedWidth']))
			ArrayHelper::setValue($this->icon, 'fixedWidth', true);

		$icon = Html::tag('div', $this->show(), ['class' => 'input-group-text']);
		$direction = (ArrayHelper::remove($this->icon, 'append', $this->default->defaultAppend)) ? 'append' : 'prepend';
		return Html::tag('div', $icon, ['class' => "input-group-{$direction}"]);
	}
}
