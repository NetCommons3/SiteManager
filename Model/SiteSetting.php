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
App::uses('M17nHelper', 'M17n.View/Helper');

/**
 * SiteSetting Model
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\SiteManager\Model
 */
class SiteSetting extends SiteManagerAppModel {

/**
 * メッセージ言語ファイルのプラグイン名(デフォルト：site_manager)
 * ※システム管理で使用する場合は、ここをsystem_managerに変更する
 *
 * @var string
 */
	public $messagePlugin = 'site_manager';

/**
 * システム標準使用言語のオプション
 * saveSiteSetting()を呼び出す前に、SiteManagerControllerでセットする
 *
 * @var array
 */
	public $defaultLanguages = array();

/**
 * 標準の開始ルームのオプション
 * saveSiteSetting()を呼び出す前に、SiteManagerControllerでセットする
 *
 * @var array
 */
	public $defaultStartRoom = array();

/**
 * METAタグのロボット型検索エンジンへの対応のオプション
 * 文言は、__constructでセットする
 *
 * @var array
 */
	public static $metaRobots = array(
		'index,follow' => array('site_manager', 'Index, Follow'),
		'noindex,follow' => array('site_manager', 'No Index, Follow'),
		'index,nofollow' => array('site_manager', 'Index, No Follow'),
		'noindex,nofollow' => array('site_manager', 'No Index, No Follow'),
	);

/**
 * METAタグの閲覧対象年齢層の指定のオプション
 * 文言は、__constructでセットする
 *
 * @var array
 */
	public static $metaRating = array(
		'General' => array('site_manager', 'General'),
		'14 years' => array('site_manager', '14 years'),
		'restricted' => array('site_manager', 'Restricted'),
		'mature' => array('site_manager', 'Mature'),
	);

/**
 * 自動ログアウトの時間
 *
 * @var array
 */
	public static $sessionTimeout = array(
		'900' => array('system_manager', '%s minutes', 15), //15分
		'1800' => array('system_manager', '%s minutes', 30), //30分
		'2700' => array('system_manager', '%s minutes', 45), //45分
		'3600' => array('system_manager', '%s hour', 1), //1時間
		'10800' => array('system_manager', '%s hours', 3), //3時間
		'21600' => array('system_manager', '%s hours', 6), //6時間
		'43200' => array('system_manager', '%s hours', 12), //12時間
		'86400' => array('system_manager', '%s day', 1), //1日
		'259200' => array('system_manager', '%s days', 3), //3日
	);

/**
 * アカウント登録の最終決定のオプション
 * 文言は、__constructでセットする
 *
 * @var array
 */
	public static $autoRegistConfirm = array(
		'0' => array('site_manager', 'Automatic registration by user(advised)'),
		'1' => array('site_manager', 'User registration by automatic'),
		'2' => array('site_manager', 'Approval by administrator'),
	);

/**
 * 自動登録時の権限のオプション
 * saveSiteSetting()を呼び出す前に、MembershipControllerでセットする
 *
 * @var array
 */
	public $autoRegistRoles = array();

/**
 * メモリ制限のオプション
 *
 * @var array
 */
	public static $memoryLimit = array(
		'64M' => '64M',
		'128M' => '128M',
		'256M' => '256M',
		'512M' => '512M',
		'1024M' => '1G',
	);

/**
 * メール形式のオプション
 * 文言は、__constructでセットする
 *
 * @var array
 */
	public static $mailMessageType = array(
		'html' => array('system_manager', 'HTML'),
		'text' => array('system_manager', 'Plan text'),
	);

/**
 * メール送信方法のオプションの定数(phpmail)
 */
	const MAIL_TRANSPORT_PHPMAIL = 'phpmail';

/**
 * メール送信方法のオプションの定数(smtp)
 */
	const MAIL_TRANSPORT_SMTP = 'smtp';

/**
 * メール送信方法のオプション
 * 文言は、__constructでセットする
 * ※sendmailを使いたい場合は、phpmailを選んで、各自php.iniにsendmailの設定を記述するため、選択肢からなくす
 *
 * @var array
 */
	public static $mailTransport = array(
		self::MAIL_TRANSPORT_PHPMAIL => array('system_manager', 'PHP mail()'),
		self::MAIL_TRANSPORT_SMTP => array('system_manager', 'SMTP'),
	);

/**
 * デフォルトのタイムゾーンのオプション
 * データは、__constructでセットする
 *
 * @var array
 */
	public static $defaultTimezones = array();

/**
 * ルームの容量のオプション
 *
 * @var array
 */
	public static $diskSpace = array(
		-1, //無制限
		10737418240, //10G
		5368709120, //5G
		1073741824, //1G
		524288000, //500M
		209715200, //200M
		104857600, //100M
		52428800, //50M
	);

/**
 * デバッグのオプション
 * 文言は、__constructでセットする
 *
 * @var array
 */
	public static $debugOptions = array(
		'0' => array('system_manager', '0: No error messages, errors, or warnings shown. Flash messages redirect.'),
		'1' => array('system_manager', '1: Errors and warnings shown, model caches refreshed, flash messages halted.'),
		'2' => array('system_manager', '2: As in 1, but also with full debug messages and SQL output.'),
	);

/**
 * Behaviors
 *
 * @var array
 */
	public $actsAs = array(
		'DataTypes.Timezone',
		'SiteManager.SiteManagerValidate',
		'SiteManager.SystemManagerValidate',
	);

/**
 * Constructor. Binds the model's database table to the object.
 *
 * @param bool|int|string|array $id Set this ID for this model on startup,
 * can also be an array of options, see above.
 * @param string $table Name of database table to use.
 * @param string $ds DataSource connection name.
 * @see Model::__construct()
 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
 */
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct();

