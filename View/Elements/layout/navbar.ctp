<?php
	$menu = array(
		'Categories' => array('controller' => 'categories', 'action' => 'index'),
		'Products' => array('controller' => 'products', 'action' => 'index'),
		'Orders' => array(
			'submenu' => array(
				'All' => array('controller' => 'orders', 'action' => 'index'),
				'Having Product 1' => array('controller' => 'orders', 'action' => 'having', 1)
			)
		)
	);
?>
<div class="navbar">
	<div class="navbar-inner">
		<div class="container">
			<?php echo $this->Html->link(__('Work Shop'), '/', array('class' => 'brand')); ?>
			<ul class="nav">
				<?php foreach ($menu as $title => $entry) : ?>
					<?php if (empty($entry['submenu'])) : ?>
						<li>
							<?php echo $this->Html->link($title, $entry, array('escape' => false)); ?>
						</li>		
					<?php else :?>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<?php echo $title ?>
								<b class="caret"></b>
							</a>
							<ul class="dropdown-menu">
							<?php foreach ($entry['submenu'] as $title => $e) : ?>
								<li>
									<?php echo $this->Html->link($title, $e, array('escape' => false)); ?>
								</li>
							<?php endforeach ?>
							</ul>
						</li>
					<?php endif; ?>
				<?php endforeach ?>
			</ul>
		</div>
	</div>
</div>
