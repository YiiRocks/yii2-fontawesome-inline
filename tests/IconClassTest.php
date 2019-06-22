<?php
/**
 *  @link https://fontawesome.mr42.me/
 *  @license https://github.com/Thoulah/yii2-fontawesome-inline/blob/master/LICENSE
 */

namespace thoulah\fontawesome\tests;

use thoulah\fontawesome\Icon;

class IconClassTest extends tests {
	public function testBasic(): void {
		$icon = new Icon();
		$this->assertStringContainsString('viewBox="0 0 512 512" class="svg-inline--fa svg-inline--fa-w-16" aria-hidden="true" role="img"', $icon->show('cookie'));
		$this->assertStringContainsString('viewBox="0 0 192 512" class="svg-inline--fa svg-inline--fa-w-6" aria-hidden="true" role="img"', $icon->show('ellipsis-v'));
		$this->assertStringContainsString('viewBox="0 0 496 512" class="svg-inline--fa svg-inline--fa-w-16" aria-hidden="true" role="img"', $icon->show('github', ['style' => 'brands']));
		$this->assertStringContainsString('viewBox="0 0 512 512" class="svg-inline--fa svg-inline--fa-w-16" aria-hidden="true" role="img"', $icon->show('nonexistent'));
	}

	public function testClass(): void {
		$icon = new Icon();
		$this->assertStringContainsString('viewBox="0 0 512 512" class="mr42 svg-inline--fa svg-inline--fa-w-16" aria-hidden="true" role="img"', $icon->show('cookie', ['class' => 'mr42']));
		$this->assertStringContainsString('viewBox="0 0 496 512" class="mr42 svg-inline--fa svg-inline--fa-w-16" aria-hidden="true" role="img"', $icon->show('github', ['class' => 'mr42', 'style' => 'brands']));
	}

	public function testFill(): void {
		$icon = new Icon();
		$this->assertStringContainsString('fill="currentColor"/></svg>', $icon->show('cookie'));
		$this->assertStringNotContainsString('fill', $icon->show('cookie', ['fill' => '']));
		$this->assertStringContainsString('fill="#003865"/></svg>', $icon->show('cookie', ['fill' => '#003865']));
	}

	public function testFixedWidth(): void {
		$icon = new Icon();
		$this->assertStringNotContainsString('svg-inline--fa-fw', $icon->show('cookie'));
		$this->assertStringContainsString('svg-inline--fa-fw', $icon->show('cookie', ['fixedWidth' => true]));
	}

	public function testHeight(): void {
		$icon = new Icon();
		$this->assertStringContainsString('viewBox="0 0 512 512" width="42" height="42" aria-hidden="true" role="img"', $icon->show('cookie', ['height' => 42]));
		$this->assertStringContainsString('viewBox="0 0 192 512" width="16" height="42" aria-hidden="true" role="img"', $icon->show('ellipsis-v', ['height' => 42]));
	}

	public function testPrefix(): void {
		$icon = new Icon();
		$icon->defaults->prefix = 'icon';
		$this->assertStringContainsString('viewBox="0 0 512 512" class="icon icon-w-16" aria-hidden="true" role="img"', $icon->show('cookie'));
		$this->assertStringContainsString('viewBox="0 0 192 512" class="icon icon-w-6" aria-hidden="true" role="img"', $icon->show('ellipsis-v'));
		$this->assertStringContainsString('viewBox="0 0 496 512" class="icon icon-w-16" aria-hidden="true" role="img"', $icon->show('github', ['style' => 'brands']));
		$this->assertStringContainsString('viewBox="0 0 512 512" class="icon icon-w-16" aria-hidden="true" role="img"', $icon->show('nonexistent'));
	}

	public function testTitle(): void {
		$icon = new Icon();
		$this->assertStringContainsString('<title>Demo Title</title>', $icon->show('cookie', ['title' => 'Demo Title']));
	}
}
