<?php
/**
 * SiteManager Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('SiteManagerAppController', 'SiteManager.Controller');
App::uses('UserRole', 'UserRoles.Model');

/**
 * サイト管理【入会退会設定】
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\SiteManager\Controller
 */
class MembershipController extends SiteManagerAppController {

/**
 * use model
 *
 * @var array
 */
	public $uses = array(
		'SiteManager.SiteSetting',
		'UserAttributes.UserAttribute',
		'UserRoles.UserRole',
	);

/**
 * edit
 *
 * @return void
 */
	public function edit() {
		//事前準備
		$this->__prepare();

		//リクエストセット
		if ($this->request->is('post')) {
			$this->set(
				'membershipTab',
				Hash::get($this->request->data['SiteSetting'], 'membershipTab', 'automatic-registration')
			);
			$this->request->data['SiteSetting'] = Hash::remove(
				$this->request->data['SiteSetting'], 'membershipTab'
			);

			$automaticInputItems = Hash::get(
				$this->request->data, '_siteManager.automaticInputItems', 'false'
			);
			$this->Session->write('automaticInputItems', $automaticInputItems);

			$this->__parseRequestData();

			$this->SiteSetting->autoRegistRoles = $this->viewVars['userRoles'];

			//登録処理
			$this->SiteManager->saveData();

		} else {
			$this->set(
				'membershipTab',
				Hash::get($this->request->query, 'membershipTab', 'automatic-registration')
			);
			if ($this->Session->read('automaticInputItems')) {
				$automaticInputItems = $this->Session->read('automaticInputItems');
				$this->Session->delete('automaticInputItems');
			} else {
				$automaticInputItems = 'false';
			}
			$this->set('automaticInputItems', $automaticInputItems);

			$this->request->data['SiteSetting'] = $this->SiteSetting->getSiteSettingForEdit(
				array('SiteSetting.key' => array(
					// * 入会設定
					// ** 自動会員登録を許可する
					'AutoRegist.use_automatic_register',
					// ** アカウント登録の最終決定
					'AutoRegist.confirmation',
					// ** 入力キーの使用
					'AutoRegist.use_secret_key',
					// ** 入力キー
					'AutoRegist.secret_key',
					// ** 自動登録時の権限
					'AutoRegist.role_key',
					// ** 自動登録時にデフォルトルームに参加する
					'AutoRegist.prarticipate_default_room',

					// ** 自動登録時の入力項目(後で、、、会員項目設定で行う？)

					// ** 利用許諾文
					'AutoRegist.disclaimer',
					// ** 会員登録承認メールの件名
					'AutoRegist.approval_mail_subject',
					// ** 会員登録承認メールの本文
					'AutoRegist.approval_mail_body',
					// ** 会員登録受付メールの件名
					'AutoRegist.acceptance_mail_subject',
					// ** 会員登録受付メールの本文
					'AutoRegist.acceptance_mail_body',

					// ** 会員登録メールの件名
					'UserRegist.mail_subject',
					// ** 会員登録メールの本文
					'UserRegist.mail_body',

					// * 退会設定
					// ** 退会機能の設定
					'UserCancel.use_cancel_feature',
					// ** 退会規約
					'UserCancel.disclaimer',
					// ** 管理者に退会メールを送付する
					'UserCancel.notify_administrators',
					// ** 退会完了メールの件名
					'UserCancel.mail_subject',
					// ** 退会完了メールの内容
					'UserCancel.mail_body',
				)
			));
		}
	}

/**
 * 前準備
 *
 * @return void
 */
	private function __prepare() {
		//権限リスト取得
		$userRoles = $this->UserRole->find('list', array(
			'recursive' => 0,
			'fields' => array('UserRole.key', 'UserRole.name'),
			'conditions' => array(
				'UserRole.type' => UserRole::ROLE_TYPE_USER,
				'UserRole.language_id' => Current::read('Language.id'),
				'UserRoleSetting.is_site_plugins' => false
			),
			'order' => array('UserRole.id' => 'asc')
		));
		$this->set('userRoles', $userRoles);

		//会員項目リスト取得
		$userAttributes = $this->UserAttribute->find('all', array(
			'recursive' => 0,
			'fields' => array(
				'UserAttribute.name',
				'UserAttributeSetting.id',
				'UserAttributeSetting.required',
				'UserAttributeSetting.auto_regist_display',
				'UserAttributeSetting.auto_regist_weight',
			),
			'conditions' => array(
				'UserAttribute.language_id' => Current::read('Language.id'),
				'UserAttributeSetting.data_type_key NOT' => array('img', 'label'),
				'OR' => array(
					'UserAttributeSetting.user_attribute_key' => 'username',
					'UserAttributeSetting.only_administrator_editable' => false,
				),
			),
			'order' => array(
				'UserAttributeSetting.auto_regist_weight' => 'asc',
				'UserAttributeSetting.row' => 'asc',
				'UserAttributeSetting.col' => 'asc',
				'UserAttributeSetting.weight' => 'asc',
			)
		));
		$this->set('userAttributes', $userAttributes);
	}

/**
 * リクエストデータのパース処理
 *
 * @return void
 */
	private function __parseRequestData() {
		$requestData = $this->request->data['UserAttributeSetting'];

		foreach ($this->viewVars['userAttributes'] as $userAttribute) {
			$id = $userAttribute['UserAttributeSetting']['id'];
			if ($userAttribute['UserAttributeSetting']['required']) {
				$requestData[$id]['auto_regist_display'] = null;
			} elseif (! $requestData[$id]['auto_regist_display']) {
				$requestData[$id]['auto_regist_display'] = null;
				$requestData[$id]['auto_regist_weight'] = UserAttributeSetting::DEFAULT_AUTO_REGIST_DISPLAY;
			}
		}

		$this->request->data['UserAttributeSetting'] = $requestData;
	}

}
