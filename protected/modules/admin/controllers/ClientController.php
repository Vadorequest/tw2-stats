<?php

class ClientController extends AdminController
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
                    'url' => array('/admin/client/index', 'status'=>'0'),
                    'icon' => BsHtml::GLYPHICON_LIST,
                ),
                array(
                    'label' => 'Актуальные клиенты',
                    'url' => array('/admin/client/index', 'status'=>'1'),
                    'icon' => BsHtml::GLYPHICON_LIST,
                ),
                array(
                    'label' => 'Архив клиентов',
                    'url' => array('/admin/client/index', 'status'=>'2'),
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
            $model=Client::model()->findByPk($id);
            if ( $model===null )
                throw new CHttpException(404,'The requested page does not exist.');
            return $model;
	}
        
        
        //
        protected function performAjaxValidation($model)
	{
            if ( isset($_POST['ajax']) && $_POST['ajax']==='client-form' ) {
                echo CActiveForm::validate($model);
                Yii::app()->end();
            }
	}
        
        
        public function actionIndex()
	{
            $model=new Client('search');
            $model->unsetAttributes();
            if ( isset($_GET['status']) ) {
                $model->status = $_GET['status'];
            }
            if( isset($_GET['Client']) ) {
                $model->attributes=$_GET['Client'];
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
            $model=new Client;
            $model->user_id = Yii::app()->user->id;
            $model->date_meet = date('d.m.Y');
            $model->date_call = date('d.m.Y');
            $model->creator_id = Yii::app()->user->id;
            
            if ( $_GET['status']==='0' ) {
                $model->status = 0;
            } else {
                $model->status = 1;
            }

            // $this->performAjaxValidation($model);

            if ( isset($_POST['Client']) ) {
                $model->attributes=$_POST['Client'];
                $model->area = $model->areas;
                $model->objectType = $model->objectTypes;
                
                $model->date_create = time();
                if ( strlen($model->result)!=0 ) {
                    $model->date_result = time();
                    if ( $model->result==1 ) {
                        $model->date_meet = strtotime($model->date_meet);
                    } else {
                        $model->date_meet = null;
                    }
                    if ( $model->result==2 ) {
                        $model->date_call = strtotime($model->date_call);
                    } else {
                        $model->date_call = null;
                    }
                } else {
                    $model->date_meet = null;
                    $model->date_call = null;
                }
                $model->origin = 0;
                if ( $model->status!=0 ) {
                    $model->date_admin = time();
                }
                
                if ( isset($_POST['_login']) && isset($_POST['_password']) && strlen($_POST['_login'])!=0 && strlen($_POST['_password'])!=0 ) {
                    $newUser = new User('create');
                    $newUser->date_create = time();
                    $newUser->login = $_POST['_login'];
                    $newUser->password = CPasswordHelper::hashPassword($_POST['_password']);
                    $newUser->type = 0;
                    $newUser->check_ip = 0;
                    if ( $newUser->save() ) {
                        $model->_user_id = $newUser->id;
                        Yii::app()->user->setFlash('success', 'Клиенту предоставлен доступ к базе.');
                        // sms
                        if ( $_SERVER['REMOTE_ADDR']!='127.0.0.1' ) {
                            Yii::app()->sms->send($model->phone, 'Вам предоставлен доступ: http://www.amberomsk.ru/. Логин: '.$newUser->login.'. Пароль: '.$_POST['_password'].'.');
                        }
                    } else {
                        Yii::app()->user->setFlash('error', 'Ошибка предоставления доступа. Возможно, логин/пароль введены некорректно.');
                    }
                }
                
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
            
            if ( $model->date_meet>0 ) {
                $model->date_meet = date('d.m.Y', $model->date_meet);
            } else {
                $model->date_meet = date('d.m.Y');
            }
            if ( $model->date_call>0 ) {
                $model->date_call = date('d.m.Y', $model->date_call);
            } else {
                $model->date_call = date('d.m.Y');
            }
            
            // $this->performAjaxValidation($model);

            if ( isset($_POST['Client']) ) {
                $model->attributes=$_POST['Client'];
                $model->area = $model->areas;
                $model->objectType = $model->objectTypes;
                $model->user_id = Yii::app()->user->id;
                
                $model->date_update = time();
                if ( strlen($model->result)!=0 ) {
                    if ( strlen($model->date_result)<=1 ) {
                        $model->date_result = time();
                    }
                    if ( $model->result==1 ) {
                        $model->date_meet = strtotime($model->date_meet);
                    }
                    if ( $model->result==2 ) {
                        $model->date_call = strtotime($model->date_call);
                    }
                }
                if ( $model->status!=0 ) {
                    if ( strlen($model->date_admin)<=1 ) {
                        $model->date_admin = time();
                    }
                }
                
                if ( $model->_user_id===null ) {
                    if ( isset($_POST['_login']) && isset($_POST['_password']) && strlen($_POST['_login'])!=0 && strlen($_POST['_password'])!=0 ) {
                        $newUser = new User('create');
                        $newUser->date_create = time();
                        $newUser->login = $_POST['_login'];
                        $newUser->password = CPasswordHelper::hashPassword($_POST['_password']);
                        $newUser->type = 0;
                        $newUser->check_ip = 0;
                        if ( $newUser->save() ) {
                            $model->_user_id = $newUser->id;
                            Yii::app()->user->setFlash('success', 'Клиенту предоставлен доступ к базе.');
                            // sms
                            if ( $_SERVER['REMOTE_ADDR']!='127.0.0.1' ) {
                                Yii::app()->sms->send($model->phone, 'Вам предоставлен доступ: http://www.amberomsk.ru/. Логин: '.$newUser->login.'. Пароль: '.$_POST['_password'].'.');
                            }
                        } else {
                            Yii::app()->user->setFlash('error', 'Ошибка предоставления доступа. Возможно, логин/пароль введены некорректно.');
                        }
                    }
                } else {
                    if ( isset($_POST['_password']) && strlen($_POST['_password'])!=0 ) {
                        User::model()->updateByPk($model->_user_id, array(
                            'password'=>CPasswordHelper::hashPassword($_POST['_password']),
                        ));
                    }
                    if ( $_POST['_cancelAccess']=='1' ) {
                        User::model()->updateByPk($model->_user_id, array(
                            'password'=>'',
                        ));
                        $model->_user_id=null;
                        Yii::app()->user->setFlash('info', 'Клиенту закрыт доступ к базе.');
                    }
                }
                
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
                //$this->loadModel($id)->delete();
            
                $model = $this->loadModel($id);
                $model->status = 2;
                $model->user_id = Yii::app()->user->id;
                $model->date_update = time();
                $model->update(array('status', 'user_id', 'date_update'));
            
                if ( !isset($_GET['ajax']) )
                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
            //} else
            //    throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}


	

        
        
}