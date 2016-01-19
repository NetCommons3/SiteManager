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
	<?php echo $this->SiteManager->inputLanguage('SiteSetting', 'ForgotPass.issue_mail_subject', array(
			//'type' => 'textarea',
		)); ?>

	<?php echo $this->SiteManager->inputLanguage('SiteSetting', 'ForgotPass.issue_mail_body', array(
			'type' => 'textarea',
			'description' => true,
		)); ?>

	<hr>

	<?php echo $this->SiteManager->inputLanguage('SiteSetting', 'ForgotPass.request_mail_subject', array(
			//'type' => 'textarea',
		)); ?>

	<?php echo $this->SiteManager->inputLanguage('SiteSetting', 'ForgotPass.request_mail_body', array(
			'type' => 'textarea',
			'description' => true,
		)); ?>
</article>
