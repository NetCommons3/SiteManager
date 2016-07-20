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
class SiteSettingUtil {

/**
 * サイト設定のデータ保持用
 *
 * @var array
 */
	protected static $_data = array();

/**
 * 初期データをセットする
 *
 * [NetCommonsAppController::beforeFilter](../NetCommons/classes/NetCommonsAppController.html#method_beforeFilter)
 * で処理を呼び出す。
 *
 * @return void
 */
	public static function initialize() {
		$SiteSetting = ClassRegistry::init('SiteManager.SiteSetting');

		self::setup(array(
			// * サイト名
			'App.site_name',
			// * システム標準使用言語
			'Config.language',

			// * 標準の開始ルーム
			'App.default_start_room',
			// * サイトタイムゾーン
			'App.default_timezone',
			// * グループルームの容量
			'App.disk_for_group_room',
			// * プライベートルームの容量
			'App.disk_for_private_room',

			// * デバッグモード
			'debug',
			// * デフォルトテーマ
			'theme',

			// * サイトの一時停止
			// ** サイトを一時停止する
			'App.close_site',

			// * パスワード再発行
			// ** パスワード再発行を使う
			'ForgotPass.use_password_reissue',

			// * 入会設定
			// ** 自動会員登録を許可する
			'AutoRegist.use_automatic_register',
		));

		//テーマのみデフォルト値セット
		if (! Hash::check(self::$_data, 'theme')) {
			self::write('theme', 'Default', '0');
		}

		//下記は設定は、Configureにもwriteする
		$siteSetting = array(
			'Config.language',
			'debug',
			'theme',
		);
		foreach ($siteSetting as $key) {
			Configure::write($key, self::read($key));
		}

		//debugについては、セッションがある場合セッションを優先する
		$debugs = $SiteSetting->debugOptions;
		if (in_array(CakeSession::read('debug'), array_keys($debugs), true)) {
			Configure::write('debug', CakeSession::read('debug'));
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
		$SiteSetting = ClassRegistry::init('SiteManager.SiteSetting');

		if ($force) {
			$conditions = $keyPaths;
		} else {
			if (is_string($keyPaths)) {
				$keyPaths = array($keyPaths);
			}
			$conditions = array();
			foreach ($keyPaths as $keyPath) {
				if (! Hash::check(self::$_data, $keyPath)) {
					$conditions[] = $keyPath;
				}
			}
		}

		if (! $conditions) {
			return;
		}

		$result = $SiteSetting->find('all', array(
			'recursive' => -1,
			'fields' => array(
				'language_id', 'key', 'value'
			),
			'conditions' => array('SiteSetting.key' => $conditions)
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
		if (! isset($langId)) {
			$langId = Current::read('Language.id', '0');
		}

		if (! Hash::check(self::$_data, $keyPath)) {
			self::setup($keyPath);
		}

		if (Hash::check(self::$_data, $keyPath . '.' . $langId)) {
			return Hash::get(self::$_data, $keyPath . '.' . $langId);
		}

		if (Hash::check(self::$_data, $keyPath . '.' . '0')) {
			return Hash::get(self::$_data, $keyPath . '.' . '0');
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
		self::$_data = Hash::insert(self::$_data, $keyPath . '.' . $langId, $value);
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
		if (isset($langId)) {
			self::$_data = Hash::remove(self::$_data, $keyPath . '.' . $langId);
		} else {
			self::$_data = Hash::remove(self::$_data, $keyPath);
		}
	}

/**
 * 全てのデータをクリアする
 *
 * @return void
 */
	public static function reset() {
		self::$_data = array();
	}

}
