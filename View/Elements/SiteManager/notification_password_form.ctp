<?php
/**
 * パスワード再発行設定 Element
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<article>
	<?php $domId = $this->SiteManager->domId('ForgotPass.use_password_reissue'); ?>
	<div ng-init="<?php echo $domId . ' = ' . (int)$this->SiteManager->getValue('SiteSetting', 'ForgotPass.use_password_reissue'); ?>">

		<?php echo $this->SiteManager->inputCommon('SiteSetting', 'ForgotPass.use_password_reissue', array(
				'type' => 'radio',
				'ng-click' => $domId . ' = click($event)',
				'options' => array(
					'1' => __d('net_commons', 'Yes'),
					'0' => __d('net_commons', 'No'),
				),
			)); ?>

		<div ng-show="<?php echo $domId; ?>">
			<?php echo $this->SiteManager->inputLanguage('SiteSetting', 'ForgotPass.issue_mail_subject', array(
					//'type' => 'textarea',
				)); ?>

			<?php echo $this->SiteManager->inputLanguage('SiteSetting', 'ForgotPass.issue_mail_body', array(
					'type' => 'textarea',
					'mailHelp' => true,
				)); ?>

			<hr>

			<?php echo $this->SiteManager->inputLanguage('SiteSetting', 'ForgotPass.request_mail_subject', array(
					//'type' => 'textarea',
				)); ?>

			<?php echo $this->SiteManager->inputLanguage('SiteSetting', 'ForgotPass.request_mail_body', array(
					'type' => 'textarea',
					'mailHelp' => true,
				)); ?>
		</div>
	</div>
</article>
