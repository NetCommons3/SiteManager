<?php
/**
 * SystemManagerValidate Behavior
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('SiteSettingValidateBehavior', 'SiteManager.Model/Behavior');

/**
 * SystemManagerValidate Behavior
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

		$value = (string)Hash::get($data[$model->alias]['Proxy.use_proxy'], '0.value');
		if (! in_array($value, ['0', '1'], true)) {
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
		$value = Hash::get($data[$model->alias]['App.default_timezone'], '0.value');
		if (! in_array($value, array_keys($model->SiteSetting->defaultTimezones), true)) {
			$this->_setValidationMessage($model, 'App.default_timezone', '0',
					__d('net_commons', 'Invalid request.'));
		}

		//パブリックルームの容量
		$value = (int)Hash::get($data[$model->alias]['App.disk_for_public_room'], '0.value');
		if (! in_array($value, $model->SiteSetting->diskSpace, true)) {
			$this->_setValidationMessage($model, 'App.disk_for_public_room', '0',
				__d('net_commons', 'Invalid request.'));
		}

		//グループルームの容量
		$value = (int)Hash::get($data[$model->alias]['App.disk_for_group_room'], '0.value');
		if (! in_array($value, $model->SiteSetting->diskSpace, true)) {
			$this->_setValidationMessage($model, 'App.disk_for_group_room', '0',
					__d('net_commons', 'Invalid request.'));
		}

		//プライベートルームの容量
		$value = (int)Hash::get($data[$model->alias]['App.disk_for_private_room'], '0.value');
		if (! in_array($value, $model->SiteSetting->diskSpace, true)) {
			$this->_setValidationMessage($model, 'App.disk_for_private_room', '0',
					__d('net_commons', 'Invalid request.'));
		}

		return $data;
	}

/**
 * セッションタイムアウトのValidate処理
 *
 * @param Model $model ビヘイビア呼び出し元モデル
 * @param array $data リクエストデータ配列
 * @return array リクエストデータ
 */
	public function validateSession(Model $model, $data) {
		if (! isset($data[$model->alias]['Session.ini.[session.cookie_lifetime]'])) {
			return $data;
		}

		//自動ログアウトするまでの時間
		$value = Hash::get($data[$model->alias]['Session.ini.[session.cookie_lifetime]'], '0.value');
		if (! in_array((int)$value, array_keys($model->SiteSetting->sessionTimeout), true)) {
			$this->_setValidationMessage($model, 'Session.ini.[session.cookie_lifetime]', '0',
					__d('net_commons', 'Invalid request.'));
		}
		$data[$model->alias]['Session.ini.[session.gc_maxlifetime]']['0']['value'] = $value;

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
		$value = Hash::get($data[$model->alias]['Php.memory_limit'], '0.value');
		if (! in_array($value, array_keys($model->SiteSetting->memoryLimit), true)) {
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
		$value = Hash::get($data[$model->alias]['Mail.messageType'], '0.value');
		if (! in_array($value, array_keys($model->SiteSetting->mailMessageType), true)) {
			$this->_setValidationMessage($model, 'Mail.messageType', '0',
					__d('net_commons', 'Invalid request.'));
		}

		//メール送信方法
		$value = Hash::get($data[$model->alias]['Mail.transport'], '0.value');
		if (! in_array($value, array_keys($model->SiteSetting->mailTransport), true)) {
			$this->_setValidationMessage($model, 'Mail.transport', '0',
					__d('net_commons', 'Invalid request.'));
		}

		//メール送信方法がSMTPの場合、SMTPサーバアドレスとポート番号は必須とする
		$value = Hash::get($data[$model->alias]['Mail.transport'], '0.value');
		if ($value === SiteSetting::MAIL_TRANSPORT_SMTP) {
			$this->_validateRequired($model, $data, 'Mail.smtp.host');
			$this->_validateRequired($model, $data, 'Mail.smtp.port');
		} else {
			unset(
				$data['Mail.smtp.host'], $data['Mail.smtp.port'],
				$data['Mail.smtp.user'], $data['Mail.smtp.pass']
			);
		}

		return $data;
	}

/**
 * セキュリティ設定のValidate処理
 *
 * @param Model $model ビヘイビア呼び出し元モデル
 * @param array $data リクエストデータ配列
 * @return array リクエストデータ
 */
	public function validateSecuritySettings(Model $model, $data) {
		if (! isset($data[$model->alias]['Upload.allow_extension'])) {
			return $data;
		}

		//アップロードファイルを許可する拡張子
		$this->_validateRequired($model, $data, 'Upload.allow_extension');

		//IPアドレスでアクセスを拒否する
		$model->validateBadIps($data);

		//管理画面のアクセスをIPアドレスで制御する
		$model->validateAllowSystemPluginIps($data);

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
		$value = (int)Hash::get($data[$model->alias]['debug'], '0.value');
		if (! in_array($value, array_keys($model->SiteSetting->debugOptions), true)) {
			$this->_setValidationMessage($model, 'debug', '0',
					__d('net_commons', 'Invalid request.'));
		}

		return $data;
	}

}
