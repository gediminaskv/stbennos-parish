<?php

class FirstCommunionRecordsController extends RController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'rights', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new FirstCommunionRecord;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['FirstCommunionRecord']))
		{
			$model->attributes=$_POST['FirstCommunionRecord'];
			if($model->save()) {
				if (isset($model->member_id)) {
					if (!isset($model->member->first_comm_dt)) {
						$member = $model->member;
						$member->first_comm_dt = $model->communion_dt;
						if (!$member->save(true, array('first_comm_dt'))) {
							Yii::trace(sprintf("Error saving member %s first_comm_dt: %s",
								$member->id, implode(", ", $member->getErrors('first_comm_dt'))),
								'application.controllers.FirstCommunionRecord');
						}
					}
				}
				$model->ref_no = $model->get_refno();
				$model->save();
				$this->redirect(array('view','id'=>$model->id));
			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['FirstCommunionRecord']))
		{
			$model->attributes=$_POST['FirstCommunionRecord'];
			if (!isset($model->ref_no)) {
				$model->ref_no = $model->get_refno();
			}
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$model = $this->loadModel($id);
		
		if (isset($model->firstCommunionCerts) and count($model->firstCommunionCerts))
			throw new CHttpException(412, "Cannot delete. This record has certificates associated");

		$model->delete();


		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('FirstCommunionRecord');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new FirstCommunionRecord('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['FirstCommunionRecord']))
			$model->attributes=$_GET['FirstCommunionRecord'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function actionSearch()
	{
		if (isset($_GET['key'])) {
			$key = $_GET['key'];
			$keys = preg_split('/[\s\+]+/', $key);

			$crit = new CDbCriteria();
			foreach($keys as $key) {
				$crit->mergeWith(array('condition' => "name like '%$key%'"), 'OR');
			}
			$ppl = new CActiveDataProvider('FirstCommunionRecord', array(
				'criteria' => $crit
			));

			if ($ppl->itemCount > 0)
				$this->renderPartial('index', array(
					'dataProvider' => $ppl
				));
		}
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return FirstCommunionRecord the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=FirstCommunionRecord::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param FirstCommunionRecord $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='first-communion-record-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
