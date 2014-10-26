<?php

class UserController extends AdminController
{
        public $header = 'Управление сотрудниками';
        public function getMenu() 
        {
            return array(
                array(
                    'label' => 'Список сотрудников',
                    'url' => array('/admin/user/index'),
                    'icon' => BsHtml::GLYPHICON_LIST,
                ),
                array(
                    'label' => 'Добавить сотрудника',
                    'url' => array('/admin/user/create'),
                    'icon' => BsHtml::GLYPHICON_PLUS_SIGN,
                    'visible' => Yii::app()->user->checkAccess('1'),
                ),
                array(
                    'label' => 'Обзор сотрудника',
                    'url' => array('/admin/user/view', 'id'=>$_GET['id']),
                    'icon' => BsHtml::GLYPHICON_EYE_OPEN,
                    'visible' => in_array($this->action->id, array('view', 'update', 'log_auth')),
                ),
                array(
                    'label' => 'Редактирование сотрудника',
                    'url' => array('/admin/user/update', 'id'=>$_GET['id']),
                    'icon' => BsHtml::GLYPHICON_PENCIL,
                    'visible' => $this->action->id=='update',
                ),
                array(
                    'label' => 'Логи авторизаций',
                    'url' => array('/admin/user/log_auth', 'id'=>$_GET['id']),
                    'icon' => BsHtml::GLYPHICON_PENCIL,
                    'visible' => $this->action->id=='log_auth',
                ),
            );
        }



        public function loadModel($id)
	{
            $model=User::model()->findByPk($id);
            if ( $model===null )
                throw new CHttpException(404,'The requested page does not exist.');
            return $model;
	}
        
        
        //
        protected function performAjaxValidation($model)
	{
            if ( isset($_POST['ajax']) && $_POST['ajax']==='user-form' ) {
                echo CActiveForm::validate($model);
                Yii::app()->end();
            }
	}
        
        
        public function actionIndex()
	{
            $model=new User('search');
            $model->unsetAttributes();
            if( isset($_GET['User']) ) {
                $model->attributes=$_GET['User'];
                if ( $model->type==1 ) {
                    $model->role = 0;
                }
                if ( $model->type==2 ) {
                    $model->type = 1;
                    $model->role = 1;
                }
                if ( $model->type==3 ) {
                    $model->type = 2;
                    $model->role = 0;
                }
                if ( $model->type==4 ) {
                    $model->type = 2;
                    $model->role = 1;
                }
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
            $model=new User('create');
            $model->type = 3;
            //$model->check_ip = 0;

            // $this->performAjaxValidation($model);

            if ( isset($_POST['User']) ) {
                $model->attributes=$_POST['User'];
                
                /* правильное назначение роли */
                if ( $model->type==='1' ) {
                    $model->role = 0;
                }
                if ( $model->type==='2' ) {
                    $model->type = 1;
                    $model->role = 1;
                }
                if ( $model->type==='3' ) {
                    $model->type = 2;
                    $model->role = 0;
                }
                if ( $model->type==='4' ) {
                    $model->type = 2;
                    $model->role = 1;
                }
                $model->date_create = time();
                
                $model->_img = CUploadedFile::getInstance($model,'_img');
                $model->password = CPasswordHelper::hashPassword($model->password);
                
                $model->pasport_date = strtotime($model->pasport_date);
                $model->birthday_date = strtotime($model->birthday_date);
                
                if ( $model->validate() && $model->_img->name!='' ) {
                    $imageExtention = pathinfo($model->_img->getName(), PATHINFO_EXTENSION);
                    $imageName      = substr(md5($model->_img->name.microtime()), 0, 28).'.'.$imageExtention;
                    $image = Yii::app()->image->load($model->_img->tempName);
                    //$image->resize(1024, 1024);
                    $image->save('./uploads/user/'.$imageName);
                    $model->pasport_photocopy = $imageName;
                }
                
                if ( $model->save() ) {
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
            $password = $model->password;
            $model->password = '';
            
            $model->pasport_date = date('d.m.Y', $model->pasport_date);
            $model->birthday_date = date('d.m.Y', $model->birthday_date);
            
            if ( $model->type==='1' && $model->role==='0' ) {
                $model->type = 1;
            }
            if ( $model->type==='1' && $model->role==='1' ) {
                $model->type = 2;
            }
            if ( $model->type==='2' && $model->role==='0' ) {
                $model->type = 3;
            }
            if ( $model->type==='2' && $model->role==='1' ) {
                $model->type = 4;
            }
            // $this->performAjaxValidation($model);

            if ( isset($_POST['User']) ) {
                $model->attributes=$_POST['User'];
                
                /* правильное назначение роли */
                if ( $model->type==1 ) {
                    $model->role = 0;
                }
                if ( $model->type==2 ) {
                    $model->type = 1;
                    $model->role = 1;
                }
                if ( $model->type==3 ) {
                    $model->type = 2;
                    $model->role = 0;
                }
                if ( $model->type==4 ) {
                    $model->type = 2;
                    $model->role = 1;
                }
                
                $model->_img = CUploadedFile::getInstance($model,'_img');
                if ( strlen($model->password)!=0 ) {
                    $model->password = CPasswordHelper::hashPassword($model->password);
                } else {
                    $model->password = $password;
                }
                
                $model->pasport_date = strtotime($model->pasport_date);
                $model->birthday_date = strtotime($model->birthday_date);
                
                if ( $model->validate() && $model->_img->name!='' ) {
                    $imageExtention = pathinfo($model->_img->getName(), PATHINFO_EXTENSION);
                    $imageName      = substr(md5($model->_img->name.microtime()), 0, 28).'.'.$imageExtention;
                    $image = Yii::app()->image->load($model->_img->tempName);
                    //$image->resize(1024, 1024);
                    $image->save('./uploads/user/'.$imageName);
                    $model->pasport_photocopy = $imageName;
                }
                
                if ( $model->save() ) {
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


        public function actionLog_auth($id)
        {
            $model=$this->loadModel($id);
            
            if ( !Yii::app()->user->checkAccess('1') && Yii::app()->user->id!=$id ) {
                $this->redirect(array('/admin/user/view', 'id'=>Yii::app()->user->id));
            }
            
            $this->render('log_auth', array(
                'model'=>$model,
            ));
        }
            
        
}