<?php
/**
 *  @link https://fontawesome.mr42.me/
 *  @license https://github.com/Thoulah/yii2-fontawesome-inline/blob/master/LICENSE
 */

namespace thoulah\fontawesome\tests;

use Yii;

class IconComponentTest extends tests {
	protected function setUp(): void {
		parent::setUp();
		$this->mockWebApplication([
			'components' => [
				'fontawesome' => [
					'class' => 'thoulah\fontawesome\IconComponent',
				],
			],
		]);
	}

	public function testBasic(): void {
		$this->assertStringContainsString('viewBox="0 0 512 512" class="svg-inline--fa svg-inline--fa-w-16" aria-hidden="true" role="img"', (string) Yii::$app->fontawesome->name('cookie'));
		$this->assertStringContainsString('viewBox="0 0 192 512" class="svg-inline--fa svg-inline--fa-w-6" aria-hidden="true" role="img"', (string) Yii::$app->fontawesome->name('ellipsis-v'));
		$this->assertStringContainsString('viewBox="0 0 496 512" class="svg-inline--fa svg-inline--fa-w-16" aria-hidden="true" role="img"', (string) Yii::$app->fontawesome->name('github', 'brands'));
		$this->assertStringContainsString('viewBox="0 0 512 512" class="svg-inline--fa svg-inline--fa-w-16" aria-hidden="true" role="img"', (string) Yii::$app->fontawesome->name('nonexistent'));
	}

	public function testClass(): void {
		$this->assertStringContainsString('viewBox="0 0 512 512" class="mr42 svg-inline--fa svg-inline--fa-w-16" aria-hidden="true" role="img"', (string) Yii::$app->fontawesome->name('cookie')->class('mr42'));
		$this->assertStringContainsString('viewBox="0 0 496 512" class="mr42 svg-inline--fa svg-inline--fa-w-16" aria-hidden="true" role="img"', (string) Yii::$app->fontawesome->name('github', 'brands')->class('mr42'));

		Yii::$app->fontawesome->defaults->prefix = 'icon';
		$this->assertStringContainsString('viewBox="0 0 512 512" class="mr42 icon icon-w-16" aria-hidden="true" role="img"', (string) Yii::$app->fontawesome->name('cookie')->class('mr42'));
		$this->assertStringContainsString('viewBox="0 0 496 512" class="mr42 icon icon-w-16" aria-hidden="true" role="img"', (string) Yii::$app->fontawesome->name('github', 'brands')->class('mr42'));
	}

	public function testFill(): void {
		$this->assertStringContainsString('fill="currentColor"/></svg>', (string) Yii::$app->fontawesome->name('cookie'));
		$this->assertStringNotContainsString('fill', (string) Yii::$app->fontawesome->name('cookie')->fill(''));
		$this->assertStringContainsString('fill="#003865"/></svg>', (string) Yii::$app->fontawesome->name('cookie')->fill('#003865'));
	}

	public function testFixedWidth(): void {
		$this->assertStringNotContainsString('svg-inline--fa-fw', (string) Yii::$app->fontawesome->name('cookie'));
		$this->assertStringContainsString('svg-inline--fa-fw', (string) Yii::$app->fontawesome->name('cookie')->fixedWidth(true));
	}

	public function testHeight(): void {
		$this->assertStringContainsString('viewBox="0 0 512 512" width="42" height="42" aria-hidden="true" role="img"', (string) Yii::$app->fontawesome->name('cookie')->height(42));
		$this->assertStringContainsString('viewBox="0 0 192 512" width="16" height="42" aria-hidden="true" role="img"', (string) Yii::$app->fontawesome->name('ellipsis-v')->height(42));
	}

	public function testPrefix(): void {
		Yii::$app->fontawesome->defaults->prefix = 'icon';
		$this->assertStringContainsString('viewBox="0 0 512 512" class="icon icon-w-16" aria-hidden="true" role="img"', (string) Yii::$app->fontawesome->name('cookie'));
		$this->assertStringContainsString('viewBox="0 0 192 512" class="icon icon-w-6" aria-hidden="true" role="img"', (string) Yii::$app->fontawesome->name('ellipsis-v'));
		$this->assertStringContainsString('viewBox="0 0 496 512" class="icon icon-w-16" aria-hidden="true" role="img"', (string) Yii::$app->fontawesome->name('github', 'brands'));
		$this->assertStringContainsString('viewBox="0 0 512 512" class="icon icon-w-16" aria-hidden="true" role="img"', (string) Yii::$app->fontawesome->name('nonexistent'));
	}

	public function testTitle(): void {
		$this->assertStringContainsString('<title>Demo Title</title>', (string) Yii::$app->fontawesome->name('cookie')->title('Demo Title'));
	}
}
