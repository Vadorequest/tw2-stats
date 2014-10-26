<?php

return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'TW2 stats by Vadorequest',

        'sourceLanguage' => 'en',
        'language' => 'en',
    
	'preload'=>array('log'),

        'aliases' => array(
            'bootstrap' => 'ext.bootstrap',
        ),
    
	'import'=>array(
		'application.models.*',
		'application.components.*',
            'application.helpers.*',
            
            'bootstrap.behaviors.*',
            'bootstrap.helpers.*',
            'bootstrap.widgets.*',
            
            'application.extensions.CAdvancedArBehavior',
	),

	'modules'=>array(
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'pass',
			'ipFilters'=>array('127.0.0.1','::1'),
                    
                    'generatorPaths' => array('bootstrap.gii'),
		),
            
            //'admin',
		
	),

	'components'=>array(
            
            'bootstrap' => array(
                'class' => 'bootstrap.components.BsApi'
            ),
            
            /*'image'=>array(
                'class'=>'application.extensions.image.CImageComponent',
                'driver'=>'GD',
                'params'=>array('directory'=>'/opt/local/bin'),
            ),*/
            
            /*'sms' => array
            (
                'class'    => 'application.extensions.yii-sms.Sms',
                'login'     => '',
                'password'   => '',
            ),*/
            
		'user'=>array(
			'allowAutoLogin'=>true,
                    // uncomment with components/PhpAuthManager.php, WebUser.php, auth.php
                   // 'class' => 'WebUser',
		),
            
            // uncomment for auth
            /*'authManager' => array(
                'class' => 'PhpAuthManager',
            ),*/
		
		'urlManager'=>array(
			'urlFormat'=>'path',
                    'showScriptName'=>false,
			'rules'=>array(
				//'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
                            //'site/profile/<login:\w+>'=>'site/profile',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		
		'db'=>array(
			'connectionString' => 'mysql:host=localhost:3306;dbname=tw2',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => 'yZ5Zw4MBALI1',
                    /*'connectionString' => 'mysql:host=localhost;dbname=firstalexxx',
                    'username' => 'firstalexxx',
                    'password' => 'jJDAUnnfAwjqH4yG',*/
                    /*'connectionString' => 'mysql:host=mysql.grendelhosting.com;dbname=u250108701_tw2',
                    'username' => 'u250108701_tw2',
                    'password' => '136660',*/
			'charset' => 'utf8',
		),
		
		'errorHandler'=>array(
			'errorAction'=>'site/error',
		),
            
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
			),
		),
	),

	'params'=>array(
		
	),
);