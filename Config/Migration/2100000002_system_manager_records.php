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

			//セキュリティ設定
			// * アップロードファイルの許可拡張子
			array(
				'language_id' => 0,
				'key' => 'Upload.allow_extension',
				//xht,xhtml,html,htm,jsをNC2から削除
				'value' => 'csv,hqx,doc,docx,dot,bin,lha,lzh,class,so,dll,pdf,ai,eps,ps,smi,smil,wbxml,wmlc,wmlsc,xla,xls,xlsx,xlt,ppt,pptx,csh,dcr,dir,dxr,spl,gtar,sh,swf,sit,tar,tcl,ent,dtd,mod,gz,tgz,zip,au,snd,mid,midi,kar,mp1,mp2,mp3,aif,aiff,m3u,ram,rm,rpm,ra,wav,bmp,gif,jpeg,jpg,jpe,png,tiff,tif,wbmp,pnm,pbm,pgm,ppm,xbm,xpm,ics,ifb,css,asc,txt,rtf,sgml,sgm,tsv,wml,wmls,xsl,mpeg,mpg,mpe,qt,mov,avi,wmv,asf,tex,dvi,mcw,wps,xjs,xlw,wk1,wk2,wk3,wk4,wj2,wj3,pot,pps,ppa,wmf,mdb,mwd,odb,obt,obz,psd,svg,svgz,bak,cab,chm,dic,eml,hlp,ini,jhd,jtd,msg,rmi,wab,wma,smf,aac,m4a,m4v,wpl,xslt,flv,odt,odg,ods,odp,odf,odb,docm,dotm,dotx,fla,jtt,mp4,xltx',
			),
			// * IP変動を禁止する会員権限
			array(
				'language_id' => 0,
				'key' => 'Security.deny_ip_move',
				'value' => 'system_administrator|administrator',
			),
			// * IPアドレスでアクセス拒否する
			array(
				'language_id' => 0,
				'key' => 'Security.enable_bad_ips',
				'value' => '0',
			),
			// * アクセス拒否IPアドレス
			array(
				'language_id' => 0,
				'key' => 'Security.bad_ips',
				'value' => '',
			),
			// * 管理画面のアクセスをIPアドレスで制御する
			array(
				'language_id' => 0,
				'key' => 'Security.enable_allow_system_plugin_ips',
				'value' => '0',
			),
			// * 管理画面アクセス許可IPアドレス
			// after()でセットする

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

		$this->records['SiteSetting'][] = array(
			'language_id' => 0,
			'key' => 'Security.allow_system_plugin_ips',
			'value' => Hash::get($_SERVER, 'REMOTE_ADDR', ''),
		);

		foreach ($this->records as $model => $records) {
			if (!$this->updateRecords($model, $records)) {
				return false;
			}
		}
		return true;
	}
}
