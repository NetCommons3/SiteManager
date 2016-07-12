<?php
/**
 * サイト管理のSave Behavior
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('ModelBehavior', 'Model');

/**
 * サイト管理のSave Behavior
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\SiteManager\Model\Behavior
 */
class SiteManagerSaveBehavior extends ModelBehavior {

/**
 * 自動登録時で入力させる項目の登録
 *
 * @param Model $model ビヘイビア呼び出し元モデル
 * @param array $data リクエストデータ配列
 * @return array リクエストデータ
 * @throws InternalErrorException
 */
	public function saveUserAttributeSettingByUserRegist(Model $model, $data) {
		if (! isset($data['UserAttributeSetting'])) {
			return $data;
		}
		$model->loadModels([
			'UserAttributeSetting' => 'UserAttributes.UserAttributeSetting',
		]);
		if (! $model->UserAttributeSetting->saveMany($data['UserAttributeSetting'])) {
			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
		}

		unset($data['UserAttributeSetting']);

		return $data;
	}

/**
 * 自動登録メール件名・本文の登録
 *
 * @param Model $model ビヘイビア呼び出し元モデル
 * @param array $data リクエストデータ配列
 * @return array リクエストデータ
 * @throws InternalErrorException
 */
	public function saveUserRegistMail(Model $model, $data) {
		if (! isset($data[$model->alias]['UserRegist.mail_subject']) ||
				! isset($data[$model->alias]['UserRegist.mail_body'])) {
			return $data;
		}
		$model->loadModels([
			'MailSettingFixedPhrase' => 'Mails.MailSettingFixedPhrase',
		]);

		$mails = $model->MailSettingFixedPhrase->find('all', array(
			'recursive' => -1,
			'conditions' => array(
				'plugin_key' => 'user_manager',
				'type_key' => 'save_notify',
			),
		));
		foreach ($mails as $index => $mail) {
			$langId = $mail['MailSettingFixedPhrase']['language_id'];
			$subject = $data[$model->alias]['UserRegist.mail_subject'][$langId]['value'];
			$body = $data[$model->alias]['UserRegist.mail_body'][$langId]['value'];
			$mails[$index]['MailSettingFixedPhrase']['mail_fixed_phrase_subject'] = $subject;
			$mails[$index]['MailSettingFixedPhrase']['mail_fixed_phrase_body'] = $body;
		}

		if (! $model->MailSettingFixedPhrase->saveMany($mails)) {
			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
		}

		unset($data[$model->alias]['UserRegist.mail_subject']);
		unset($data[$model->alias]['UserRegist.mail_body']);

		return $data;
	}

}
