<?php
/**
 * SiteSettingUtil::readAll()のテスト
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
 * SiteSettingUtil::readAll()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\SiteManager\Test\Case\Utility\SiteSettingUtil
 */
class SiteManagerUtilitySiteSettingUtilReadAllTest extends NetCommonsCakeTestCase {

/**
 * Plugin name
 *
 * @var string
 */
	public $plugin = 'site_manager';

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		SiteSettingUtil::reset();
	}

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
 * readAll()のテスト
 *
 * @return void
 */
	public function testReadAll() {
		//データ生成
		SiteSettingUtil::write('aaaa', 'Test', '0');
		$this->assertEquals('Test', SiteSettingUtil::read('aaaa'));

		//テスト実施
		$result = SiteSettingUtil::readAll();

		//チェック
		$expected = array(
			'aaaa' => array('0' => 'Test')
		);
		$this->assertEquals($expected, $result);
	}

}
