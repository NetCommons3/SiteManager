<?php
/**
 * MailSettings Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('SiteManagerAppController', 'SiteManager.Controller');

/**
 * サイト管理【メール設定】
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\SiteManager\Controller
 */
class MailSettingsController extends SiteManagerAppController {

/**
 * use model
 *
 * @var array
 */
	//public $uses = array();

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
				'conditions' => array('key' => array(
					//本文ヘッダー
					'Mail.body_header',
					//署名
					'Mail.signature',
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
