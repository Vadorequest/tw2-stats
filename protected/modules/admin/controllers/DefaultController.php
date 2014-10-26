<?php

Class DefaultController extends AdminController 
{
    
    public $header = 'Главная';
    public function getMenu()
    {
        return array();
    }
        
    
    public function actions()
    {
        return array(
            'captcha'=>array(
                    'class'=>'CCaptchaAction',
                    //'backColor'=>0xF5F5F5,
                'testLimit'=>'1',
            ),
        );
    }
    
    public function actionIndex()
    {
        $this->render('index');
    }
    
    
    public function actionLogin()
    {
        $model = new AdminLoginForm;
            
        if ( isset($_POST['ajax']) && $_POST['ajax']==='login-form' ) {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        if ( isset($_POST['AdminLoginForm']) ) {
            $model->attributes=$_POST['AdminLoginForm'];
            if ( $model->validate() && $model->login() ) {
                
                /*$webchatUsers = new WebchatUsers;
                $webchatUsers->name = User::model()->findByPk(Yii::app()->user->id)->name;
                $webchatUsers->gravatar = 'test@gmail.com';
                $webchatUsers->save();*/
                
                //$this->redirect(array('/admin/object/index', 'status'=>'0'));
                $this->redirect(array('/admin/default/index'));
            } else {
                Yii::app()->user->setFlash('error', 'Неверный логин или пароль.');
            }
        }

        $this->layout = '/layouts/login';
        $this->render('login');
    }
    
    
    public function actionLogout()
    {
        WebchatUsers::model()->deleteAll('`name`=\''.User::model()->findByPk(Yii::app()->user->id)->name.'\'');
        Yii::app()->user->logout();
        if (isset($_SERVER['HTTP_COOKIE'])) {
            $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
            foreach($cookies as $cookie) {
                $parts = explode('=', $cookie);
                $name = trim($parts[0]);
                setcookie($name, '', time()-1000);
                setcookie($name, '', time()-1000, '/');
            }
        }
        unset($_SESSION);
        $this->redirect(/*Yii::app()->homeUrl*/array('/admin'));
    }
    
    
    public function actionProfile()
    {
        $this->redirect(array('/admin/user/view', 'id'=>Yii::app()->user->id));
    }
    
    
    public function actionSettings()
    {
        if ( Yii::app()->user->checkAccess('1') ) {
            $this->redirect(array('/admin/user/update', 'id'=>Yii::app()->user->id));
        } else {
            
            $this->header = 'Настройки профиля';
            
            $model = User::model()->findByPk(Yii::app()->user->id);
            $password = $model->password;
            $model->password = '';
            
            $model->pasport_date = date('d.m.Y', $model->pasport_date);
            $model->birthday_date = date('d.m.Y', $model->birthday_date);
            
            if ( isset($_POST['User']) ) {
                $model->attributes=$_POST['User'];
                
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
                    $this->redirect(array('/admin/user/view','id'=>$model->id));
                }
            }
            
            $this->render('settings', array(
                'model'=>$model,
            ));
            
        }
    }
    
    
    public function actionTest()
    {
        $result = file_get_contents('http://amberomsk.chatovod.ru/');
        echo $result;
    }
    
    
    public function action_ajax_chat()
    {
        $result = array();
        $users = ChatUser::model()->findAll();
        foreach ( $users as $user ) {
            if ( $user->user_id !== Yii::app()->user->id ) {
                $result[$user->user_id] = $user->user->name;
            }
        }
        echo json_encode($result);
    }
    
    
    public function action_ajax_chat_messages()
    {
        $result = array();
        $criteria = new CDbCriteria;
        $criteria->addCondition('(`user_from`='.Yii::app()->user->id.' AND `user_to`='.$_POST['user_id'].') OR (`user_from`='.$_POST['user_id'].' AND `user_to`='.Yii::app()->user->id.')');
        $criteria->order = '`id` ASC';
        $messages = ChatMessage::model()->findAll($criteria);
        $result[] = User::model()->findByPk($_POST['user_id'])->name;
        $result[] = time();
        foreach ( $messages as $message ) {
            $result[] = array(
                'date'=>Yii::app()->dateFormatter->format('dd.MM.yy HH:mm', $message->date),
                'user_from'=>$message->user1->name,
                'text'=>$message->text,
            );
        }
        echo json_encode($result);
    }

    
    public function action_ajax_chat_send()
    {
        $newMessage = new ChatMessage;
        $newMessage->user_from = Yii::app()->user->id;
        $newMessage->user_to = $_POST['user_to'];
        $newMessage->date = time();
        $newMessage->text = htmlspecialchars($_POST['text']);
        $newMessage->save();
        echo Yii::app()->dateFormatter->format('dd.MM.yy HH:mm', time());
    }
    
    
    public function action_ajax_chat_update()
    {
        $result = array();
        $criteria = new CDbCriteria;
        $criteria->addCondition('`user_from`='.$_POST['user_from'].' AND `user_to`='.Yii::app()->user->id.' AND `date`>='.$_POST['date']);
        $criteria->order = '`id` ASC';
        $messages = ChatMessage::model()->findAll($criteria);
        $result[] = time();
        foreach ( $messages as $message ) {
            $result[] = array(
                'date'=>Yii::app()->dateFormatter->format('dd.MM.yy HH:mm', $message->date),
                'user_from'=>$message->user1->name,
                'text'=>$message->text,
            );
        }
        echo json_encode($result);
    }
    
}