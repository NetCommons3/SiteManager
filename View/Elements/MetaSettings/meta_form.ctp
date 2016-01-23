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
$SiteSettin->prepare();
?>

<article>
	<?php echo $this->SiteManager->inputCommon('SiteSetting', 'Meta.author', array(
		'description' => true
	)); ?>

	<?php echo $this->SiteManager->inputCommon('SiteSetting', 'Meta.copyright', array(
		'description' => true
	)); ?>

	<?php echo $this->SiteManager->inputCommon('SiteSetting', 'Meta.keywords', array(
		'type' => 'textarea',
		'description' => true
	)); ?>

	<?php echo $this->SiteManager->inputCommon('SiteSetting', 'Meta.description', array(
		'type' => 'textarea',
		'description' => true
	)); ?>

	<?php echo $this->SiteManager->inputCommon('SiteSetting', 'Meta.robots', array(
		'type' => 'select',
		'options' => $SiteSetting->metaRobots,
		'description' => true
	)); ?>

	<?php echo $this->SiteManager->inputCommon('SiteSetting', 'Meta.rating', array(
		'type' => 'select',
		'options' => $SiteSetting->metaRating,
	)); ?>
</article>
