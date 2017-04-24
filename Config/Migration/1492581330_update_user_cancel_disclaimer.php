<?php
/**
 * 退会規約のアップデート
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsMigration', 'NetCommons.Config/Migration');

/**
 * 退会規約のアップデート
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\SiteManager\Config\Migration
 */
class UpdateUserCancelDisclaimer extends NetCommonsMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'update_user_cancel_disclaimer';

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
		$SiteSetting = $this->generateModel('SiteSetting');

		if ($direction === 'up') {
			$update = [
				'SiteSetting.value' => '\'<p><span style="color: #f25a62; text-decoration: underline;"><strong>個人情報の削除</strong></span><br />' .
						'個人情報として登録された内容とプライベートルームの内容がアップロードファイルも含めて完全に削除されます。<br />' .
						'同じメールアドレスを使って再登録することはできますが、同じプライベートルームを利用することはできません。</p>' .
						'<p>&nbsp;</p>' .
						'<p><span style="color: #f25a62; text-decoration: underline;"><strong>個人情報の削除されない項目</strong></span><br />' .
						'パブリックおよびコミュニティに投稿した内容やアップロードしたファイル等は、退会処理では削除されません。<br />' .
						'投稿した内容を残したくない場合は、これらの書き込みを削除してから退会処理を行ってください。</p>\''
			];
			$conditions = [
				'SiteSetting.language_id' => '2',
				'SiteSetting.key' => 'UserCancel.disclaimer',
				'SiteSetting.value' => '',
			];
			if (! $SiteSetting->updateAll($update, $conditions)) {
				return false;
			}

			$update = [
				'SiteSetting.value' => '\'<p><span style="color: #f25a62; text-decoration: underline;"><strong>User data which will be deleted</strong></span><br />' .
						'If proceeded, your user profile and private room in this NetCommons will vanish, and cannot be used again.</p>' .
						'<p><span style="color: #f25a62; text-decoration: underline;"><strong>User data which will not be deleted</strong></span><br />' .
						'Your posts and uploaded files in this NetCommons will not be deleted automatically.<br />' .
						'If you wish to delete them, you have to do it manually before you cancel your account.\''
			];
			$conditions = [
				'SiteSetting.language_id' => '1',
				'SiteSetting.key' => 'UserCancel.disclaimer',
				'SiteSetting.value' => '',
			];
			if (! $SiteSetting->updateAll($update, $conditions)) {
				return false;
			}
		}

		return true;
	}
}
