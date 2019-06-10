<?php
namespace Thoulah\FontAwesomeInline\bootstrap4;

use Yii;
use Thoulah\FontAwesomeInline\Icon;
use yii\base\InvalidConfigException;
use yii\helpers\{ArrayHelper, Inflector};

class ActiveField extends \yii\bootstrap4\ActiveField {
	private $validDirections = ['prepend', 'append'];
	private $validStyles = ['solid', 'regular', 'light', 'brands'];
	private $validGroupSizes = ['sm', 'lg'];
	public $icon;
	public $iconPrefix = 'svg-inline--fa';

	/*
	 * {@inheritdoc}
	 */
	public function __construct($config = []) {
		parent::__construct($config);

		$direction = ArrayHelper::getValue($this->icon, 'direction', 'prepend');
		if (!in_array($direction, $this->validDirections))
			throw new InvalidConfigException('The \'direction\' option can be either '.Inflector::sentence($this->validDirections, ' or ').'.');

		$groupsize = ArrayHelper::getValue($this->icon, 'groupsize', 'sm');
		if (!in_array($groupsize, $this->validGroupSizes))
			throw new InvalidConfigException('The \'groupsize\' option can be '.Inflector::sentence($this->validGroupSizes, ' or ').'.');

		$style = ArrayHelper::getValue($this->icon, 'style', 'solid');
		if (!in_array($style, $this->validStyles))
			throw new InvalidConfigException('The \'style\' option can be either '.Inflector::sentence($this->validStyles, ', or ').'.');

		$this->setInputTemplate();
	}

	public function setInputTemplate(): void {
		if (empty($this->icon))
			return;

		$icon = (isset(Yii::$app->icon) && Yii::$app->icon instanceof Icon) ? Yii::$app->icon : new Icon();

		if (!isset(Yii::$app->icon) || !Yii::$app->icon instanceof Icon)
			$icon->prefix = $this->iconPrefix;

		if (is_string($this->icon)) :
			$this->inputTemplate = $icon->activeFieldAddon($this->icon);
			return;
		endif;

		$iconName = ArrayHelper::remove($this->icon, 'name', 'question-circle');
		$this->inputTemplate = $icon->activeFieldAddon($iconName, $this->icon);
	}
}
