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
		$this->assertContains('viewBox="0 0 512 512" aria-hidden="true" role="img" class="svg-inline--fa svg-inline--fa-w-16"', (string) Yii::$app->fontawesome->name('cookie'));
		$this->assertContains('viewBox="0 0 192 512" aria-hidden="true" role="img" class="svg-inline--fa svg-inline--fa-w-6"', (string) Yii::$app->fontawesome->name('ellipsis-v'));
		$this->assertContains('viewBox="0 0 496 512" aria-hidden="true" role="img" class="svg-inline--fa svg-inline--fa-w-16"', (string) Yii::$app->fontawesome->name('github', 'brands'));
		$this->assertContains('viewBox="0 0 512 512" aria-hidden="true" role="img" class="svg-inline--fa svg-inline--fa-w-16"', (string) Yii::$app->fontawesome->name(''));
	}

	public function testClass() {
		$this->assertContains('viewBox="0 0 512 512" class="mr42 svg-inline--fa svg-inline--fa-w-16" aria-hidden="true" role="img"', (string) Yii::$app->fontawesome->name('cookie')->class('mr42'));
		$this->assertContains('viewBox="0 0 496 512" class="mr42 svg-inline--fa svg-inline--fa-w-16" aria-hidden="true" role="img"', (string) Yii::$app->fontawesome->name('github', 'brands')->class('mr42'));

		Yii::$app->fontawesome->default->prefix = 'icon';
		$this->assertContains('viewBox="0 0 512 512" class="mr42 icon icon-w-16" aria-hidden="true" role="img"', (string) Yii::$app->fontawesome->name('cookie')->class('mr42'));
		$this->assertContains('viewBox="0 0 496 512" class="mr42 icon icon-w-16" aria-hidden="true" role="img"', (string) Yii::$app->fontawesome->name('github', 'brands')->class('mr42'));
	}

	public function testFill() {
		$this->assertContains('fill="currentColor"/></svg>', (string) Yii::$app->fontawesome->name('cookie'));
		$this->assertNotContains('fill', (string) Yii::$app->fontawesome->name('cookie')->fill(''));
		$this->assertContains('fill="#003865"/></svg>', (string) Yii::$app->fontawesome->name('cookie')->fill('#003865'));
	}

	public function testFixedWidth() {
		$this->assertNotContains('svg-inline--fa-fw', (string) Yii::$app->fontawesome->name('cookie'));
		$this->assertContains('svg-inline--fa-fw', (string) Yii::$app->fontawesome->name('cookie')->fixedWidth(true));
	}

	public function testHeight() {
		$this->assertContains('viewBox="0 0 512 512" height="42" aria-hidden="true" role="img" width="42"', (string) Yii::$app->fontawesome->name('cookie')->height(42));
		$this->assertContains('viewBox="0 0 192 512" height="42" aria-hidden="true" role="img" width="16"', (string) Yii::$app->fontawesome->name('ellipsis-v')->height(42));
	}

	public function testPrefix() {
		Yii::$app->fontawesome->default->prefix = 'icon';
		$this->assertContains('viewBox="0 0 512 512" aria-hidden="true" role="img" class="icon icon-w-16"', (string) Yii::$app->fontawesome->name('cookie'));
		$this->assertContains('viewBox="0 0 192 512" aria-hidden="true" role="img" class="icon icon-w-6"', (string) Yii::$app->fontawesome->name('ellipsis-v'));
		$this->assertContains('viewBox="0 0 496 512" aria-hidden="true" role="img" class="icon icon-w-16"', (string) Yii::$app->fontawesome->name('github', 'brands'));
		$this->assertContains('viewBox="0 0 512 512" aria-hidden="true" role="img" class="icon icon-w-16"', (string) Yii::$app->fontawesome->name(''));
	}

	public function testTitle() {
		$this->assertContains('<title>Demo Title</title>', (string) Yii::$app->fontawesome->name('cookie')->title('Demo Title'));
	}
}
