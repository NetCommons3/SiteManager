<?php
/**
 * サイト管理【利用言語設定】テンプレート
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
		__d('site_manager', 'Please select the language to use.')
	); ?>

<?php echo $this->NetCommonsForm->create('SiteSetting', array(
		'ng-controller' => 'SiteManager',
	)); ?>

	<div class="panel panel-default">
		<div class="panel-body">
			<?php echo $this->NetCommonsForm->input('Language.code', array(
				'type' => 'checkbox',
				'multiple' => true,
				'options' => $defaultLangs,
				'default' => $activeLangs,
				'hiddenField' => false,
				'error' => false,
			)); ?>

			<?php if (isset($validationErrors['Language.code'])) : ?>
				<div class="has-error">
					<?php foreach ($validationErrors['Language.code'] as $error): ?>
						<div class="help-block">
							<?php echo $error; ?>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
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
