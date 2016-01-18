<?php
/**
 * サイト管理【ページスタイル】テンプレート
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php echo $this->SiteManager->tabs(); ?>

<?php echo $this->NetCommonsForm->create('Room'); ?>

	<?php echo $this->SiteManager->roomTabs(); ?>

	<div class="panel panel-default">
		<div class="panel-body">
			<?php echo $this->ThemeSettings->render('DefaultPageSettings/theme_form'); ?>
		</div>
	</div>

<?php echo $this->NetCommonsForm->end();
