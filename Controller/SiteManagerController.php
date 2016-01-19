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
 * use model
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
		//ルームデータ取得
		$rooms = $this->RoomsLanguage->find('all', array(
			'recursive' => 0,
			'conditions' => array(
				'RoomsLanguage.room_id' => Room::$spaceRooms,
				'RoomsLanguage.language_id' => Current::read('Language.id')
			)
		));
		$this->set('rooms', Hash::combine($rooms, '{n}.RoomsLanguage.room_id', '{n}.RoomsLanguage.name'));

		//リクエストセット
		if ($this->request->is('post')) {

		} else {
			$settings = $this->SiteSetting->find('all', array(
				'recursive' => -1,
				'conditions' => array('SiteSetting.key' => array(
					//サイト名
					'App.site_name',
					//システム標準使用言語
					'Config.language',
					//標準の開始ルーム
					'App.default_start_room',
					//サイトを閉鎖する
					'App.close_site',
					//サイト閉鎖の理由
					'App.site_closing_reason',
				))
			));
			$this->request->data['SiteSetting'] = Hash::combine($settings,
				'{n}.SiteSetting.language_id',
				'{n}.SiteSetting',
				'{n}.SiteSetting.key'
			);
		}
	}
}