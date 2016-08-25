<?php
/**
 * サイト管理【入会・退会・承認設定】テンプレート
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php echo $this->SiteManager->tabs(); ?>
<?php echo $this->MessageFlash->description(
		__d('site_manager', 'Against approval is required content, you can set the e-mail subject line, ' .
							'text that is sent to complete approval from the application request (remand).')
	); ?>

<?php echo $this->NetCommonsForm->create('SiteSetting', array(
		'ng-controller' => 'SiteManager',
	)); ?>

	<div class="panel panel-default">
		<div class="panel-body">
			<?php echo $this->SwitchLanguage->tablist('site-settings-'); ?>

			<?php echo $this->element('Workflow/content_workflo_form'); ?>
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
