<?php
/**
 * MailSignatureSettingsController::edit()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('SiteManagerControllerTestCase', 'SiteManager.TestSuite.TestSuite');

/**
 * MailSignatureSettingsController::edit()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\SiteManager\Test\Case\Controller\MailSignatureSettingsController
 */
class MailSignatureSettingsControllerEditTest extends SiteManagerControllerTestCase {

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
	protected $_controller = 'mail_signature_settings';

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
		$this->_testGetAction(array('action' => 'edit'),
				array('method' => 'assertNotEmpty'), null, 'view');

		//チェック
		$this->__assertEditGet();
		$this->assertInput('textarea', 'data[SiteSetting][Mail/body_header][1][value]', null, $this->view);
		$this->assertInput('textarea', 'data[SiteSetting][Mail/body_header][2][value]', null, $this->view);
		$this->assertInput('textarea', 'data[SiteSetting][Mail/signature][1][value]', null, $this->view);
		$this->assertInput('textarea', 'data[SiteSetting][Mail/signature][2][value]', null, $this->view);
	}

/**
 * edit()のチェック
 *
 * @return void
 */
	private function __assertEditGet() {
		$this->assertInput('form', null, '/site_manager/mail_signature_settings/edit', $this->view);
		$this->assertInput('input', '_method', 'POST', $this->view);

		$this->assertInput('input', 'data[SiteSetting][Mail/body_header][1][id]', '59', $this->view);
		$this->assertInput('input', 'data[SiteSetting][Mail/body_header][1][key]', 'Mail.body_header', $this->view);
		$this->assertInput('input', 'data[SiteSetting][Mail/body_header][1][language_id]', '1', $this->view);

		$this->assertInput('input', 'data[SiteSetting][Mail/body_header][2][id]', '58', $this->view);
		$this->assertInput('input', 'data[SiteSetting][Mail/body_header][2][key]', 'Mail.body_header', $this->view);
		$this->assertInput('input', 'data[SiteSetting][Mail/body_header][2][language_id]', '2', $this->view);

		$this->assertInput('input', 'data[SiteSetting][Mail/signature][1][id]', '61', $this->view);
		$this->assertInput('input', 'data[SiteSetting][Mail/signature][1][key]', 'Mail.signature', $this->view);
		$this->assertInput('input', 'data[SiteSetting][Mail/signature][1][language_id]', '1', $this->view);

		$this->assertInput('input', 'data[SiteSetting][Mail/signature][2][id]', '60', $this->view);
		$this->assertInput('input', 'data[SiteSetting][Mail/signature][2][key]', 'Mail.signature', $this->view);
		$this->assertInput('input', 'data[SiteSetting][Mail/signature][2][language_id]', '2', $this->view);
	}

/**
 * POSTリクエストデータ生成
 *
 * @return array リクエストデータ
 */
	private function __data() {
		$data = array(
			'SiteSetting' => array(
				'Mail/body_header' => array(
					'1' => array(
						'id' => '59',
						'key' => 'Mail.body_header',
						'language_id' => '1',
						'value' => 'Mail.body_header Test EN',
					),
					'2' => array(
						'id' => '58',
						'key' => 'Mail.body_header',
						'language_id' => '2',
						'value' => 'Mail.body_header Test JA',
					)
				),
				'Mail/signature' => array(
					'1' => array(
						'id' => '61',
						'key' => 'Mail.signature',
						'language_id' => '1',
						'value' => 'Mail.signature Test EN',
					),
					'2' => array(
						'id' => '60',
						'key' => 'Mail.signature',
						'language_id' => '2',
						'value' => 'Mail.signature Test JA',
					)
				)
			)
		);

		return $data;
	}

/**
 * edit()アクションのPOSTリクエストテスト
 *
 * @return void
 */
	public function testEditPost() {
		//チェック
		$this->controller->Components->Session
			->expects($this->once())->method('setFlash')
			->with(__d('net_commons', 'Successfully saved.'));

		//テスト実行
		$this->_testPostAction('post', $this->__data(),
				array('action' => 'edit'), null, 'view');

		$this->_testGetAction(array('action' => 'edit'),
				array('method' => 'assertNotEmpty'), null, 'view');

		//チェック
		$this->__assertEditGet();
		$this->assertInput('textarea', 'data[SiteSetting][Mail/body_header][1][value]', 'Mail.body_header Test EN', $this->view);
		$this->assertInput('textarea', 'data[SiteSetting][Mail/body_header][2][value]', 'Mail.body_header Test JA', $this->view);
		$this->assertInput('textarea', 'data[SiteSetting][Mail/signature][1][value]', 'Mail.signature Test EN', $this->view);
		$this->assertInput('textarea', 'data[SiteSetting][Mail/signature][2][value]', 'Mail.signature Test JA', $this->view);
	}

}
