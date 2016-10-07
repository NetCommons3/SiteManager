<?php
/**
 * SiteSettingUtilFunc::acceptLanguage()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsCakeTestCase', 'NetCommons.TestSuite');
App::uses('SiteSettingUtilFunc', 'SiteManager.Utility');

/**
 * SiteSettingUtilFunc::acceptLanguage()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\SiteManager\Test\Case\Utility\SiteSettingUtilFunc
 */
class SiteManagerUtilitySiteSettingUtilFuncAcceptLanguageTest extends NetCommonsCakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.m17n.language',
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
		$this->_server = $_SERVER;
		parent::setUp();
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		$_SERVER = $this->_server;
		parent::tearDown();
	}

/**
 * $_SERVER['HTTP_ACCEPT_LANGUAGE']がない場合のテスト
 *
 * @return void
 */
	public function testWOAcceptLanguage() {
		//テスト実施
		$result = (new SiteSettingUtilFunc())->acceptLanguage();

		//チェック
		$this->assertEquals($result, 'ja');
	}

/**
 * $_SERVER['HTTP_ACCEPT_LANGUAGE']がある場合のテスト
 *
 * @return void
 */
	public function testWAcceptLanguage() {
		//データ生成
		$_SERVER['HTTP_ACCEPT_LANGUAGE'] = 'en,en-US;q=0.7,ja;q=0.3';

		//テスト実施
		$result = (new SiteSettingUtilFunc())->acceptLanguage();

		//チェック
		$this->assertEquals($result, 'en');
	}

/**
 * $_SERVER['HTTP_ACCEPT_LANGUAGE']があり、enの場合のテスト
 *
 * @return void
 */
	public function testEnWAcceptLanguage() {
		//データ生成
		$_SERVER['HTTP_ACCEPT_LANGUAGE'] = 'ch,en;q=0.7,du;q=0.3';

		//テスト実施
		$result = (new SiteSettingUtilFunc())->acceptLanguage();

		//チェック
		$this->assertEquals($result, 'en');
	}

/**
 * $_SERVER['HTTP_ACCEPT_LANGUAGE']があり、en-USの場合のテスト
 *
 * @return void
 */
	public function testEnUSWAcceptLanguage() {
		//データ生成
		$_SERVER['HTTP_ACCEPT_LANGUAGE'] = 'ch,en-US;q=0.7,du;q=0.3';

		//テスト実施
		$result = (new SiteSettingUtilFunc())->acceptLanguage();

		//チェック
		$this->assertEquals($result, 'en');
	}

/**
 * $_SERVER['HTTP_ACCEPT_LANGUAGE']があり、ja>enの場合のテスト
 *
 * @return void
 */
	public function testJaWAcceptLanguage() {
		//データ生成
		$_SERVER['HTTP_ACCEPT_LANGUAGE'] = 'ch,ja;q=0.7,en;q=0.3';

		//テスト実施
		$result = (new SiteSettingUtilFunc())->acceptLanguage();

		//チェック
		$this->assertEquals($result, 'ja');
	}

/**
 * $_SERVER['HTTP_ACCEPT_LANGUAGE']があるがヒットしなかった場合のテスト
 *
 * @return void
 */
	public function testNotHitWAcceptLanguage() {
		//データ生成
		$_SERVER['HTTP_ACCEPT_LANGUAGE'] = 'ch,du;q=0.7,ca;q=0.3';

		//テスト実施
		$result = (new SiteSettingUtilFunc())->acceptLanguage();

		//チェック
		$this->assertEquals($result, 'ja');
	}

/**
 * $_SERVER['HTTP_ACCEPT_LANGUAGE']があるがフォーマットがおかしかった場合のテスト
 *
 * @return void
 */
	public function testFormatErrorWAcceptLanguage() {
		//データ生成
		$_SERVER['HTTP_ACCEPT_LANGUAGE'] = 'aaaa;aaaa';

		//テスト実施
		$result = (new SiteSettingUtilFunc())->acceptLanguage();

		//チェック
		$this->assertEquals($result, 'ja');
	}

}
