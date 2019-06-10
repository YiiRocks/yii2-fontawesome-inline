<?php
namespace Thoulah\FontAwesomeInline\tests;

use yii\base\DynamicModel;
use yii\helpers\ArrayHelper;

/**
 * @group FontAwesomeInline
 */
class tests extends \PHPUnit\Framework\TestCase {
	protected function setUp() {
		parent::setUp();
		$this->mockWebApplication();
	}

	protected function mockWebApplication($config = [], $appClass = '\yii\web\Application') {
		new $appClass(ArrayHelper::merge([
			'id' => 'testapp',
			'basePath' => __DIR__,
			'vendorPath' => dirname(__DIR__).'/vendor',
			'aliases' => [
				'@bower' => '@vendor/bower-asset',
				'@npm' => '@vendor/npm-asset',
			],
			'components' => [
				'request' => [
					'cookieValidationKey' => '42',
					'scriptFile' => __DIR__.'/index.php',
					'scriptUrl' => '/index.php',
				],
			]
		], $config));
	}
}
