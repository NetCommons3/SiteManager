<?php
/**
 * システム管理のSave Behavior
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('ModelBehavior', 'Model');

/**
 * システム管理のSave Behavior
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\SiteManager\Model\Behavior
 */
class SystemManagerSaveBehavior extends ModelBehavior {

/**
 *  ルームの容量の登録
 *
 * @param Model $model ビヘイビア呼び出し元モデル
 * @param array $data リクエストデータ配列
 * @return array リクエストデータ
 * @throws InternalErrorException
 */
	public function saveRoomDiskSize(Model $model, $data) {
		if (! isset($data[$model->alias]['App.disk_for_group_room']) ||
				! isset($data[$model->alias]['App.disk_for_private_room'])) {
			return $data;
		}
		$model->loadModels([
			'Space' => 'Rooms.Space',
		]);

		$spaces = array(
			'App.disk_for_group_room' => Space::COMMUNITY_SPACE_ID,
			'App.disk_for_private_room' => Space::PRIVATE_SPACE_ID,
		);
		foreach ($spaces as $key => $spaceId) {
			$value = (int)Hash::get($data[$model->alias][$key], '0.value');
			if ($value < 0) {
				$value = null;
			}
			$model->Space->id = $spaceId;
			if (! $model->Space->saveField('room_disk_size', $value)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}
			$model->Space->cacheClear();
			unset($data[$model->alias][$key]);
		}

		return $data;
	}

}
