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
					$this->NetCommonsHtml->url(array('action' => 'edit'))
				); ?>
		</div>
	</div>

<?php echo $this->NetCommonsForm->end();
