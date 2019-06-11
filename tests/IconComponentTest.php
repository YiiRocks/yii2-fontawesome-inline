<?php
namespace thoulah\fontawesome\tests;

use Yii;

class IconComponentTest extends tests {
	protected function setUp() {
		parent::setUp();
		$this->mockWebApplication([
			'components' => [
				'fontawesome' => [
					'class' => '\thoulah\fontawesome\IconComponent',
				],
			],
		]);
	}

	public function testBasic() {
		$this->assertContains('viewBox="0 0 512 512" aria-hidden="true" role="img" class="svg-inline--fa svg-inline--fa-w-16"', Yii::$app->fontawesome->name('cookie')->show());
		$this->assertContains('viewBox="0 0 192 512" aria-hidden="true" role="img" class="svg-inline--fa svg-inline--fa-w-6"', Yii::$app->fontawesome->name('ellipsis-v')->show());
		$this->assertContains('viewBox="0 0 496 512" aria-hidden="true" role="img" class="svg-inline--fa svg-inline--fa-w-16"', Yii::$app->fontawesome->name('github', 'brands')->show());
		$this->assertContains('viewBox="0 0 512 512" aria-hidden="true" role="img" class="svg-inline--fa svg-inline--fa-w-16"', Yii::$app->fontawesome->name('')->show());
	}

	public function testClass() {
		$this->assertContains('viewBox="0 0 512 512" class="mr42 svg-inline--fa svg-inline--fa-w-16" aria-hidden="true" role="img"', Yii::$app->fontawesome->name('cookie')->class('mr42')->show());
		$this->assertContains('viewBox="0 0 496 512" class="mr42 svg-inline--fa svg-inline--fa-w-16" aria-hidden="true" role="img"', Yii::$app->fontawesome->name('github', 'brands')->class('mr42')->show());

		Yii::$app->fontawesome->default->prefix = 'icon';
		$this->assertContains('viewBox="0 0 512 512" class="mr42 icon icon-w-16" aria-hidden="true" role="img"', Yii::$app->fontawesome->name('cookie')->class('mr42')->show());
		$this->assertContains('viewBox="0 0 496 512" class="mr42 icon icon-w-16" aria-hidden="true" role="img"', Yii::$app->fontawesome->name('github', 'brands')->class('mr42')->show());
	}

	public function testFill() {
		$this->assertContains('fill="currentColor"/></svg>', Yii::$app->fontawesome->name('cookie')->show());
		$this->assertNotContains('fill', Yii::$app->fontawesome->name('cookie')->fill('')->show());
		$this->assertContains('fill="#003865"/></svg>', Yii::$app->fontawesome->name('cookie')->fill('#003865')->show());
	}

	public function testHeight() {
		$this->assertContains('viewBox="0 0 512 512" height="42" aria-hidden="true" role="img" width="42"', Yii::$app->fontawesome->name('cookie')->height(42)->show());
		$this->assertContains('viewBox="0 0 192 512" height="42" aria-hidden="true" role="img" width="16"', Yii::$app->fontawesome->name('ellipsis-v')->height(42)->show());
	}

	public function testPrefix() {
		Yii::$app->fontawesome->default->prefix = 'icon';

		$this->assertContains('viewBox="0 0 512 512" aria-hidden="true" role="img" class="icon icon-w-16"', Yii::$app->fontawesome->name('cookie')->show());
		$this->assertContains('viewBox="0 0 192 512" aria-hidden="true" role="img" class="icon icon-w-6"', Yii::$app->fontawesome->name('ellipsis-v')->show());
		$this->assertContains('viewBox="0 0 496 512" aria-hidden="true" role="img" class="icon icon-w-16"', Yii::$app->fontawesome->name('github', 'brands')->show());
		$this->assertContains('viewBox="0 0 512 512" aria-hidden="true" role="img" class="icon icon-w-16"', Yii::$app->fontawesome->name('')->show());
	}

	public function testTitle() {
		$this->assertContains('<title>Demo Title</title>', Yii::$app->fontawesome->name('cookie')->title('Demo Title')->show());
	}
}
