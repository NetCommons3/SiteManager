<?php
/**
 * SiteSettingUtil::reset()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsCakeTestCase', 'NetCommons.TestSuite');
App::uses('SiteSettingUtil', 'SiteManager.Utility');

/**
 * SiteSettingUtil::reset()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\SiteManager\Test\Case\Utility\SiteSettingUtil
 */
class SiteManagerUtilitySiteSettingUtilResetTest extends NetCommonsCakeTestCase {

/**
 * Plugin name
 *
 * @var string
 */
	public $plugin = 'site_manager';

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		SiteSettingUtil::reset();
		parent::tearDown();
	}

/**
 * reset()のテスト
 *
 * @return void
 */
	public function testReset() {
		//データ生成
		SiteSettingUtil::write('aaaa', 'Test');
		$this->assertEquals('Test', SiteSettingUtil::read('aaaa'));

		//テスト実施
		SiteSettingUtil::reset();

		//チェック
		$this->assertNotEquals('Test', SiteSettingUtil::read('aaaa'));
		$this->assertEmpty(SiteSettingUtil::readAll());
	}

}
