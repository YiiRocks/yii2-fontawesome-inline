<?php
namespace thoulah\fontawesome\bootstrap4;

use Yii;
use thoulah\fontawesome\{Icon, IconComponent, Options};
use yii\helpers\ArrayHelper;

class ActiveField extends \yii\bootstrap4\ActiveField {
	public $icon;

	public function __construct($config = []) {
		parent::__construct($config);

		$options = new Options();
		$options->validate($this->icon);
		$this->setInputTemplate();
	}

	private function setInputTemplate(): void {
		if (empty($this->icon))
			return;
		$iconName = (is_string($this->icon)) ? $this->icon : (string) ArrayHelper::remove($this->icon, 'name');

		if (isset(Yii::$app->fontawesome) && Yii::$app->fontawesome instanceof IconComponent) :
			$iconStyle = ArrayHelper::remove($this->icon, 'style');
			$icon = Yii::$app->fontawesome->name($iconName, $iconStyle);

			foreach (['append', 'class', 'fill', 'fixedWidth', 'groupSize', 'height', 'title'] as $property) :
				$prop = ArrayHelper::remove($this->icon, $property);
				if ($prop !== null)
					$icon->$property($prop);
			endforeach;

			$this->inputTemplate = $icon->activeFieldAddon();
			return;
		endif;

		$icon = new Icon();
		$this->inputTemplate = (is_string($this->icon)) ? $icon->activeFieldAddon($iconName) : $icon->activeFieldAddon($iconName, $this->icon);
	}
}
