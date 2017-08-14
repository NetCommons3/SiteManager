<?php
/**
 * 自動登録設定の入力項目 Element
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

echo $this->NetCommonsHtml->css('/site_manager/css/style.css');
App::uses('UserAttribute', 'UserAttributes.Model');

?>

<div class="panel-heading clearfix" ng-click="AutomaticInputItems = ! AutomaticInputItems">
	<div class="pull-left">
		<?php echo __d('site_manager', 'Input items'); ?>
	</div>
	<div class="pull-right">
		<span class="glyphicon glyphicon-chevron-down" aria-hidden="true" ng-show="AutomaticInputItems"> </span>
		<span class="glyphicon glyphicon-chevron-right" aria-hidden="true" ng-show="!AutomaticInputItems"> </span>
	</div>
</div>

<?php
	foreach ($userAttributes as $i => $userAttribute) {
		$userAttrSettingId = $userAttribute['UserAttributeSetting']['id'];

		echo $this->NetCommonsForm->hidden('UserAttributeSetting.' . $userAttrSettingId . '.id', array(
			'value' => $userAttribute['UserAttributeSetting']['id'],
		));

		if ($userAttribute['UserAttributeSetting']['required']) {
			$userAttributes[$i]['UserAttributeSetting']['auto_regist_display'] = '1';
			echo $this->NetCommonsForm->hidden('UserAttributeSetting.' . $userAttrSettingId . '.auto_regist_display', array(
				'value' => '1',
			));
		} else {
			echo $this->NetCommonsForm->checkbox('UserAttributeSetting.' . $userAttrSettingId . '.auto_regist_display', array(
				'value' => $userAttribute['UserAttributeSetting']['auto_regist_display'],
				'class' => 'hidden'
			));
		}

		echo $this->NetCommonsForm->text('UserAttributeSetting.' . $userAttrSettingId . '.auto_regist_weight', array(
			'value' => $i + 1,
			'class' => 'hidden'
		));
	}
	$camelUserAttributes = NetCommonsAppController::camelizeKeyRecursive($userAttributes);
?>
<div class="panel-body" ng-show="AutomaticInputItems" ng-controller="MembershipInputItems"
		ng-init="initialize(<?php echo h(json_encode(['userAttributes' => $camelUserAttributes])); ?>)">

	<?php echo $this->MessageFlash->description(__d('site_manager', 'Member items that are required is a change not allowed.')); ?>

	<ul class="automatic-user-attribute" ng-repeat="userAttr in userAttributes track by $index">
		<li class="list-group-item clearfix"
			ng-class="{'list-group-item-success': (userAttr.userAttributeSetting.required || userAttr.userAttributeSetting.autoRegistDisplay)}">

			<div class="pull-left">
				<button type="button" class="btn btn-default btn-xs"
						ng-click="move('up', $index)" ng-disabled="$first">
					<span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span>
				</button>

				<button type="button" class="btn btn-default btn-xs"
						ng-click="move('down', $index)" ng-disabled="$last">
					<span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span>
				</button>

				<input type="hidden" name="data[UserAttributeSetting][{{userAttr.userAttributeSetting.id}}][auto_regist_weight]" ng-value="{{$index + 1}}">

				<button type="button" class="btn btn-default btn-xs user-attributes-display-btn"
						ng-disabled="(userAttr.userAttributeSetting.required ||
									userAttr.userAttributeSetting.userAttributeKey == '<?php echo UserAttribute::EMAIL_FIELD; ?>')"
						ng-click="display($index, 0)"
						ng-show="(userAttr.userAttributeSetting.required || userAttr.userAttributeSetting.autoRegistDisplay)">

					<span class="glyphicon glyphicon-eye-open" aria-hidden="true"> </span>
					<?php echo __d('user_attributes', 'Display'); ?>
				</button>

				<button type="button" class="btn btn-default btn-xs user-attributes-display-btn"
						ng-click="display($index, 1)"
						ng-show="(!userAttr.userAttributeSetting.required && !userAttr.userAttributeSetting.autoRegistDisplay)">

					<span class="glyphicon glyphicon-minus" aria-hidden="true"> </span>
					<?php echo __d('user_attributes', 'Non display'); ?>
				</button>

				<input type="hidden" name="data[UserAttributeSetting][{{userAttr.userAttributeSetting.id}}][auto_regist_display]"
						value="{{userAttr.userAttributeSetting.autoRegistDisplay}}">
			</div>

			<div class="pull-left">
				{{userAttr.userAttribute.name}}
				<strong class="text-danger h4" ng-show="(userAttr.userAttributeSetting.required || userAttr.userAttributeSetting.userAttributeKey === 'email')">
					<?php echo __d('net_commons', '*'); ?>
				</strong>
			</div>
		</li>
	</ul>
</div>
