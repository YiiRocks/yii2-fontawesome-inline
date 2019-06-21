<?php
/**
 *  @link https://fontawesome.mr42.me/
 *  @license https://github.com/Thoulah/yii2-fontawesome-inline/blob/master/LICENSE
 */

namespace thoulah\fontawesome\bootstrap4;

use thoulah\fontawesome\{Icon, IconComponent, Options};
use Yii;
use yii\helpers\ArrayHelper;

/**
 * {@inheritdoc}
 */
class ActiveField extends \yii\bootstrap4\ActiveField {
	/**
	 * @var array per-icon settings
	 */
	public $icon;

	/**
	 * {@inheritdoc}
	 */
	public function __construct($config = []) {
		$options = new Options();
		$options->validateOptions($this->icon);
		parent::__construct($config);
	}

	/**
	 * {@inheritdoc}
	 */
	public function render($content = null) {
		if (!empty($this->icon)) {
			$groupSize = ArrayHelper::remove($this->icon, 'groupSize');
			$append = ArrayHelper::getValue($this->icon, 'append');

			$fieldAddon = Html::activeFieldAddon($groupSize, $append);
			$fieldIcon = Html::activeFieldIcon($append);
			$inputTemplate = str_replace('{icon}', $fieldIcon, $fieldAddon);
			$this->inputTemplate = str_replace('{icon}', $this->getIcon(), $inputTemplate);
		}

		return parent::render($content);
	}

	private function getIcon(): string {
		$iconName = (is_string($this->icon))
			? $this->icon
			: (string) ArrayHelper::remove($this->icon, 'name');

		if (isset(Yii::$app->fontawesome) && Yii::$app->fontawesome instanceof IconComponent) {
			$iconStyle = ArrayHelper::remove($this->icon, 'style');
			$icon = Yii::$app->fontawesome->name($iconName, $iconStyle);

			$fixedWidth = ArrayHelper::remove($this->icon, 'fixedWidth', $icon->defaults->activeFormFixedWidth);
			$icon->fixedWidth($fixedWidth);

			foreach (['append', 'class', 'fill', 'height', 'title'] as $property) {
				$prop = ArrayHelper::remove($this->icon, $property);
				if ($prop !== null) {
					$icon->$property($prop);
				}
			}

			return $icon;
		}

		$icon = new Icon();
		return (is_string($this->icon))
			? $icon->activeFieldAddon($iconName)
			: $icon->activeFieldAddon($iconName, $this->icon);
	}
}
