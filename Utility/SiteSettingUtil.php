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

App::uses('CakeText', 'Utility');
App::uses('SiteSettingUtilFunc', 'SiteManager.Utility');
App::uses('NetCommonsCache', 'NetCommons.Utility');

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
class SiteSettingUtil {

/**
 * サイト設定のデータ保持用
 *
 * @var array
 */
	protected static $_data = array();

/**
 * initializeしたかどうか
 *
 * @var array
 */
	protected static $_initialized = false;

/**
 * SiteSettingモデル
 *
 * @var SiteSetting
 */
	protected static $_SiteSetting;

/**
 * SiteSettingUtilFuncユーティリティ
 *
 * @var SiteSettingUtilFunc
 */
	protected static $_SiteSettingUtilFunc;

/**
 * Utilityの事前準備
 *
 * staticにしているため、constractが使用されないので、各メソッドで呼び出す
 *
 * @return void
 */
	private static function __prepareUtility() {
		if (! self::$_SiteSetting) {
			self::$_SiteSetting = ClassRegistry::init('SiteManager.SiteSetting');
			self::$_SiteSettingUtilFunc = new SiteSettingUtilFunc();
		}
	}

/**
 * 初期データをセットする
 *
 * [NetCommonsAppController::beforeFilter](../NetCommons/classes/NetCommonsAppController.html#method_beforeFilter)
 * で処理を呼び出す。
 *
 * @return void
 */
	public static function initialize() {
		if (self::$_initialized) {
			return;
		}
		self::$_initialized = true;

		//事前準備
		self::__prepareUtility();

		self::setup(array(
			// * サイト名
			'App.site_name',
			// * システム標準使用言語
			'Config.language',

			// * 標準の開始ルーム
			'App.default_start_room',
			// * サイトタイムゾーン
			'App.default_timezone',

			// * デバッグモード
			'debug',
			//// * デフォルトテーマ
			//'theme',

			// * サイトの一時停止
			// ** サイトを一時停止する
			'App.close_site',

			// * パスワード再発行
			// ** パスワード再発行を使う
			'ForgotPass.use_password_reissue',

			// * 入会設定
			// ** 自動会員登録を許可する
			'AutoRegist.use_automatic_register',

			// * セッション
			'Session',

			// * サーバ設定
			// ** PHP最大メモリ数
			'Php.memory_limit',
		));

		//テーマのみデフォルト値セット
		if (! isset(self::$_data['theme'])) {
			self::write('theme', 'Default', '0');
		}

		//下記は設定は、Configureにもwriteする
		$siteSetting = array(
			'Config.language',
			'theme',
		);
		foreach ($siteSetting as $key) {
			Configure::write($key, self::read($key));
		}

		//Sessionの設定値を変えるため、Configureにセットする
		$session = Hash::merge(Configure::read('Session'), self::read('Session'));
		Configure::write('Session', $session);

		if (isset(self::$_data['Php']['memory_limit'])) {
			ini_set('memory_limit', self::read('Php.memory_limit'));
		}
	}

/**
 * データをセットする
 *
 * @param array $keyPaths Hashクラスのpath
 * @param bool $force 強制的に書き込むかどうか。falseの場合、既にあれば書き込みを行わない。
 * @return void
 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
 */
	public static function setup($keyPaths, $force = false) {
		//事前準備
		self::__prepareUtility();

		if (is_string($keyPaths)) {
			$keyPaths = array($keyPaths);
		}
		$conditions = array();
		foreach ($keyPaths as $keyPath) {
			if ($force || ! Hash::check(self::$_data, $keyPath)) {
				$conditions[] = array(
					'SiteSetting.key LIKE' => $keyPath . '%'
				);
			}
		}

		if (! $conditions) {
			return;
		}

		$result = self::$_SiteSetting->cacheFindQuery('all', array(
			'recursive' => -1,
			'fields' => array(
				'language_id', 'key', 'value'
			),
			'conditions' => array('OR' => $conditions)
		));

		foreach ($result as $siteSetting) {
			self::write(
				$siteSetting['SiteSetting']['key'],
				$siteSetting['SiteSetting']['value'],
				$siteSetting['SiteSetting']['language_id']
			);
		}
	}

/**
 * 指定された$keyの値を返します。
 *
 * サイト名(App.site_name)を取得したい場合
 * ```
 * SiteSetting::read('App.site_name');
 * ```
 *
 * @param string|null $keyPath Hashクラスのpath
 * @param mixed $default デフォルト値
 * @param int $langId 言語ID(Language.id)
 * @return array|null SiteSettingデータ
 */
	public static function read($keyPath, $default = null, $langId = null) {
		//事前準備
		self::__prepareUtility();

		if (! isset($langId)) {
			$langId = Current::read('Language.id', '2');
		}

		$pathes = array();
		if (! is_array($keyPath)) {
			$basePathes = self::_tokenize($keyPath);
		} else {
			$basePathes = $keyPath;
		}

		$pathes = $basePathes;
		if (Hash::get(self::$_data, $pathes) === null) {
			self::setup($keyPath);
		}

		if ($keyPath === 'Config.language' &&
				Hash::get(self::$_data, $keyPath . '.' . '0') === '') {

			return self::$_SiteSettingUtilFunc->acceptLanguage();
		}

		$pathes = $basePathes;
		$pathes[] = $langId;
		$value = Hash::get(self::$_data, $pathes);
		if ($value) {
			return $value;
		}

		$pathes = $basePathes;
		$pathes[] = '0';
		$value = Hash::get(self::$_data, $pathes);
		if ($value) {
			return $value;
		}

		$pathes = $basePathes;
		$value = Hash::get(self::$_data, $pathes);
		if (is_array($value)) {
			$valueArray = $value;
			$result = array();
			$result = self::$_SiteSettingUtilFunc->getReadData($result, $valueArray, $default, $langId);
			return $result;
		}

		return $default;
	}

/**
 * 指定された$keyの値をセットします
 *
 * サイト名(App.site_name)をセットしたい場合
 * ```
 * SiteSetting::write('App.site_name', 'NetCommons3', '2');
 * ```
 *
 * @param string $keyPath Hashクラスのpath、nullの場合、Hash::mergeする
 * @param mixed $value セットする値
 * @param int $langId 言語ID(Language.id)
 * @return void
 */
	public static function write($keyPath, $value, $langId) {
		//事前準備
		self::__prepareUtility();

		//`$keyPath = 'App.site_name';　$value = 'aaaa';` を
		//`$keyPath = 'App';　$value = array('site_name' => 'aaaa');` に変換する
		if (strpos($keyPath, '.') !== false) {
			$pathes = self::_tokenize($keyPath);

			//配列の平坦化から多次元配列に変換
			$keyPath = array_shift($pathes);
			$valueArray = array();
			$tmp =& $valueArray;
			foreach ($pathes as $key) {
				$tmp[$key] = array();
				$tmp =& $tmp[$key];
			}
			$tmp = $value;
			$value = $valueArray;
		}

		if (is_array($value)) {
			$data = array();
			if (! isset(self::$_data[$keyPath])) {
				self::$_data[$keyPath] = array();
			}
			self::$_data[$keyPath] = array_replace_recursive(
				self::$_data[$keyPath], self::$_SiteSettingUtilFunc->writeArray($data, $value, $langId)
			);
		} else {
			self::$_data = Hash::insert(self::$_data, $keyPath . '.' . $langId, $value);
		}
	}

/**
 * 指定された$keyの値を削除します。
 *
 * サイト名(App.site_name)を削除したい場合
 * ```
 * SiteSetting::remove('App.site_name')
 * ```
 *
 * @param string $keyPath Hashクラスのpath
 * @param int|null $langId 言語ID(Language.id)
 * @return void
 */
	public static function remove($keyPath, $langId = null) {
		if (! isset($langId) && strpos($keyPath, '.') !== false) {
			$pathes = self::_tokenize($keyPath);

			$tmp =& self::$_data;
			$index = 0;
			foreach ($pathes as $key) {
				$index++;
				if (count($pathes) === $index) {
					unset($tmp[$key]);
				} else {
					$tmp =& $tmp[$key];
				}
			}
		} else {
			if (isset($langId)) {
				self::$_data = Hash::remove(self::$_data, $keyPath . '.' . $langId);
			} else {
				self::$_data = Hash::remove(self::$_data, $keyPath);
			}
		}
		self::$_data = array_filter(self::$_data);
	}

/**
 * 全てのデータをクリアする
 *
 * @return void
 */
	public static function reset() {
		//事前準備
		self::__prepareUtility();
		self::$_initialized = false;
	}

/**
 * 全てのデータを取得
 *
 * @return array
 */
	public static function readAll() {
		return self::$_data;
	}

/**
 * CakeText::tokenizeをSiteSetting用に修正
 *
 * @param string $keyPath Hashクラスのpath
 * @return array
 */
	protected static function _tokenize($keyPath) {
		$pathes = CakeText::tokenize($keyPath, '.', '[', ']');
		$pathes = preg_replace('/[\[\]]/', '', $pathes);

		return $pathes;
	}

}
