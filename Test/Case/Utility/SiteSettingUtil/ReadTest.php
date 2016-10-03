<?php
/**
 * SiteSettingUtil::read()のテスト
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
 * SiteSettingUtil::read()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\SiteManager\Test\Case\Utility\SiteSettingUtil
 */
class SiteManagerUtilitySiteSettingUtilReadTest extends NetCommonsCakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.site_manager.site_setting4test',
	);

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

		Current::write('Language.id', '2');

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
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		SiteSettingUtil::reset();
		Current::$current = array();

		parent::tearDown();
	}

/**
 * read()テストのDataProvider
 *
 * ### 戻り値
 *  - keyPath keyパス
 *  - default 値
 *  - expected 期待値
 *
 * @return array データ
 */
	public function dataProviderWOLanguage() {
		return array(
			array(
				'keyPath' => 'App.site_name',
				'default' => 'NetCommons 22',
				'expected' => 'NetCommons JA',
			),
			array(
				'keyPath' => 'Session.cookie',
				'default' => 'nc_cookie_default',
				'expected' => 'nc_cookie',
			),
			array(
				'keyPath' => 'Session.ini.[session.cookie_lifetime]',
				'default' => 100,
				'expected' => 129600,
			),
			array(
				'keyPath' => array('Session', 'ini', 'session.gc_maxlifetime'),
				'default' => 100,
				'expected' => 64800,
			),
			array(
				'keyPath' => 'Session',
				'default' => array(
					'defaults' => 'php',
					'ini' => array(
						'session.cookie_lifetime' => 129600,
						'session.gc_maxlifetime' => 64800,
					),
					'timeout' => 2160,
				),
				'expected' => array(
					'defaults' => 'php',
					'ini' => array(
						'session.cookie_lifetime' => 129600,
						'session.gc_maxlifetime' => 64800,
					),
					'timeout' => 2160,
				),
			),
		);
	}

/**
 * read()のテスト
 *
 * @param string|array $keyPath keyパス
 * @param mixed $default デフォルト値
 * @param array $expected 期待値
 * @dataProvider dataProviderWOLanguage
 * @return void
 */
	public function testReadWOLanguage($keyPath, $default, $expected) {
		//テスト実施
		$result = SiteSettingUtil::read($keyPath);

		//チェック
		$this->assertEquals($expected, $result);
	}

/**
 * read()テストのDataProvider
 *
 * ### 戻り値
 *  - keyPath keyパス
 *  - default 値
 *  - expected 期待値
 *
 * @return array データ
 */
	public function dataProviderByDefault() {
		return array(
			array(
				'keyPath' => 'App.site_name',
				'default' => 'NetCommons 22',
				'expected' => 'NetCommons 22',
			),
			array(
				'keyPath' => 'Session.name',
				'default' => 'nc_cookie_default',
				'expected' => 'nc_cookie_default',
			),
			array(
				'keyPath' => 'Session.ini.[session.cookie_lifetime2]',
				'default' => 100,
				'expected' => 100,
			),
			array(
				'keyPath' => 'Session2',
				'default' => array(
					'defaults' => 'database',
					'ini' => array(
						'session.cookie_lifetime' => 100,
						'session.gc_maxlifetime' => 200,
					),
					'timeout' => 2160,
				),
				'expected' => array(
					'defaults' => 'database',
					'ini' => array(
						'session.cookie_lifetime' => 100,
						'session.gc_maxlifetime' => 200,
					),
					'timeout' => 2160,
				),
			),
		);
	}

/**
 * read()のテスト
 *
 * @param string|array $keyPath keyパス
 * @param mixed $default デフォルト値
 * @param array $expected 期待値
 * @dataProvider dataProviderByDefault
 * @return void
 */
	public function testReadByDefault($keyPath, $default, $expected) {
		//テスト実施
		$result = SiteSettingUtil::read($keyPath, $default, '3');

		//チェック
		$this->assertEquals($expected, $result);
	}

/**
 * read()テストのDataProvider
 *
 * ### 戻り値
 *  - keyPath keyパス
 *  - default 値
 *  - expected 期待値
 *
 * @return array データ
 */
	public function dataProviderWithLanguage() {
		return array(
			array(
				'keyPath' => 'App.site_name',
				'default' => 'NetCommons 22',
				'expected' => 'NetCommons EN',
			),
			array(
				'keyPath' => 'Session.cookie',
				'default' => 'nc_cookie_default',
				'expected' => 'nc_cookie',
			),
			array(
				'keyPath' => 'Session',
				'default' => array(
					'defaults' => 'php',
					'ini' => array(
						'session.cookie_lifetime' => 129600,
						'session.gc_maxlifetime' => 64800,
					),
					'timeout' => 2160,
				),
				'expected' => array(
					'defaults' => 'php',
					'ini' => array(
						'session.cookie_lifetime' => 129600,
						'session.gc_maxlifetime' => 64800,
					),
					'timeout' => 2160,
				),
			),
		);
	}

/**
 * read()のテスト
 *
 * @param string|array $keyPath keyパス
 * @param mixed $default デフォルト値
 * @param array $expected 期待値
 * @dataProvider dataProviderWithLanguage
 * @return void
 */
	public function testReadWithLanguage($keyPath, $default, $expected) {
		//テスト実施
		$result = SiteSettingUtil::read($keyPath, $default, '1');

		//チェック
		$this->assertEquals($expected, $result);
	}

}
