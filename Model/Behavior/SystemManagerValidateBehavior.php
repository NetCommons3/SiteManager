<?php
/**
 * SiteSettingValidate Behavior
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('SiteSettingValidateBehavior', 'SiteManager.Model/Behavior');

/**
 * SiteSettingValidate Behavior
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\SiteManager\Model\Behavior
 */
class SystemManagerValidateBehavior extends SiteSettingValidateBehavior {

/**
 * プロキシ設定のValidate処理
 *
 * @param Model $model ビヘイビア呼び出し元モデル
 * @param array $data リクエストデータ配列
 * @return array リクエストデータ
 */
	public function validateProxy(Model $model, $data) {
		if (! isset($data[$model->alias]['Proxy.use_proxy'])) {
			return $data;
		}

		if (! in_array((string)Hash::get($data[$model->alias]['Proxy.use_proxy'], '0.value'), ['0', '1'], true)) {
			$this->_setValidationMessage($model, 'Proxy.use_proxy', '0',
					__d('net_commons', 'Invalid request.'));
		}

		//Proxyを使う場合、Proxyサーバアドレスとポート番号は必須とする
		if (Hash::get($data[$model->alias]['Proxy.use_proxy'], '0.value')) {
			$this->_validateRequired($model, $data, 'Proxy.host');
			$this->_validateRequired($model, $data, 'Proxy.port');
		} else {
			unset($data['Proxy.host'], $data['Proxy.port'], $data['Proxy.user'], $data['Proxy.pass']);
		}

		return $data;
	}

/**
 * システム設定のValidate処理
 *
 * @param Model $model ビヘイビア呼び出し元モデル
 * @param array $data リクエストデータ配列
 * @return array リクエストデータ
 */
	public function validateSystemSetting(Model $model, $data) {
		if (! isset($data[$model->alias]['App.default_timezone']) ||
				! isset($data[$model->alias]['App.disk_for_group_room']) ||
				! isset($data[$model->alias]['App.disk_for_private_room'])) {
			return $data;
		}

		//デフォルトのタイムゾーン
		foreach ($data[$model->alias]['App.default_timezone'] as $langId => $check) {
			if (! in_array(Hash::get($check, 'value'), array_keys(SiteSetting::$defaultTimezones), true)) {
				$this->_setValidationMessage($model, 'App.default_timezone', $langId,
						__d('net_commons', 'Invalid request.'));
			}
		}

		//グループルームの容量
		if (! in_array((int)Hash::get($data[$model->alias]['App.disk_for_group_room'], '0.value'), SiteSetting::$diskSpace, true)) {
			$this->_setValidationMessage($model, 'App.disk_for_group_room', '0',
					__d('net_commons', 'Invalid request.'));
		}

		//プライベートルームの容量
		if (! in_array((int)Hash::get($data[$model->alias]['App.disk_for_private_room'], '0.value'), SiteSetting::$diskSpace, true)) {
			$this->_setValidationMessage($model, 'App.disk_for_private_room', '0',
					__d('net_commons', 'Invalid request.'));
		}

		return $data;
	}

/**
 * ログイン・ログアウト設定のValidate処理
 *
 * @param Model $model ビヘイビア呼び出し元モデル
 * @param array $data リクエストデータ配列
 * @return array リクエストデータ
 */
	public function validateAuthSetting(Model $model, $data) {
		if (! isset($data[$model->alias]['Session.ini.session.cookie_lifetime'])) {
			return $data;
		}

		//自動ログアウトするまでの時間
		if (! in_array((int)Hash::get($data[$model->alias]['Session.ini.session.cookie_lifetime'], '0.value'), array_keys(SiteSetting::$sessionTimeout), true)) {
			$this->_setValidationMessage($model, 'Session.ini.session.cookie_lifetime', '0',
					__d('net_commons', 'Invalid request.'));
		}

		//SSLを有効にする
		if (! in_array((string)Hash::get($data[$model->alias]['Auth.use_ssl'], '0.value'), ['0', '1'], true)) {
			$this->_setValidationMessage($model, 'Auth.use_ssl', '0',
					__d('net_commons', 'Invalid request.'));
		}

		return $data;
	}

/**
 * Webサーバ設定のValidate処理
 *
 * @param Model $model ビヘイビア呼び出し元モデル
 * @param array $data リクエストデータ配列
 * @return array リクエストデータ
 */
	public function validateWebServer(Model $model, $data) {
		if (! isset($data[$model->alias]['Php.memory_limit'])) {
			return $data;
		}

		//PHP最大メモリ数
		if (! in_array(Hash::get($data[$model->alias]['Php.memory_limit'], '0.value'), array_keys(SiteSetting::$memoryLimit), true)) {
			$this->_setValidationMessage($model, 'Php.memory_limit', '0',
					__d('net_commons', 'Invalid request.'));
		}

		return $data;
	}

/**
 * メールサーバ設定のValidate処理
 *
 * @param Model $model ビヘイビア呼び出し元モデル
 * @param array $data リクエストデータ配列
 * @return array リクエストデータ
 */
	public function validateMailServer(Model $model, $data) {
		if (! isset($data[$model->alias]['Mail.from'])) {
			return $data;
		}

		//送信者メールアドレス
		$this->_validateRequired($model, $data, 'Mail.from');

		//メール形式
		if (! in_array(Hash::get($data[$model->alias]['Mail.messageType'], '0.value'), array_keys(SiteSetting::$mailMessageType), true)) {
			$this->_setValidationMessage($model, 'Mail.messageType', '0',
					__d('net_commons', 'Invalid request.'));
		}

		//メール送信方法
		if (! in_array(Hash::get($data[$model->alias]['Mail.transport'], '0.value'), array_keys(SiteSetting::$mailTransport), true)) {
			$this->_setValidationMessage($model, 'Mail.transport', '0',
					__d('net_commons', 'Invalid request.'));
		}

		//メール送信方法がSMTPの場合、SMTPサーバアドレスとポート番号は必須とする
		if (Hash::get($data[$model->alias]['Mail.transport'], '0.value') === SiteSetting::MAIL_TRANSPORT_SMTP) {
			$this->_validateRequired($model, $data, 'Mail.smtp.host');
			$this->_validateRequired($model, $data, 'Mail.smtp.port');
		} else {
			unset($data['Mail.smtp.host'], $data['Mail.smtp.port'], $data['Mail.smtp.user'], $data['Mail.smtp.pass']);
		}

		return $data;
	}

/**
 * 開発者向けのValidate処理
 *
 * @param Model $model ビヘイビア呼び出し元モデル
 * @param array $data リクエストデータ配列
 * @return array リクエストデータ
 */
	public function validateDeveloper(Model $model, $data) {
		if (! isset($data[$model->alias]['debug'])) {
			return $data;
		}

		//デバッグのチェック
		if (! in_array((int)Hash::get($data[$model->alias]['debug'], '0.value'), array_keys(SiteSetting::$debugOptions), true)) {
			$this->_setValidationMessage($model, 'debug', '0',
					__d('net_commons', 'Invalid request.'));
		}

		return $data;
	}

}
