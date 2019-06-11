<?php
namespace thoulah\fontawesome\tests;

use thoulah\fontawesome\IconWidget;

class IconWidgetTest extends tests {
	public function testBasic() {
		IconWidget::$counter = 0;
		$this->assertContains('viewBox="0 0 512 512" id="w0" aria-hidden="true" role="img" class="svg-inline--fa svg-inline--fa-w-16"', IconWidget::widget(['name' => 'cookie']));
		$this->assertContains('viewBox="0 0 192 512" id="w1" aria-hidden="true" role="img" class="svg-inline--fa svg-inline--fa-w-6"', IconWidget::widget(['name' => 'ellipsis-v']));
		$this->assertContains('viewBox="0 0 496 512" id="w2" aria-hidden="true" role="img" class="svg-inline--fa svg-inline--fa-w-16"', IconWidget::widget(['name' => 'github', 'options' => ['style' => 'brands']]));
		$this->assertContains('viewBox="0 0 512 512" id="w3" aria-hidden="true" role="img" class="svg-inline--fa svg-inline--fa-w-16"', IconWidget::widget(['name' => '']));
	}

	public function testClass() {
		IconWidget::$counter = 0;
		$this->assertContains('viewBox="0 0 512 512" class="mr42 svg-inline--fa svg-inline--fa-w-16" id="w0" aria-hidden="true" role="img"', IconWidget::widget(['name' => 'cookie', 'options' => ['class' => 'mr42']]));
		$this->assertContains('viewBox="0 0 496 512" class="mr42 svg-inline--fa svg-inline--fa-w-16" id="w1" aria-hidden="true" role="img"', IconWidget::widget(['name' => 'github', 'options' => ['class' => 'mr42', 'style' => 'brands']]));
	}

	public function testFill() {
		$this->assertContains('fill="currentColor"/></svg>', IconWidget::widget(['name' => 'cookie']));
		$this->assertNotContains('fill', IconWidget::widget(['name' => 'cookie', 'options' => ['fill' => '']]));
		$this->assertContains('fill="#003865"/></svg>', IconWidget::widget(['name' => 'cookie', 'options' => ['fill' => '#003865']]));
	}

	public function testHeight() {
		IconWidget::$counter = 0;
		$this->assertContains('viewBox="0 0 512 512" height="42" id="w0" aria-hidden="true" role="img" width="42"', IconWidget::widget(['name' => 'cookie', 'options' => ['height' => 42]]));
		$this->assertContains('viewBox="0 0 192 512" height="42" id="w1" aria-hidden="true" role="img" width="16"', IconWidget::widget(['name' => 'ellipsis-v', 'options' => ['height' => 42]]));
	}

	public function testPrefix() {
		IconWidget::$counter = 0;
		IconWidget::$default = ['prefix' => 'icon'];
		$this->assertContains('viewBox="0 0 512 512" id="w0" aria-hidden="true" role="img" class="icon icon-w-16"', IconWidget::widget(['name' => 'cookie']));
		$this->assertContains('viewBox="0 0 192 512" id="w1" aria-hidden="true" role="img" class="icon icon-w-6"', IconWidget::widget(['name' => 'ellipsis-v']));
		$this->assertContains('viewBox="0 0 496 512" id="w2" aria-hidden="true" role="img" class="icon icon-w-16"', IconWidget::widget(['name' => 'github', 'options' => ['style' => 'brands']]));
		$this->assertContains('viewBox="0 0 512 512" id="w3" aria-hidden="true" role="img" class="icon icon-w-16"', IconWidget::widget(['name' => '']));
	}

	public function testTitle() {
		$this->assertContains('<title>Demo Title</title>', IconWidget::widget(['name' => 'cookie', 'options' => ['title' => 'Demo Title']]));
	}
}
