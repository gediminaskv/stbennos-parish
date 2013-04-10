<?php
/* @var $this FieldValueController */
/* @var $model FieldValues */

$this->breadcrumbs=array(
	'Field Values'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List FieldValues', 'url'=>array('index')),
	array('label'=>'Create FieldValues', 'url'=>array('create')),
	array('label'=>'Update FieldValues', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete FieldValues', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage FieldValues', 'url'=>array('admin')),
);
?>

<h1>View FieldValues #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'field_id',
		'id',
		'name',
		'code',
		'pos',
	),
)); ?>
