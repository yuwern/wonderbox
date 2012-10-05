<?php /* SVN: $Id: $ */ ?>
<div class="categories form">
<?php echo $this->Form->create('Category', array('class' => 'normal'));?>
	<fieldset>
		<legend><?php echo $this->Html->link(__l('Categories'), array('action' => 'index'));?> &raquo; <?php echo __l('Admin Edit Category');?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name',array('div'=>'input text required'));
		echo $this->Form->input('is_active');
		
	?>
	</fieldset>
	<div class="submit-block">
		<?php echo $this->Form->submit(__l('Update'));?>
		</div>
	<?php echo $this->Form->end(); ?>
</div>