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
	const STRTR_FROM_DOT = '.';

/**
 * strtrで変換する文字列(to)
 */
	const STRTR_TO_DOT = '/';

/**
 * strtrで変換する文字列(from)
 */
	const STRTR_FROM_BRACKETS_LEFT = '[';

/**
 * strtrで変換する文字列(to)
 */
	const STRTR_TO_BRACKETS_LEFT = '{';

/**
 * strtrで変換する文字列(from)
 */
	const STRTR_FROM_BRACKETS_RIGHT = ']';

/**
 * strtrで変換する文字列(to)
 */
	const STRTR_TO_BRACKETS_RIGHT = '}';

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
				$requestKey = self::invertRequestKey($key);

				unset($controller->request->data['SiteSetting'][$key]);
				$controller->request->data['SiteSetting'][$requestKey] = $data;
			}
		}
	}

/**
 * saveSiteSettingに登録する処理
 *
 * @param string $redirect リダイレクト
 * @return void
 */
	public function saveData($redirect = null) {
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
			if (isset($redirect)) {
				$controller->redirect($redirect);
			} else {
				$controller->redirect($controller->referer());
			}
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
				$requestKey = self::convertRequestKey($key);

				unset($controller->request->data['SiteSetting'][$key]);
				$controller->request->data['SiteSetting'][$requestKey] = $data;
			}
		}

		if (property_exists($controller, 'SiteSetting')) {
			foreach ($controller->SiteSetting->validationErrors as $key => $data) {
				$requestKey = self::convertRequestKey($key);

				unset($controller->SiteSetting->validationErrors[$key]);
				$controller->SiteSetting->validationErrors[$requestKey] = $data;
			}
		}
	}

/**
 * リクエストキーを変換する
 *
 * @param string $requestKey リクエストキー文字列
 * @return string
 */
	public static function convertRequestKey($requestKey) {
		$requestKey = strtr(
			$requestKey, self::STRTR_FROM_DOT, self::STRTR_TO_DOT
		);
		$requestKey = strtr(
			$requestKey, self::STRTR_FROM_BRACKETS_LEFT, self::STRTR_TO_BRACKETS_LEFT
		);
		$requestKey = strtr(
			$requestKey, self::STRTR_FROM_BRACKETS_RIGHT, self::STRTR_TO_BRACKETS_RIGHT
		);

		return $requestKey;
	}

/**
 * 変換したリクエストキーを戻す
 *
 * @param string $requestKey リクエストキー文字列
 * @return string
 */
	public static function invertRequestKey($requestKey) {
		$requestKey = strtr(
			$requestKey, self::STRTR_TO_DOT, self::STRTR_FROM_DOT
		);
		$requestKey = strtr(
			$requestKey, self::STRTR_TO_BRACKETS_LEFT, self::STRTR_FROM_BRACKETS_LEFT
		);
		$requestKey = strtr(
			$requestKey, self::STRTR_TO_BRACKETS_RIGHT, self::STRTR_FROM_BRACKETS_RIGHT
		);

		return $requestKey;
	}

}
