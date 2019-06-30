<?php
namespace thoulah\fontawesome\tests;

use Yii;

class IconComponentTest extends tests
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->mockWebApplication([
            'components' => [
                'fontawesome' => [
                    'class' => 'thoulah\fontawesome\IconComponent',
                ],
            ],
        ]);
    }

    public function testBasic(): void
    {
        $this->assertStringContainsString('viewBox="0 0 512 512" class="svg-inline--fa svg-inline--fa-w-16" aria-hidden="true" role="img"', (string) Yii::$app->fontawesome->name('cookie'));
        $this->assertStringContainsString('viewBox="0 0 192 512" class="svg-inline--fa svg-inline--fa-w-6" aria-hidden="true" role="img"', (string) Yii::$app->fontawesome->name('ellipsis-v'));
        $this->assertStringContainsString('viewBox="0 0 496 512" class="svg-inline--fa svg-inline--fa-w-16" aria-hidden="true" role="img"', (string) Yii::$app->fontawesome->name('github', 'brands'));
        $this->assertStringContainsString('viewBox="0 0 512 512" class="svg-inline--fa svg-inline--fa-w-16" aria-hidden="true" role="img"', (string) Yii::$app->fontawesome->name('nonexistent'));
    }

    public function testClass(): void
    {
        $this->assertStringContainsString('viewBox="0 0 512 512" class="mr42 svg-inline--fa svg-inline--fa-w-16" aria-hidden="true" role="img"', (string) Yii::$app->fontawesome->name('cookie')->class('mr42'));
        $this->assertStringContainsString('viewBox="0 0 496 512" class="mr42 svg-inline--fa svg-inline--fa-w-16" aria-hidden="true" role="img"', (string) Yii::$app->fontawesome->name('github', 'brands')->class('mr42'));

        Yii::$app->fontawesome->defaults->prefix = 'icon';
        $this->assertStringContainsString('viewBox="0 0 512 512" class="mr42 icon icon-w-16" aria-hidden="true" role="img"', (string) Yii::$app->fontawesome->name('cookie')->class('mr42'));
        $this->assertStringContainsString('viewBox="0 0 496 512" class="mr42 icon icon-w-16" aria-hidden="true" role="img"', (string) Yii::$app->fontawesome->name('github', 'brands')->class('mr42'));
    }

    public function testFill(): void
    {
        $this->assertStringContainsString('fill="currentColor"/></svg>', (string) Yii::$app->fontawesome->name('cookie'));
        $this->assertStringNotContainsString('fill', (string) Yii::$app->fontawesome->name('cookie')->fill(''));
        $this->assertStringContainsString('fill="#003865"/></svg>', (string) Yii::$app->fontawesome->name('cookie')->fill('#003865'));
    }

    public function testFixedWidth(): void
    {
        $this->assertStringNotContainsString('svg-inline--fa-fw', (string) Yii::$app->fontawesome->name('cookie'));
        $this->assertStringContainsString('svg-inline--fa-fw', (string) Yii::$app->fontawesome->name('cookie')->fixedWidth(true));
    }

    public function testHeight(): void
    {
        $this->assertStringContainsString('viewBox="0 0 512 512" width="42" height="42" aria-hidden="true" role="img"', (string) Yii::$app->fontawesome->name('cookie')->height(42));
        $this->assertStringContainsString('viewBox="0 0 192 512" width="16" height="42" aria-hidden="true" role="img"', (string) Yii::$app->fontawesome->name('ellipsis-v')->height(42));
    }

    public function testLoadFile(): void
    {
        $expected = <<<'html'
<svg xmlns="http://www.w3.org/2000/svg" width="12" height="16" viewBox="0 0 12 16" aria-hidden="true" role="img"><path fill-rule="evenodd" d="M8.5 1H1c-.55 0-1 .45-1 1v12c0 .55.45 1 1 1h10c.55 0 1-.45 1-1V4.5L8.5 1zM11 14H1V2h7l3 3v9zM5 6.98L3.5 8.5 5 10l-.5 1L2 8.5 4.5 6l.5.98zM7.5 6L10 8.5 7.5 11l-.5-.98L8.5 8.5 7 7l.5-1z" fill="currentColor"/></svg>
html;

        $this->assertEquals($expected, (string) Yii::$app->fontawesome->name('@vendor/phpunit/php-code-coverage/src/Report/Html/Renderer/Template/icons/file-code.svg'));
    }

    public function testPrefix(): void
    {
        Yii::$app->fontawesome->defaults->prefix = 'icon';
        $this->assertStringContainsString('viewBox="0 0 512 512" class="icon icon-w-16" aria-hidden="true" role="img"', (string) Yii::$app->fontawesome->name('cookie'));
        $this->assertStringContainsString('viewBox="0 0 192 512" class="icon icon-w-6" aria-hidden="true" role="img"', (string) Yii::$app->fontawesome->name('ellipsis-v'));
        $this->assertStringContainsString('viewBox="0 0 496 512" class="icon icon-w-16" aria-hidden="true" role="img"', (string) Yii::$app->fontawesome->name('github', 'brands'));
        $this->assertStringContainsString('viewBox="0 0 512 512" class="icon icon-w-16" aria-hidden="true" role="img"', (string) Yii::$app->fontawesome->name('nonexistent'));
    }

    public function testTitle(): void
    {
        $this->assertStringContainsString('<title>Demo Title</title>', (string) Yii::$app->fontawesome->name('cookie')->title('Demo Title'));
    }
}
