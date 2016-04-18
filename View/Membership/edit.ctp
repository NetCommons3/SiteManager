<?php
/**
 * サイト管理【入会・退会・承認設定】テンプレート
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php echo $this->SiteManager->tabs(); ?>


<?php echo $this->NetCommonsForm->create('SiteSetting', array(
		'ng-controller' => 'SiteManager',
		'ng-init' => $this->SiteManager->domId('membershipTab') . ' = \'' . h($membershipTab) . '\''
	)); ?>

	<?php $this->NetCommonsForm->unlockField('membershipTab'); ?>
	<?php echo $this->NetCommonsForm->hidden('membershipTab', array(
		'ng-value' => $this->SiteManager->domId('membershipTab')
	)); ?>

	<div>
	<?php echo $this->SiteManager->membershipTabs(); ?>

	<div class="panel panel-default">
		<div class="panel-body">
			<?php echo $this->SwitchLanguage->tablist('site-settings-'); ?>

			<div class="tab-content">
				<div class="tab-pane<?php echo ($membershipTab === 'automatic-registration' ? ' active' : ''); ?>" id="automatic-registration">
					<?php echo $this->element('Membership/automatic_registration_form'); ?>
				</div>

				<div class="tab-pane<?php echo ($membershipTab === 'membership-cancellation' ? ' active' : ''); ?>" id="membership-cancellation">
					<?php echo $this->element('Membership/membership_cancellation_form'); ?>
				</div>
			</div>
		</div>

		<div class="panel-footer text-center">
			<?php echo $this->BackTo->linkButton(__d('net_commons', 'Cancel'), '', array(
				'ng-href' => $this->NetCommonsHtml->url(array('action' => 'edit')) . '?membershipTab=' . '{{' . $this->SiteManager->domId('membershipTab') . '}}'
			)); ?>

			<?php echo $this->Button->save(	__d('net_commons', 'OK')); ?>
		</div>
	</div>

	</div>

<?php echo $this->NetCommonsForm->end();
