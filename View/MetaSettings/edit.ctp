<?php
/**
 * サイト管理【メタ情報】テンプレート
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
		__d('site_manager', 'Meta-information (meta tag), is described in the head tag of the html page, is a tag that defines a variety of additional information of the page.' .
							'The meta-information by setting properly, will also be the SEO measures. Also, if you change the content in each page, it can be changed in the Page Setup.')
	); ?>

<?php echo $this->NetCommonsForm->create('SiteSetting', array(
		'ng-controller' => 'SiteManager',
	)); ?>

	<div class="panel panel-default">
		<div class="panel-body">
			<?php echo $this->element('MetaSettings/meta_form'); ?>
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
