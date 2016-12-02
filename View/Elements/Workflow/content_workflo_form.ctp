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
			'label' => __d('site_manager', 'Workflow.approval_mail_subject'),
			'required' => true,
		)); ?>

	<?php echo $this->SiteManager->inputLanguage('SiteSetting', 'Workflow.approval_mail_body', array(
			'type' => 'textarea',
			'label' => __d('site_manager', 'Workflow.approval_mail_body'),
			'help' => __d('site_manager', 'Workflow.approval_mail_body help'),
			'mailHelp' => array(
				'addMessage' => __d(
					'site_manager',
					'The email subject and body of the applicant request that is sent to the room administrator when you registered the content.'
				) . '<br>'
			),
			'required' => true,
		)); ?>

	<hr>

	<?php echo $this->SiteManager->inputLanguage('SiteSetting', 'Workflow.disapproval_mail_subject', array(
			//'type' => 'textarea',
			'label' => __d('site_manager', 'Workflow.disapproval_mail_subject'),
			'required' => true,
		)); ?>

	<?php echo $this->SiteManager->inputLanguage('SiteSetting', 'Workflow.disapproval_mail_body', array(
			'type' => 'textarea',
			'label' => __d('site_manager', 'Workflow.disapproval_mail_body'),
			'help' => __d('site_manager', 'Workflow.disapproval_mail_body help'),
			'mailHelp' => array(
				'addMessage' => __d(
					'site_manager',
					'The email subject and body that is sent to the contributor when remanded the content.'
				) . '<br>'
			),
			'required' => true,
		)); ?>

	<hr>

	<?php echo $this->SiteManager->inputLanguage('SiteSetting', 'Workflow.approval_completion_mail_subject', array(
			//'type' => 'textarea',
			'label' => __d('site_manager', 'Workflow.approval_completion_mail_subject'),
			'required' => true,
		)); ?>

	<?php echo $this->SiteManager->inputLanguage('SiteSetting', 'Workflow.approval_completion_mail_body', array(
			'type' => 'textarea',
			'label' => __d('site_manager', 'Workflow.approval_completion_mail_body'),
			'help' => __d('site_manager', 'Workflow.approval_completion_mail_body help'),
			'mailHelp' => array(
				'addMessage' => __d(
					'site_manager',
					'The email subject and body that is sent to the contributor when you have completed approved the content.'
				) . '<br>'
			),
			'required' => true,
		)); ?>

	<hr>

	<?php echo $this->SiteManager->inputLanguage('SiteSetting', 'Workflow.contact_after_approval_mail_subject', array(
		//'type' => 'textarea',
		'label' => __d('site_manager', 'Workflow.contact_after_approval_mail_subject'),
		'required' => true,
	)); ?>

	<?php echo $this->SiteManager->inputLanguage('SiteSetting', 'Workflow.contact_after_approval_mail_body', array(
		'type' => 'textarea',
		'label' => __d('site_manager', 'Workflow.contact_after_approval_mail_body'),
		'help' => __d('site_manager', 'Workflow.contact_after_approval_mail_body help'),
		'mailHelp' => array(
			'addMessage' => __d(
					'site_manager',
					'Already is the text and e-mail subject line that is sent to the contributor at the time you enter to contact the person in charge of editing the content that has been approved.'
				) . '<br>'
		),
		'required' => true,
	)); ?>

</article>
