# Option 3 – Component

## This is the preferred method if you need to override any of the default options throughout your application

Add `fontawesome` as component to your Yii config file:
```php
'components' => [
	'fontawesome' => [
		'class' => thoulah\fontawesome\IconComponent::class,
//		'config' => [
//			'fontAwesomeFolder' => '@npm/fontawesome-pro/svgs',
//			'style' => 'regular',
//		],
	]
]
```

Now you can globally insert an icon:
```php
echo Yii::$app->fontawesome->name('at')->show();
echo Yii::$app->fontawesome->name('github', 'brands')->fill->('#003865')->show();
echo Yii::$app->fontawesome->name('font-awesome', 'brands')->class('yourClass')->show();
```

The component will not register the CSS for you, so you can add this to your layout.
```php
\thoulah\fontawesome\FontAwesomeAsset::register($this);
```
