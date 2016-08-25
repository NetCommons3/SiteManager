<?php
/**
 * 承認設定 Element
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<article>
	<?php echo $this->SiteManager->inputLanguage('SiteSetting', 'Workflow.approval_mail_subject', array(
			//'type' => 'textarea',
			'required' => true,
		)); ?>

	<?php echo $this->SiteManager->inputLanguage('SiteSetting', 'Workflow.approval_mail_body', array(
			'type' => 'textarea',
			'mailHelp' => true,
			'required' => true,
		)); ?>

	<hr>

	<?php echo $this->SiteManager->inputLanguage('SiteSetting', 'Workflow.disapproval_mail_subject', array(
			//'type' => 'textarea',
			'required' => true,
		)); ?>

	<?php echo $this->SiteManager->inputLanguage('SiteSetting', 'Workflow.disapproval_mail_body', array(
			'type' => 'textarea',
			'mailHelp' => true,
			'required' => true,
		)); ?>

	<hr>

	<?php echo $this->SiteManager->inputLanguage('SiteSetting', 'Workflow.approval_completion_mail_subject', array(
			//'type' => 'textarea',
			'required' => true,
		)); ?>

	<?php echo $this->SiteManager->inputLanguage('SiteSetting', 'Workflow.approval_completion_mail_body', array(
			'type' => 'textarea',
			'mailHelp' => true,
			'required' => true,
		)); ?>

</article>
