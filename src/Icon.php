<?php
namespace thoulah\fontawesome;

use yii\helpers\ArrayHelper;

class Icon extends \yii\web\View {
	public $defaults;

	/*
	 *	Construct
	 */
	public function __construct() {
		parent::__construct();
		$this->defaults = new Options();
		$this->registerAssetBundle(FontAwesomeAsset::class);
	}

	/*
	 *  Outputs the SVG string
	 */
	public function show(string $name, array $options = []): string {
		ArrayHelper::setValue($options, 'name', $name);

		$svg = new Svg($this->defaults);
		return $svg->getString($options);
	}

	/*
	 *  Return the complete ActiveField inputTemplate
	 */
	public function activeFieldAddon(string $name, array $options = []): string {
		$Html = __NAMESPACE__."\\{$this->defaults->bootstrap}\\Html";
		$groupSize = ArrayHelper::remove($options, 'groupSize', $this->defaults->groupSize);

		$append = ArrayHelper::getValue($options, 'append', $this->defaults->append);
		$icon = $Html::activeFieldAddon($groupSize, $append);
		return str_replace('{icon}', $this->activeFieldIcon($name, $options), $icon);
	}

	/*
	 *  Return the partial ActiveField inputTemplate for manual use
	 */
	public function activeFieldIcon(string $name, array $options = []): string {
		$Html = __NAMESPACE__."\\{$this->defaults->bootstrap}\\Html";
		if (!isset($options['fixedWidth']))
			ArrayHelper::setValue($options, 'fixedWidth', $this->defaults->activeFormFixedWidth);

		$append = ArrayHelper::remove($options, 'append', $this->defaults->append);
		$icon = $Html::activeFieldIcon($append);
		return str_replace('{icon}', $this->show($name, $options), $icon);
	}
}
