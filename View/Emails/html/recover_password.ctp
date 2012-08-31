<?php

echo $this->Html->link('click here to recover password', array(
	'controller' => 'users',
	'action' => 'reset',
	$token,
	'full_base' => true
));