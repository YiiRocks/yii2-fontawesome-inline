<?php
namespace thoulah\fontawesome\bootstrap4;

use Yii;
use thoulah\fontawesome\{Icon, IconComponent, Options};
use yii\helpers\ArrayHelper;

class ActiveField extends \yii\bootstrap4\ActiveField {
	public $icon;

	public function __construct($config = []) {
		$options = new Options();
		$options->validateOptions($this->icon);

#		$this->template = (ArrayHelper::getValue($this->icon, 'append'))
#			? "{label}\n{icon}\n{input}\n{hint}\n{error}"
#			: "{label}\n{input}\n{icon}\n{hint}\n{error}";

#		$this->setInputTemplate();
		parent::__construct($config);
	}

	public function render($content = null) {
		if (!empty($this->icon)) :
			$groupSize = ArrayHelper::remove($this->icon, 'groupSize');
			$append = ArrayHelper::getValue($this->icon, 'append');

			$template = str_replace('{icon}', Html::activeFieldIcon($append), Html::activeFieldAddon($groupSize, $append));
			$this->inputTemplate = str_replace('{icon}', $this->getIcon(), $template);
		endif;

		return parent::render($content);
	}

	private function getIcon(): string {
		$iconName = (is_string($this->icon)) ? $this->icon : (string) ArrayHelper::remove($this->icon, 'name');

		if (isset(Yii::$app->fontawesome) && Yii::$app->fontawesome instanceof IconComponent) :
			$iconStyle = ArrayHelper::remove($this->icon, 'style');
			$icon = Yii::$app->fontawesome->name($iconName, $iconStyle);

			$fixedWidth = ArrayHelper::remove($this->icon, 'fixedWidth', $icon->defaults->activeFormFixedWidth);
			$icon->fixedWidth($fixedWidth);
			foreach (['append', 'class', 'fill', 'height', 'title'] as $property) :
				$prop = ArrayHelper::remove($this->icon, $property);
				if ($prop !== null)
					$icon->$property($prop);
			endforeach;

			return $icon;
		endif;

		$icon = new Icon();
		return (is_string($this->icon)) ? $icon->activeFieldAddon($iconName) : $icon->activeFieldAddon($iconName, $this->icon);
	}
}
