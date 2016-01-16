<?php
/**
 * SiteSettings Test Case
 *
 * @author   Ryuji AMANO <ryuji@ryus.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('SiteSetting', 'NetCommons.Model');
App::uses('NetCommonsCakeTestCase', 'NetCommons.TestSuite');

/**
 * Summary for SiteSettings Test Case
 */
class SiteSettingTest extends NetCommonsCakeTestCase {

/**
 * @var array fixture
 */
	public $fixtures = array(
		'plugin.site_manager.site_setting',
		'plugin.users.user',
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->SiteSetting = ClassRegistry::init('SiteManager.SiteSetting');
		Configure::write('Config.language', 'ja');
		Current::$current['Language']['id'] = 2; // ja
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->SiteSetting);
		Configure::write('Config.language', null);

		parent::tearDown();
	}

/**
 * getSiteTheme サイト用テーマ名の取得
 *
 * @return void
 */
	public function testGetSiteTheme() {
		//データがある場合
		$ck = $this->SiteSetting->getSiteTheme();
		$this->assertTextEquals('UnitTestTheme', $ck);
		//該当のレコード削除  //データが無い場合を作る
		$ck = $this->SiteSetting->find('first', array(
			'conditions' => array('SiteSetting.key' => 'theme'),
		));
		$ck1 = $this->SiteSetting->delete($ck['SiteSetting']['id']);
		$this->assertTrue($ck1);
		//問い合わせた結果データは無いのでnullが戻る
		$ck = $this->SiteSetting->getSiteTheme();
		$this->assertEquals(null, $ck);
	}

/**
 * test getTimezone
 *
 * @return void
 */
	public function testGetTimezone() {
		$siteTimezone = $this->SiteSetting->getSiteTimezone();
		$this->assertEquals('Asia/Tokyo', $siteTimezone);
	}
}
