<?php

class ReviewController extends AdminController
{
        public $header = 'Управление отзывами';
        public function getMenu() 
        {
            return array(
                array(
                    'label' => 'Список отзывов',
                    'url' => array('/admin/review/index'),
                    'icon' => BsHtml::GLYPHICON_LIST,
                ),
                array(
                    'label' => 'Добавить отзыв',
                    'url' => array('/admin/review/create'),
                    'icon' => BsHtml::GLYPHICON_PLUS_SIGN,
                ),
                array(
                    'label' => 'Обзор отзыва',
                    'url' => array('/admin/review/view', 'id'=>$_GET['id']),
                    'icon' => BsHtml::GLYPHICON_EYE_OPEN,
                    'visible' => in_array($this->action->id, array('view', 'update')),
                ),
                array(
                    'label' => 'Редактирование отзыва',
                    'url' => array('/admin/review/update', 'id'=>$_GET['id']),
                    'icon' => BsHtml::GLYPHICON_PENCIL,
                    'visible' => $this->action->id=='update',
                ),
            );
        }



        public function loadModel($id)
	{
            $model=Review::model()->findByPk($id);
            if ( $model===null )
                throw new CHttpException(404,'The requested page does not exist.');
            return $model;
	}
        
        
        //
        protected function performAjaxValidation($model)
	{
            if ( isset($_POST['ajax']) && $_POST['ajax']==='review-form' ) {
                echo CActiveForm::validate($model);
                Yii::app()->end();
            }
	}
        
        
        public function actionIndex()
	{
            $model=new Review('search');
            $model->unsetAttributes();
            if( isset($_GET['Review']) ) {
                $model->attributes=$_GET['Review'];
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
            $model=new Review;

            // $this->performAjaxValidation($model);

            if ( isset($_POST['Review']) ) {
                $model->attributes=$_POST['Review'];
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

            if ( isset($_POST['Review']) ) {
                $model->attributes=$_POST['Review'];
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