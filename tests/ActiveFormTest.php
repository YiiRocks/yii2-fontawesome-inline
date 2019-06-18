<?php
namespace thoulah\fontawesome\tests;

use thoulah\fontawesome\bootstrap4\ActiveForm;
use yii\base\DynamicModel;

class ActiveFormTest extends tests {
	protected function setUp() {
		$_SERVER['REQUEST_URI'] = "index.php";
		parent::setUp();
	}

	public function testBasic() {
		ActiveForm::$counter = 0;
		ob_start();
		$model = new DynamicModel(['test']);
		$form = ActiveForm::begin();
			echo $form->field($model, 'test', [
				'icon' => 'user',
			]);
		ActiveForm::end();
		$out = ob_get_clean();

		$expected = <<<html
<div class="input-group"><div class="input-group-prepend"><div class="input-group-text"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" aria-hidden="true" role="img" class="svg-inline--fa svg-inline--fa-w-14 svg-inline--fa-fw"><path d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-74.2-60.2-134.4-134.4-134.4z" fill="currentColor"/></svg></div></div><input type="text" id="dynamicmodel-test" class="form-control" name="DynamicModel[test]"></div>
html;

		$this->assertContains($expected, $out);
	}

	public function testAppend() {
		ActiveForm::$counter = 0;
		ob_start();
		$model = new DynamicModel(['test']);
		$form = ActiveForm::begin();
			echo $form->field($model, 'test', [
				'icon' => [
					'name' => 'user',
					'append' => true,
				]
			]);
		ActiveForm::end();
		$out = ob_get_clean();

		$this->assertContains('<input type="text" id="dynamicmodel-test" class="form-control" name="DynamicModel[test]"><div class="input-group-append">', $out);
	}

	public function testBrands() {
		ActiveForm::$counter = 0;
		ob_start();
		$model = new DynamicModel(['test']);
		$form = ActiveForm::begin();
			echo $form->field($model, 'test', [
				'icon' => [
					'name' => 'bandcamp',
					'style' => 'brands',
				]
			]);
		ActiveForm::end();
		$out = ob_get_clean();

		$expected = <<<html
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512" aria-hidden="true" role="img" class="svg-inline--fa svg-inline--fa-w-16 svg-inline--fa-fw"><path d="M248 8C111 8 0 119 0 256s111 248 248 248 248-111 248-248S385 8 248 8zm48.2 326.1h-181L199.9 178h181l-84.7 156.1z" fill="currentColor"/></svg>
html;

		$this->assertContains($expected, $out);
	}

	public function testClass() {
		ActiveForm::$counter = 0;
		ob_start();
		$model = new DynamicModel(['test']);
		$form = ActiveForm::begin();
			echo $form->field($model, 'test', [
				'icon' => [
					'name' => 'user',
					'class' => 'yourClass',
				]
			]);
		ActiveForm::end();
		$out = ob_get_clean();

		$this->assertContains('class="yourClass svg-inline--fa svg-inline--fa-w-14 svg-inline--fa-fw"', $out);
	}

	public function testFill() {
		ActiveForm::$counter = 0;
		ob_start();
		$model = new DynamicModel(['test']);
		$form = ActiveForm::begin();
			echo $form->field($model, 'test', [
				'icon' => [
					'name' => 'user',
					'fill' => '#003865',
				]
			]);
		ActiveForm::end();
		$out = ob_get_clean();

		$this->assertContains('fill="#003865"', $out);
	}

	public function testFixedWidthDisabled() {
		ActiveForm::$counter = 0;
		ob_start();
		$model = new DynamicModel(['test']);
		$form = ActiveForm::begin();
			echo $form->field($model, 'test', [
				'icon' => [
					'name' => 'user',
					'fixedWidth' => false,
				]
			]);
		ActiveForm::end();
		$out = ob_get_clean();

		$this->assertNotContains('svg-inline--fa-fw', $out);
	}

	public function testGroupsize() {
		ActiveForm::$counter = 0;
		ob_start();
		$model = new DynamicModel(['test']);
		$form = ActiveForm::begin();
			echo $form->field($model, 'test', [
				'icon' => [
					'name' => 'user',
					'groupSize' => 'sm',
				]
			]);
		ActiveForm::end();
		$out = ob_get_clean();

		$this->assertContains('<div class="input-group input-group-sm">', $out);
	}

	public function testTitle() {
		ActiveForm::$counter = 0;
		ob_start();
		$model = new DynamicModel(['test']);
		$form = ActiveForm::begin();
			echo $form->field($model, 'test', [
				'icon' => [
					'name' => 'user',
					'title' => 'Your Title',
				]
			]);
		ActiveForm::end();
		$out = ob_get_clean();

		$this->assertContains('<title>Your Title</title>', $out);
	}
}
