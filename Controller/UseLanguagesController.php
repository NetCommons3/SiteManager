<?php
/**
 * SiteManagerApp Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('SiteManagerAppController', 'SiteManager.Controller');
App::uses('Plugin', 'PluginManager.Model');

/**
 * サイト管理【利用言語設定】
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\SiteManager\Controller
 */
class UseLanguagesController extends SiteManagerAppController {

/**
 * 使用するモデル
 *
 * @var array
 */
	public $uses = array(
		'M17n.Language',
		'SiteManager.SiteSetting',
		'PluginManager.Plugin',
	);

/**
 * Helpers
 */
	public $helpers = array(
		'M17n.M17n',
	);

/**
 * edit
 *
 * @return void
 */
	public function edit() {
		list($activeLangs, $enableLangs) = $this->Language->getLanguagesWithName();

		if ($this->request->is('post')) {
			try {
				$this->Language->begin();
				$this->Plugin->begin();

				$result = $this->Language->saveActive($this->data);
				if (! $result) {
					$this->NetCommons->handleValidationError($this->Language->validationErrors);
					$this->set('validationErrors', $this->Language->validationErrors);
					$activeLangs = array();
				}

				$this->Plugin->saveEnableM17n($this->data);

				$this->Language->commit();
				$this->Plugin->commit();

			} catch (Exception $ex) {
				$this->Language->rollback($ex);
				$this->Plugin->rollback();
			}

			if ($result) {
				$this->NetCommons->setFlashNotification(__d('net_commons', 'Successfully saved.'), array(
					'class' => 'success',
				));
				return $this->redirect($this->referer());
			}
		}

		$plugins = $this->Plugin->cacheFindQuery('list', array(
			'recursive' => -1,
			'fields' => array('key', 'name'),
			'conditions' => array(
				'type' => Plugin::PLUGIN_TYPE_FOR_FRAME,
				'language_id' => Current::read('Language.id'),
			),
			'order' => array('weight' => 'asc', 'id' => 'asc'),
		));
		$this->set('plugins', $plugins);

		$plugins = $this->Plugin->cacheFindQuery('list', array(
			'recursive' => -1,
			'fields' => array('key', 'key'),
			'conditions' => array(
				'type' => Plugin::PLUGIN_TYPE_FOR_FRAME,
				'language_id' => Current::read('Language.id'),
				'is_m17n' => true,
			),
			'order' => array('weight' => 'asc', 'id' => 'asc'),
		));
		$this->set('isM17nPlugins', array_keys($plugins));

		$this->set('activeLangs', $activeLangs);
		$this->set('enableLangs', $enableLangs);
	}

}
