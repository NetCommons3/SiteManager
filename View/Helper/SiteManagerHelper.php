<?php
/**
 * SiteManager Helper
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppHelper', 'View/Helper');
App::uses('Room', 'Rooms.Model');

/**
 * サイト管理ヘルパー
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\SiteManager\View\Helper
 */
class SiteManagerHelper extends AppHelper {

/**
 * 使用するヘルパー
 *
 * @var array
 */
	public $helpers = array(
		'M17n.SwitchLanguage',
		'NetCommons.NetCommonsForm',
		'NetCommons.NetCommonsHtml',
	);

/**
 * タブ
 *
 * @var array
 */
	protected $_tabs = array(
		'site_manager' => array(
			'controller' => 'site_manager',
			'action' => 'edit',
		),
		'meta_settings' => array(
			'controller' => 'meta_settings',
			'action' => 'edit',
		),
		'default_page_settings' => array(
			'controller' => 'default_page_settings',
			'action' => 'edit',
			'key' => Room::PUBLIC_PARENT_ID
		),
		'membership' => array(
			'controller' => 'membership',
			'action' => 'edit',
		),
		'mail_settings' => array(
			'controller' => 'mail_settings',
			'action' => 'edit',
		),
	);

/**
 * Before render callback. beforeRender is called before the view file is rendered.
 *
 * Overridden in subclasses.
 *
 * @param string $viewFile The view file that is going to be rendered
 * @return void
 */
	public function beforeRender($viewFile) {
		$this->NetCommonsHtml->css(array(
			'/site_manager/css/style.css', '/data_types/css/style.css'
		));
		$this->NetCommonsHtml->script(array(
			'/site_manager/js/site_manager.js'
		));
		parent::beforeRender($viewFile);
	}

/**
 * タブの出力
 *
 * @param string|null $active アクティブタブ
 * @return string HTML
 */
	public function tabs($active = null) {
		if (! isset($active)) {
			$active = $this->_View->request->params['controller'];
		}

		$output = '';
		$output .= '<ul class="nav nav-tabs" role="tablist">';
		foreach ($this->_tabs as $key => $tab) {
			$output .= '<li class="' . ($key === $active ? 'active' : '') . '">';
			$output .= $this->NetCommonsHtml->link(__d('site_manager', 'Tab.' . $key), $tab);
			$output .= '</li>';
		}
		$output .= '</ul>';
		$output .= '<br>';

		return $output;
	}

/**
 * タブの出力
 *
 * @return string HTML
 */
	public function roomTabs() {
		$output = '';
		$output .= '<ul class="nav nav-pills" role="tablist">';
		foreach ($this->_View->viewVars['rooms'] as $roomId => $room) {
			$output .= '<li class="' . ((string)$roomId === $this->_View->viewVars['activeRoomId'] ? 'active' : '') . '">';
			$output .= $this->NetCommonsHtml->link(
							Hash::get($this->_View->viewVars['rooms'], $roomId . '.RoomsLanguage.name'),
							Hash::merge(Hash::get($this->_tabs, $this->_View->request->params['controller']), array('key' => $roomId))
						);
			$output .= '</li>';
		}
		$output .= '</ul>';
		$output .= '<br>';

		return $output;
	}

/**
 * タブの出力
 *
 * @return string HTML
 */
	public function membershipTabs() {
		$output = '';

		$output .= '<ul class="nav nav-pills" role="tablist">';

		$tabs = array(
			'automatic-registration' => __d('site_manager', 'Automatic registration'),
			'membership-cancellation' => __d('site_manager', 'Membership cancellation'),
			'notification-password' => __d('site_manager', 'Notification of password'),
			'content-workflow' => __d('site_manager', 'Content workflow'),
		);

		$active = $this->_View->viewVars['membershipTab'];
		foreach ($tabs as $key => $label) {
			if ($key === $active) {
				$output .= '<li class="active">';
			} else {
				$output .= '<li>';
			}

			$output .= '<a href="#' . $key . '" aria-controls="' . $key . '" role="tab" data-toggle="tab" ' .
							'ng-click="' . $this->domId('membershipTab') . ' = \'' . $key . '\'">';
			$output .= $label;
			$output .= '</a>';
			$output .= '</li>';
		}

		$output .= '</ul>';
		$output .= '<br>';

		return $output;
	}

/**
 * inputタグ
 *
 * @param string $model モデル名
 * @param string $key キー
 * @param int $languageId 言語ID
 * @return string HTML
 */
	public function inputHidden($model, $key, $languageId) {
		$output = '';

		if (! isset($this->_View->request->data[$model][$key])) {
			return $output;
		}

		$inputValue = $model . '.' . $key . '.' . $languageId;
		$inputName = 'data[' . $model . '][' . $key . '][' .$languageId . ']';

		//id
		$output .= $this->NetCommonsForm->hidden($inputValue . '.id',
			array(
				'name' => $inputName . '[id]',
				'value' => Hash::get($this->_View->request->data[$model][$key],  $languageId . '.id')
			)
		);
		//key
		$output .= $this->NetCommonsForm->hidden($inputValue . '.key',
			array(
				'name' => $inputName . '[key]',
				'value' => Hash::get($this->_View->request->data[$model][$key],  $languageId . '.key')
			)
		);
		//language_id
		$output .= $this->NetCommonsForm->hidden($inputValue . '.language_id',
			array(
				'name' => $inputName . '[language_id]',
				'value' => Hash::get($this->_View->request->data[$model][$key],  $languageId . '.language_id')
			)
		);

		return $output;
	}

/**
 * inputタグ
 *
 * @param string $model モデル名
 * @param string $key キー
 * @param array $options オプション
 * @param string $labelPlugin __dのプラグイン名
 * @return string HTML
 */
	public function inputCommon($model, $key, $options = array(), $labelPlugin = 'site_manager') {
		$output = '';

		if (! isset($this->_View->request->data[$model][$key])) {
			return $output;
		}

		$hasDescription = Hash::get($options, 'description', false);
		Hash::remove($options, 'description');

		$languageId = '0';
		$inputValue = $model . '.' . $key . '.' . $languageId;
		$inputName = 'data[' . $model . '][' . $key . '][' .$languageId . ']';

		//hidden
		$output .= $this->inputHidden($model, $key, $languageId);

		//value
		if (Hash::get($options, 'div', true)) {
			$output .= '<div class="form-group">';
		} else {
			$output .= '<div>';
		}

		$valueOptions = array(
			'name' => $inputName . '[value]',
			'value' => $this->getValue($model, $key, $languageId),
		);
		if (Hash::get($options, 'type', 'text') === 'radio') {
			$output .= $this->NetCommonsForm->label($inputValue . '.value', __d($labelPlugin, $key));
			$output .= '<div class="form-control nc-data-label">';
			$output .= $this->NetCommonsForm->radio($inputValue . '.value', Hash::get($options, 'options', array()), Hash::merge(array(
				'div' => array('class' => 'form-control form-inline'),
				'separator' => '<span class="radio-separator"></span>'
			), $valueOptions, $options));
			$output .= '</div>';
		} else {
			$output .= $this->NetCommonsForm->input($inputValue . '.value',
				Hash::merge(array(
					'label' => __d($labelPlugin, $key),
					'div' => false,
					'error' => false,
				), $valueOptions, $options)
			);
		}

		$output .= $this->description($key, $hasDescription, $labelPlugin);
		$output .= $this->NetCommonsForm->error($inputValue . '.value');
		$output .= '</div>';

		return $output;
	}

/**
 * inputタグ(言語)
 *
 * @param string $model モデル名
 * @param string $key キー
 * @param array $options オプション
 * @param string $labelPlugin __dのプラグイン名
 * @return string HTML
 */
	public function inputLanguage($model, $key, $options = array(), $labelPlugin = 'site_manager') {
		$output = '';

		if (! isset($this->_View->request->data[$model][$key])) {
			return $output;
		}

		$hasDescription = Hash::get($options, 'description', false);
		Hash::remove($options, 'description');

		$activeLangId = $this->_View->viewVars['activeLangId'];
		$languageIds = array_keys($this->_View->viewVars['languages']);
		foreach ($languageIds as $languageId) {
			$inputValue = $model . '.' . $key . '.' . $languageId;
			$inputName = 'data[' . $model . '][' . $key . '][' .$languageId . ']';

			$output .= '<div class="tab-pane' . ((string)$activeLangId === (string)$languageId ? ' active' : '') . '" ' .
							'ng-show="' . 'activeLangId === \'' . $languageId . '\'' . '">';

			//hidden
			$output .= $this->inputHidden($model, $key, $languageId);
			//value
			$output .= '<div class="form-group">';
			$output .= $this->NetCommonsForm->input($inputValue . '.value',
				Hash::merge(array(
					'label' => $this->SwitchLanguage->inputLabel(__d($labelPlugin, $key), $languageId),
					'name' => $inputName . '[value]',
					'value' => $this->getValue($model, $key, $languageId),
					'div' => false,
					'error' => false,
				), $options)
			);
			$output .= $this->description($key, $hasDescription, $labelPlugin);
			$output .= $this->NetCommonsForm->error($inputValue . '.value');
			$output .= '</div>';

			$output .= '</div>';
		}

		return $output;
	}

/**
 * 説明
 *
 * @param string $key キー
 * @param bool $hasDescription 説明の有無
 * @param string $labelPlugin __dのプラグイン名
 * @return string HTML
 */
	public function description($key, $hasDescription, $labelPlugin = 'site_manager') {
		$output = '';

		if ($hasDescription) {
			$output .= '<div class="bg-info text-info site-manager-description">';
			$output .= __d($labelPlugin, $key . ' description');
			$output .= '</div>';
		}

		return $output;
	}

/**
 * 値の取得
 *
 * @param string $model モデル名
 * @param string $key キー
 * @param int $languageId 言語ID
 * @return string HTML
 */
	public function getValue($model, $key, $languageId = '0') {
		if (! isset($this->_View->request->data[$model][$key])) {
			return '';
		}

		return Hash::get($this->_View->request->data[$model][$key],  $languageId . '.value');
	}

}
