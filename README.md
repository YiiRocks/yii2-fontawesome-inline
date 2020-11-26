# Inline Font Awesome Icons for Yii2

> **inline**  
> ***/ˈɪnlʌɪn/***  
> *adjective*
>
> included as part of the main text on a page, rather than in a separate section

This extension provides simple functions for [Yii framework 2.0](http://www.yiiframework.com/) applications to add
[Font Awesome](https://fontawesome.com/) [Icons](https://fontawesome.com/icons) inline
***without the use of JavaScript***.

[![Packagist Version](https://img.shields.io/packagist/v/thoulah/yii2-fontawesome-inline.svg)](https://packagist.org/packages/thoulah/yii2-fontawesome-inline)
[![PHP from Packagist](https://img.shields.io/packagist/php-v/thoulah/yii2-fontawesome-inline.svg)](https://php.net/)
[![Packagist](https://img.shields.io/packagist/dt/thoulah/yii2-fontawesome-inline.svg)](https://packagist.org/packages/thoulah/yii2-fontawesome-inline)
[![GitHub](https://img.shields.io/github/license/YiiRocks/yii2-fontawesome-inline.svg)](https://github.com/YiiRocks/yii2-fontawesome-inline/blob/master/LICENSE)

## Installation

The package could be installed via composer:

```bash
composer require thoulah/yii2-fontawesome-inline
```

## Quick Usage

```php
echo Yii::$app->fontawesome->name('github', 'brands')->fill->('#003865');
```
Various implementations and options are available. Please visit [Yii.Rocks](https://www.yii.rocks/yii2-fontawesome-inline/) for more information.

## Unit testing

The package is tested with [PHPUnit](https://phpunit.de/). To run tests:

```bash
./vendor/bin/phpunit
```

[![Code Climate maintainability](https://img.shields.io/codeclimate/maintainability/YiiRocks/yii2-fontawesome-inline.svg)](https://codeclimate.com/github/YiiRocks/yii2-fontawesome-inline)
[![Codacy branch grade](https://img.shields.io/codacy/grade/77359b0ae813411895da7d33bb009bf0/master.svg)](https://app.codacy.com/gh/YiiRocks/yii2-fontawesome-inline)
[![Scrutinizer code quality (GitHub/Bitbucket)](https://img.shields.io/scrutinizer/quality/g/yiirocks/yii2-fontawesome-inline/master.svg)](https://scrutinizer-ci.com/g/yiirocks/yii2-fontawesome-inline/)
[![Travis (.com) branch](https://img.shields.io/travis/com/yiirocks/yii2-fontawesome-inline/master.svg)](https://travis-ci.com/yiirocks/yii2-fontawesome-inline)
