<?php /* SVN: $Id: $ */ ?>
<div class="beautyProfiles form">
<?php echo $this->Form->create('BeautyProfile', array('class' => 'normal'));?>
	<fieldset>
		<legend><?php echo $this->Html->link(__l('Beauty Profiles'), array('action' => 'index'));?> &raquo; <?php echo __l('Add Beauty Profile');?></legend>
	<?php
		echo $this->Form->input('beauty_question_id');
		echo $this->Form->input('answer1');
		echo $this->Form->input('answer2');
		echo $this->Form->input('answer3');
		echo $this->Form->input('answer4');
		echo $this->Form->input('answer5');
		echo $this->Form->input('answer6');
		echo $this->Form->input('answer7');
		echo $this->Form->input('answer8');
		echo $this->Form->input('answer9');
		echo $this->Form->input('answer10');
	?>
	</fieldset>
<?php echo $this->Form->end(__l('Add'));?>
</div>