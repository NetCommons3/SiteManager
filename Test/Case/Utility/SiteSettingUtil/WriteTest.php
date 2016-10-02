<?php
/**
 * SiteSettingUtil::write()のテスト
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
 * SiteSettingUtil::write()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\SiteManager\Test\Case\Utility\SiteSettingUtil
 */
class SiteManagerUtilitySiteSettingUtilWriteTest extends NetCommonsCakeTestCase {

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
 * alphaNumericSymbols()テストのDataProvider
 *
 * ### 戻り値
 *  - keyPath keyパス
 *  - value 値
 *  - langId 言語ID
 *  - expected 期待値
 *
 * @return array データ
 */
	public function dataProvider() {
		return array(
			array(
				'keyPath' => 'App.site_name',
				'value' => 'NetCommons',
				'langId' => '2',
				'expected' => array(
					'App' => array('site_name' => array('2' => 'NetCommons'))
				),
			),
			array(
				'keyPath' => 'Session.cookie',
				'value' => 'test',
				'langId' => '0',
				'expected' => array(
					'Session' => array('cookie' => array('0' => 'test'))
				),
			),
			array(
				'keyPath' => 'Session.ini[session.cookie_lifetime]',
				'value' => 129600,
				'langId' => '0',
				'expected' => array(
					'Session' => array(
						'ini' => array(
							'session.cookie_lifetime' => array(
								'0' => 129600
							)
						)
					),
				),
			),
			array(
				'keyPath' => 'Session',
				'value' => array(
					'defaults' => 'php',
					'ini' => array(
						'session.cookie_lifetime' => 129600,
						'session.gc_maxlifetime' => 64800,
					),
					'timeout' => 2160,
				),
				'langId' => '0',
				'expected' => array(
					'Session' => array (
						'defaults' => array (
							'0' => 'php',
						),
						'ini' => array (
							'session.cookie_lifetime' => array (
								'0' => 129600,
							),
							'session.gc_maxlifetime' => array (
								'0' => 64800,
							),
						),
						'timeout' => array (
							'0' => 2160,
						),
					),
				),
			),
		);
	}

/**
 * write()のテスト
 *
 * @param string|array $keyPath keyパス
 * @param mixed $value 値
 * @param null|int $langId 言語ID
 * @param array $expected 期待値
 * @dataProvider dataProvider
 * @return void
 */
	public function testWrite($keyPath, $value, $langId, $expected) {
		//テスト実施
		SiteSettingUtil::write($keyPath, $value, $langId);

		//チェック
		$this->assertEquals($expected, SiteSettingUtil::readAll());
	}

}
