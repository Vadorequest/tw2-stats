<?php

class ObjectTypeController extends AdminController
{
        public $header = 'Управление типами недвижимости';
        public function getMenu() 
        {
            return array(
                array(
                    'label' => 'Типы недвижимости',
                    'url' => array('/admin/objectType/index'),
                    'icon' => BsHtml::GLYPHICON_LIST,
                ),
                array(
                    'label' => 'Добавить тип',
                    'url' => array('/admin/objectType/create'),
                    'icon' => BsHtml::GLYPHICON_PLUS_SIGN,
                    'visible' => Yii::app()->user->checkAccess('1'),
                ),
                array(
                    'label' => 'Обзор типа',
                    'url' => array('/admin/objectType/view', 'id'=>$_GET['id']),
                    'icon' => BsHtml::GLYPHICON_EYE_OPEN,
                    'visible' => in_array($this->action->id, array('view', 'update')),
                ),
                array(
                    'label' => 'Редактирование типа',
                    'url' => array('/admin/objectType/update', 'id'=>$_GET['id']),
                    'icon' => BsHtml::GLYPHICON_PENCIL,
                    'visible' => $this->action->id=='update',
                ),
            );
        }



        public function loadModel($id)
	{
            $model=ObjectType::model()->findByPk($id);
            if ( $model===null )
                throw new CHttpException(404,'The requested page does not exist.');
            return $model;
	}
        
        
        //
        protected function performAjaxValidation($model)
	{
            if ( isset($_POST['ajax']) && $_POST['ajax']==='objectType-form' ) {
                echo CActiveForm::validate($model);
                Yii::app()->end();
            }
	}
        
        
        public function actionIndex()
	{
            $model=new ObjectType('search');
            $model->unsetAttributes();
            if( isset($_GET['ObjectType']) ) {
                $model->attributes=$_GET['ObjectType'];
            }
            
            $this->render('index', array(
                'model'=>$model,
            ));
	}
    
        
	public function actionView($id)
	{
            $this->render('view', array(
                'model'=>$this->loadModel($id),
            ));
	}
        
        


	public function actionCreate()
	{
            $model=new ObjectType;

            // $this->performAjaxValidation($model);

            if ( isset($_POST['ObjectType']) ) {
                $model->attributes=$_POST['ObjectType'];
                if( $model->save() ) {
                    $this->redirect(array('view','id'=>$model->id));
                }
            }

            $this->render('create', array(
                'model'=>$model,
            ));
	}


	public function actionUpdate($id)
	{
            $model=$this->loadModel($id);

            // $this->performAjaxValidation($model);

            if ( isset($_POST['ObjectType']) ) {
                $model->attributes=$_POST['ObjectType'];
                if( $model->save() ) {
                    $this->redirect(array('view','id'=>$model->id));
                }
            }

            $this->render('update',array(
                'model'=>$model,
            ));
	}


	public function actionDelete($id)
	{
            //if ( Yii::app()->request->isPostRequest ) {
                $this->loadModel($id)->delete();
                if ( !isset($_GET['ajax']) )
                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
            //} else
            //    throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}


	

        
        
}