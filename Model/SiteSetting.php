<?php
/**
 * SiteSetting Model
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('Current', 'NetCommons.Utility');
App::uses('SiteManagerAppModel', 'SiteManager.Model');

/**
 * SiteSetting Model
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\SiteSetting\Model
 */
class SiteSetting extends SiteManagerAppModel {

/**
 * サイトに設定されているテーマを返す
 *
 * @return string or null
 */
	public function getSiteTheme() {
		$row = $this->find('first', array(
			'conditions' => array('SiteSetting.key' => 'theme'),
		));
		if ($row && isset($row['SiteSetting'])
			&& isset($row['SiteSetting']['value'])) {
			return $row['SiteSetting']['value'];
		}
		return null;
	}

/**
 * サイトのデフォルトタイムゾーン（未ログインのゲスト用）を返す
 *
 * @return string timezone
 */
	public function getSiteTimezone() {
		$languageId = Current::read('Language.id');
		$setting = $this->findByLanguageIdAndKey($languageId, 'App.default_timezone');
		$timezone = $setting['SiteSetting']['value'];
		return $timezone;
	}

/**
 * サイトのデフォルトタイムゾーン（未ログインのゲスト用）を返す
 *
 * @return bool True on success, false on validation errors
 * @return array サイト設定データ配列
 */
	public function getSiteSettingForEdit($conditions = array()) {
		$settings = $this->find('all', array(
			'recursive' => -1,
			'conditions' => $conditions
		));
		$settings = Hash::combine($settings,
			'{n}.SiteSetting.language_id',
			'{n}.SiteSetting',
			'{n}.SiteSetting.key'
		);

		return $settings;
	}

/**
 * サイト設定の登録処理
 *
 * @param array $data received post data
 * @return bool True on success, false on validation errors
 * @throws InternalErrorException
 */
	public function saveSiteSetting($data) {
		//トランザクションBegin
		$this->begin();

		//バリデーション
		if (! $this->validateSiteSetting($data)) {
			return false;
		}

		try {
			//登録処理
//			if (! $this->save(null, false)) {
//				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
//			}

			//トランザクションCommit
			$this->commit();

		} catch (Exception $ex) {
			//トランザクションRollback
			$this->rollback($ex);
		}

		return true;
	}

/**
 * サイト設定のValidate処理
 *
 * @param array $data received post data
 * @return bool True on success, false on validation errors
 */
//	public function validateSiteSetting($data) {
//		if (isset($data[$this->alias]['App.site_name'])) {
//			foreach ($data[$this->alias]['App.site_name'] as $langId => $check) {
//				if (! $check['value']) {
//					$this->validationErrors['App.site_name'][$langId]['value'] = array(
//						sprintf(__d('net_commons', 'Please input %s.'), __d('site_manager', 'App.site_name')),
//					);
//				}
//			}
//		}
//
//		return ! $this->validationErrors;
//	}

}

