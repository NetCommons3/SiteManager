<?php
/**
 * Migration file
 *
 * @author Mitsuru Mutaguchi <mutaguchi@opensource-workshop.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsMigration', 'NetCommons.Config/Migration');

/**
 * システム管理用データ - 担当者への連絡通知
 *
 * @package NetCommons\SiteManager\Config\Migration
 */
class ContactAfterApprovalMail extends NetCommonsMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'contact_after_approval_mail';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
		),
		'down' => array(
		),
	);

/**
 * recodes
 *
 * @var array $migration
 */
	public $records = array(
		'SiteSetting' => array(
			// ** 担当者への連絡メールの件名
			// *** 日本語
			array(
				'language_id' => '2',
				'key' => 'Workflow.contact_after_approval_mail_subject',
				'value' => '(担当者への連絡){X-PLUGIN_MAIL_SUBJECT}',
			),
			// *** 英語
			array(
				'language_id' => '1',
				'key' => 'Workflow.contact_after_approval_mail_subject',
				'value' => '(contact the person in charge){X-PLUGIN_MAIL_SUBJECT}',
			),
			// ** 担当者への連絡メールの本文
			// *** 日本語
			array(
				'language_id' => '2',
				'key' => 'Workflow.contact_after_approval_mail_body',
				'value' => '{X-USER}さんから{X-PLUGIN_NAME}の担当者への連絡があったことをお知らせします。

{X-WORKFLOW_COMMENT}


{X-PLUGIN_MAIL_BODY}',
			),
			// *** 英語
			array(
				'language_id' => '1',
				'key' => 'Workflow.contact_after_approval_mail_body',
				'value' => 'Let you know that there was a report from {X-USER} \'s to the person in charge of {X-PLUGIN_NAME}.

{X-WORKFLOW_COMMENT}


{X-PLUGIN_MAIL_BODY}',
			),
		),
	);

/**
 * Before migration callback
 *
 * @param string $direction Direction of migration process (up or down)
 * @return bool Should process continue
 */
	public function before($direction) {
		return true;
	}

/**
 * After migration callback
 *
 * @param string $direction Direction of migration process (up or down)
 * @return bool Should process continue
 */
	public function after($direction) {
		if ($direction === 'down') {
			return true;
		}

		foreach ($this->records as $model => $records) {
			if (!$this->updateRecords($model, $records)) {
				return false;
			}
		}
		return true;
	}
}
