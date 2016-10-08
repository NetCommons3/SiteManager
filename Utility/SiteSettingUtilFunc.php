<?php
/**
 * SiteSetting Utility
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * SiteSetting Utility
 *
 * サイトの設定として必要な情報を保持します。<br>
 * [NetCommonsAppController::beforeFilter](../NetCommons/classes/NetCommonsAppController.html#method_beforeFilter)
 * で初期処理が呼び出され、値が設定されます。<br>
 * 値を取得する時は、[readメソッド](#method_read)を使用します。<br>
 * 値を保持する時は、[writeメソッド](#method_write)を使用します。<br>
 * 値を削除する時は、[removeメソッド](#method_remove)を使用します。<br>
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\SiteManager\Utility
 */
class SiteSettingUtilFunc {

/**
 * SiteSetting::readの再帰処理
 *
 * @param array &$result 結果データ
 * @param array $valueArray セットする値
 * @param mixed $default デフォルト値
 * @param int $langId 言語ID(Language.id)
 * @return mixed
 */
	public function getReadData(&$result, $valueArray, $default, $langId) {
		if (isset($valueArray[$langId])) {
			return $valueArray[$langId];
		} elseif (isset($valueArray['0'])) {
			return $valueArray['0'];
		} elseif (isset($default) && ! is_array($default)) {
			return $default;
		} else {
			$result = $this->getReadDataArray($result, $valueArray, $default, $langId);
		}

		return $result;
	}

/**
 * SiteSetting::readの再帰処理
 *
 * @param array &$result 結果データ
 * @param array $valueArray セットする値
 * @param mixed $default デフォルト値
 * @param int $langId 言語ID(Language.id)
 * @return mixed
 */
	public function getReadDataArray(&$result, $valueArray, $default, $langId) {
		foreach ($valueArray as $key2 => $value2) {
			if (is_array($value2)) {
				if (isset($value2[$langId])) {
					$result[$key2] = $value2[$langId];
				} elseif (isset($value2['0'])) {
					$result[$key2] = $value2['0'];
				} elseif (isset($default[$key2])) {
					$result[$key2] = $default[$key2];
				} else {
					$result[$key2] = array();
					if (isset($default[$key2])) {
						$default2 = $default[$key2];
					} else {
						$default2 = null;
					}
					$this->getReadDataArray($result[$key2], $value2, $default2, $langId);
				}
			} else {
				$result[$key2] = $value2;
			}
		}

		return $result;
	}

/**
 * AcceptLanguageの値を返します。
 *
 * @return array|null SiteSettingデータ
 */
	public function acceptLanguage() {
		//言語データ取得
		$Language = ClassRegistry::init('M17n.Language');
		$languages = $Language->getLanguage('list', array(
			'fields' => array('code', 'code'),
		));

		$maximalNum = 0;
		$acceptLanguage = explode(',', Hash::get($_SERVER, 'HTTP_ACCEPT_LANGUAGE', 'ja'));
		$usedLanguage = 'ja';
		foreach ($acceptLanguage as $value) {
			$pri = explode(';', trim($value));
			if (isset($pri[1])) {
				$num = (float)preg_replace('/^q=/', '', $pri[1]);
			} else {
				$num = 1;
			}
			if ($num > $maximalNum) {
				$priKey = '';
				if (array_key_exists($pri[0], $languages)) {
					$priKey = $pri[0];
				} elseif (strpos($pri[0], '-') !== false) {
					$priKey = substr($pri[0], 0, strpos($pri[0], '-'));
				}
				if (array_key_exists($priKey, $languages)) {
					$maximalNum = $num;
					$usedLanguage = $languages[$priKey];
				}
			}
		}
		return $usedLanguage;
	}

/**
 * SiteSetting::writeの再帰処理
 *
 * @param array &$data データ
 * @param mixed $value セットする値
 * @param int $langId 言語ID(Language.id)
 * @return array
 */
	public function writeArray(&$data, $value, $langId) {
		if (is_array($value)) {
			foreach ($value as $key2 => $value2) {
				$data[$key2] = $this->writeArray($data[$key2], $value2, $langId);
			}
		} else {
			$data[$langId] = $value;
		}
		return $data;
	}

}
