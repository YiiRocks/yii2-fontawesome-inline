Inline Font Awesome icons for Yii2
==================================

This extension provides a simple function for [Yii framework 2.0](http://www.yiiframework.com/) applications to add
[Font Awesome](https://fontawesome.com/) [icons](https://fontawesome.com/icons) inline without the use of JavaScript.

For license information check the [LICENSE](https://github.com/Thoulah/yii2-fontawesome-inline/blob/master/LICENSE)-file.

Installation
------------

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

Usage
-----

```php
$icon = new \Thoulah\FontAwesomeInline\Icon();
echo $icon->show('at');
echo $icon->show('github', ['style' => 'brand']);
echo $icon->show('font-awesome', ['class' => 'mb-2', 'style' => 'brand']);
```

Status
------

[![Yii2](https://img.shields.io/badge/Powered_by-Yii_Framework-brightgreen.svg)](https://www.yiiframework.com/)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Thoulah/yii2-fontawesome-inline/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Thoulah/yii2-fontawesome-inline/?branch=master)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/77359b0ae813411895da7d33bb009bf0)](https://www.codacy.com/app/Thoulah/yii2-fontawesome-inline?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=Thoulah/yii2-fontawesome-inline&amp;utm_campaign=Badge_Grade)
[![Build Status](https://travis-ci.com/Thoulah/yii2-fontawesome-inline.svg?branch=master)](https://travis-ci.com/Thoulah/yii2-fontawesome-inline)
