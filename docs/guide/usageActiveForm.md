# Usage from ActiveForm

It is possible to use the icons in forms as described on the Bootstrap [Input group](https://getbootstrap.com/docs/4.3/components/input-group/) page.

## Automatic

```php
use thoulah\fontawesome\bootstrap4\ActiveForm;

$form = ActiveForm::begin();

echo $form->field($model, 'field1', [
	'icon' => 'user',
]);

echo $form->field($model, 'field2', [
	'icon' => [
		'name' => 'github',
		'style' => 'brands',
	],
]);

echo $form->field($model, 'field3', [
	'icon' => [
		'name' => 'github',
		'style' => 'brands',
        'append => true,
	],
]);

ActiveForm::end();
```

## Manual

For `$icon` you can use any earlier described usage method.

```php
$form = ActiveForm::begin();

echo $form->field($model, 'field', [
	'inputTemplate' => $icon->activeFieldAddon('user'),
]);

ActiveForm::end();
```

```php
$form = ActiveForm::begin();

echo $form->field($model, 'field', [
	'inputTemplate' => '<div id="yourClass" class="float-right">YourText</div>'.$icon->activeFieldAddon('font-awesome', ['style' => 'brands']),
]);

ActiveForm::end();
```

```php
$form = ActiveForm::begin();

echo $form->field($model, 'field', [
	'inputTemplate' => '<div class="input-group">YourText'.$icon->activeFieldIcon('font-awesome', ['style' => 'brands']).'{input}</div>',
]);

ActiveForm::end();
```

Please see [Options](options.md) for more information.
