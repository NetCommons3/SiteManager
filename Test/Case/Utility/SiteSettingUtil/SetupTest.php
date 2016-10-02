<?php
/**
 * SiteSettingUtil::setup()のテスト
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
 * SiteSettingUtil::setup()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\SiteManager\Test\Case\Utility\SiteSettingUtil
 */
class SiteManagerUtilitySiteSettingUtilSetupTest extends NetCommonsCakeTestCase {

/**
 * Plugin name
 *
 * @var string
 */
	public $plugin = 'site_manager';

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.site_manager.site_setting4test',
	);

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
 * setup()の言語ごとで異なるテスト(初回)
 *
 * @return void
 */
	public function testArgumentsStringByLanguageForInit() {
		//データ生成
		$keyPaths = 'App.site_name';
		$force = false;

		//テスト実施
		SiteSettingUtil::setup($keyPaths, $force);

		//チェック
		$expected = array(
			'App' => array(
				'site_name' => array(
					'2' => 'NetCommons3 JA',
					'1' => 'NetCommons3 EN',
				)
			)
		);
		$this->assertEquals($expected, SiteSettingUtil::readAll());
	}

/**
 * setup()の言語ごとで異なるテスト(既にある場合)
 *
 * @return void
 */
	public function testArgumentsStringByLanguageForExists() {
		//データ生成
		$keyPaths = 'App.site_name';
		$force = false;
		SiteSettingUtil::write($keyPaths, 'NetCommons3 Test', '0');
		$expected = array(
			'App' => array(
				'site_name' => array(
					'0' => 'NetCommons3 Test',
				)
			)
		);
		$this->assertEquals($expected, SiteSettingUtil::readAll());

		//テスト実施
		SiteSettingUtil::setup($keyPaths, $force);

		//チェック
		$this->assertEquals($expected, SiteSettingUtil::readAll());
	}

/**
 * setup()の言語ごとで異なるテスト(強制取得)
 *
 * @return void
 */
	public function testArgumentsStringByLanguageForForce() {
		//データ生成
		$keyPaths = 'App.site_name';
		$force = true;
		SiteSettingUtil::write($keyPaths, 'NetCommons3 Test', '0');
		$expected = array(
			'App' => array(
				'site_name' => array(
					'0' => 'NetCommons3 Test',
				)
			)
		);
		$this->assertEquals($expected, SiteSettingUtil::readAll());

		//テスト実施
		SiteSettingUtil::setup($keyPaths, $force);

		//チェック
		$expected = array(
			'App' => array(
				'site_name' => array(
					'0' => 'NetCommons3 Test',
					'2' => 'NetCommons3 JA',
					'1' => 'NetCommons3 EN',
				)
			)
		);
		$this->assertEquals($expected, SiteSettingUtil::readAll());
	}

/**
 * setup()の共通テスト(初回)
 *
 * @return void
 */
	public function testArgumentsStringByCommonForInit() {
		//データ生成
		$keyPaths = 'Config.language';
		$force = false;

		//テスト実施
		SiteSettingUtil::setup($keyPaths, $force);

		//チェック
		$expected = array(
			'Config' => array(
				'language' => array(
					'0' => 'ja',
				)
			)
		);
		$this->assertEquals($expected, SiteSettingUtil::readAll());
	}

/**
 * setup()の共通テスト(既にある場合)
 *
 * @return void
 */
	public function testArgumentsStringByCommonForExists() {
		//データ生成
		$keyPaths = 'Config.language';
		$force = false;
		SiteSettingUtil::write($keyPaths, 'NetCommons3 Test', '0');
		$expected = array(
			'Config' => array(
				'language' => array(
					'0' => 'NetCommons3 Test',
				)
			)
		);
		$this->assertEquals($expected, SiteSettingUtil::readAll());

		//テスト実施
		SiteSettingUtil::setup($keyPaths, $force);

		//チェック
		$this->assertEquals($expected, SiteSettingUtil::readAll());
	}

/**
 * setup()の共通テスト(強制取得)
 *
 * @return void
 */
	public function testArgumentsStringByCommonForForce() {
		//データ生成
		$keyPaths = 'Config.language';
		$force = true;
		SiteSettingUtil::write($keyPaths, 'NetCommons3 Test', '0');
		$expected = array(
			'Config' => array(
				'language' => array(
					'0' => 'NetCommons3 Test',
				)
			)
		);
		$this->assertEquals($expected, SiteSettingUtil::readAll());

		//テスト実施
		SiteSettingUtil::setup($keyPaths, $force);

		//チェック
		$expected = array(
			'Config' => array(
				'language' => array(
					'0' => 'ja',
				)
			)
		);

		$this->assertEquals($expected, SiteSettingUtil::readAll());
	}

/**
 * setup()の配列テスト
 *
 * @return void
 */
	public function testArgumentsArray() {
		//データ生成
		$keyPaths = array(
			'App.site_name',
			'Config.language',
		);
		$force = false;

		//テスト実施
		SiteSettingUtil::setup($keyPaths, $force);

		//チェック
		$expected = array(
			'Config' => array(
				'language' => array(
					'0' => 'ja',
				),
			),
			'App' => array(
				'site_name' => array(
					'2' => 'NetCommons3 JA',
					'1' => 'NetCommons3 EN',
				)
			)
		);
		$this->assertEquals($expected, SiteSettingUtil::readAll());
	}

/**
 * setup()のLike取得テスト
 *
 * @return void
 */
	public function testArgumentsLike() {
		//データ生成
		$keyPaths = 'Session';
		$force = false;

		//テスト実施
		SiteSettingUtil::setup($keyPaths, $force);

		//チェック
		$expected = array(
			'Session' => array(
				'cookie' => array(
					'0' => 'nc_cookie',
				),
				'ini' => array(
					'session.cookie_lifetime' => array(
						'0' => '21600',
					),
					'session.gc_maxlifetime' => array(
						'0' => '21600',
					)
				),
			),
		);
		$this->assertEquals($expected, SiteSettingUtil::readAll());
	}

}
