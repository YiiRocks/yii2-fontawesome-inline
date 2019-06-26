# Usage as a Widget

```php
use thoulah\fontawesome\IconWidget4 as IconWidget;
echo IconWidget::widget(['name' => 'at']);
echo IconWidget::widget(['name' => 'github', 'options' => ['style' => 'brands', 'fill' => '#003865']]);

echo IconWidget::widget([
    'name' => 'font-awesome',
    'options' => [
        'class' => 'yourClass',
        'style' => 'brands'
    ],
]);
```

Please see [Options](options.md) for more information.
