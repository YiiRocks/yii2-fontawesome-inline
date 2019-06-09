<?php
namespace Thoulah\FontAwesomeInline\tests;

use Thoulah\FontAwesomeInline\Icon;
use yii\helpers\ArrayHelper;

/**
 * @group FontAwesomeInline
 */
class IconTest extends tests
{
    public function testShow()
    {
        $icon = new Icon();

        $this->assertContains('viewBox="0 0 512 512" aria-hidden="true" role="img" class="svg-inline--fa svg-inline--fa-w-16"', $icon->show('cookie'));
        $this->assertContains('viewBox="0 0 512 512" class="mr42 svg-inline--fa svg-inline--fa-w-16" aria-hidden="true" role="img"', $icon->show('cookie', ['class' => 'mr42']));
        $this->assertContains('viewBox="0 0 496 512" aria-hidden="true" role="img" class="svg-inline--fa svg-inline--fa-w-16"', $icon->show('github', ['style' => 'brands']));
        $this->assertContains('viewBox="0 0 496 512" class="mr42 svg-inline--fa svg-inline--fa-w-16" aria-hidden="true" role="img"', $icon->show('github', ['class' => 'mr42', 'style' => 'brands']));
        $this->assertContains('viewBox="0 0 512 512" aria-hidden="true" role="img" class="svg-inline--fa svg-inline--fa-w-16"', $icon->show('zzzzzz'));

    }

    public function testPrefix()
    {
        $icon = new Icon();
        $icon->prefix = 'icon';

        $this->assertContains('viewBox="0 0 512 512" aria-hidden="true" role="img" class="icon icon-w-16"', $icon->show('cookie'));
        $this->assertContains('viewBox="0 0 512 512" class="mr42 icon icon-w-16" aria-hidden="true" role="img"', $icon->show('cookie', ['class' => 'mr42']));
        $this->assertContains('viewBox="0 0 496 512" aria-hidden="true" role="img" class="icon icon-w-16"', $icon->show('github', ['style' => 'brands']));
        $this->assertContains('viewBox="0 0 496 512" class="mr42 icon icon-w-16" aria-hidden="true" role="img"', $icon->show('github', ['class' => 'mr42', 'style' => 'brands']));
        $this->assertContains('viewBox="0 0 512 512" aria-hidden="true" role="img" class="icon icon-w-16"', $icon->show('zzzzzz'));
    }
}
