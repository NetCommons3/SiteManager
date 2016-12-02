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
		'label' => __d('site_manager', 'Meta.author'),
		'help' => __d('site_manager', 'Meta.author help')
	)); ?>

	<?php echo $this->SiteManager->inputLanguage('SiteSetting', 'Meta.copyright', array(
		'label' => __d('site_manager', 'Meta.copyright'),
		'help' => __d('site_manager', 'Meta.copyright help')
	)); ?>

	<?php echo $this->SiteManager->inputLanguage('SiteSetting', 'Meta.keywords', array(
		'type' => 'textarea',
		'label' => __d('site_manager', 'Meta.keywords'),
		'help' => __d('site_manager', 'Meta.keywords help')
	)); ?>

	<?php echo $this->SiteManager->inputLanguage('SiteSetting', 'Meta.description', array(
		'type' => 'textarea',
		'label' => __d('site_manager', 'Meta.description'),
		'help' => __d('site_manager', 'Meta.description help')
	)); ?>

	<?php echo $this->SiteManager->inputCommon('SiteSetting', 'Meta.robots', array(
		'type' => 'select',
		'options' => $SiteSetting->metaRobots,
		'label' => __d('site_manager', 'Meta.robots'),
		'help' => __d('site_manager', 'Meta.robots help')
	)); ?>
</article>
