<?php
/* @var $this NoImpedimentLetterController */
/* @var $model NoImpedimentLetter */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'banns_id'); ?>
		<?php echo $form->textField($model,'banns_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'letter_dt'); ?>
		<?php echo $form->textField($model,'letter_dt'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->