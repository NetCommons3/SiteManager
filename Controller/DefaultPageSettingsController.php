<?php
/**
 * DefaultPageSettings Controller
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
 * サイト管理【ページスタイル】
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\SiteManager\Controller
 */
class DefaultPageSettingsController extends SiteManagerAppController {

/**
 * use components
 *
 * @var array
 */
	public $components = array(
		'ThemeSettings.ThemeSettings',
	);

/**
 * use model
 *
 * @var array
 */
	public $uses = array(
		'Rooms.Room',
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
		$this->set('rooms', Hash::combine($rooms, '{n}.RoomsLanguage.room_id', '{n}'));
		$this->set('activeRoomId', Hash::get($this->request->pass, '0'));

		//テーマセット
		$this->ThemeSettings->setThemes();

		//リクエストセット
		if ($this->request->is('put')) {
			$this->request->data = Hash::remove($this->request->data, 'save');

			if ($this->Room->saveTheme($this->request->data)) {
				//正常の場合
				$this->NetCommons->setFlashNotification(__d('net_commons', 'Successfully saved.'), array(
					'class' => 'success',
				));
				$this->redirect($this->referer());

			} else {
				$this->NetCommons->handleValidationError($this->Room->validationErrors);
			}

		} else {
			$this->request->data['Room'] = $this->viewVars['rooms'][$this->viewVars['activeRoomId']]['Room'];
			$this->theme = Hash::get($this->request->query, 'theme', $this->theme);
		}
	}
}
