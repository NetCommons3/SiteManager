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

<article ng-controller="WysiwygSiteManager">
	<?php $domId = $this->SiteManager->domId('SiteSetting.UserCancel.use_cancel_feature'); ?>
	<div ng-init="<?php echo $domId . ' = ' . (int)$this->SiteManager->getValue('SiteSetting', 'UserCancel.use_cancel_feature'); ?>">

		<?php echo $this->SiteManager->inputCommon('SiteSetting', 'UserCancel.use_cancel_feature', array(
				'type' => 'radio',
				'ng-click' => $domId . ' = click($event)',
				'options' => array(
					'1' => __d('net_commons', 'Yes'),
					'0' => __d('net_commons', 'No'),
				),
			)); ?>

		<div class="row" ng-show="<?php echo $domId; ?>" ng-cloak>
			<div class="col-xs-offset-1 col-xs-11">
				<?php echo $this->SiteManager->inputLanguage('SiteSetting', 'UserCancel.disclaimer', array(
						'type' => 'wysiwyg',
						'help' => true,
					)); ?>

				<?php $notifyDomId = $this->SiteManager->domId('SiteSetting.UserCancel.notify_administrators'); ?>
				<div ng-init="<?php echo $notifyDomId . ' = ' . (int)$this->SiteManager->getValue('SiteSetting', 'UserCancel.notify_administrators'); ?>">

					<?php echo $this->SiteManager->inputCommon('SiteSetting', 'UserCancel.notify_administrators', array(
							'type' => 'radio',
							'ng-click' => $notifyDomId . ' = click($event)',
							'options' => array(
								'1' => __d('net_commons', 'Yes'),
								'0' => __d('net_commons', 'No'),
							),
						)); ?>

					<div class="row" ng-show="<?php echo $notifyDomId; ?>">
						<div class="col-xs-offset-1 col-xs-11">
							<?php echo $this->SiteManager->inputLanguage('SiteSetting', 'UserCancel.mail_subject', array(
									//'type' => 'textarea',
									'required' => true,
								)); ?>

							<?php echo $this->SiteManager->inputLanguage('SiteSetting', 'UserCancel.mail_body', array(
									'type' => 'textarea',
									'mailHelp' => true,
									'required' => true,
								)); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</article>
