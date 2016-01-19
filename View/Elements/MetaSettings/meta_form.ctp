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
		'options' => array(
			'index,follow' => __d('site_manager', 'Index, Follow'),
			'noindex,follow' => __d('site_manager', 'No Index, Follow'),
			'index,nofollow' => __d('site_manager', 'Index, No Follow'),
			'noindex,nofollow' => __d('site_manager', 'No Index, No Follow'),
		),
		'description' => true
	)); ?>

	<?php echo $this->SiteManager->inputCommon('SiteSetting', 'Meta.rating', array(
		'type' => 'select',
		'options' => array(
			'General' => __d('site_manager', 'General'),
			'14 years' => __d('site_manager', '14 years'),
			'restricted' => __d('site_manager', 'Restricted'),
			'mature' => __d('site_manager', 'Mature'),
		),
	)); ?>
</article>
