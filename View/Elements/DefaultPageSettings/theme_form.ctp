<?php
/**
 * テーマ設定 Element
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

$url = array(
	'key' => h($activeRoomId),
	'?' => array('theme' => h($theme['key'])),
);
?>

<article>
	<?php echo $this->NetCommonsForm->create('Room', array(
			'url' => NetCommonsUrl::actionUrlAsArray(array('key' => $activeRoomId)),
		)); ?>

		<?php echo $this->NetCommonsForm->hidden('Room.id'); ?>
		<?php echo $this->NetCommonsForm->hidden('Room.theme', array('value' => $theme['key'])); ?>

		<?php echo $this->NetCommonsHtml->link(__d('net_commons', 'Preview'), '#', array(
			'class' => 'btn btn-default btn-xs',
			'ng-disabled' => 'sending',
			'ng-click' => 'themePreview(\'' . $this->NetCommonsHtml->url(['key' => h($activeRoomId), '?' => array('theme' => h($theme['key']))]) . '\')',
		)); ?>

		<?php echo $this->Button->save(__d('net_commons', 'OK'), array('class' => 'btn btn-primary btn-xs')); ?>
	<?php echo $this->NetCommonsForm->end(); ?>

</article>



