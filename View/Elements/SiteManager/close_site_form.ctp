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

<article>
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

		<div ng-show="<?php echo $domId; ?>">
			<?php echo $this->SiteManager->inputLanguage('SiteSetting', 'App.site_closing_reason', array(
					'type' => 'textarea',
				)); ?>
		</div>
	</div>
</article>
