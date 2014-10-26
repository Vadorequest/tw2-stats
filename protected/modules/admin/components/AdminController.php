<?php

Class AdminController extends Controller
{
    public $layout='/layouts/main';
    //public $header='';
    //public $menu=array();
    //public $breadcrumbs=array();
 
    
    public function filters()
    {
        return array(
            'accessControl',
        );
    }
    
    
    public function init()
    {
        if ( !Yii::app()->user->isGuest ) {
            $username = User::model()->findByPk(Yii::app()->user->id)->name;
            $chat = WebchatUsers::model()->find('`name`=\''.$username.'\'');
            if ( $chat ) {
                $chat->last_activity = date('Y-m-d H:i:s');
                $chat->update(array('last_activity'));
            }
            
            //
            
            $c = ChatUser::model()->find('`user_id`='.Yii::app()->user->id);
            if ( $c ) {
                $c->last_activity = time();
                $c->update(array('last_activity'));
            } else {
                $c = new ChatUser;
                $c->user_id = Yii::app()->user->id;
                $c->last_activity = time();
                $c->save();
            }
        }
    }

    
    public function accessRules()
    {
        return array(
            array('allow',
                'actions'=>array('captcha'),
                'users'=>array('*'),
            ),
            array('allow',
                'controllers'=>array('default'),
                'actions'=>array('login'),
                'users'=>array('*'),
            ),
            array('allow',
                'roles'=>array('1'),
            ),
            array('allow',
                'controllers'=>array('default', 'client', 'object', 'blackList'),
                'roles'=>array('2'),
            ),
            /*
                blackList - удаление только своих записей
             *              */
            array('allow',
                'controllers'=>array('office', 'user', 'area', 'objectType', 'tariff'),
                'actions'=>array('index', 'view'),
                'roles'=>array('2'),
            ),
            array('allow',
                'controllers'=>array('user'),
                'actions'=>array('log_auth'),
                'roles'=>array('2'),
            ),
            /*
                log_auth - просмотр только своих логов
             *              */
            array('allow',
                'controllers'=>array('review'),
                'actions'=>array('create'),
                'roles'=>array('2'),
            ),
            array('deny',
                'users'=>array('*'),
                'deniedCallback' => function() { Yii::app()->controller->redirect(array('/admin/default/login')); },
            ),
        );
    }

    
}