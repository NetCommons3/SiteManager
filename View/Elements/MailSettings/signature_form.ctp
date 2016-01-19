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
	<?php echo $this->SiteManager->inputLanguage('SiteSetting', 'Mail.body_header', array(
			'type' => 'textarea',
			'description' => true,
		)); ?>

	<?php echo $this->SiteManager->inputLanguage('SiteSetting', 'Mail.signature', array(
			'type' => 'textarea',
			'description' => true,
		)); ?>
</article>
