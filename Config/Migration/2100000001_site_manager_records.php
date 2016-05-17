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
 * サイト管理用データ
 *
 * @package NetCommons\SiteManager\Config\Migration
 */
class SiteManagerRecords extends NetCommonsMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'site_manager_records';

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
			// * サイト名
			// ** 日本語
			array(
				'language_id' => '2',
				'key' => 'App.site_name',
				'value' => 'NetCommons3',
			),
			// ** 英語
			array(
				'language_id' => '1',
				'key' => 'App.site_name',
				'value' => 'NetCommons3',
			),
			// * システム標準使用言語
			array(
				'language_id' => 0,
				'key' => 'Config.language',
				'value' => 'ja',
			),
			// * 標準の開始ルーム
			array(
				'language_id' => 0,
				'key' => 'App.default_start_room',
				'value' => '2',
			),
			// * パスワード再発行通知
			// ** パスワード再発行の機能を使う
			array(
				'language_id' => 0,
				'key' => 'ForgotPass.use_password_reissue',
				'value' => '1', //0:いいえ|1:はい
			),
			// ** 新規パスワード通知の件名
			// *** 日本語
			array(
				'language_id' => '2',
				'key' => 'ForgotPass.issue_mail_subject',
				'value' => '[{X-SITE_NAME}]新規パスワードのリクエスト',
			),
			// *** 英語
			array(
				'language_id' => '1',
				'key' => 'ForgotPass.issue_mail_subject',
				'value' => '[{X-SITE_NAME}]Request for new password',
			),
			// ** パスワード通知メールの本文
			// *** 日本語
			array(
				'language_id' => '2',
				'key' => 'ForgotPass.issue_mail_body',
				'value' => '{X-SITE_NAME}におけるログイン用パスワードの新規発行リクエストがありました。
新たにパスワードを発行する場合は、認証キー入力画面で、下記の認証キーを入力して下さい。

このリクエストが手違いの場合はこのメールを破棄してください。
今までのパスワードでログインすることができます。

認証キー：
{X-AUTHORIZATION_KEY}',
			),
			// *** 英語
			array(
				'language_id' => '1',
				'key' => 'ForgotPass.issue_mail_body',
				'value' => 'A web user has just requested for a new password for your account at {X-SITE_NAME} site.
If you didn\'t ask for one, don\'t worry.  Just delete this e-mail.
新たにパスワードを発行する場合は、認証キー入力画面で、下記の認証キーを入力して下さい。

Authorization key：
{X-AUTHORIZATION_KEY}',
			),
			// ** 新規パスワード発行の件名
			// *** 日本語
			array(
				'language_id' => '2',
				'key' => 'ForgotPass.request_mail_subject',
				'value' => '[{X-SITE_NAME}]新規パスワードのリクエスト',
			),
			// *** 英語
			array(
				'language_id' => '1',
				'key' => 'ForgotPass.request_mail_subject',
				'value' => '[{X-SITE_NAME}]Request for new password',
			),
			// ** パスワード発行メールの本文
			// *** 日本語
			array(
				'language_id' => '2',
				'key' => 'ForgotPass.request_mail_body',
				'value' => '{X-SITE_NAME}におけるログイン用パスワードの新規発行リクエストがありました。
下記のログインIDを使用して、新しいパスワードを再登録して下さい。

ハンドル: {X-HANDLENAME}
ログインID: {X-USERNAME}',
			),
			// *** 英語
			array(
				'language_id' => '1',
				'key' => 'ForgotPass.request_mail_body',
				'value' => 'A web user has just requested for a new password for your account at {X-SITE_NAME} site.
下記のログインIDを使用して、新しいパスワードを再登録して下さい。

Handle: {X-HANDLENAME}
Login id: {X-USERNAME}',
			),

			// * サイトを一時停止する
			array(
				'language_id' => 0,
				'key' => 'App.close_site',
				'value' => '0',
			),
			// * メンテナンス画面に表示する文言
			// ** 日本語
			array(
				'language_id' => '2',
				'key' => 'App.site_closing_reason',
				'value' => '<div class="jumbotron"><h1>{X-SITE_NAME}</h1><h2>このサイトはただいまメンテナンス中です。後程お越しください。</h2></div>',
			),
			// ** 英語
			array(
				'language_id' => '1',
				'key' => 'App.site_closing_reason',
				'value' => '<div class="jumbotron"><h1>{X-SITE_NAME}</h1><h2>This site is on maintenance. Please try again later.</h2></div>',
			),

			//メタ情報
			// * 作成者
			array(
				'language_id' => 0,
				'key' => 'Meta.author',
				'value' => 'NetCommons',
			),
			// * 著作権表示
			array(
				'language_id' => 0,
				'key' => 'Meta.copyright',
				'value' => 'Copyright © 2016',
			),
			// * キーワード
			array(
				'language_id' => 0,
				'key' => 'Meta.keywords',
				'value' => 'CMS,Netcommons,NetCommons3,CakePHP',
			),
			// * サイトの説明
			array(
				'language_id' => 0,
				'key' => 'Meta.description',
				'value' => 'CMS,Netcommons,NetCommons3,CakePHP',
			),
			// * ロボット型検索エンジンへの対応
			array(
				'language_id' => 0,
				'key' => 'Meta.robots',
				'value' => 'index,follow',
			),
			// * 閲覧対象年齢層の指定
			array(
				'language_id' => 0,
				'key' => 'Meta.rating',
				'value' => 'General',
			),

			//ページスタイル
			// * テーマ(Roomデータを参照する)
			// * レイアウト(後で、、、ルーム管理かページ設定で行う)

			//入会・退会設定
			// * 入会設定
			// ** 自動会員登録を許可する
			array(
				'language_id' => 0,
				'key' => 'AutoRegist.use_automatic_register',
				'value' => '0',
			),
			// ** アカウント登録の最終決定
			array(
				'language_id' => 0,
				'key' => 'AutoRegist.confirmation',
				'value' => '0', //0:ユーザ自身による確認(推奨)|1:自動的にアカウントを登録する|2:管理者による承認
			),
			// ** 入力キーの使用
			array(
				'language_id' => 0,
				'key' => 'AutoRegist.use_secret_key',
				'value' => '0',
			),
			// ** 入力キー
			array(
				'language_id' => 0,
				'key' => 'AutoRegist.secret_key',
				'value' => '',
			),
			// ** 自動登録時の権限
			array(
				'language_id' => 0,
				'key' => 'AutoRegist.role_key',
				'value' => 'common_user', //administrator:サイト管理者|common_user:一般
			),
			// ** 自動登録時にデフォルトルームに参加する
			array(
				'language_id' => 0,
				'key' => 'AutoRegist.prarticipate_default_room',
				'value' => '1',
			),
			// ** 自動登録時の入力項目(後で、、、会員項目設定で行う？)
			// ** 利用許諾文
			// *** 日本語
			array(
				'language_id' => '2',
				'key' => 'AutoRegist.disclaimer',
				'value' => '本規約は、当サイトにより提供されるコンテンツの利用条件を定めるものです。以下の利用条件をよくお読みになり、これに同意される場合にのみご登録いただきますようお願いいたします。<br>
<br>
当サイトを利用するにあたり、以下に該当する又はその恐れのある行為を行ってはならないものとします。<br>
<br>
・公序良俗に反する行為<br>
・法令に違反する行為<br>
・犯罪行為及び犯罪行為に結びつく行為<br>
・他の利用者、第三者、当サイトの権利を侵害する行為<br>
・他の利用者、第三者、当サイトを誹謗、中傷する行為及び名誉・信用を傷つける行為<br>
・他の利用者、第三者、当サイトに不利益を与える行為<br>
・当サイトの運営を妨害する行為<br>
・事実でない情報を発信する行為<br>
・プライバシー侵害の恐れのある個人情報の投稿<br>
・その他、当サイトが不適当と判断する行為<br>
<br>
【免責】<br>
<br>
利用者が当サイト及び当サイトに関連するコンテンツ、リンク先サイトにおける一切のサービス等をご利用されたことに起因または関連して生じた一切の損害（間接的であると直接的であるとを問わない）について、当サイトは責任を負いません。<br>',
			),
			// *** 英語
			array(
				'language_id' => '1',
				'key' => 'AutoRegist.disclaimer',
				'value' => 'The terms & conditions for using the contents of this site is governed by this agreement. Please read carefully the following conditions, and register only if you agree to them.<br>
<br>
By using this site, I agree to refrain from the following actions, or behavior that may lead to the following actions.<br>
<br>
actions that are against public order or morals<br>
actions that are against the laws or ordinances<br>
criminal acts or actions connected to criminal acts<br>
actions that violate rights of other users, third party, or this site<br>
actions that slander, defame, or cause the loss of prestige or credibility of other users, third party, or this site<br>
actions that result in liability to other users, third party, or this site<br>
actions that hinder the operation of this site<br>
actions that disseminate information that are not true<br>
postings of personal information that may lead to invasion of privacy<br>
other actions that are deemed unsuitable by this site<br>
<br>
Disclaimer<br>
<br>
This site is not responsible for damage (direct or indirect) to user that is caused by, is resulted from the connection of, the usage of this site, contents related to this site, services from links stemming from this site, etc.<br>',
			),
			// ** 会員登録承認メールの件名
			// *** 日本語
			array(
				'language_id' => '2',
				'key' => 'AutoRegist.approval_mail_subject',
				'value' => '[{X-SITE_NAME}]会員登録確認メール',
			),
			// *** 英語
			array(
				'language_id' => '1',
				'key' => 'AutoRegist.approval_mail_subject',
				'value' => 'Welcome to {X-SITE_NAME}',
			),
			// ** 会員登録承認メールの本文
			// *** 日本語
			array(
				'language_id' => '2',
				'key' => 'AutoRegist.approval_mail_body',
				'value' => '{X-SITE_NAME}におけるユーザ登録用メールアドレスとしてあなたのメールアドレスが使用されました。
もし{X-SITE_NAME}でのユーザ登録に覚えがない場合はこのメールを破棄してください。

{X-SITE_NAME}でのユーザ登録を完了するには下記のリンクをクリックして登録の承認を行ってください。

{X-URL}',
			),
			// *** 英語
			array(
				'language_id' => '1',
				'key' => 'AutoRegist.approval_mail_body',
				'value' => 'Thank you for your registereing for {X-SITE_NAME} site.
Your email address has been used to register an account.
If you did not ask for one, don\'t worry. Just delete this e-mail.
Please confirm your request by clicking on the link below:

{X-URL}',
			),
			// ** 会員登録受付メールの件名
			// *** 日本語
			array(
				'language_id' => '2',
				'key' => 'AutoRegist.acceptance_mail_subject',
				'value' => '[{X-SITE_NAME}]承認待ち会員のお知らせ',
			),
			// *** 英語
			array(
				'language_id' => '1',
				'key' => 'AutoRegist.acceptance_mail_subject',
				'value' => '[{X-SITE_NAME}]New Registrant',
			),
			// ** 会員登録受付メールの本文
			// *** 日本語
			array(
				'language_id' => '2',
				'key' => 'AutoRegist.acceptance_mail_body',
				'value' => '{X-SITE_NAME}にて新規登録ユーザがありました。

ログインを許可する場合は、下記のリンクをクリックして登録ユーザ宛てに承認メールを送信してください。

{X-URL}',
			),
			// *** 英語
			array(
				'language_id' => '1',
				'key' => 'AutoRegist.acceptance_mail_body',
				'value' => 'A new user has just registered.
Clicking on the link below will activate the account of this user.

{X-URL}',
			),
			// ** 会員登録メールの件名
			// *** 日本語
			array(
				'language_id' => '2',
				'key' => 'AutoRegist.mail_subject',
				'value' => '{X-SITE_NAME}へようこそ',
			),
			// *** 英語
			array(
				'language_id' => '1',
				'key' => 'AutoRegist.mail_subject',
				'value' => 'Welcome to {X-SITE_NAME}.',
			),
			// ** 会員登録メールの本文
			// *** 日本語
			array(
				'language_id' => '2',
				'key' => 'AutoRegist.mail_body',
				'value' => '会員登録が完了しましたのでお知らせします。
ハンドル：{X-HANDLE}
ログインID：{X-LOGIN_ID}
パスワード：{X-PASSWORD}
e-mail：{X-EMAIL}

下記アドレスからログインしてください。
{X-URL}',
			),
			// *** 英語
			array(
				'language_id' => '1',
				'key' => 'AutoRegist.mail_body',
				'value' => 'Thank you for registering for {X-SITE_NAME}.
Handle:{X-HANDLENAME}
Login_id:{X-USERNAME}
Password:{X-PASSWORD}
e-mail:{X-EMAIL}

You may now log in by clicking on this link or copying and pasting it in your browser:
{X-URL}',
			),

			// * 退会設定
			// ** 退会機能の設定
			array(
				'language_id' => 0,
				'key' => 'UserCancel.use_cancel_feature',
				'value' => '0', //0:退会機能を使用しない|1:自動的に退会させる
			),
			// ** 退会規約
			// *** 日本語
			array(
				'language_id' => '2',
				'key' => 'UserCancel.disclaimer',
				'value' => '',
			),
			// *** 英語
			array(
				'language_id' => '1',
				'key' => 'UserCancel.disclaimer',
				'value' => '',
			),
			// ** 管理者に退会メールを送付する
			array(
				'language_id' => 0,
				'key' => 'UserCancel.notify_administrators',
				'value' => '1',
			),
			// ** 退会完了メールの件名
			// *** 日本語
			array(
				'language_id' => '2',
				'key' => 'UserCancel.mail_subject',
				'value' => '[{X-SITE_NAME}]会員退会のお知らせ',
			),
			// *** 英語
			array(
				'language_id' => '1',
				'key' => 'UserCancel.mail_subject',
				'value' => '[{X-SITE_NAME}]Announcements for leaving Members',
			),
			// ** 退会完了メールの内容
			// *** 日本語
			array(
				'language_id' => '2',
				'key' => 'UserCancel.mail_body',
				'value' => '{X-SITE_NAME}の{X-HANDLE}が退会しました。',
			),
			// *** 英語
			array(
				'language_id' => '1',
				'key' => 'UserCancel.mail_body',
				'value' => '{X-SITE_NAME}\'s{X-HANDLE} is already leaved.',
			),

			//コンテンツ承認
			// * コンテンツ承認設定
			// ** 申請メールの件名
			array(
				'language_id' => '2',
				'key' => 'Workflow.approval_mail_subject',
				'value' => '(承認依頼){X-PLUGIN_MAIL_SUBJECT}',
			),
			// *** 英語
			array(
				'language_id' => '1',
				'key' => 'Workflow.approval_mail_subject',
				'value' => '(approval request){X-PLUGIN_MAIL_SUBJECT}[{X-SITE_NAME}]{X-PLUGIN_NAME}',
			),
			// ** 申請メールの本文
			// *** 日本語
			array(
				'language_id' => '2',
				'key' => 'Workflow.approval_mail_body',
				'value' => '{X-USER}さんから{X-PLUGIN_NAME}の承認依頼があったことをお知らせします。

{X-WORKFLOW_COMMENT}


{X-PLUGIN_MAIL_BODY}',
			),
			// *** 英語
			array(
				'language_id' => '1',
				'key' => 'Workflow.approval_mail_body',
				'value' => '{X-USER} we let you know that there was an approval request of {X-PLUGIN_NAME} from.

{X-WORKFLOW_COMMENT}


{X-PLUGIN_MAIL_BODY}',
			),
			// ** 差し戻しメールの件名
			// *** 日本語
			array(
				'language_id' => '2',
				'key' => 'Workflow.disapproval_mail_subject',
				'value' => '(差し戻し){X-PLUGIN_MAIL_SUBJECT}',
			),
			// *** 英語
			array(
				'language_id' => '1',
				'key' => 'Workflow.disapproval_mail_subject',
				'value' => '(remand){X-PLUGIN_MAIL_SUBJECT} [{X-SITE_NAME}]{X-PLUGIN_NAME}',
			),
			// ** 差し戻しメールの本文
			// *** 日本語
			array(
				'language_id' => '2',
				'key' => 'Workflow.disapproval_mail_body',
				'value' => '{X-USER}さんの{X-PLUGIN_NAME}が差し戻しされたことをお知らせします。
もし{X-USER}さんの{X-PLUGIN_NAME}に覚えがない場合はこのメールを破棄してください。

{X-WORKFLOW_COMMENT}


{X-PLUGIN_MAIL_BODY}',
			),
			// *** 英語
			array(
				'language_id' => '1',
				'key' => 'Workflow.disapproval_mail_body',
				'value' => '{X-USER} \'s {X-PLUGIN_NAME} is to inform you that it has been remanded.
Please discard this email if you\'re still unable to recognize the if {X-USER} \'s {X-PLUGIN_NAME}.

{X-WORKFLOW_COMMENT}


{X-PLUGIN_MAIL_BODY}',
			),
			// ** 承認完了メールの件名
			// *** 日本語
			array(
				'language_id' => '2',
				'key' => 'Workflow.approval_completion_mail_subject',
				'value' => '(承認完了){X-PLUGIN_MAIL_SUBJECT}',
			),
			// *** 英語
			array(
				'language_id' => '1',
				'key' => 'Workflow.approval_completion_mail_subject',
				'value' => '(approval completion){X-PLUGIN_MAIL_SUBJECT}',
			),
			// ** 承認完了メールの本文
			// *** 日本語
			array(
				'language_id' => '2',
				'key' => 'Workflow.approval_completion_mail_body',
				'value' => '{X-USER}さんの{X-PLUGIN_NAME}の承認が完了されたことをお知らせします。
もし{X-USER}さんの{X-PLUGIN_NAME}に覚えがない場合はこのメールを破棄してください。

{X-WORKFLOW_COMMENT}


{X-PLUGIN_MAIL_BODY}',
			),
			// *** 英語
			array(
				'language_id' => '1',
				'key' => 'Workflow.approval_completion_mail_body',
				'value' => 'To inform you that approval of {X-USER} \'s {X-PLUGIN_NAME} has been completed.
Please discard this email if you\'re still unable to recognize the if {X-USER} \'s {X-PLUGIN_NAME}.

{X-WORKFLOW_COMMENT}


{X-PLUGIN_MAIL_BODY}',
			),

			//メール設定
			// * 本文ヘッダー
			// ** 日本語
			array(
				'language_id' => '2',
				'key' => 'Mail.body_header',
				'value' => '※このメールに返信しても相手には届きませんのでご注意ください。

',
			),
			// ** 英語
			array(
				'language_id' => '1',
				'key' => 'Mail.body_header',
				'value' => '- Please note even if you reply this mail directly, the mail\'s sender can not receive it.

',
			),

			// * 署名
			// ** 日本語
			array(
				'language_id' => '2',
				'key' => 'Mail.signature',
				'value' => '',
			),
			// ** 英語
			array(
				'language_id' => '1',
				'key' => 'Mail.signature',
				'value' => '',
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
