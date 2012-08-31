<div class="users form">
<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __('Change your password'); ?></legend>
		<?php
		echo $this->Form->input('password');
		echo $this->Form->input('email', array('type' => 'hidden'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Go!')); ?>
</div>