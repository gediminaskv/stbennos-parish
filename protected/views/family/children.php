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
	array('label'=>'View Families', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Families', 'url'=>array('admin')),
);
?>

<h1>Family <?php echo $model->id; ?>: More Children</h1>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'families-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
<?php
	$tabs = array(
	);
	$children = $model->children();
	for($i = 0; $i < 10; ++$i) {
		$n = 2 + $i;
		$j = 4 + $i;
		$child = isset($children[$j-1]) ? $children[$j-1] : new People();
		$tabs["tab$n"] = array(
			'title' => "Child $j",
			'view'	=> '../person/_person_form',
			'data'	=> array(
				'form'		=> $form,
				'person'	=> "child][$i",
				'model'		=> $child
			)
		);
	}
?>
    <?php $this->widget('CTabView',array(
    'tabs'=>$tabs
	)); ?>
<?#php echo $this->renderPartial('_form', array('model'=>$model)); ?>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
