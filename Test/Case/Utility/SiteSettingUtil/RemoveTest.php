<?php
/**
 * SiteSettingUtil::remove()のテスト
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
 * SiteSettingUtil::remove()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\SiteManager\Test\Case\Utility\SiteSettingUtil
 */
class SiteManagerUtilitySiteSettingUtilRemoveTest extends NetCommonsCakeTestCase {

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
 * remove()テストのDataProvider
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
				'langId' => '2',
				'expected' => array(
					'debug' => array('0' => '1'),
					'App' => array(
						'site_name' => array(
							'1' => 'NetCommons EN',
						),
					),
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
			array(
				'keyPath' => 'App.site_name',
				'langId' => null,
				'expected' => array(
					'debug' => array('0' => '1'),
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
			array(
				'keyPath' => 'Session',
				'langId' => null,
				'expected' => array(
					'debug' => array('0' => '1'),
					'App' => array(
						'site_name' => array(
							'2' => 'NetCommons JA',
							'1' => 'NetCommons EN',
						),
					),
				),
			),
			array(
				'keyPath' => 'debug',
				'langId' => '0',
				'expected' => array(
					'App' => array(
						'site_name' => array(
							'2' => 'NetCommons JA',
							'1' => 'NetCommons EN',
						),
					),
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
			array(
				'keyPath' => 'Session.ini.[session.cookie_lifetime]',
				'langId' => null,
				'expected' => array(
					'debug' => array('0' => '1'),
					'App' => array(
						'site_name' => array(
							'2' => 'NetCommons JA',
							'1' => 'NetCommons EN',
						),
					),
					'Session' => array (
						'defaults' => array (
							'0' => 'php',
						),
						'ini' => array (
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
 * remove()のテスト
 *
 * @param string|array $keyPath keyパス
 * @param null|int $langId 言語ID
 * @param array $expected 期待値
 * @dataProvider dataProvider
 * @return void
 */
	public function testRemove($keyPath, $langId, $expected) {
		//テストデータ
		SiteSettingUtil::write('debug', '1', '0');
		SiteSettingUtil::write('App.site_name', 'NetCommons JA', '2');
		SiteSettingUtil::write('App.site_name', 'NetCommons EN', '1');
		SiteSettingUtil::write('Session', array(
			'defaults' => 'php',
			'ini' => array(
				'session.cookie_lifetime' => 129600,
				'session.gc_maxlifetime' => 64800,
			),
			'timeout' => 2160,
		), '0');

		//テスト実施
		SiteSettingUtil::remove($keyPath, $langId);

		//チェック
		$this->assertEquals($expected, SiteSettingUtil::readAll());
	}

}
