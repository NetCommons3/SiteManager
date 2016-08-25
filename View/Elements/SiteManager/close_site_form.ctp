<?php
/**
 * サイト閉鎖設定 Element
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<article ng-controller="WysiwygSiteManager">
	<?php $domId = $this->SiteManager->domId('SiteSetting.App.close_site'); ?>
	<div ng-init="<?php echo $domId . ' = ' . (int)$this->SiteManager->getValue('SiteSetting', 'App.close_site'); ?>">

		<?php echo $this->SiteManager->inputCommon('SiteSetting', 'App.close_site', array(
				'type' => 'radio',
				'ng-click' => $domId . ' = click($event)',
				'options' => array(
					'1' => __d('net_commons', 'Yes'),
					'0' => __d('net_commons', 'No'),
				),
				'help' => __d('site_manager', 'App.close_site help')
			)); ?>

		<div class="row"  ng-show="<?php echo $domId; ?>" ng-cloak>
			<div class="col-xs-offset-1 col-xs-11">
				<?php echo $this->SiteManager->inputLanguage('SiteSetting', 'App.site_closing_reason', array(
						'type' => 'wysiwyg',
						'required' => true,
					)); ?>
				<?php echo $this->NetCommonsForm->help($this->SiteManager->helpSiteClose()); ?>
			</div>
		</div>
	</div>
</article>
