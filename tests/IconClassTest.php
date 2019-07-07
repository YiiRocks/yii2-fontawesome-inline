<?php
namespace thoulah\fontawesome\tests;

use thoulah\fontawesome\Icon;

class IconClassTest extends tests
{
    public function testBasic(): void
    {
        $icon = new Icon();
        $this->assertStringContainsString('viewBox="0 0 512 512" aria-hidden="true" role="img" class="svg-inline--fa svg-inline--fa-w-16"', $icon->show('cookie'));
        $this->assertStringContainsString('viewBox="0 0 192 512" aria-hidden="true" role="img" class="svg-inline--fa svg-inline--fa-w-6"', $icon->show('ellipsis-v'));
        $this->assertStringContainsString('viewBox="0 0 496 512" aria-hidden="true" role="img" class="svg-inline--fa svg-inline--fa-w-16"', $icon->show('github', ['style' => 'brands']));
        $this->assertStringContainsString('viewBox="0 0 512 512" aria-hidden="true" role="img" class="svg-inline--fa svg-inline--fa-w-16"', $icon->show('nonexistent'));
    }

    public function testClass(): void
    {
        $icon = new Icon();
        $this->assertStringContainsString('class="yourClass svg-inline--fa svg-inline--fa-w-16"', $icon->show('cookie', ['class' => 'yourClass']));
        $this->assertStringContainsString('class="yourClass svg-inline--fa svg-inline--fa-w-16"', $icon->show('github', ['class' => 'yourClass', 'style' => 'brands']));
    }

    public function testCss(): void
    {
        $icon = new Icon();
        $this->assertStringContainsString('style="text-align: center;"', $icon->show('cookie', ['css' => ['text-align' => 'center']]));
        $this->assertStringContainsString('style="text-align: center;"', $icon->show('github', ['css' => ['text-align' => 'center'], 'style' => 'brands']));
    }

    public function testCustomFile(): void
    {
        $expected = <<<'html'
<svg xmlns="http://www.w3.org/2000/svg" width="12" height="16" viewBox="0 0 12 16" aria-hidden="true" role="img"><path fill-rule="evenodd" d="M8.5 1H1c-.55 0-1 .45-1 1v12c0 .55.45 1 1 1h10c.55 0 1-.45 1-1V4.5L8.5 1zM11 14H1V2h7l3 3v9zM5 6.98L3.5 8.5 5 10l-.5 1L2 8.5 4.5 6l.5.98zM7.5 6L10 8.5 7.5 11l-.5-.98L8.5 8.5 7 7l.5-1z" fill="currentColor"/></svg>
html;

        $icon = new Icon();
        $this->assertEquals($expected, $icon->show('@vendor/phpunit/php-code-coverage/src/Report/Html/Renderer/Template/icons/file-code.svg'));
    }

    public function testFill(): void
    {
        $icon = new Icon();
        $this->assertStringContainsString('fill="currentColor"/></svg>', $icon->show('cookie'));
        $this->assertStringNotContainsString('fill', $icon->show('cookie', ['fill' => '']));
        $this->assertStringContainsString('fill="#003865"/></svg>', $icon->show('cookie', ['fill' => '#003865']));
    }

    public function testFixedWidth(): void
    {
        $icon = new Icon();
        $this->assertStringNotContainsString('svg-inline--fa-fw', $icon->show('cookie'));
        $this->assertStringContainsString('svg-inline--fa-fw', $icon->show('cookie', ['fixedWidth' => true]));
    }

    public function testHeight(): void
    {
        $icon = new Icon();
        $this->assertStringContainsString('width="42" height="42"', $icon->show('cookie', ['height' => 42]));
        $this->assertStringContainsString('width="16" height="42"', $icon->show('ellipsis-v', ['height' => 42]));
    }

    public function testPrefix(): void
    {
        $icon = new Icon();
        $icon->defaults->prefix = 'icon';
        $this->assertStringContainsString('class="icon icon-w-16"', $icon->show('cookie'));
        $this->assertStringContainsString('class="icon icon-w-6"', $icon->show('ellipsis-v'));
        $this->assertStringContainsString('class="icon icon-w-16"', $icon->show('github', ['style' => 'brands']));
        $this->assertStringContainsString('class="icon icon-w-16"', $icon->show('nonexistent'));
    }

    public function testTitle(): void
    {
        $icon = new Icon();
        $this->assertStringContainsString('<title>Demo Title</title>', $icon->show('cookie', ['title' => 'Demo Title']));
    }
}
