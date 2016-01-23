<?php
/**
 * SiteManager Component
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('Component', 'Controller');

/**
 * SiteManager Component
 *
 * このコンポーネントで$this->reqeust->data[SiteSetting]のパラメータを
 * DBの型 <-> viewで使用する型に変換する
 *
 * #### サンプルコード
 * ##### startup()
 * ```
 * $this->reqeust->data[SiteSetting][App/site_name]
 * ↓↓↓↓↓↓
 * $this->reqeust->data[SiteSetting][App.site_name]
 * ```
 *
 * ##### beforeRender()
 * ```
 * $this->reqeust->data[SiteSetting][App.site_name]
 * ↓↓↓↓↓↓
 * $this->reqeust->data[SiteSetting][App/site_name]
 *
 * $this->reqeust->validationErrors[SiteSetting][App.site_name]
 * ↓↓↓↓↓↓
 * $this->reqeust->validationErrors[SiteSetting][App/site_name]
 * ```
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\SiteManager\Controller\Component
 */
class SiteManagerComponent extends Component {

/**
 * strtrで変換する文字列(from)
 */
	const STRTR_FROM = '.';

/**
 * strtrで変換する文字列(to)
 */
	const STRTR_TO = '/';

/**
 * Called before the Controller::beforeFilter().
 *
 * @param Controller $controller Controller with components to initialize
 * @return void
 * @link http://book.cakephp.org/2.0/en/controllers/components.html#Component::initialize
 */
	public function initialize(Controller $controller) {
		$this->controller = $controller;
		parent::initialize($controller);
	}

/**
 * Called after the Controller::beforeFilter() and before the controller action
 *
 * @param Controller $controller Controller with components to startup
 * @return void
 * @throws ForbiddenException
 */
	public function startup(Controller $controller) {
		if (property_exists($controller, 'SiteSetting')) {
			$controller->SiteSetting->messagePlugin = $controller->params['plugin'];
		}

		if (isset($controller->request->data['SiteSetting'])) {
			foreach ($controller->request->data['SiteSetting'] as $key => $data) {
				$requestKey = strtr($key, self::STRTR_TO, self::STRTR_FROM);

				unset($controller->request->data['SiteSetting'][$key]);
				$controller->request->data['SiteSetting'][$requestKey] = $data;
			}
		}
	}

/**
 * saveSiteSettingに登録する処理
 *
 * @return void
 */
	public function saveData() {
		$controller = $this->controller;

		//不要パラメータ除去
		$controller->request->data = Hash::remove($controller->request->data, 'save');
		$controller->request->data = Hash::remove($controller->request->data, 'active_lang_id');

		//登録処理
		if ($controller->SiteSetting->saveSiteSetting($controller->request->data)) {
			//正常の場合
			$controller->NetCommons->setFlashNotification(__d('net_commons', 'Successfully saved.'), array(
				'class' => 'success',
			));
			$controller->redirect($controller->referer());
		} else {
			$controller->NetCommons->handleValidationError($controller->SiteSetting->validationErrors);
		}
	}

/**
 * Called before the Controller::beforeRender(), and before
 * the view class is loaded, and before Controller::render()
 *
 * @param Controller $controller Controller with components to beforeRender
 * @return void
 * @link http://book.cakephp.org/2.0/en/controllers/components.html#Component::beforeRender
 */
	public function beforeRender(Controller $controller) {
		if (isset($controller->request->data['SiteSetting'])) {
			foreach ($controller->request->data['SiteSetting'] as $key => $data) {
				$requestKey = strtr($key, self::STRTR_FROM, self::STRTR_TO);

				unset($controller->request->data['SiteSetting'][$key]);
				$controller->request->data['SiteSetting'][$requestKey] = $data;
			}
		}

		if (property_exists($controller, 'SiteSetting')) {
			foreach ($controller->SiteSetting->validationErrors as $key => $data) {
				$requestKey = strtr($key, self::STRTR_FROM, self::STRTR_TO);

				unset($controller->SiteSetting->validationErrors[$key]);
				$controller->SiteSetting->validationErrors[$requestKey] = $data;
			}
		}
	}

}
