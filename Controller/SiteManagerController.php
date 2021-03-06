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
App::uses('Room', 'Rooms.Model');

/**
 * サイト管理【一般設定】
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\SiteManager\Controller
 */
class SiteManagerController extends SiteManagerAppController {

/**
 * 使用するモデル
 *
 * @var array
 */
	public $uses = array(
		'Rooms.RoomsLanguage',
		'SiteManager.SiteSetting',
	);

/**
 * edit
 *
 * @return void
 */
	public function edit() {
		//ルームデータ取得（とりあえず、スペースのみ）
		$rooms = $this->RoomsLanguage->find('all', array(
			'recursive' => 0,
			'conditions' => array(
				'RoomsLanguage.room_id' => Room::getSpaceRooms(),
				'RoomsLanguage.language_id' => Current::read('Language.id')
			)
		));
		$this->set('rooms', Hash::combine($rooms, '{n}.RoomsLanguage.room_id', '{n}.RoomsLanguage.name'));

		//リクエストセット
		if ($this->request->is('post')) {
			//システム標準使用言語
			$this->SiteSetting->defaultLanguages = array_merge([''], $this->viewVars['languages']);
			//標準の開始ルームのリストをセット
			$this->SiteSetting->defaultStartRoom = array_keys($this->viewVars['rooms']);

			//登録処理
			$this->SiteManager->saveData();

		} else {
			$this->request->data['SiteSetting'] = $this->SiteSetting->getSiteSettingForEdit(
				array('SiteSetting.key' => array(
					//サイト名
					'App.site_name',
					//システム標準使用言語
					'Config.language',
					//標準の開始ルーム
					'App.default_start_room',

					// * サイトの一時停止
					// ** サイトを一時停止する
					'App.close_site',
					// ** メンテナンス画面に表示する文言
					'App.site_closing_reason',

					// * パスワード再発行通知
					// ** パスワード再発行を使う
					'ForgotPass.use_password_reissue',
					// ** 新規パスワード通知の件名
					'ForgotPass.issue_mail_subject',
					// ** パスワード通知メールの本文
					'ForgotPass.issue_mail_body',
					// ** 新規パスワード発行の件名
					'ForgotPass.request_mail_subject',
					// ** パスワード発行メールの本文
					'ForgotPass.request_mail_body',
				)
			));
		}
	}
}
