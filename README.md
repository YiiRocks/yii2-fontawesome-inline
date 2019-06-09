Inline [Font Awesome](http://fortawesome.github.io/Font-Awesome/) icons for Yii2
===============================

This extension provides a simple function for [Yii framework 2.0](http://www.yiiframework.com/) applications to add
[Font Awesome](https://fontawesome.com/) icons inline without the use of JavaScript.

For license information check the [LICENSE](https://github.com/Thoulah/yii2-fontawesome-inline/blob/master/LICENSE)-file.

Installation
------------

The preferred way to install this extension is through [composer](https://getcomposer.org/).

Either run

```bash
composer require thoulah/yii2-fontawesome-inline
```

or add

```
"thoulah/yii2-fontawesome-inline": "dev-master",
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
