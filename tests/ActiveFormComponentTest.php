<?php
namespace thoulah\fontawesome\tests;

use thoulah\fontawesome\bootstrap4\ActiveForm;
use Yii;
use yii\base\DynamicModel;

class ActiveFormComponentTest extends tests
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->mockWebApplication([
            'components' => [
                'fontawesome' => [
                    'class' => 'thoulah\fontawesome\IconComponent',
                ],
            ],
        ]);
    }

    public function testActiveFieldAddon(): void
    {
        ActiveForm::$counter = 0;
        ob_start();
        $model = new DynamicModel(['test']);
        $form = ActiveForm::begin();
        echo $form->field($model, 'test', [
                'inputTemplate' => Yii::$app->fontawesome->activeFieldAddon('user'),
            ]);
        ActiveForm::end();
        $out = ob_get_clean();

        $this->assertStringNotContainsString('{icon}', $out);
    }

    public function testActiveFieldIcon(): void
    {
        ActiveForm::$counter = 0;
        ob_start();
        $model = new DynamicModel(['test']);
        $form = ActiveForm::begin();
        echo $form->field($model, 'test', [
                'inputTemplate' => Yii::$app->fontawesome->activeFieldIcon('user'),
            ]);
        ActiveForm::end();
        $out = ob_get_clean();

        $this->assertStringNotContainsString('{icon}', $out);
    }

    public function testAppend(): void
    {
        ActiveForm::$counter = 0;
        ob_start();
        $model = new DynamicModel(['test']);
        $form = ActiveForm::begin();
        echo $form->field($model, 'test', [
                'icon' => [
                    'name' => 'user',
                    'append' => true,
                ],
            ]);
        ActiveForm::end();
        $out = ob_get_clean();

        $this->assertStringContainsString('<input type="text" id="dynamicmodel-test" class="form-control" name="DynamicModel[test]"><div class="input-group-append">', $out);
    }

    public function testBasic(): void
    {
        ActiveForm::$counter = 0;
        ob_start();
        $model = new DynamicModel(['test']);
        $form = ActiveForm::begin();
        echo $form->field($model, 'test', [
                'icon' => 'user',
            ]);
        ActiveForm::end();
        $out = ob_get_clean();

        $expected = <<<'html'
<div class="input-group"><div class="input-group-prepend"><div class="input-group-text"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa svg-inline--fa-w-14 svg-inline--fa-fw" aria-hidden="true" role="img"><path d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-74.2-60.2-134.4-134.4-134.4z" fill="currentColor"/></svg></div></div><input type="text" id="dynamicmodel-test" class="form-control" name="DynamicModel[test]"></div>
html;

        $this->assertStringContainsString($expected, $out);
        $this->assertStringNotContainsString('{icon}', $out);
    }

    public function testBrands(): void
    {
        ActiveForm::$counter = 0;
        ob_start();
        $model = new DynamicModel(['test']);
        $form = ActiveForm::begin();
        echo $form->field($model, 'test', [
                'icon' => [
                    'name' => 'bandcamp',
                    'style' => 'brands',
                ],
            ]);
        ActiveForm::end();
        $out = ob_get_clean();

        $expected = <<<'html'
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512" class="svg-inline--fa svg-inline--fa-w-16 svg-inline--fa-fw" aria-hidden="true" role="img"><path d="M248 8C111 8 0 119 0 256s111 248 248 248 248-111 248-248S385 8 248 8zm48.2 326.1h-181L199.9 178h181l-84.7 156.1z" fill="currentColor"/></svg>
html;

        $this->assertStringContainsString($expected, $out);
    }

    public function testClass(): void
    {
        ActiveForm::$counter = 0;
        ob_start();
        $model = new DynamicModel(['test']);
        $form = ActiveForm::begin();
        echo $form->field($model, 'test', [
                'icon' => [
                    'name' => 'user',
                    'class' => 'yourClass',
                ],
            ]);
        ActiveForm::end();
        $out = ob_get_clean();

        $this->assertStringContainsString('class="yourClass svg-inline--fa svg-inline--fa-w-14 svg-inline--fa-fw"', $out);
    }

    public function testFill(): void
    {
        ActiveForm::$counter = 0;
        ob_start();
        $model = new DynamicModel(['test']);
        $form = ActiveForm::begin();
        echo $form->field($model, 'test', [
                'icon' => [
                    'name' => 'user',
                    'fill' => '#003865',
                ],
            ]);
        ActiveForm::end();
        $out = ob_get_clean();

        $this->assertStringContainsString('fill="#003865"', $out);
    }

    public function testFixedWidthDisabled(): void
    {
        ActiveForm::$counter = 0;
        ob_start();
        $model = new DynamicModel(['test']);
        $form = ActiveForm::begin();
        echo $form->field($model, 'test', [
                'icon' => [
                    'name' => 'user',
                    'fixedWidth' => false,
                ],
            ]);
        ActiveForm::end();
        $out = ob_get_clean();

        $this->assertStringNotContainsString('svg-inline--fa-fw', $out);
    }

    public function testGroupsize(): void
    {
        ActiveForm::$counter = 0;
        ob_start();
        $model = new DynamicModel(['test']);
        $form = ActiveForm::begin();
        echo $form->field($model, 'test', [
                'icon' => [
                    'name' => 'user',
                    'groupSize' => 'sm',
                ],
            ]);
        ActiveForm::end();
        $out = ob_get_clean();

        $this->assertStringContainsString('<div class="input-group input-group-sm">', $out);

        ActiveForm::$counter = 0;
        ob_start();
        $model = new DynamicModel(['test']);
        $form = ActiveForm::begin();
        echo $form->field($model, 'test', [
                'icon' => [
                    'name' => 'user',
                    'groupSize' => 'lg',
                ],
            ]);
        ActiveForm::end();
        $out = ob_get_clean();

        $this->assertStringContainsString('<div class="input-group input-group-lg">', $out);
    }

    public function testTitle(): void
    {
        ActiveForm::$counter = 0;
        ob_start();
        $model = new DynamicModel(['test']);
        $form = ActiveForm::begin();
        echo $form->field($model, 'test', [
                'icon' => [
                    'name' => 'user',
                    'title' => 'Your Title',
                ],
            ]);
        ActiveForm::end();
        $out = ob_get_clean();

        $this->assertStringContainsString('<title>Your Title</title>', $out);
    }
}
