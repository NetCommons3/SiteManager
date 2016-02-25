<?php
/**
 * SiteManagerValidateBehavior Behavior
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
class SiteManagerValidateBehavior extends SiteSettingValidateBehavior {

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
		$data = $this->_validateRequired($model, $data, 'App.site_name');

		//システム標準使用言語
		if (! in_array(Hash::get($data[$model->alias]['Config.language'], '0.value'), $model->SiteSetting->defaultLanguages, true)) {
			$this->_setValidationMessage($model, 'Config.language', '0',
					__d('net_commons', 'Invalid request.'));
		}

		//標準の開始ルーム
		if (! in_array((int)Hash::get($data[$model->alias]['App.default_start_room'], '0.value'), $model->SiteSetting->defaultStartRoom, true)) {
			$this->_setValidationMessage($model, 'App.default_start_room', '0',
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
			$this->_setValidationMessage($model, 'App.close_site', '0',
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
		if (isset($data[$model->alias]['AutoRegist.use_automatic_register'])) {
			$data = $this->__validateMembershipAutoRegist($model, $data);
		}
		//退会のvalidation
		if (isset($data[$model->alias]['UserCancel.use_cancel_feature'])) {
			$data = $this->__validateMembershipUserCancel($model, $data);
		}

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
		//自動会員登録を許可する
		if (! in_array((string)Hash::get($data[$model->alias]['AutoRegist.use_automatic_register'], '0.value'), ['0', '1'], true)) {
			$this->_setValidationMessage($model, 'AutoRegist.use_automatic_register', '0',
					__d('net_commons', 'Invalid request.'));
		}

		if (Hash::get($data[$model->alias]['AutoRegist.use_automatic_register'], '0.value')) {
			//自動会員登録を許可する場合、入力チェックする
			// * アカウント登録の最終決定
			if (! in_array((int)Hash::get($data[$model->alias]['AutoRegist.confirmation'], '0.value'),
													array_keys($model->SiteSetting->autoRegistConfirm), true)) {
				$this->_setValidationMessage($model, 'AutoRegist.confirmation', '0',
						__d('net_commons', 'Invalid request.'));
			}
			// * 入力キーの使用
			if (! in_array((string)Hash::get($data[$model->alias]['AutoRegist.use_secret_key'], '0.value'), ['0', '1'], true)) {
				$this->_setValidationMessage($model, 'AutoRegist.use_secret_key', '0',
						__d('net_commons', 'Invalid request.'));
			}
			// * 自動登録時の権限
			if (! in_array(Hash::get($data[$model->alias]['AutoRegist.role_key'], '0.value'),
													array_keys($model->SiteSetting->autoRegistRoles), true)) {
				$this->_setValidationMessage($model, 'AutoRegist.role_key', '0',
						__d('net_commons', 'Invalid request.'));
			}
			// * 自動登録時にデフォルトルームに参加する
			if (! in_array((string)Hash::get($data[$model->alias]['AutoRegist.prarticipate_default_room'], '0.value'), ['0', '1'], true)) {
				$this->_setValidationMessage($model, 'AutoRegist.prarticipate_default_room', '0',
						__d('net_commons', 'Invalid request.'));
			}
		} else {
			//自動会員登録を許可しない場合、リクエストデータから破棄
			$settingKeys = $data[$model->alias];
			unset($settingKeys['AutoRegist.use_automatic_register']);
			$settingKeys = array_keys($data[$model->alias]);

			foreach ($settingKeys as $key) {
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
		//退会機能を許可する
		if (! in_array((string)Hash::get($data[$model->alias]['UserCancel.use_cancel_feature'], '0.value'), ['0', '1'], true)) {
			$this->_setValidationMessage($model, 'UserCancel.use_cancel_feature', '0',
					__d('net_commons', 'Invalid request.'));
		}

		if (Hash::get($data[$model->alias]['UserCancel.use_cancel_feature'], '0.value')) {
			//自動的に退会させる場合、入力チェックする
			// * 管理者に退会メールを送付する
			if (! in_array((string)Hash::get($data[$model->alias]['UserCancel.notify_administrators'], '0.value'), ['0', '1'], true)) {
				$this->_setValidationMessage($model, 'UserCancel.notify_administrators', '0',
						__d('net_commons', 'Invalid request.'));
			}
		} else {
			//退会機能を使用しない場合、リクエストデータから破棄
			$settingKeys = $data[$model->alias];
			unset($settingKeys['UserCancel.use_cancel_feature']);
			$settingKeys = array_keys($data[$model->alias]);

			foreach ($settingKeys as $key) {
				if (substr($key, 0, strlen('UserCancel.')) === 'UserCancel.') {
					unset($data[$model->alias][$key]);
				}
			}
		}

		return $data;
	}

}
