<?php
/**
 * 自動登録設定 Element
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('SiteSetting', 'SiteManager.Model');
$SiteSetting = new SiteSetting();
$SiteSetting->prepare();
?>

<article>
	<?php $domId = $this->SiteManager->domId('SiteSetting.AutoRegist.use_automatic_register'); ?>
	<div ng-init="<?php echo $domId . ' = ' . (int)$this->SiteManager->getValue('SiteSetting', 'AutoRegist.use_automatic_register'); ?>">

		<?php echo $this->SiteManager->inputCommon('SiteSetting', 'AutoRegist.use_automatic_register', array(
				'type' => 'radio',
				'ng-click' => $domId . ' = click($event)',
				'options' => array(
					'1' => __d('net_commons', 'Yes'),
					'0' => __d('net_commons', 'No'),
				),
			)); ?>

		<div ng-show="<?php echo $domId; ?>">
			<?php echo $this->SiteManager->inputCommon('SiteSetting', 'AutoRegist.confirmation', array(
					'type' => 'select',
					'options' => $SiteSetting->autoRegistConfirm
				)); ?>
		</div>

		<?php $secretDomId = $this->SiteManager->domId('SiteSetting.AutoRegist.use_secret_key'); ?>
		<div ng-show="<?php echo $domId; ?>"
				ng-init="<?php echo $secretDomId . ' = ' . (int)$this->SiteManager->getValue('SiteSetting', 'AutoRegist.use_secret_key'); ?>">

			<div class="form-group">
				<?php echo $this->SiteManager->inputCommon('SiteSetting', 'AutoRegist.use_secret_key', array(
						'type' => 'radio',
						'ng-click' => $secretDomId . ' = click($event)',
						'options' => array(
							'1' => __d('net_commons', 'Yes'),
							'0' => __d('net_commons', 'No'),
						),
						'div' => false,
					)); ?>

				<div class="form-input-outer" ng-show="<?php echo $secretDomId; ?>">
					<?php echo $this->SiteManager->inputCommon('SiteSetting', 'AutoRegist.secret_key', array(
							'type' => 'text',
							'label' => false,
							'placeholder' => __d('site_manager', 'AutoRegist.secret_key help')
						)); ?>
				</div>
			</div>
		</div>

		<div ng-show="<?php echo $domId; ?>">
			<?php echo $this->SiteManager->inputCommon('SiteSetting', 'AutoRegist.role_key', array(
					'type' => 'select',
					'options' => $userRoles,
				)); ?>
		</div>

		<div ng-show="<?php echo $domId; ?>">
			<?php echo $this->SiteManager->inputCommon('SiteSetting', 'AutoRegist.prarticipate_default_room', array(
					'type' => 'radio',
					'options' => array(
						'1' => __d('net_commons', 'Yes'),
						'0' => __d('net_commons', 'No'),
					),
				)); ?>
		</div>

		<div class="panel panel-default" ng-show="<?php echo $domId; ?>">
			<div class="panel-heading">
				<?php echo __d('site_manager', 'Input items'); ?>
			</div>
			<div class="panel-body">

			</div>
		</div>

		<div ng-show="<?php echo $domId; ?>">
			<?php echo $this->SiteManager->inputLanguage('SiteSetting', 'AutoRegist.disclaimer', array(
					'type' => 'textarea',
					'help' => true,
				)); ?>
		</div>

		<hr ng-show="<?php echo $domId; ?>">

		<div ng-show="<?php echo $domId; ?>">
			<?php echo $this->SiteManager->inputLanguage('SiteSetting', 'AutoRegist.approval_mail_subject', array(
					//'type' => 'textarea',
				)); ?>
		</div>

		<div ng-show="<?php echo $domId; ?>">
			<?php echo $this->SiteManager->inputLanguage('SiteSetting', 'AutoRegist.approval_mail_body', array(
					'type' => 'textarea',
					'mailHelp' => true,
				)); ?>
		</div>

		<hr ng-show="<?php echo $domId; ?>">

		<div ng-show="<?php echo $domId; ?>">
			<?php echo $this->SiteManager->inputLanguage('SiteSetting', 'AutoRegist.acceptance_mail_subject', array(
					//'type' => 'textarea',
				)); ?>
		</div>

		<div ng-show="<?php echo $domId; ?>">
			<?php echo $this->SiteManager->inputLanguage('SiteSetting', 'AutoRegist.acceptance_mail_body', array(
					'type' => 'textarea',
					'mailHelp' => true,
				)); ?>
		</div>

		<hr ng-show="<?php echo $domId; ?>">

		<div ng-show="<?php echo $domId; ?>">
			<?php echo $this->SiteManager->inputLanguage('SiteSetting', 'AutoRegist.mail_subject', array(
					//'type' => 'textarea',
				)); ?>
		</div>

		<div ng-show="<?php echo $domId; ?>">
			<?php echo $this->SiteManager->inputLanguage('SiteSetting', 'AutoRegist.mail_body', array(
					'type' => 'textarea',
					'mailHelp' => true,
				)); ?>
		</div>
	</div>
</article>
