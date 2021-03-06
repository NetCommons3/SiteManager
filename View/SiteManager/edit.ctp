<?php
/**
 * サイト管理【一般設定】テンプレート
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php echo $this->SiteManager->tabs(); ?>

<?php echo $this->NetCommonsForm->create('SiteSetting', array(
		'ng-controller' => 'SiteManager',
	)); ?>

	<div class="panel panel-default">
		<div class="panel-body">
			<?php echo $this->SwitchLanguage->tablist('site-settings-'); ?>
			<br>

			<div class="panel panel-default">
				<div class="panel-body">
					<?php echo $this->element('SiteManager/general_form'); ?>
				</div>
			</div>

			<div class="panel panel-default">
				<div class="panel-heading">
					<?php echo __d('site_manager', 'Notification of password'); ?>
				</div>

				<div class="panel-body">
					<?php echo $this->element('SiteManager/notification_password_form'); ?>
				</div>
			</div>

			<div class="panel panel-default">
				<div class="panel-heading">
					<?php echo __d('site_manager', 'Close site settings'); ?>
				</div>

				<div class="panel-body">
					<?php echo $this->element('SiteManager/close_site_form'); ?>
				</div>
			</div>
		</div>

		<div class="panel-footer text-center">
			<?php echo $this->Button->cancelAndSave(
					__d('net_commons', 'Cancel'),
					__d('net_commons', 'OK'),
					'#', array('ng-click' => 'cancel()')
				); ?>
		</div>
	</div>

<?php echo $this->NetCommonsForm->end();
