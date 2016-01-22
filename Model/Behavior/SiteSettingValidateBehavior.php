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
 * サイト設定の必須Validate処理
 *
 * @param Model $model ビヘイビア呼び出し元モデル
 * @param array $data リクエストデータ配列
 * @param string $key キー
 * @return array リクエストデータ
 */
	protected function _validateRequired(Model $model, $data, $key) {
		if (! isset($data[$model->alias][$key])) {
			return $data;
		}
		foreach ($data[$model->alias][$key] as $langId => $check) {
			if (! $check['value']) {
				$this->_setValidationMessage($model, $key, $langId,
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
	protected function _setValidationMessage(Model $model, $key, $langId, $message) {
		$model->validationErrors[$key][$langId]['value'] = array($message);
	}

}
