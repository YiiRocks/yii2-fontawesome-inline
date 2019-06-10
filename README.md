# Inline Font Awesome icons for Yii2

This extension provides a simple function for [Yii framework 2.0](http://www.yiiframework.com/) applications to add
[Font Awesome](https://fontawesome.com/) [icons](https://fontawesome.com/icons) inline without the use of JavaScript.

For license information check the [LICENSE](https://github.com/Thoulah/yii2-fontawesome-inline/blob/master/LICENSE)-file.

## Installation

The preferred way to install this extension is through [composer](https://getcomposer.org/).

Either run

```bash
composer require thoulah/yii2-fontawesome-inline
```

or add

```json
"thoulah/yii2-fontawesome-inline": "^1.0"
```

to the `require` section of your `composer.json` file.

## Default Usage

### Option 1

```php
$icon = new \Thoulah\FontAwesomeInline\Icon();
echo $icon->show('at');
echo $icon->show('github', ['style' => 'brands', 'fill' => '#003865']);
echo $icon->show('font-awesome', ['class' => 'yourClass', 'style' => 'brands']);
```

### Option 2

Add the class to the Yii config file:
```php
'modules' => [
	'icon' => [
		'class' => Thoulah\FontAwesomeInline\Icon::class,
		// 'fallbackIcon' => 'path/to/your/icon.svg',
		// 'prefix' => 'icon',
	]
]
```

Now you can globally insert an icon:
```php
echo Yii::$app->icon->show('at');
echo Yii::$app->icon->show('github', ['style' => 'brands', 'fill' => '#003865']);
echo Yii::$app->icon->show('font-awesome', ['class' => 'yourClass', 'style' => 'brands']);
```

### This is the prefered method if you need to override any of the default options

## Additional Usage: ActiveForm

It is also possible to use the icons in forms as described on the Bootstrap [Input group](https://getbootstrap.com/docs/4.3/components/input-group/) page.

### Manually
```php
$form = ActiveForm::begin();

echo $form->field($model, 'field', [
	'inputTemplate' => '<div id="yourClass" class="float-right">YourText</div>'.Yii::$app->icon->activeFieldAddon('font-awesome', ['style' => 'brands']),
]);

ActiveForm::end();
```
```php
$form = ActiveForm::begin();

echo $form->field($model, 'field', [
	'inputTemplate' => '<div class="input-group">YourText'.Yii::$app->icon->activeFieldIcon('font-awesome', ['style' => 'brands']).'{input}</div>',
]);

ActiveForm::end();
```

### Automatically
```php
use Thoulah\FontAwesomeInline\bootstrap4\ActiveForm;

$form = ActiveForm::begin();

echo $form->field($model, 'field1', [
	'icon' => 'user',
]);

echo $form->field($model, 'field2', [
	'icon' => [
		'name' => 'github',
		'class' => 'yourClass',
		'fill' => '#003865',
		'direction' => 'append',
		'size' => 'sm',
		'style' => 'brands',
	],
]);

ActiveForm::end();
```

### ActiveForm Icons are currently highly experimental and subject to change

## Status

[![Yii2](https://img.shields.io/badge/Powered_by-Yii_Framework-brightgreen.svg)](https://www.yiiframework.com/)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Thoulah/yii2-fontawesome-inline/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Thoulah/yii2-fontawesome-inline/?branch=master)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/77359b0ae813411895da7d33bb009bf0)](https://www.codacy.com/app/Thoulah/yii2-fontawesome-inline?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=Thoulah/yii2-fontawesome-inline&amp;utm_campaign=Badge_Grade)
[![Build Status](https://travis-ci.com/Thoulah/yii2-fontawesome-inline.svg?branch=master)](https://travis-ci.com/Thoulah/yii2-fontawesome-inline)
