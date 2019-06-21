<?php
/**
 *  @link https://thoulah.mr42.me/fontawesome
 *  @license https://github.com/Thoulah/yii2-fontawesome-inline/blob/master/LICENSE
 */

namespace thoulah\fontawesome\bootstrap4;

/**
 * {@inheritdoc}
 */
class Html extends \yii\bootstrap4\Html {
	/**
	 *  Returns the ActiveField inputTemplate.
	 */
	public static function activeFieldAddon(?string $groupSize, ?bool $append): string {
		$inputGroupClass = ['input-group'];
		if ($groupSize !== null && $groupSize !== 'md') {
			static::addCssClass($inputGroupClass, "input-group-{$groupSize}");
		}

		return static::tag('div', ($append) ? '{input}{icon}' : '{icon}{input}', ['class' => $inputGroupClass]);
	}

	/**
	 *  Returns the partial ActiveField Icon.
	 */
	public static function activeFieldIcon(?bool $append): string {
		$direction = ($append) ? 'append' : 'prepend';
		$icon = static::tag('div', '{icon}', ['class' => 'input-group-text']);
		return static::tag('div', $icon, ['class' => "input-group-{$direction}"]);
	}
}
