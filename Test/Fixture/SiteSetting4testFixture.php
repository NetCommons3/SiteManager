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

App::uses('SiteSettingFixture', 'SiteManager.Test/Fixture');

/**
 * SiteSettingFixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\SiteManager\Test\Fixture
 */
class SiteSetting4testFixture extends SiteSettingFixture {

/**
 * Model name
 *
 * @var string
 */
	public $name = 'SiteSetting';

/**
 * Full Table Name
 *
 * @var string
 */
	public $table = 'site_settings';

/**
 * Records
 *
 * @var array
 */
	public $records = array();

/**
 * Initialize the fixture.
 *
 * @return void
 */
	public function init() {
		require_once App::pluginPath('SiteManager') . 'Config' . DS . 'Migration' . DS . '1469687773_site_manager_records.php';
		$records = (new SiteManagerRecords())->records[$this->name];
		$this->records = array_merge($this->records, $records);
		$this->records[0]['value'] = 'NetCommons3 JA';
		$this->records[1]['value'] = 'NetCommons3 EN';

		require_once App::pluginPath('SiteManager') . 'Config' . DS . 'Migration' . DS . '1469687774_system_manager_records.php';
		$records = (new SystemManagerRecords())->records[$this->name];
		$this->records = array_merge($this->records, $records);

		require_once App::pluginPath('SiteManager') . 'Config' . DS . 'Migration' . DS . '1469687775_meta_of_m17n.php';
		$records = (new MetaOfM17n())->records[$this->name];
		$this->records = array_merge($this->records, $records);

		require_once App::pluginPath('SiteManager') . 'Config' . DS . 'Migration' . DS . '1469687776_mail_smtp_tls.php';
		$records = (new MailSmtpTls())->records[$this->name];
		$this->records = array_merge($this->records, $records);

		require_once App::pluginPath('SiteManager') . 'Config' . DS . 'Migration' . DS . '1469687777_contact_after_approval_mail.php';
		$records = (new ContactAfterApprovalMail())->records[$this->name];
		$this->records = array_merge($this->records, $records);

		if ($this->records[62]['key'] === 'Session.ini.session.cookie_lifetime') {
			$this->records[62]['key'] = 'Session.ini.[session.cookie_lifetime]';
		}
		if ($this->records[63]['key'] === 'Session.ini.session.gc_maxlifetime') {
			$this->records[63]['key'] = 'Session.ini.[session.gc_maxlifetime]';
		}
		if ($this->records[65]['key'] === 'Session.ini.session.name') {
			$this->records[65]['key'] = 'Session.cookie';
		}

		parent::init();
	}

}
