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

/**
 * SiteSettingValidate Behavior
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\SiteManager\Model\Behavior
 */
class SiteSettingValidateBehavior extends ModelBehavior {

/**
 * Setup this behavior with the specified configuration settings.
 *
 * @param Model $model Model using this behavior
 * @param array $config Configuration settings for $model
 * @return void
 */
	public function setup(Model $model, $config = array()) {
		parent::setup($model, $config);

		$model->loadModels([
			'SiteSetting' => 'SiteManager.SiteSetting',
		]);
	}

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
 * Wysiwygのクレンジング
 *
 * @param Model $model ビヘイビア呼び出し元モデル
 * @param array $data リクエストデータ配列
 * @param string $key キー
 * @return array リクエストデータ
 */
	protected function _cleansingWysiwyg(Model $model, $data, $key) {
		if (! isset($data[$model->alias][$key])) {
			return $data;
		}

		$model->Behaviors->load('Wysiwyg.Purifiable', [
			'fields' => [$model->alias => ['value']],
		]);

		foreach ($data[$model->alias][$key] as $langId => $check) {
			$model->create($check);
			$model->validates();
			$data[$model->alias][$key][$langId] = $model->data[$model->alias];
		}

		$model->Behaviors->unload('Wysiwyg.Purifiable');
		return $data;
	}

/**
 * validationMessageの有無
 *
 * @param Model $model ビヘイビア呼び出し元モデル
 * @param string $key キー
 * @param int $langId 言語ID
 * @return bool
 */
	protected function _hasValidationError(Model $model, $key, $langId) {
		if (isset($model->validationErrors[$key][$langId]['value']) &&
				$model->validationErrors[$key][$langId]['value']) {
			return true;
		} else {
			return false;
		}
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
