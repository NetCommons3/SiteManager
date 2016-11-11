<?php
/**
 * MetaSettingsController::edit()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('SiteManagerControllerTestCase', 'SiteManager.TestSuite');

/**
 * MetaSettingsController::edit()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\SiteManager\Test\Case\Controller\MetaSettingsController
 */
class MetaSettingsControllerEditTest extends SiteManagerControllerTestCase {

/**
 * Plugin name
 *
 * @var string
 */
	public $plugin = 'site_manager';

/**
 * Controller name
 *
 * @var string
 */
	protected $_controller = 'meta_settings';

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		//ログイン
		TestAuthGeneral::login($this);
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		//ログアウト
		TestAuthGeneral::logout($this);

		parent::tearDown();
	}

/**
 * edit()アクションのGetリクエストテスト
 *
 * @return void
 */
	public function testEditGet() {
		//テスト実行
		$this->_testGetAction(
			array('action' => 'edit'),
			array('method' => 'assertNotEmpty'), null, 'view'
		);

		//チェック
		$this->__assertEditGet();

		$this->assertInput(
			'input', 'data[SiteSetting][Meta/author][1][value]', 'NetCommons', $result
		);
		$this->assertInput(
			'input', 'data[SiteSetting][Meta/author][2][value]', 'NetCommons', $result
		);
		$this->assertInput(
			'input', 'data[SiteSetting][Meta/copyright][1][value]', null, $result
		);
		$this->assertInput(
			'textarea', 'data[SiteSetting][Meta/keywords][1][value]', 'CMS,Netcommons,NetCommons3,CakePHP', $result
		);
		$this->assertInput(
			'textarea', 'data[SiteSetting][Meta/keywords][2][value]', 'CMS,Netcommons,NetCommons3,CakePHP', $result
		);
		$this->assertInput(
			'textarea', 'data[SiteSetting][Meta/description][1][value]', 'CMS,Netcommons,NetCommons3,CakePHP', $result
		);
		$this->assertInput(
			'textarea', 'data[SiteSetting][Meta/description][2][value]', 'CMS,Netcommons,NetCommons3,CakePHP', $result
		);
	}

