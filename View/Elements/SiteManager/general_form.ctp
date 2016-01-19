<?php
/**
 * 一般設定 Element
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('M17nHelper', 'M17n.View/Helper');
?>

<article>
	<?php echo $this->SiteManager->inputLanguage('SiteSetting', 'App.site_name', array('required' => true)); ?>

	<?php echo $this->SiteManager->inputCommon('SiteSetting', 'Config.language', array(
		'type' => 'select',
		'empty' => __d('site_manager', 'Automatic language'),
		'options' => array_map('__', array_intersect_key(M17nHelper::$languages, array_flip($languages))),
		'description' => true
	)); ?>

	<?php echo $this->SiteManager->inputCommon('SiteSetting', 'App.default_start_room', array(
		'type' => 'select',
		'options' => $rooms,
		'description' => true
	)); ?>
</article>
