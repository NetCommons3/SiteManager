<?php
/**
 * 退会設定 Element
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<article>
	<?php $domId = $this->SiteManager->domId('SiteSetting.UserCancel.use_cancel_feature'); ?>
	<div ng-init="<?php echo $domId . ' = ' . (int)$this->SiteManager->getValue('SiteSetting', 'UserCancel.use_cancel_feature'); ?>">

		<?php echo $this->SiteManager->inputCommon('SiteSetting', 'UserCancel.use_cancel_feature', array(
				'type' => 'radio',
				'ng-click' => $domId . ' = click($event)',
				'options' => array(
					'1' => __d('site_manager', 'Automatic membership cancellation'),
					'0' => __d('site_manager', 'Do not use membership cancellation'),
				),
			)); ?>

		<div ng-show="<?php echo $domId; ?>">
			<?php echo $this->SiteManager->inputLanguage('SiteSetting', 'UserCancel.disclaimer', array(
					'type' => 'textarea',
					'help' => true,
				)); ?>
		</div>

		<?php $notifyDomId = $this->SiteManager->domId('SiteSetting.UserCancel.notify_administrators'); ?>
		<div ng-show="<?php echo $domId; ?>"
				ng-init="<?php echo $notifyDomId . ' = ' . (int)$this->SiteManager->getValue('SiteSetting', 'UserCancel.notify_administrators'); ?>">

			<?php echo $this->SiteManager->inputCommon('SiteSetting', 'UserCancel.notify_administrators', array(
					'type' => 'radio',
					'ng-click' => $notifyDomId . ' = click($event)',
					'options' => array(
						'1' => __d('net_commons', 'Yes'),
						'0' => __d('net_commons', 'No'),
					),
				)); ?>

			<div ng-show="<?php echo $notifyDomId; ?>">
				<?php echo $this->SiteManager->inputLanguage('SiteSetting', 'UserCancel.mail_subject', array(
						//'type' => 'textarea',
					)); ?>
			</div>

			<div ng-show="<?php echo $notifyDomId; ?>">
				<?php echo $this->SiteManager->inputLanguage('SiteSetting', 'UserCancel.mail_body', array(
						'type' => 'textarea',
						'help' => true,
					)); ?>
			</div>
		</div>

	</div>
</article>