		//METAタグのロボット型検索エンジンへの対応のオプション
		foreach (self::$metaRobots as $key => $message) {
			self::$metaRobots[$key] = __d($message[0], $message[1]);
		}
		//METAタグの閲覧対象年齢層の指定のオプション
		foreach (self::$metaRating as $key => $message) {
			self::$metaRating[$key] = __d($message[0], $message[1]);
		}
		//メール形式のオプション
		foreach (self::$mailMessageType as $key => $message) {
			self::$mailMessageType[$key] = __d($message[0], $message[1]);
		}
		//メール送信方法のオプション
		foreach (self::$mailTransport as $key => $message) {
			self::$mailTransport[$key] = __d($message[0], $message[1]);
		}
		//debugのオプション
		foreach (self::$debugOptions as $key => $message) {
			self::$debugOptions[$key] = __d($message[0], $message[1]);
		}
		//デフォルトのタイムゾーン
		$timezones = $this->getTimezone();
		self::$defaultTimezones = Hash::combine($timezones, '{n}.code', '{n}.name');
		//アカウント登録の最終決定
		foreach (self::$autoRegistConfirm as $key => $message) {
			self::$autoRegistConfirm[$key] = __d($message[0], $message[1]);
		}
		//セッションタイムアウト
		foreach (self::$sessionTimeout as $key => $message) {
			self::$sessionTimeout[$key] = __d($message[0], $message[1], $message[2]);
		}
	}

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
 * @param array $conditions 条件配列
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
 * ### 注意事項
 * この引数$dataは、リクエストの中身そのまま。
 * ```
 * (例)SiteMnagerControllerからの登録処理
 * array (
 *   'SiteSetting' =>
 *   array (
 *     'App.site_name' =>
 *     array (
 *       1 =>
 *       array (
 *         'id' => '2',
 *         'key' => 'App.site_name',
 *         'language_id' => '1',
 *         'value' => 'NetCommons3',
 *       ),
 *       2 =>
 *       array (
 *         'id' => '1',
 *         'key' => 'App.site_name',
 *         'language_id' => '2',
 *         'value' => '',
 *       ),
 *     ),
 *     'Config.language' =>
 *     array (
 *       0 =>
 *       array (
 *         'id' => '3',
 *         'key' => 'Config.language',
 *         'language_id' => '0',
 *         'value' => 'ja',
 *       ),
 *     ),
 *
 *   ・・・
 * )
 * ```
 *
 * @param array $data リクエストデータ配列
 * @return bool True on success, false on validation errors
 * @throws InternalErrorException
 */
	public function saveSiteSetting($data) {
		//トランザクションBegin
		$this->begin();

		//バリデーション
		$result = $this->validateSiteSetting($data);
		if (! $result) {
			return false;
		}
		$data = $result;

		try {
			//登録処理
			$saveData = Hash::extract($data, 'SiteSetting.{s}.{n}');
			if (! $this->saveMany($saveData, ['validate' => false])) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

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
 * @param array $data リクエストデータ配列
 * @return bool|array 正常な場合、登録不要なデータを削除して戻す。validateionErrorが空でない場合は、falseを返す。
 */
	public function validateSiteSetting($data) {
		$data = $this->validateAppSetting($data);
		$data = $this->validateSiteClose($data);
		$data = $this->validateMembership($data);
		$data = $this->validateProxy($data);
		$data = $this->validateSystemSetting($data);
		$data = $this->validateAuthSetting($data);
		$data = $this->validateWebServer($data);
		$data = $this->validateMailServer($data);
		$data = $this->validateDeveloper($data);

		if (! $this->validationErrors) {
			return $data;
		} else {
			return false;
		}
	}

}

