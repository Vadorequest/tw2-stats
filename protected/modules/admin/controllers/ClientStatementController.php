<?php

class ClientStatementController extends AdminController
{
        public $header = 'Управление клиентами';
        public function getMenu() 
        {
            return array(
                array(
                    'label' => 'Все клиенты',
                    'url' => array('/admin/client/index'),
                    'icon' => BsHtml::GLYPHICON_LIST,
                ),
                array(
                    'label' => 'Потенциальные клиенты',
                    'url' => array('/admin/client/index', 'potencial'=>'1'),
                    'icon' => BsHtml::GLYPHICON_LIST,
                ),
                array(
                    'label' => 'Архив клиентов',
                    'url' => array('/admin/client/index', 'archive'=>'1'),
                    'icon' => BsHtml::GLYPHICON_LIST,
                ),
                array(
                    'label' => 'Заявления от клиентов',
                    'url' => array('/admin/clientStatement/index'),
                    'icon' => BsHtml::GLYPHICON_EXCLAMATION_SIGN,
                ),
                array(
                    'label' => 'Добавить клиента',
                    'url' => array('/admin/client/create'),
                    'icon' => BsHtml::GLYPHICON_PLUS_SIGN,
                ),
                array(
                    'label' => 'Обзор клиента',
                    'url' => array('/admin/client/view', 'id'=>$_GET['id']),
                    'icon' => BsHtml::GLYPHICON_EYE_OPEN,
                    'visible' => in_array($this->action->id, array('view', 'update')),
                ),
                array(
                    'label' => 'Редактирование клиента',
                    'url' => array('/admin/client/update', 'id'=>$_GET['id']),
                    'icon' => BsHtml::GLYPHICON_PENCIL,
                    'visible' => $this->action->id=='update',
                ),
            );
        }



        public function loadModel($id)
	{
            $model=ClientStatement::model()->findByPk($id);
            if ( $model===null )
                throw new CHttpException(404,'The requested page does not exist.');
            return $model;
	}
        
        
        //
        protected function performAjaxValidation($model)
	{
            if ( isset($_POST['ajax']) && $_POST['ajax']==='clientStatement-form' ) {
                echo CActiveForm::validate($model);
                Yii::app()->end();
            }
	}
        
        
        public function actionIndex()
	{
            $model=new ClientStatement('search');
            $model->unsetAttributes();
            if( isset($_GET['ClientStatement']) ) {
                $model->attributes=$_GET['ClientStatement'];
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
            $model=new ClientStatement;

            // $this->performAjaxValidation($model);

            if ( isset($_POST['ClientStatement']) ) {
                $model->attributes=$_POST['ClientStatement'];
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

            if ( isset($_POST['ClientStatement']) ) {
                $model->attributes=$_POST['ClientStatement'];
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