<?php
/**
 * Workflow Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('SiteManagerAppController', 'SiteManager.Controller');

/**
 * サイト管理【コンテンツ承認設定】
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\SiteManager\Controller
 */
class WorkflowController extends SiteManagerAppController {

/**
 * use model
 *
 * @var array
 */
	public $uses = array(
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
			//登録処理
			$this->SiteManager->saveData();

		} else {
			$this->request->data['SiteSetting'] = $this->SiteSetting->getSiteSettingForEdit(
				array('SiteSetting.key' => array(
					// * コンテンツ承認設定
					// ** 申請メールの件名
					'Workflow.approval_mail_subject',
					// ** 申請メールの本文
					'Workflow.approval_mail_body',
					// ** 差し戻しメールの件名
					'Workflow.disapproval_mail_subject',
					// ** 差し戻しメールの本文
					'Workflow.disapproval_mail_body',
					// ** 承認完了メールの件名
					'Workflow.approval_completion_mail_subject',
					// ** 承認完了メールの本文
					'Workflow.approval_completion_mail_body',
				)
			));
		}
	}
}
