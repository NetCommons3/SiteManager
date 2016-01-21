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

App::uses('ModelBehavior', 'Model');
App::uses('SiteSetting', 'SiteManager.Model');

/**
 * SiteSettingValidate Behavior
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\SiteManager\Model\Behavior
 */
class SiteSettingValidateBehavior extends ModelBehavior {

/**
 * 一般設定のValidate処理
 *
 * @param Model $model ビヘイビア呼び出し元モデル
 * @param array $data リクエストデータ配列
 * @return array リクエストデータ
 */
	public function validateAppSetting(Model $model, $data) {
		if (! isset($data[$model->alias]['App.site_name'])) {
			return $data;
		}

		//サイト名
		$data = $this->__validateRequired($model, $data, 'App.site_name');

		//システム標準使用言語
		if (! in_array(Hash::get($data[$model->alias]['Config.language'], '0.value'), $model->defaultLanguages, true)) {
			$this->__setValidationMessage($model, 'Config.language', '0',
					__d('net_commons', 'Invalid request.'));
		}

		//標準の開始ルーム
		if (! in_array((int)Hash::get($data[$model->alias]['App.default_start_room'], '0.value'), $model->defaultStartRoom, true)) {
			$this->__setValidationMessage($model, 'App.default_start_room', '0',
					__d('net_commons', 'Invalid request.'));
		}

		return $data;
	}

/**
 * サイト閉鎖のValidate処理
 *
 * @param Model $model ビヘイビア呼び出し元モデル
 * @param array $data リクエストデータ配列
 * @return array リクエストデータ
 */
	public function validateSiteClose(Model $model, $data) {
		if (! isset($data[$model->alias]['App.close_site'])) {
			return $data;
		}

		if (! in_array((string)Hash::get($data[$model->alias]['App.close_site'], '0.value'), ['0', '1'], true)) {
			$this->__setValidationMessage($model, 'App.close_site', '0',
					__d('net_commons', 'Invalid request.'));
		}

		return $data;
	}

/**
 * 入会・退会・承認等のValidate処理
 *
 * @param Model $model ビヘイビア呼び出し元モデル
 * @param array $data リクエストデータ配列
 * @return array リクエストデータ
 */
	public function validateMembership(Model $model, $data) {
		//入会のvalidation
		$data = $this->__validateMembershipAutoRegist($model, $data);
		//退会のvalidation
		$data = $this->__validateMembershipUserCancel($model, $data);

		//パスワード再発行・コンテンツ承認設定は、チェックは不要のため、処理ない。

		return $data;
	}

/**
 * 入会のValidate処理
 *
 * @param Model $model ビヘイビア呼び出し元モデル
 * @param array $data リクエストデータ配列
 * @return array リクエストデータ
 */
	private function __validateMembershipAutoRegist(Model $model, $data) {
		if (! isset($data[$model->alias]['AutoRegist.use_automatic_register'])) {
			return $data;
		}

		//自動会員登録を許可する
		if (! in_array((string)Hash::get($data[$model->alias]['AutoRegist.use_automatic_register'], '0.value'), ['0', '1'], true)) {
			$this->__setValidationMessage($model, 'AutoRegist.use_automatic_register', '0',
					__d('net_commons', 'Invalid request.'));
		}

		if (Hash::get($data[$model->alias]['AutoRegist.use_automatic_register'], '0.value')) {
			//自動会員登録を許可する場合、入力チェックする
			// * アカウント登録の最終決定
			if (! in_array((int)Hash::get($data[$model->alias]['AutoRegist.confirmation'], '0.value'), array_keys(SiteSetting::$autoRegistConfirm), true)) {
				$this->__setValidationMessage($model, 'AutoRegist.confirmation', '0',
						__d('net_commons', 'Invalid request.'));
			}
			// * 入力キーの使用
			if (! in_array((string)Hash::get($data[$model->alias]['AutoRegist.use_secret_key'], '0.value'), ['0', '1'], true)) {
				$this->__setValidationMessage($model, 'AutoRegist.use_secret_key', '0',
						__d('net_commons', 'Invalid request.'));
			}
			// * 自動登録時の権限
			if (! in_array(Hash::get($data[$model->alias]['AutoRegist.role_key'], '0.value'), array_keys($model->autoRegistRoles), true)) {
				$this->__setValidationMessage($model, 'AutoRegist.role_key', '0',
						__d('net_commons', 'Invalid request.'));
			}
			// * 自動登録時にデフォルトルームに参加する
			if (! in_array((string)Hash::get($data[$model->alias]['AutoRegist.prarticipate_default_room'], '0.value'), ['0', '1'], true)) {
				$this->__setValidationMessage($model, 'AutoRegist.prarticipate_default_room', '0',
						__d('net_commons', 'Invalid request.'));
			}
		} else {
			//自動会員登録を許可しない場合、リクエストデータから破棄
			$settingKeys = array_keys($data[$model->alias]);
			foreach ($settingKeys as $key) {
				if ($key === 'AutoRegist.use_automatic_register') {
					continue;
				}
				if (substr($key, 0, strlen('AutoRegist.')) === 'AutoRegist.') {
					unset($data[$model->alias][$key]);
				}
			}
		}

		return $data;
	}

/**
 * 退会のValidate処理
 *
 * @param Model $model ビヘイビア呼び出し元モデル
 * @param array $data リクエストデータ配列
 * @return array リクエストデータ
 */
	private function __validateMembershipUserCancel(Model $model, $data) {
		if (! isset($data[$model->alias]['UserCancel.use_cancel_feature'])) {
			return $data;
		}

		//退会機能を許可する
		if (! in_array((string)Hash::get($data[$model->alias]['UserCancel.use_cancel_feature'], '0.value'), ['0', '1'], true)) {
			$this->__setValidationMessage($model, 'UserCancel.use_cancel_feature', '0',
					__d('net_commons', 'Invalid request.'));
		}

		if (Hash::get($data[$model->alias]['UserCancel.use_cancel_feature'], '0.value')) {
			//自動的に退会させる場合、入力チェックする
			// * 管理者に退会メールを送付する
			if (! in_array((string)Hash::get($data[$model->alias]['UserCancel.notify_administrators'], '0.value'), ['0', '1'], true)) {
				$this->__setValidationMessage($model, 'UserCancel.notify_administrators', '0',
						__d('net_commons', 'Invalid request.'));
			}
		} else {
			//退会機能を使用しない場合、リクエストデータから破棄
			$settingKeys = array_keys($data[$model->alias]);
			foreach ($settingKeys as $key) {
				if ($key === 'UserCancel.use_cancel_feature') {
					continue;
				}
				if (substr($key, 0, strlen('UserCancel.')) === 'UserCancel.') {
					unset($data[$model->alias][$key]);
				}
			}
		}

		return $data;
	}

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
			$this->__setValidationMessage($model, 'Proxy.use_proxy', '0',
					__d('net_commons', 'Invalid request.'));
		}

		//Proxyを使う場合、Proxyサーバアドレスとポート番号は必須とする
		if (Hash::get($data[$model->alias]['Proxy.use_proxy'], '0.value')) {
			$this->__validateRequired($model, $data, 'Proxy.host');
			$this->__validateRequired($model, $data, 'Proxy.port');
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
				$this->__setValidationMessage($model, 'App.default_timezone', $langId,
						__d('net_commons', 'Invalid request.'));
			}
		}

		//グループルームの容量
		if (! in_array((int)Hash::get($data[$model->alias]['App.disk_for_group_room'], '0.value'), SiteSetting::$diskSpace, true)) {
			$this->__setValidationMessage($model, 'App.disk_for_group_room', '0',
					__d('net_commons', 'Invalid request.'));
		}

		//プライベートルームの容量
		if (! in_array((int)Hash::get($data[$model->alias]['App.disk_for_private_room'], '0.value'), SiteSetting::$diskSpace, true)) {
			$this->__setValidationMessage($model, 'App.disk_for_private_room', '0',
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
			$this->__setValidationMessage($model, 'Php.memory_limit', '0',
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
		$this->__validateRequired($model, $data, 'Mail.from');

		//メール形式
		if (! in_array(Hash::get($data[$model->alias]['Mail.messageType'], '0.value'), array_keys(SiteSetting::$mailMessageType), true)) {
			$this->__setValidationMessage($model, 'Mail.messageType', '0',
					__d('net_commons', 'Invalid request.'));
		}

		//メール送信方法
		if (! in_array(Hash::get($data[$model->alias]['Mail.transport'], '0.value'), array_keys(SiteSetting::$mailTransport), true)) {
			$this->__setValidationMessage($model, 'Mail.transport', '0',
					__d('net_commons', 'Invalid request.'));
		}

		//メール送信方法がSMTPの場合、SMTPサーバアドレスとポート番号は必須とする
		if (Hash::get($data[$model->alias]['Mail.transport'], '0.value') === SiteSetting::MAIL_TRANSPORT_SMTP) {
			$this->__validateRequired($model, $data, 'Mail.smtp.host');
			$this->__validateRequired($model, $data, 'Mail.smtp.port');
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
			$this->__setValidationMessage($model, 'debug', '0',
					__d('net_commons', 'Invalid request.'));
		}

		return $data;
	}

/**
 * サイト設定の必須Validate処理
 *
 * @param Model $model ビヘイビア呼び出し元モデル
 * @param array $data リクエストデータ配列
 * @param string $key キー
 * @return array リクエストデータ
 */
	private function __validateRequired(Model $model, $data, $key) {
		if (! isset($data[$model->alias][$key])) {
			return $data;
		}
		foreach ($data[$model->alias][$key] as $langId => $check) {
			if (! $check['value']) {
				$this->__setValidationMessage($model, $key, $langId,
						sprintf(__d('net_commons', 'Please input %s.'), __d($model->messagePlugin, $key)));
			}
		}
		return $data;
	}

/**
 * validationMessageのセット処理
 *
 * @param Model $model ビヘイビア呼び出し元モデル
 * @param string $key キー
 * @param int $langId 言語ID
 * @param string $message メッセージ
 * @return array リクエストデータ
 */
	private function __setValidationMessage(Model $model, $key, $langId, $message) {
		$model->validationErrors[$key][$langId]['value'] = array($message);
	}

}
