# Option 2 – Widget

```php
use thoulah\fontawesome\IconWidget;
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
