<?php $this->extend('/Layouts/split'); ?>
<?php $this->start('left'); ?>
<div class="products index" id="products-list">
	<h2><?php echo __('Products'); ?></h2>
	<table class="table">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('description'); ?></th>
			<th><?php echo $this->Paginator->sort('category_id'); ?></th>
			<th><?php echo $this->Paginator->sort('price'); ?></th>
			<th><?php echo $this->Paginator->sort('quantity_left'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
	foreach ($products as $product): ?>
	<tr data-id="<?php echo $product['Product']['id'] ?>">
		<td><?php echo h($product['Product']['id']); ?>&nbsp;</td>
		<td><?php echo h($product['Product']['name']); ?>&nbsp;</td>
		<td><?php echo h($product['Product']['description']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($product['Category']['name'], array('controller' => 'categories', 'action' => 'view', $product['Category']['id'])); ?>
		</td>
		<td><?php echo h($product['Product']['price']); ?>&nbsp;</td>
		<td><?php echo h($product['Product']['quantity_left']); ?>&nbsp;</td>
		<td><?php echo h($product['Product']['created']); ?>&nbsp;</td>
		<td><?php echo h($product['Product']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $product['Product']['id']), null, __('Are you sure you want to delete # %s?', $product['Product']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<?php echo $this->Paginator->pagination(); ?>
</div>
<?php $this->end();?>
<?php $this->start('right');?>
<div class="products form span9">
<?php echo $this->Form->create('Product', array('action' => 'add', 'id' => 'product-form')); ?>
	<fieldset>
		<legend><?php echo __('Add Product'); ?></legend>
	<?php
		echo $this->Form->input('name', array('class' => 'name'));
		echo $this->Form->input('description', array('class' => 'description'));
		echo $this->Form->input('category_id', array('class' => 'category_id'));
		echo $this->Form->input('price', array('class' => 'price'));
		echo $this->Form->input('quantity_left', array('class' => 'quantity_left'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<?php $this->end();?>

<?php $this->start('script') ?>
<script>
	App.Model.Product = App.Model.extend({
		name: 'Product',
		urlRoot: '/products'
	});

	App.IndexView = Backbone.View.extend({
		el: '#products-list',
		events: {
			'click tbody tr': 'load',
			'hover tbody tr': 'highlight'
		},

		initialize: function() {
			model = new App.Model.Product();
			var editView = new App.EditView({model: model});
		},

		load: function(e) {
			var id = $(e.currentTarget).data('id');
			var model = new App.Model.Product({id: id});
			var editView = new App.EditView({model: model});
			Backbone.ModelBinding.bind(editView, {all: 'class'});
			model.fetch();
		},
		
		highlight: function(e) {
			$(e.currentTarget).css('cursor', 'pointer');
		}
	});
 
	App.EditView = Backbone.View.extend({
		el: '#product-form',
		model: null,

		events: {
			'submit': 'save'
		},
		
		save: function(e) {
			e.preventDefault();
			var self = this;
			this.model.save()
				.success(function(){
					window.location.reload();
				})
				.error(function(response) {
					var errors = JSON.parse(response.responseText);
					if ('errors' in errors) {
						self.showErrors(errors.errors);
					}
				});
		},

		showErrors: function(errors) {
			for (field in errors) {
				var m = new App.ValidationError({
					message: errors[field].pop()
				});
				this.$('.' + field).parent().append(m.el)
					.closest('.control-group').addClass('error');
			}
		}
	});

	App.ValidationError = Backbone.View.extend({
		tagName: 'span',
		className: 'help-inline',

		initialize: function() {
			this.$el.html(this.options.message);
		}
	});

	var list = new App.IndexView();
</script>
<?php $this->end();?>


