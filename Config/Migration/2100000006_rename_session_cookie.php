<?php
/**
 * Cookie名のkeyを修正
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsMigration', 'NetCommons.Config/Migration');

/**
 * Cookie名のkeyを修正
 *
 * @package NetCommons\SiteManager\Config\Migration
 */
class RenameSessionCookie extends NetCommonsMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'rename_session_cookie';

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
	public $records = array();

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

		$Model = $this->generateModel('SiteSetting');
		$conditions = array(
			'SiteSetting.key' => 'Session.ini.session.name'
		);
		$update = array(
			'SiteSetting.key' => '\'Session.cookie\''
		);
		if (! $Model->updateAll($update, $conditions)) {
			return false;;
		}
		return true;
	}
}
