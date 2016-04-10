<?php
/**
 * Migration file
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsMigration', 'NetCommons.Config/Migration');

/**
 * システム管理用データ
 *
 * @package NetCommons\SiteManager\Config\Migration
 */
class SystemManagerRecords extends NetCommonsMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'system_manager_records';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
		),
		'down' => array(
		),
	);

/**
 * recodes
 *
 * @var array $migration
 */
	public $records = array(
		'SiteSetting' => array(
			//一般設定
			// * サイトタイムゾーン
			// ** 日本語
			array(
				'language_id' => '2',
				'key' => 'App.default_timezone',
				'value' => 'Asia/Tokyo',
			),
			// ** 英語
			array(
				'language_id' => '1',
				'key' => 'App.default_timezone',
				'value' => 'UTC',
			),
			// * グループルームの容量
			array(
				'language_id' => 0,
				'key' => 'App.disk_for_group_room',
				'value' => '524288000',
			),
			// * プライベートルームの容量
			array(
				'language_id' => 0,
				'key' => 'App.disk_for_private_room',
				'value' => '52428800',
			),

			//セッションタイムアウト
			// * 自動ログアウトする時間(cookie_lifetime)(6時間)
			array(
				'language_id' => 0,
				'key' => 'Session.ini.session.cookie_lifetime',
				'value' => '21600',
			),
			// * 自動ログアウトする時間(gc_maxlifetime)(6時間)
			array(
				'language_id' => 0,
				'key' => 'Session.ini.session.gc_maxlifetime',
				'value' => '21600',
			),

			//サーバ設定
			// * システムコンフィグ
			// ** PHP最大メモリ数
			array(
				'language_id' => 0,
				'key' => 'Php.memory_limit',
				'value' => '128M',
			),
			// * セッション
			// ** Cookieの名称
			array(
				'language_id' => 0,
				'key' => 'Session.ini.session.name',
				'value' => 'nc_cookie',
			),
			// * プロキシ
			// ** プロキシサーバを使用する
			array(
				'language_id' => 0,
				'key' => 'Proxy.use_proxy',
				'value' => '0',
			),
			// ** プロキシホスト
			array(
				'language_id' => 0,
				'key' => 'Proxy.host',
				'value' => '',
			),
			// ** プロキシポート番号
			array(
				'language_id' => 0,
				'key' => 'Proxy.port',
				'value' => '8080',
			),
			// ** プロキシユーザ名
			array(
				'language_id' => 0,
				'key' => 'Proxy.user',
				'value' => '',
			),
			// ** プロキシパスワード
			array(
				'language_id' => 0,
				'key' => 'Proxy.pass',
				'value' => '',
			),

			//メール設定
			// * 送信者メールアドレス
			array(
				'language_id' => 0,
				'key' => 'Mail.from',
				'value' => '',
			),
			// * 送信者
			// ** 日本語
			array(
				'language_id' => '2',
				'key' => 'Mail.from_name',
				'value' => '管理者',
			),
			// ** 英語
			array(
				'language_id' => '1',
				'key' => 'Mail.from_name',
				'value' => 'Administrator',
			),
			// * メール形式
			array(
				'language_id' => 0,
				'key' => 'Mail.messageType',
				'value' => 'text',
			),
			// * メール送信方法
			array(
				'language_id' => 0,
				'key' => 'Mail.transport',
				'value' => 'smtp',
			),
			// ** sendmailへのパス
			array(
				'language_id' => 0,
				'key' => 'Mail.sendmail',
				'value' => '/usr/sbin/sendmail',
			),
			// ** SMTPサーバアドレス
			array(
				'language_id' => 0,
				'key' => 'Mail.smtp.host',
				'value' => 'localhost',
			),
			// ** SMTPポート番号
			array(
				'language_id' => 0,
				'key' => 'Mail.smtp.port',
				'value' => '25',
			),
			// ** SMTPAuthユーザ名
			array(
				'language_id' => 0,
				'key' => 'Mail.smtp.user',
				'value' => '',
			),
			// ** SMTPAuthパスワード
			array(
				'language_id' => 0,
				'key' => 'Mail.smtp.pass',
				'value' => '',
			),
			// ** Cronを使用する
			array(
				'language_id' => 0,
				'key' => 'Mail.use_cron',
				'value' => '0',
			),

			//開発者向け
			// * デバッグ出力
			array(
				'language_id' => 0,
				'key' => 'debug',
				'value' => '1',
			),
		),
	);

/**
 * Before migration callback
 *
 * @param string $direction Direction of migration process (up or down)
 * @return bool Should process continue
 */
	public function before($direction) {
		return true;
	}

/**
 * After migration callback
 *
 * @param string $direction Direction of migration process (up or down)
 * @return bool Should process continue
 */
	public function after($direction) {
		if ($direction === 'down') {
			return true;
		}
		foreach ($this->records as $model => $records) {
			if (!$this->updateRecords($model, $records)) {
				return false;
			}
		}
		return true;
	}
}
