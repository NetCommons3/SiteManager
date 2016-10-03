<?php
/**
 * SiteSettingFixture
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * SiteSettingFixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\SiteManager\Test\Fixture
 */
class SiteSettingFixture extends CakeTestFixture {

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => '2',
			'language_id' => '2',
			'key' => 'theme',
			'value' => 'UnitTestTheme',
			'label' => 'Theme',
			'weight' => '1',
		),
		array(
			'id' => '3',
			'language_id' => '0',
			'key' => 'App.default_timezone',
			'value' => 'Asia/Tokyo',
			'label' => 'SiteTimezone',
			'weight' => '1',
		),
		array(
			'id' => '5',
			'language_id' => '0',
			'key' => 'Mail.from',
			'value' => '',
			'label' => 'Mail.from',
			'weight' => '1',
		),
		array(
			'id' => '6',
			'language_id' => '0',
			'key' => 'Upload.allow_extension',
			'value' => 'gif,jpg,png,zip,mp4',
			'label' => 'Upload.allow_extension',
			'weight' => '1',
		),
		array(
			'id' => '7',
			'language_id' => '0',
			'key' => 'Config.language',
			'value' => 'ja',
			'label' => '',
			'weight' => null,
		),
	);

/**
 * Initialize the fixture.
 *
 * @return void
 */
	public function init() {
		require_once App::pluginPath('SiteManager') . 'Config' . DS . 'Schema' . DS . 'schema.php';
		$this->fields = (new SiteManagerSchema())->tables[Inflector::tableize($this->name)];
		parent::init();
	}

}
