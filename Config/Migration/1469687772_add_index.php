<?php
/**
 * AddIndex migration
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * AddIndex migration
 *
 * @package NetCommons\SiteManager\Config\Migration
 */
class AddIndex extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'add_index';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'alter_field' => array(
				'site_settings' => array(
					'key' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_general_ci', 'comment' => 'Key of the record.    e.g.) theme_name, site_name', 'charset' => 'utf8'),
				),
			),
			'create_field' => array(
				'site_settings' => array(
					'indexes' => array(
						'key' => array('column' => 'key', 'unique' => 0),
					),
				),
			),
		),
		'down' => array(
			'alter_field' => array(
				'site_settings' => array(
					'key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'Key of the record.    e.g.) theme_name, site_name', 'charset' => 'utf8'),
				),
			),
			'drop_field' => array(
				'site_settings' => array('indexes' => array('key')),
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
		return true;
	}
}
