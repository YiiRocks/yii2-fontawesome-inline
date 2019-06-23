<?php
/**
 * @link https://fontawesome.mr42.me/
 * @license https://github.com/Thoulah/yii2-fontawesome-inline/blob/master/LICENSE
 */

namespace thoulah\fontawesome\tests;

use yii\helpers\ArrayHelper;

class tests extends \PHPUnit\Framework\TestCase {
	protected function setUp(): void {
		$_SERVER['REQUEST_URI'] = 'index.php';
		parent::setUp();
		$this->mockWebApplication();
	}

	protected function mockWebApplication($config = [], $appClass = '\yii\web\Application'): void {
		new $appClass(ArrayHelper::merge([
			'id' => 'testapp',
			'basePath' => __DIR__,
			'vendorPath' => dirname(__DIR__) . '/vendor',
			'aliases' => [
				'@bower' => '@vendor/bower-asset',
			],
			'components' => [
				'request' => [
					'cookieValidationKey' => '42',
					'scriptFile' => __DIR__ . '/index.php',
					'scriptUrl' => '/index.php',
				],
			],
		], $config));
	}
}
