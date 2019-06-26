# Usage as a Component

## This is the preferred method if you need to override any of the default options throughout your application

Add `fontawesome` as component to your Yii config file:
```php
'components' => [
    'fontawesome' => [
        'class' => thoulah\fontawesome\IconComponent::class,
//      'fontAwesomeFolder' => '@npm/fontawesome-pro/svgs',
//      'style' => 'regular',
    ]
]
```

Now you can globally insert an icon:
```php
echo Yii::$app->fontawesome->name('at');
echo Yii::$app->fontawesome->name('github', 'brands')->fill->('#003865');
echo Yii::$app->fontawesome->name('font-awesome', 'brands')->class('yourClass');
```

Please see [Options](options.md) for more information.
