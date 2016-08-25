<?php
/**
 * IpAddress管理 Behavior
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('SiteSettingValidateBehavior', 'SiteManager.Model/Behavior');
App::uses('Current', 'NetCommons.Utility');

/**
 * IpAddress管理 Behavior
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\SiteManager\Model\Behavior
 */
class IpAddressManagerBehavior extends SiteSettingValidateBehavior {

/**
 * IPアドレスのアクセス拒否のValidate処理
 *
 * @param Model $model ビヘイビア呼び出し元モデル
 * @param array $data リクエストデータ配列
 * @return void
 */
	public function validateBadIps(Model $model, $data) {
		//IPアドレスでアクセスを拒否する
		$value = (string)Hash::get($data[$model->alias]['Security.enable_bad_ips'], '0.value');
		if (! in_array($value, ['0', '1'], true)) {
			$this->_setValidationMessage($model, 'Security.enable_bad_ips', '0',
					__d('net_commons', 'Invalid request.'));
		}

		//アクセスを拒否するIPアドレス
		if ((string)Hash::get($data[$model->alias]['Security.enable_bad_ips'], '0.value') === '1') {
			$this->validateIp($model, $data, 'Security.bad_ips');

			$ips = $data[$model->alias]['Security.bad_ips']['0']['value'];
			if (! $this->_hasValidationError($model, 'Security.bad_ips', '0')) {
				if ($this->hasCurrentIp($model, $ips)) {
					$this->_setValidationMessage(
						$model, 'Security.bad_ips', '0',
						__d('system_manager',
								'Contains the current IP address. Please excluded from the list.')
					);
				}
			}
		}
	}

/**
 * 管理画面のアクセスのIPアドレス制御のValidate処理
 *
 * @param Model $model ビヘイビア呼び出し元モデル
 * @param array $data リクエストデータ配列
 * @return void
 */
	public function validateAllowSystemPluginIps(Model $model, $data) {
		//管理画面のアクセスをIPアドレスで制御する
		$value = (string)Hash::get(
			$data[$model->alias]['Security.enable_allow_system_plugin_ips'], '0.value'
		);
		if (! in_array($value, ['0', '1'], true)) {
			$this->_setValidationMessage($model, 'Security.enable_allow_system_plugin_ips', '0',
					__d('net_commons', 'Invalid request.'));
		}

		//アクセスを許可するIPアドレス
		$value = (string)Hash::get(
			$data[$model->alias]['Security.enable_allow_system_plugin_ips'], '0.value'
		);
		if ($value === '1') {
			$this->validateIp($model, $data, 'Security.allow_system_plugin_ips');

			$ips = $data[$model->alias]['Security.allow_system_plugin_ips']['0']['value'];
			if (! $this->_hasValidationError($model, 'Security.allow_system_plugin_ips', '0')) {
				if (! $this->hasCurrentIp($model, $ips)) {
					$this->_setValidationMessage(
						$model,
						'Security.allow_system_plugin_ips', '0',
						__d('system_manager',
								'It does not include the current IP address. Please add to the list.')
					);
				}
			}
		}
	}

/**
 * 現在アクセスしているIPアドレスの取得
 *
 * @param Model $model ビヘイビア呼び出し元モデル
 * @return string
 */
	public function getCurrentIp(Model $model) {
		return Hash::get($_SERVER, 'HTTP_X_FORWARDED_FOR', Hash::get($_SERVER, 'REMOTE_ADDR'));
	}

/**
 * 現在アクセスしているIPアドレスがあるかどうか
 *
 * @param Model $model ビヘイビア呼び出し元モデル
 * @param array|string $ips IPアドレスリスト
 * @return bool
 */
	public function hasCurrentIp(Model $model, $ips) {
		if (! $ips) {
			return false;
		}

		if (is_string($ips)) {
			$ips = explode('|', $ips);
		}

		$currentIp = $this->getCurrentIp($model);
		if (! $currentIp) {
			return false;
		}
		foreach ($ips as $accept) {
			if (strpos($accept, '/')) {
				list($acceptIp, $mask) = explode('/', $accept);
			} else {
				$acceptIp = $accept;
				$mask = 32;
			}
			$acceptLong = ip2long($acceptIp) >> (32 - $mask);
			$currentLong = ip2long($currentIp) >> (32 - $mask);
			if ($acceptLong === $currentLong) {
				return true;
			}
		}

		return false;
	}

/**
 * IPアドレスのFormatチェック
 *
 * @param Model $model ビヘイビア呼び出し元モデル
 * @param array $data リクエストデータ配列
 * @param string $key IPアドレスリスト
 * @return bool
 */
	public function validateIp(Model $model, $data, $key) {
		//必須チェック
		$this->_validateRequired($model, $data, $key);
		if ($this->_hasValidationError($model, $key, '0')) {
			return false;
		}

		$ips = explode('|', $data[$model->alias][$key]['0']['value']);

		//フォーマットチェック
		$formatErrorMessage = __d(
			'net_commons', 'Unauthorized pattern for %s. Please input the data in %s format.'
		);
		foreach ($ips as $accept) {
			if (strpos($accept, '/')) {
				list($acceptIp, $mask) = explode('/', $accept);
			} else {
				$acceptIp = $accept;
				$mask = 32;
			}
			$acceptLong = ip2long($acceptIp) >> (32 - $mask);

			if (ip2long($acceptIp) === -1 || ip2long($acceptIp) === false || ! $acceptLong) {
				$this->_setValidationMessage(
					$model, $key, '0',
					sprintf($formatErrorMessage, __d('system_manager', $key), __d('net_commons', 'IP Address'))
				);
				return false;
			}
		}

		return true;
	}

}
