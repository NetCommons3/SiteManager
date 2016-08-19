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
<br>

<div class="panel panel-default">
	<div class="panel-body">
		<article ng-controller="WysiwygSiteManager">
			<?php $domId = $this->SiteManager->domId('SiteSetting.AutoRegist.use_automatic_register'); ?>
			<?php $confirmationDomId = $this->SiteManager->domId('SiteSetting.AutoRegist.confirmation'); ?>
			<div ng-init="<?php echo $domId . ' = ' . (int)$this->SiteManager->getValue('SiteSetting', 'AutoRegist.use_automatic_register'); ?>;
							<?php echo $confirmationDomId . ' = ' . (int)$this->SiteManager->getValue('SiteSetting', 'AutoRegist.confirmation'); ?>">

				<?php echo $this->SiteManager->inputCommon('SiteSetting', 'AutoRegist.use_automatic_register', array(
						'type' => 'radio',
						'ng-click' => $domId . ' = click($event)',
						'options' => array(
							'1' => __d('net_commons', 'Yes'),
							'0' => __d('net_commons', 'No'),
						),
					)); ?>

				<div col="row" ng-show="<?php echo $domId; ?>" ng-cloak>
					<div class="col-xs-offset-1 col-xs-11">
						<div>
							<?php echo $this->SiteManager->inputCommon('SiteSetting', 'AutoRegist.confirmation', array(
									'type' => 'select',
									'options' => $SiteSetting->autoRegistConfirm,
									'ng-click' => $confirmationDomId . ' = click($event)',
								)); ?>
						</div>

						<?php $secretDomId = $this->SiteManager->domId('SiteSetting.AutoRegist.use_secret_key'); ?>
						<div ng-init="<?php echo $secretDomId . ' = ' . (int)$this->SiteManager->getValue('SiteSetting', 'AutoRegist.use_secret_key'); ?>">

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
											'placeholder' => __d('site_manager', 'AutoRegist.secret_key placeholder'),
											'div' => false,
										)); ?>
								</div>

								<?php echo $this->NetCommonsForm->help(__d('site_manager', 'AutoRegist.use_secret_key help')); ?>
							</div>
						</div>

						<div>
							<?php echo $this->SiteManager->inputCommon('SiteSetting', 'AutoRegist.role_key', array(
									'type' => 'select',
									'options' => $userRoles,
									'help' => true,
								)); ?>
						</div>

						<div class="panel panel-default automatic-input-items"
								ng-init="AutomaticInputItems = <?php echo $automaticInputItems; ?>"
								ng-show="(AutomaticInputItems)">
							<?php
								echo $this->NetCommonsForm->hidden('_siteManager.automaticInputItems', array(
									'value' => '{{AutomaticInputItems}}'
								));
								$this->NetCommonsForm->unlockField('_siteManager.automaticInputItems');
							?>
							<?php echo $this->element('Membership/automatic_input_items'); ?>
						</div>

						<div>
							<?php echo $this->SiteManager->inputLanguage('SiteSetting', 'AutoRegist.disclaimer', array(
									'type' => 'wysiwyg',
									'help' => true,
								)); ?>
						</div>

						<hr ng-show="<?php echo '(' . $confirmationDomId . ' === 0' . ' || ' . $confirmationDomId . ' === 2)'; ?>">

						<div ng-show="<?php echo '(' . $confirmationDomId . ' === 0' . ' || ' . $confirmationDomId . ' === 2)'; ?>">
							<?php echo $this->SiteManager->inputLanguage('SiteSetting', 'AutoRegist.approval_mail_subject', array(
									//'type' => 'textarea',
								)); ?>
						</div>

						<div ng-show="<?php echo '(' . $confirmationDomId . ' === 0' . ' || ' . $confirmationDomId . ' === 2)'; ?>">
							<?php echo $this->SiteManager->inputLanguage('SiteSetting', 'AutoRegist.approval_mail_body', array(
									'type' => 'textarea',
									'mailHelp' => true,
								)); ?>
						</div>

						<hr ng-show="(<?php echo $confirmationDomId . ' === 2'; ?>)">

						<div ng-show="(<?php echo $confirmationDomId . ' === 2'; ?>)">
							<?php echo $this->SiteManager->inputLanguage('SiteSetting', 'AutoRegist.acceptance_mail_subject', array(
									//'type' => 'textarea',
								)); ?>
						</div>

						<div ng-show="(<?php echo $confirmationDomId . ' === 2'; ?>)">
							<?php echo $this->SiteManager->inputLanguage('SiteSetting', 'AutoRegist.acceptance_mail_body', array(
									'type' => 'textarea',
									'mailHelp' => true,
								)); ?>
						</div>
					</div>
				</div>
			</div>
		</article>
	</div>
</div>

<div class="panel panel-default">
	<div class="panel-body">
		<article>
			<div>
				<?php echo $this->SiteManager->inputLanguage('SiteSetting', 'UserRegist.mail_subject', array(
						//'type' => 'textarea',
					)); ?>
			</div>

			<div>
				<?php echo $this->SiteManager->inputLanguage('SiteSetting', 'UserRegist.mail_body', array(
						'type' => 'textarea',
						'mailHelp' => true,
					)); ?>
			</div>
		</article>
	</div>
</div>

