<?php
/**
 * Meta情報 Element
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
	<?php echo $this->SiteManager->inputLanguage('SiteSetting', 'Meta.author', array(
		'help' => true
	)); ?>

	<?php echo $this->SiteManager->inputLanguage('SiteSetting', 'Meta.copyright', array(
		'help' => true
	)); ?>

	<?php echo $this->SiteManager->inputLanguage('SiteSetting', 'Meta.keywords', array(
		'type' => 'textarea',
		'help' => true
	)); ?>

	<?php echo $this->SiteManager->inputLanguage('SiteSetting', 'Meta.description', array(
		'type' => 'textarea',
		'help' => true
	)); ?>

	<?php echo $this->SiteManager->inputCommon('SiteSetting', 'Meta.robots', array(
		'type' => 'select',
		'options' => $SiteSetting->metaRobots,
		'help' => true
	)); ?>
</article>
