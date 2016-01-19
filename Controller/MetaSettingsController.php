<?php
/**
 * MetaSettings Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('SiteManagerAppController', 'SiteManager.Controller');

/**
 * サイト管理【メタ情報】
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\SiteManager\Controller
 */
class MetaSettingsController extends SiteManagerAppController {

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
		//リクエストセット
		if ($this->request->is('post')) {

		} else {
			$settings = $this->SiteSetting->find('all', array(
				'recursive' => -1,
				'conditions' => array('SiteSetting.key' => array(
					//作成者
					'Meta.author',
					//著作権表示
					'Meta.copyright',
					//キーワード
					'Meta.keywords',
					//サイトの説明
					'Meta.description',
					//ロボット型検索エンジンへの対応
					'Meta.robots',
					//閲覧対象年齢層の指定
					'Meta.rating',
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
