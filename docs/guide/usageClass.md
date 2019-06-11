# Option 1 – Class

```php
$icon = new \thoulah\fontawesome\Icon();
echo $icon->show('at');
echo $icon->show('github', ['style' => 'brands', 'fill' => '#003865']);
echo $icon->show('font-awesome', ['class' => 'yourClass', 'style' => 'brands']);
```
