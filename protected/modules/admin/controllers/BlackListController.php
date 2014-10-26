<?php

class BlackListController extends AdminController
{
        public $header = 'Управление черным списком';
        public function getMenu() 
        {
            return array(
                array(
                    'label' => 'Черный список',
                    'url' => array('/admin/blackList/index'),
                    'icon' => BsHtml::GLYPHICON_LIST,
                ),
            );
        }



        public function loadModel($id)
	{
            $model=BlackList::model()->findByPk($id);
            if ( $model===null )
                throw new CHttpException(404,'The requested page does not exist.');
            return $model;
	}
        
        
        //
        protected function performAjaxValidation($model)
	{
            if ( isset($_POST['ajax']) && $_POST['ajax']==='blackList-form' ) {
                echo CActiveForm::validate($model);
                Yii::app()->end();
            }
	}
        
        
        public function actionIndex()
	{
            $model=new BlackList('search');
            $model->unsetAttributes();
            if( isset($_GET['BlackList']) ) {
                $model->attributes=$_GET['BlackList'];
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
        
        


	/*public function actionCreate()
	{
            $model=new BlackList;

            // $this->performAjaxValidation($model);

            if ( isset($_POST['BlackList']) ) {
                $model->attributes=$_POST['BlackList'];
                if( $model->save() ) {
                    $this->redirect(array('view','id'=>$model->id));
                }
            }

            $this->render('create', array(
                'model'=>$model,
            ));
	}*/


	/*public function actionUpdate($id)
	{
            $model=$this->loadModel($id);

            // $this->performAjaxValidation($model);

            if ( isset($_POST['BlackList']) ) {
                $model->attributes=$_POST['BlackList'];
                if( $model->save() ) {
                    $this->redirect(array('view','id'=>$model->id));
                }
            }

            $this->render('update',array(
                'model'=>$model,
            ));
	}*/


	public function actionDelete($id)
	{
            //if ( Yii::app()->request->isPostRequest ) {
                
                if ( !Yii::app()->user->checkAccess('1') ) {
                    $model = $this->loadModel($id);
                    if ( $model->user_id==Yii::app()->user->id ) {
                        $model->delete();
                    } else {
                        return false;
                    }
                } else {
                    $this->loadModel($id)->delete();
                }
                
                if ( !isset($_GET['ajax']) )
                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
            //} else
            //    throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}


	public function actionAdd()
        {
            $model = new BlackList;
            $model->user_id = Yii::app()->user->id;
            $model->date = time();
            $model->phone = $_POST['phone'];
            if ( $model->save() ) {
                echo '1';
            } else {
                echo '0';
            }
        }
        
        
        
        public function actionSearch()
        {
            $model = BlackList::model()->find('`phone`=\''.$_POST['phone'].'\'');
            if ( $model ) {
                echo '1';
            } else {
                echo '0';
            }
        }

        
        
}