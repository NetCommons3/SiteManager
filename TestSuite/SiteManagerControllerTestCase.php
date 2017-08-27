<?php
/**
 * SiteManagerControllerTestCase TestCase
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

//@codeCoverageIgnoreStart;
App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');
//@codeCoverageIgnoreEnd;

/**
 * SiteManagerControllerTestCase TestCase
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\SiteManager\TestSuite
 * @codeCoverageIgnore
 */
abstract class SiteManagerControllerTestCase extends NetCommonsControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	private $__fixtures = array(
		'plugin.site_manager.site_setting4test',
		'plugin.site_manager.plugin4test',
		'plugin.site_manager.plugins_role4test',
	);

/**
 * Plugin name
 *
 * @var string
 */
	public $plugin = 'site_manager';

/**
 * Fixtures load
 *
 * @param string $name The name parameter on PHPUnit_Framework_TestCase::__construct()
 * @param array  $data The data parameter on PHPUnit_Framework_TestCase::__construct()
 * @param string $dataName The dataName parameter on PHPUnit_Framework_TestCase::__construct()
 * @return void
 */
	public function __construct($name = null, array $data = array(), $dataName = '') {
		if (! isset($this->fixtures)) {
			$this->fixtures = array();
		}
		$this->fixtures = array_merge($this->__fixtures, $this->fixtures);
		parent::__construct($name, $data, $dataName);
	}

}
