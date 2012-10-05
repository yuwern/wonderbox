<?php /* SVN: $Id: $ */ ?>
<div class="products form">
<?php echo $this->element('js_tiny_mce_setting', array('cache' => array('config' => 'site_element_cache')));?>
<?php echo $this->Form->create('Product', array('class' => 'normal','enctype' => 'multipart/form-data'));?>
	<fieldset>
		<legend><?php echo $this->Html->link(__l('Products'), array('action' => 'index'));?> &raquo; <?php echo __l('Admin Add Product');?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('Attachment.filename', array('type' => 'file', 'label' => __l('Product Image'),'class'=>'required','div'=>'input file required'));
		echo $this->Form->input('category_id');
		echo $this->Form->input('brand_id');
		echo $this->Form->input('description', array('label' => __l('Description'),'type' =>'textarea', 'class' => 'js-editor'));
		echo $this->Form->input('price',array('label'=>__('Amount')));
		echo $this->Form->input('wonder_point');
		echo $this->Form->input('end_date');
		echo $this->Form->input('is_active',array('type'=>'checkbox'));
	?>
	</fieldset>
		<div class="submit-block">
		<?php echo $this->Form->submit(__l('Add'));?>
		</div>
		<?php echo $this->Form->end(); ?>
</div>