/**
 * edit()のチェック
 *
 * @return void
 */
	private function __assertEditGet() {
		$result = $this->_parseView($this->view);
		var_export($result);

		$this->assertInput('form', null, '/site_manager/meta_settings/edit', $result);
		$this->assertRegExp(
			'/<a href=".*?' . preg_quote('/site_manager/site_manager/edit', '/') . '".*?>' .
				preg_quote('一般設定', '/') .
			'<\/a>/',
			$result
		);
		$this->assertRegExp(
			'/<a href=".*?' . preg_quote('/site_manager/meta_settings/edit', '/') . '".*?>' .
				preg_quote('メタ情報', '/') .
			'<\/a>/',
			$result
		);
		$this->assertRegExp(
			'/<a href=".*?' . preg_quote('/site_manager/default_page_settings/edit/2', '/') . '".*?>' .
				preg_quote('ページスタイル', '/') .
			'<\/a>/',
			$result
		);
		$this->assertRegExp(
			'/<a href=".*?' . preg_quote('/site_manager/membership/edit', '/') . '".*?>' .
				preg_quote('入会・退会', '/') .
			'<\/a>/',
			$result
		);
		$this->assertRegExp(
			'/<a href=".*?' . preg_quote('/site_manager/workflow/edit', '/') . '".*?>' .
				preg_quote('承認メール', '/') .
			'<\/a>/',
			$result
		);
		$this->assertRegExp(
			'/<a href=".*?' . preg_quote('/site_manager/mail_signature_settings/edit', '/') . '".*?>' .
				preg_quote('メール署名', '/') .
			'<\/a>/',
			$result
		);
		$this->assertInput(
			'input', '_method', 'POST', $result
		);
		$this->assertInput(
			'input', 'active_lang_id', 'activeLangId', $result
		);
		$this->assertInput(
			'input', 'data[SiteSetting][Meta/author][1][id]', '89', $result
		);
		$this->assertInput(
			'input', 'data[SiteSetting][Meta/author][1][key]', 'Meta.author', $result
		);
		$this->assertInput(
			'input', 'data[SiteSetting][Meta/author][1][language_id]', '1', $result
		);
		$this->assertInput(
			'input', 'data[SiteSetting][Meta/author][2][id]', '90', $result
		);
		$this->assertInput(
			'input', 'data[SiteSetting][Meta/author][2][key]', 'Meta.author', $result
		);
		$this->assertInput(
			'input', 'data[SiteSetting][Meta/author][2][language_id]', '2', $result
		);
		$this->assertInput(
			'input', 'data[SiteSetting][Meta/copyright][1][id]', '91', $result
		);
		$this->assertInput(
			'input', 'data[SiteSetting][Meta/copyright][1][key]', 'Meta.copyright', $result
		);
		$this->assertInput(
			'input', 'data[SiteSetting][Meta/copyright][1][language_id]', '1', $result
		);
		$this->assertInput(
			'input', 'data[SiteSetting][Meta/copyright][2][id]', '92', $result
		);
		$this->assertInput(
			'input', 'data[SiteSetting][Meta/copyright][2][key]', 'Meta.copyright', $result
		);
		$this->assertInput(
			'input', 'data[SiteSetting][Meta/copyright][2][language_id]', '2', $result
		);
		$this->assertInput(
			'input', 'data[SiteSetting][Meta/copyright][2][value]', null, $result
		);
		$this->assertInput(
			'input', 'data[SiteSetting][Meta/keywords][1][id]', '93', $result
		);
		$this->assertInput(
			'input', 'data[SiteSetting][Meta/keywords][1][key]', 'Meta.keywords', $result
		);
		$this->assertInput(
			'input', 'data[SiteSetting][Meta/keywords][1][language_id]', '1', $result
		);
		$this->assertInput(
			'input', 'data[SiteSetting][Meta/keywords][2][id]', '94', $result
		);
		$this->assertInput(
			'input', 'data[SiteSetting][Meta/keywords][2][key]', 'Meta.keywords', $result
		);
		$this->assertInput(
			'input', 'data[SiteSetting][Meta/keywords][2][language_id]', '2', $result
		);
		$this->assertInput(
			'input', 'data[SiteSetting][Meta/description][1][id]', '95', $result
		);
		$this->assertInput(
			'input', 'data[SiteSetting][Meta/description][1][key]', 'Meta.description', $result
		);
		$this->assertInput(
			'input', 'data[SiteSetting][Meta/description][1][language_id]', '1', $result
		);
		$this->assertInput(
			'input', 'data[SiteSetting][Meta/description][2][id]', '96', $result
		);
		$this->assertInput(
			'input', 'data[SiteSetting][Meta/description][2][key]', 'Meta.description', $result
		);
		$this->assertInput(
			'input', 'data[SiteSetting][Meta/description][2][language_id]', '2', $result
		);
		$this->assertInput(
			'input', 'data[SiteSetting][Meta/robots][0][id]', '21', $result
		);
		$this->assertInput(
			'input', 'data[SiteSetting][Meta/robots][0][key]', 'Meta.robots', $result
		);
		$this->assertInput(
			'input', 'data[SiteSetting][Meta/robots][0][language_id]', '0', $result
		);
		$this->assertInput('select', 'data[SiteSetting][Meta/robots][0][value]', null, $result);
		$this->assertInput('option', 'index,follow', 'selected', $result);
		$this->assertInput('option', 'noindex,follow', null, $result);
		$this->assertInput('option', 'index,nofollow', null, $result);
		$this->assertInput('option', 'noindex,nofollow', null, $result);
		$this->assertInput('input', 'data[_NetCommonsTime][user_timezone]', null, $result);
		$this->assertInput(
			'input', 'data[_NetCommonsTime][convert_fields]', '', $result
		);
	}

///**
// * POSTリクエストデータ生成
// *
// * @return array リクエストデータ
// */
//	private function __data() {
//		$data = array(
//			//TODO:必要に応じて、assertを追加する
//		);
//
//		return $data;
//	}
//
///**
// * edit()アクションのPOSTリクエストテスト
// *
// * @return void
// */
//	public function testEditPost() {
//		//テスト実行
//		$this->_testPostAction(
//			'put', $this->__data(),
//			array('action' => 'edit'),
//			null, 'view'
//		);
//
//		//チェック
//		$header = $this->controller->response->header();
//		$pattern = 'site_manager/site_manager/index/' . $blockId;
//		$this->assertTextContains($pattern, $header['Location']);
//	}
//
///**
// * ValidationErrorテスト
// *
// * @return void
// */
//	public function testEditPostValidationError() {
//		$this->_mockForReturnFalse('TODO:MockにするModel名書く', 'TODO:Mockにするメソッド名書く');
//
//		//テスト実行
//		$this->_testPostAction(
//			'put', $this->__data(),
//			array('action' => 'edit'),
//			null, 'view'
//		);
//		//$this->_testPostAction(
//		//	'put', $this->__data(),
//		//	array('action' => 'edit'),
//		//	'BadRequestException', 'view'
//		//);
//
//		//TODO:必要に応じてassert書く
//	}

}
