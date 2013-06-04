<?php
/* @var $this FamilyController */
/* @var $model Families */

$this->breadcrumbs=array(
	'Families'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Families', 'url'=>array('index')),
	array('label'=>'Create Family', 'url'=>array('create')),
	array('label'=>'View Family', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Families', 'url'=>array('admin')),
);
?>

<h1>Set Google map location for family <?php echo $model->id; ?></h1>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'families-locate-form',
	'enableAjaxValidation'=>true,
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
	<?php
		echo $form->labelEx($model, 'gmap_url');
		echo $form->textArea($model, 'gmap_url');
		echo '<br />Locate on google maps and click "Link" and copy paste the URL';
		echo $form->error($model, 'gmap_url');
	?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>


<?php $this->endWidget(); ?>

</div><!-- form -->
