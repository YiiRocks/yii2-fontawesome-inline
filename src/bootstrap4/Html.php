<?php
namespace thoulah\fontawesome\bootstrap4;

use thoulah\fontawesome\Options;
use yii\helpers\ArrayHelper;

class Html extends \yii\bootstrap4\Html {
	public static function activeFieldAddon(?string $groupSize, ?bool $append): string {
		$inputGroupClass = ['input-group'];
		if ($groupSize !== null && $groupSize !== 'md')
			static::addCssClass($inputGroupClass, "input-group-{$groupSize}");

		return static::tag('div', ($append) ? '{input}{icon}' : '{icon}{input}', ['class' => $inputGroupClass]);
	}

	public static function activeFieldIcon(?bool $append): string {
		$direction = ($append) ? 'append' : 'prepend';
		$icon = static::tag('div', '{icon}', ['class' => 'input-group-text']);
		return static::tag('div', $icon, ['class' => "input-group-{$direction}"]);
	}
}
