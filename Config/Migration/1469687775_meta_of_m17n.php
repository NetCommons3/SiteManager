<?php
/**
 * メタ情報の多言語対応＋閲覧対象年齢層の指定削除
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsMigration', 'NetCommons.Config/Migration');

/**
 * メタ情報の多言語対応＋閲覧対象年齢層の指定削除
 *
 * @package NetCommons\SiteManager\Config\Migration
 */
class MetaOfM17n extends NetCommonsMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'meta_of_m17n';

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
			//メタ情報
			// * 作成者
			array(
				'language_id' => '1',
				'key' => 'Meta.author',
				'value' => 'NetCommons',
			),
			array(
				'language_id' => '2',
				'key' => 'Meta.author',
				'value' => 'NetCommons',
			),
			// * 著作権表示
			array(
				'language_id' => '1',
				'key' => 'Meta.copyright',
				'value' => 'Copyright © 2016',
			),
			array(
				'language_id' => '2',
				'key' => 'Meta.copyright',
				'value' => 'Copyright © 2016',
			),
			// * キーワード
			array(
				'language_id' => '1',
				'key' => 'Meta.keywords',
				'value' => 'CMS,Netcommons,NetCommons3,CakePHP',
			),
			array(
				'language_id' => '2',
				'key' => 'Meta.keywords',
				'value' => 'CMS,Netcommons,NetCommons3,CakePHP',
			),
			// * サイトの説明
			array(
				'language_id' => '1',
				'key' => 'Meta.description',
				'value' => 'CMS,Netcommons,NetCommons3,CakePHP',
			),
			array(
				'language_id' => '2',
				'key' => 'Meta.description',
				'value' => 'CMS,Netcommons,NetCommons3,CakePHP',
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

		//既存データ削除
		$conditions = array(
			'SiteSetting.key' => array(
				'Meta.author',
				'Meta.copyright',
				'Meta.keywords',
				'Meta.description',
				'Meta.rating',
			)
		);
		$Model = $this->generateModel('SiteSetting');
		$Model->deleteAll($conditions, false, false);

		foreach ($this->records as $model => $records) {
			if (!$this->updateRecords($model, $records)) {
				return false;
			}
		}
		return true;
	}
}
