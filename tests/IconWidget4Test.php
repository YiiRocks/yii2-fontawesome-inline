<?php

namespace thoulah\fontawesome\tests;

use thoulah\fontawesome\IconWidget4 as IconWidget;

class IconWidget4Test extends tests
{
    public function testBasic(): void
    {
        IconWidget::$counter = 0;
        $this->assertStringContainsString('viewBox="0 0 512 512" id="w0" aria-hidden="true" role="img" class="svg-inline--fa svg-inline--fa-w-16"', IconWidget::widget(['name' => 'cookie']));
        $this->assertStringContainsString('viewBox="0 0 192 512" id="w1" aria-hidden="true" role="img" class="svg-inline--fa svg-inline--fa-w-6"', IconWidget::widget(['name' => 'ellipsis-v']));
        $this->assertStringContainsString('viewBox="0 0 496 512" id="w2" aria-hidden="true" role="img" class="svg-inline--fa svg-inline--fa-w-16"', IconWidget::widget(['name' => 'github', 'options' => ['style' => 'brands']]));
        $this->assertStringContainsString('viewBox="0 0 512 512" id="w3" aria-hidden="true" role="img" class="svg-inline--fa svg-inline--fa-w-16"', IconWidget::widget(['name' => 'nonexistent']));
    }

    public function testClass(): void
    {
        $this->assertStringContainsString('class="yourClass svg-inline--fa svg-inline--fa-w-16"', IconWidget::widget(['name' => 'cookie', 'options' => ['class' => 'yourClass']]));
        $this->assertStringContainsString('class="yourClass svg-inline--fa svg-inline--fa-w-16"', IconWidget::widget(['name' => 'github', 'options' => ['class' => 'yourClass', 'style' => 'brands']]));
    }

    public function testCss(): void
    {
        $this->assertStringContainsString('style="text-align: center;"', IconWidget::widget(['name' => 'cookie', 'options' => ['css' => ['text-align' => 'center']]]));
        $this->assertStringContainsString('style="text-align: center;"', IconWidget::widget(['name' => 'github', 'options' => ['css' => ['text-align' => 'center'], 'style' => 'brands']]));
    }

    public function testFill(): void
    {
        $this->assertStringContainsString('fill="currentColor"', IconWidget::widget(['name' => 'cookie']));
        $this->assertStringNotContainsString('fill', IconWidget::widget(['name' => 'cookie', 'options' => ['fill' => '']]));
        $this->assertStringContainsString('fill="#003865"', IconWidget::widget(['name' => 'cookie', 'options' => ['fill' => '#003865']]));
    }

    public function testFixedWidth(): void
    {
        $this->assertStringNotContainsString('svg-inline--fa-fw', IconWidget::widget(['name' => 'cookie']));
        $this->assertStringContainsString('svg-inline--fa-fw', IconWidget::widget(['name' => 'cookie', 'options' => ['fixedWidth' => true]]));
    }

    public function testHeight(): void
    {
        $this->assertStringContainsString('width="42" height="42"', IconWidget::widget(['name' => 'cookie', 'options' => ['height' => 42]]));
        $this->assertStringContainsString('width="16" height="42"', IconWidget::widget(['name' => 'ellipsis-v', 'options' => ['height' => 42]]));
    }

    public function testPrefix(): void
    {
        IconWidget::$defaults = ['prefix' => 'icon'];
        $this->assertStringContainsString('class="icon icon-w-16"', IconWidget::widget(['name' => 'cookie']));
        $this->assertStringContainsString('class="icon icon-w-6"', IconWidget::widget(['name' => 'ellipsis-v']));
        $this->assertStringContainsString('class="icon icon-w-16"', IconWidget::widget(['name' => 'github', 'options' => ['style' => 'brands']]));
        $this->assertStringContainsString('class="icon icon-w-16"', IconWidget::widget(['name' => 'nonexistent']));
    }

    public function testTitle(): void
    {
        $this->assertStringContainsString('<title>Demo Title</title>', IconWidget::widget(['name' => 'cookie', 'options' => ['title' => 'Demo Title']]));
    }

    public function testWidth(): void
    {
        $this->assertStringContainsString('width="42" height="42"', IconWidget::widget(['name' => 'cookie', 'options' => ['width' => 42]]));
        $this->assertStringContainsString('width="42" height="112"', IconWidget::widget(['name' => 'ellipsis-v', 'options' => ['width' => 42]]));
    }
}
