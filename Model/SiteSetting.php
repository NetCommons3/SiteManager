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
App::uses('SiteSettingUtil', 'SiteManager.Utility');
App::uses('SiteManagerAppModel', 'SiteManager.Model');
App::uses('AutoUserRegist', 'Auth.Model');
App::uses('M17nHelper', 'M17n.View/Helper');
App::uses('Space', 'Rooms.Model');
App::uses('AuthenticatorPlugin', 'Auth.Utility');

/**
 * SiteSetting Model
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\SiteManager\Model
 * @SuppressWarnings(PHPMD.TooManyFields)
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
 * 文言は、prepare()でセットする
 *
 * @var array
 */
	public $metaRobots = array(
		'index,follow' => array('site_manager', 'Index, Follow'),
		'noindex,follow' => array('site_manager', 'No Index, Follow'),
		'index,nofollow' => array('site_manager', 'Index, No Follow'),
		'noindex,nofollow' => array('site_manager', 'No Index, No Follow'),
	);

/**
 * 自動ログアウトの時間
 *
 * @var array
 */
	public $sessionTimeout = array(
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
 * 文言は、prepare()でセットする
 *
 * @var array
 */
	public $autoRegistConfirm = array(
		AutoUserRegist::CONFIRMATION_USER_OWN => array(
			'site_manager', 'Automatic registration by user(advised)'
		),
		AutoUserRegist::CONFIRMATION_AUTO_REGIST => array(
			'site_manager', 'User registration by automatic'
		),
		AutoUserRegist::CONFIRMATION_ADMIN_APPROVAL => array(
			'site_manager', 'Approval by administrator'
		),
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
	public $memoryLimit = array(
		'64M' => '64M',
		'128M' => '128M',
		'256M' => '256M',
		'512M' => '512M',
		'1024M' => '1G',
	);

/**
 * メール形式のオプション
 * 文言は、prepare()でセットする
 *
 * @var array
 */
	public $mailMessageType = array(
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
 * 文言は、prepare()でセットする
 * ※sendmailを使いたい場合は、phpmailを選んで、各自php.iniにsendmailの設定を記述するため、選択肢からなくす
 *
 * @var array
 */
	public $mailTransport = array(
		self::MAIL_TRANSPORT_PHPMAIL => array('system_manager', 'PHP mail()'),
		self::MAIL_TRANSPORT_SMTP => array('system_manager', 'SMTP'),
	);

/**
 * データベースタイプ（MATCH AGAINST）
 */
	const DATABASE_SEARCH_MATCH_AGAIN = 'match_against';

/**
 * データベースタイプ（LIKE）
 */
	const DATABASE_SEARCH_LIKE = 'like';

/**
 * デフォルトのタイムゾーンのオプション
 * データは、prepare()でセットする
 *
 * @var array
 */
	public $defaultTimezones = array();

/**
 * ルームの容量のオプション
 *
 * @var array
 */
	public $diskSpace = array(
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
 * 文言は、prepare()でセットする
 *
 * @var array
 */
	public $debugOptions = array(
		'0' => array(
			'system_manager', '0: No error messages, errors, or warnings shown. Flash messages redirect.'
		),
		'1' => array(
			'system_manager', '1: Errors and warnings shown, model caches refreshed, flash messages halted.'
		),
		'2' => array(
			'system_manager', '2: As in 1, but also with full debug messages and SQL output.'
		),
	);

/**
 * IP変動を禁止する会員権限のオプション
 * saveSiteSetting()を呼び出す前に、SecuritySettingsControllerでセットする
 *
 * @var array
 */
	public $userRoles = array();

/**
 * validateする外部プラグイン
 * ### 設定例
 * ```
 * array('AuthShibboleth')
 * ```
 *
 * @var array
 * @see SiteSetting::__validateExternals()
 */
	public $validatePlugins = array();

/**
 * Behaviors
 *
 * @var array
 */
	public $actsAs = array(
		'NetCommons.NetCommonsCache',
		'DataTypes.Timezone',
		'SiteManager.IpAddressManager',
		'SiteManager.SiteManagerValidate',
		'SiteManager.SiteManagerSave',
		'SiteManager.SystemManagerValidate',
		'SiteManager.SystemManagerSave',
		'ThemeSettings.Theme',
	);

/**
 * 設定画面の前準備
 *
 * @return void
 */
	public function prepare() {
		//METAタグのロボット型検索エンジンへの対応のオプション
		foreach ($this->metaRobots as $key => $message) {
			$this->metaRobots[$key] = __d($message[0], $message[1]);
		}
		//メール形式のオプション
		foreach ($this->mailMessageType as $key => $message) {
			$this->mailMessageType[$key] = __d($message[0], $message[1]);
		}
		//メール送信方法のオプション
		foreach ($this->mailTransport as $key => $message) {
			$this->mailTransport[$key] = __d($message[0], $message[1]);
		}
		//debugのオプション
		foreach ($this->debugOptions as $key => $message) {
			$this->debugOptions[$key] = __d($message[0], $message[1]);
		}
		//デフォルトのタイムゾーン
		$timezones = $this->getTimezone();
		$this->defaultTimezones = Hash::combine($timezones, '{n}.code', '{n}.name');
		//アカウント登録の最終決定
		foreach ($this->autoRegistConfirm as $key => $message) {
			$this->autoRegistConfirm[$key] = __d($message[0], $message[1]);
		}
		//セッションタイムアウト
		foreach ($this->sessionTimeout as $key => $message) {
			$this->sessionTimeout[$key] = __d($message[0], $message[1], $message[2]);
		}
	}

/**
 * デフォルト開始ページの取得
 *
 * @return string or null
 */
	public function getDefaultStartPage() {
		$this->loadModels([
			'Page' => 'Pages.Page',
			'Room' => 'Rooms.Room',
			'Space' => 'Rooms.Space',
		]);
		//パブリックスペースの場合
		$defaultStartRoom = SiteSettingUtil::read('App.default_start_room');
		if ($defaultStartRoom === Space::getRoomIdRoot(Space::PUBLIC_SPACE_ID, 'Room')) {
			return '/';
		}
		//プライベートの場合、プライベートの利用可をチェックする
		if ($defaultStartRoom === Space::getRoomIdRoot(Space::PRIVATE_SPACE_ID) &&
				! Current::read('User.UserRoleSetting.use_private_room')) {
			return '/';
		}

		$query = $this->Room->getReadableRoomsConditions(array(
			'Room.parent_id' => $defaultStartRoom
		));
		$room = $this->Room->find('first', Hash::merge($query, array('recursive' => -1)));
		if (! $room) {
			return '/';
		}

		$page = $this->Page->find('first', array(
			'recursive' => -1,
			'conditions' => array('id' => $room['Room']['page_id_top'])
		));
		if (! $page) {
			return '/';
		}

		$space = $this->Space->find('first', array(
			'recursive' => -1,
			'conditions' => array('id' => $room['Room']['space_id'])
		));
		if ($space['Space']['permalink']) {
			return '/' . $space['Space']['permalink'] . '/' . $page['Page']['permalink'];
		} else {
			return '/' . $page['Page']['permalink'];
		}
	}

/**
 * サイトに設定されているテーマを返す
 *
 * @return string or null
 */
	public function getSiteTheme() {
		return SiteSettingUtil::read('theme');
	}

/**
 * サイトのデフォルトタイムゾーン（未ログインのゲスト用）を返す
 *
 * @return string timezone
 */
	public function getSiteTimezone() {
		return SiteSettingUtil::read('App.default_timezone');
	}

/**
 * サイト設定データを取得する
 *
 * @param array $conditions 条件配列
 * @return array サイト設定データ配列
 */
	public function getSiteSettingForEdit($conditions = array()) {
		$this->loadModels(array(
			'MailSettingFixedPhrase' => 'Mails.MailSettingFixedPhrase',
		));

		$settings = $this->find('all', array(
			'recursive' => -1,
			'conditions' => $conditions
		));
		$settings = Hash::combine($settings,
			'{n}.SiteSetting.language_id',
			'{n}.SiteSetting',
			'{n}.SiteSetting.key'
		);

		if (isset($conditions['SiteSetting.key']) &&
				in_array('UserRegist.mail_subject', $conditions['SiteSetting.key'], true)) {

			$mails = $this->MailSettingFixedPhrase->find('all', array(
				'recursive' => -1,
				'conditions' => array(
					'plugin_key' => 'user_manager',
					'type_key' => 'save_notify',
				),
			));

			foreach ($mails as $mail) {
				$langId = $mail['MailSettingFixedPhrase']['language_id'];
				$settings['UserRegist.mail_subject'][$langId] = array(
					'id' => null,
					'key' => 'UserRegist.mail_subject',
					'language_id' => $langId,
					'value' => $mail['MailSettingFixedPhrase']['mail_fixed_phrase_subject'],
				);
				$settings['UserRegist.mail_body'][$langId] = array(
					'id' => null,
					'key' => 'UserRegist.mail_body',
					'language_id' => $langId,
					'value' => $mail['MailSettingFixedPhrase']['mail_fixed_phrase_body'],
				);
			}
		}

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
			$data = $this->saveRoomDiskSize($data);
			$data = $this->saveUserAttributeSettingByUserRegist($data);
			$data = $this->saveUserRegistMail($data);

			$saveData = Hash::extract($data, 'SiteSetting.{s}.{n}');

			if ($saveData && ! $this->saveMany($saveData, ['validate' => false])) {
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
 * サイト設定の登録処理
 *
 * @param string $key 更新するキー
 * @param mixed $value 更新する値
 * @return bool True on success, false on validation errors
 * @throws InternalErrorException
 */
	public function saveSiteSettingByKey($key, $value) {
		//トランザクションBegin
		$this->begin();

		try {
			$siteSetting = $this->find('first', array(
				'recursive' => -1,
				'conditions' => array('key' => $key)
			));
			$this->id = $siteSetting['SiteSetting']['id'];

			//登録処理
			if (! $this->SiteSetting->saveField('value', $value)) {
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
		$this->prepare();

		$data = $this->validateAppSetting($data);
		$data = $this->validatePasswordReissue($data);
		$data = $this->validateSiteClose($data);
		$data = $this->validateMembership($data);
		$data = $this->validateWorkflow($data);

		$data = $this->validateProxy($data);
		$data = $this->validateSystemSetting($data);
		$data = $this->validateSession($data);
		$data = $this->validateWebServer($data);
		$data = $this->validateMailServer($data);
		$data = $this->validateSecuritySettings($data);
		$data = $this->validateDeveloper($data);

		$data = $this->__validateExternals($data);

		if (! $this->validationErrors) {
			return $data;
		} else {
			return false;
		}
	}

/**
 * 外部プラグイン、動的にビヘイビア呼んでvalidateチェック
 *
 * @param array $data データ
 * @return array
 */
	private function __validateExternals($data) {
		// 外部プラグインでvalidateするため一時的に退避
		$messagePlugin = $this->messagePlugin;

		foreach ($this->validatePlugins as $plugin) {
			// XXXX.XXXXVaidateBehavior load
			$this->Behaviors->load($plugin . '.' . $plugin . 'Validate');

			// validateのエラーメッセージで外部プラグインの言語ファイルを使うようにセット
			$this->messagePlugin = Inflector::underscore($plugin);

			// XXXX.XXXXVaidateBehavior::validateXXXX()でvalidate実行
			$validateFunction = 'validate' . $plugin;
			$data = $this->$validateFunction($data);
		}
		$this->messagePlugin = $messagePlugin;

		return $data;
	}

}

