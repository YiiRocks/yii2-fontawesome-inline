<?php
namespace thoulah\fontawesome\tests;

use thoulah\fontawesome\Icon;

class IconClassTest extends tests {
	public function testBasic() {
		$icon = new Icon();
		$this->assertContains('viewBox="0 0 512 512" aria-hidden="true" role="img" class="svg-inline--fa svg-inline--fa-w-16"', $icon->show('cookie'));
		$this->assertContains('viewBox="0 0 192 512" aria-hidden="true" role="img" class="svg-inline--fa svg-inline--fa-w-6"', $icon->show('ellipsis-v'));
		$this->assertContains('viewBox="0 0 496 512" aria-hidden="true" role="img" class="svg-inline--fa svg-inline--fa-w-16"', $icon->show('github', ['style' => 'brands']));
		$this->assertContains('viewBox="0 0 512 512" aria-hidden="true" role="img" class="svg-inline--fa svg-inline--fa-w-16"', $icon->show(''));
	}

	public function testClass() {
		$icon = new Icon();
		$this->assertContains('viewBox="0 0 512 512" class="mr42 svg-inline--fa svg-inline--fa-w-16" aria-hidden="true" role="img"', $icon->show('cookie', ['class' => 'mr42']));
		$this->assertContains('viewBox="0 0 496 512" class="mr42 svg-inline--fa svg-inline--fa-w-16" aria-hidden="true" role="img"', $icon->show('github', ['class' => 'mr42', 'style' => 'brands']));
	}

	public function testFill() {
		$icon = new Icon();
		$this->assertContains('fill="currentColor"/></svg>', $icon->show('cookie'));
		$this->assertNotContains('fill', $icon->show('cookie', ['fill' => '']));
		$this->assertContains('fill="#003865"/></svg>', $icon->show('cookie', ['fill' => '#003865']));
	}

	public function testFixedWidth() {
		$icon = new Icon();
		$this->assertNotContains('svg-inline--fa-fw', $icon->show('cookie'));
		$this->assertContains('svg-inline--fa-fw', $icon->show('cookie', ['fixedWidth' => true]));
	}

	public function testHeight() {
		$icon = new Icon();
		$this->assertContains('viewBox="0 0 512 512" height="42" aria-hidden="true" role="img" width="42"', $icon->show('cookie', ['height' => 42]));
		$this->assertContains('viewBox="0 0 192 512" height="42" aria-hidden="true" role="img" width="16"', $icon->show('ellipsis-v', ['height' => 42]));
	}

	public function testPrefix() {
		$icon = new Icon();
		$icon->default->prefix = 'icon';
		$this->assertContains('viewBox="0 0 512 512" aria-hidden="true" role="img" class="icon icon-w-16"', $icon->show('cookie'));
		$this->assertContains('viewBox="0 0 192 512" aria-hidden="true" role="img" class="icon icon-w-6"', $icon->show('ellipsis-v'));
		$this->assertContains('viewBox="0 0 496 512" aria-hidden="true" role="img" class="icon icon-w-16"', $icon->show('github', ['style' => 'brands']));
		$this->assertContains('viewBox="0 0 512 512" aria-hidden="true" role="img" class="icon icon-w-16"', $icon->show(''));
	}

	public function testTitle() {
		$icon = new Icon();
		$this->assertContains('<title>Demo Title</title>', $icon->show('cookie', ['title' => 'Demo Title']));
	}
}
