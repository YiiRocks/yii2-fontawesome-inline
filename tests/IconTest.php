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
        $out = $icon->show('github', ['style' => 'brands']);

        $this->assertContains('viewBox="0 0 496 512" aria-hidden="true" role="img" class="fa fa-w-16"', $out);
    }

    public function testPrefix()
    {
        $icon = new Icon();
        $icon->prefix = 'icon';
        $out = $icon->show('github', ['style' => 'brands']);

        $this->assertContains('viewBox="0 0 496 512" aria-hidden="true" role="img" class="icon icon-w-16"', $out);
    }
}
