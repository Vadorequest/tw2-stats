<?php

Class StatisticController extends AdminController
{
    public $header = 'Статистика';
    public function getMenu() 
    {
        return array(
            array(
                'label' => 'Полезные действия',
                'url' => array('/admin/statistic/useful'),
                'icon' => BsHtml::GLYPHICON_CERTIFICATE,
            ),
            array(
                'label' => 'Статистика финансов',
                'url' => array('/admin/statistic/money'),
                'icon' => BsHtml::GLYPHICON_USD,
            ),
            array(
                'label' => 'Статистика парсера',
                'url' => array('/admin/statistic/parser'),
                'icon' => BsHtml::GLYPHICON_STATS,
            ),
        );
    }
    
    
    public function actionParser()
    {
        $model = new ParserStatistic('search');
        $model->unsetAttributes();
        if( isset($_GET['ParserStatistic']) ) {
            $model->attributes=$_GET['ParserStatistic'];
        }
        
        $this->render('parser', array(
            'model'=>$model,
        ));
    }
    
    
    public function actionUseful()
    {
        $model = new User();
        $model->unsetAttributes();
        if ( !isset($_GET['date_from']) ) {
            $_GET['date_from'] = date('d.m.Y', time());
        }
        if ( !isset($_GET['date_to']) ) {
            $_GET['date_to'] = date('d.m.Y', time()+3600*24);
        }
        
        $this->render('useful', array(
            'model'=>$model,
        ));
    }
    
    
    public function actionMoney()
    {
        $model = new User();
        $model->unsetAttributes();
        if ( !isset($_GET['date_from']) ) {
            $_GET['date_from'] = date('d.m.Y', time());
        }
        if ( !isset($_GET['date_to']) ) {
            $_GET['date_to'] = date('d.m.Y', time()+3600*24);
        }
        
        $this->render('money', array(
            'model'=>$model,
        ));
    }
    
}