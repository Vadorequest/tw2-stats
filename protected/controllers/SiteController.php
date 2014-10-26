<?php

class SiteController extends Controller
{

    public function actionIndex()
    {
        $world = $this->world;
        
        $x                  = (isset($_GET['x'])) ? (int)$_GET['x'] : 500;
        if ( $x<0 || $x>1000 ) {
            $x = 500;
        }
        $y                  = (isset($_GET['y'])) ? (int)$_GET['y'] : 500;
        if ( $y<0 || $y>1000 ) {
            $y = 500;
        }
        $z                  = (isset($_GET['z'])) ? (int)$_GET['z'] : 2;
        if ( $z<1 || $z>100 ) {
            $z = 2;
        }
        $radius             = round(500/$z);
        $show_barbarians    = (isset($_GET['show_barbarians'])) ? $_GET['show_barbarians'] : 0;
        $players            = (isset($_GET['players'])) ? $_GET['players'] : '';
        $tribes             = (isset($_GET['tribes'])) ? $_GET['tribes'] : '';
        $increase_size      = (isset($_GET['increase_size'])) ? $_GET['increase_size'] : 0;
        $min                = (isset($_GET['min'])) ? (int)$_GET['min'] : 0;
        
        $data = array(
            'x'                 => $x,
            'y'                 => $y,
            'z'                 => $z,
            'radius'            => $radius,
            'show_barbarians'   => $show_barbarians,
            'players'           => $players,
            'tribes'            => $tribes,
            'increase_size'     => $increase_size,
            'min'               => $min,
        );
        
        $vils = Yii::app()->db->createCommand()
            ->select('*')
            ->from('village_'.$world)
            ->where('(x>=:x1 AND x<=:x2) AND (y>=:y1 AND y<=:y2) AND (points>=:min)'.( ($show_barbarians) ? '' : ' AND character_id is NOT NULL' ), array(
                'x1'=>$x-$radius,
                'x2'=>$x+$radius,
                'y1'=>$y-$radius,
                'y2'=>$y+$radius,
                'min'=>$min,
            ))
            ->queryAll();
        
        $this->render('index', array(
            'data'=>$data,
            'vils'=>$vils,
        ));
    }
    
    
    public function actionApp()
    {
        require_once 'app.php';
    }


    public function actionError()
    {
        if( $error=Yii::app()->errorHandler->error ) {
            if ( Yii::app()->request->isAjaxRequest ) {
                echo $error['message'];
            } else {
                $this->render('error', $error);
            }
        }
    }
    
    
    public function actionImport_villages()
    {
        $data = $_POST['data'];
        $world = $_POST['world'];
        if ( !in_array($world, $this->worlds) ) {
            Yii::app()->end();
        }
        foreach ( $data as $village ) {
            $model = new Village('village_'.$world);
            $model = $model->findByPk($village['id']);
            if ( !$model ) {
                $model = new Village('village_'.$world);
            }
            $model->id = $village['id'];
            $model->beginner_protection = $village['beginner_protection'];
            $model->character_id = $village['character_id'];
            $model->character_name = $village['character_name'];
            $model->character_points = $village['character_points'];
            $model->name = $village['name'];
            $model->points = $village['points'];
            $model->province_name = $village['province_name'];
            $model->tribe_id = $village['tribe_id'];
            $model->tribe_name = $village['tribe_name'];
            $model->tribe_points = $village['tribe_points'];
            $model->tribe_tag = $village['tribe_tag'];
            $model->x = $village['x'];
            $model->y = $village['y'];
            if ( $model->save() ) {
                $history = new HistoryVillage('history_village_'.$world);
                $history->date = time();
                $history->village_id = $village['id'];
                $history->character_id = $village['character_id'];
                $history->character_name = $village['character_name'];
                $history->points = $village['points'];
                $history->tribe_id = $village['tribe_id'];
                $history->tribe_name = $village['tribe_name'];
                $history->tribe_tag = $village['tribe_tag'];
                $history->save();
            }
        }
        //Yii::app()->db->createCommand()->delete('history_village_'.$world, 'date<'.(time()-3600*24*15));
        Config::model()->updateByPk(1, array('last_update_'.$world=>time()));
    }
    
    
    public function actionTest()
    {
        $worlds = $this->worlds;
        $time = time()-3600*24*15;
        foreach ( $worlds as $w ) {
            Yii::app()->db->createCommand()->delete('history_character_'.$w, 'date<'.$time);
            Yii::app()->db->createCommand()->delete('history_tribe_'.$w, 'date<'.$time);
            Yii::app()->db->createCommand()->delete('history_village_'.$w, 'date<'.$time);
        }
        //echo ini_get('max_input_vars');
    }
    
    
    public function actionTime()
    {
        echo time();
    }
    
    
    public function actionImport_tribes()
    {
        $data = $_POST['data'];
        $world = $_POST['world'];
        if ( !in_array($world, $this->worlds) ) {
            Yii::app()->end();
        }
        foreach ( $data as $tribe ) {
            //echo $tribe['rank'].'<br />';
            $model = new Tribe('tribe_'.$world);
            $model = $model->findByPk($tribe['tribe_id']);
            if ( !$model ) {
                $model = new Tribe('tribe_'.$world);
            }
            $model->id = $tribe['tribe_id'];
            $model->rank = $tribe['rank'];
            $model->points = $tribe['points'];
            $model->villages = $tribe['villages'];
            $model->bash_points_def = $tribe['bash_points_def'];
            $model->bash_points_off = $tribe['bash_points_off'];
            $model->bash_points_total = $tribe['bash_points_total'];
            $model->members = $tribe['members'];
            $model->name = $tribe['name'];
            $model->tag = $tribe['tag'];
            if ( $model->save() ) {
                $history = new HistoryTribe('history_tribe_'.$world);
                $history->date = time();
                $history->tribe_id = $tribe['tribe_id'];
                $history->rank = $tribe['rank'];
                $history->points = $tribe['points'];
                $history->villages = $tribe['villages'];
                $history->bash_points_def = $tribe['bash_points_def'];
                $history->bash_points_off = $tribe['bash_points_off'];
                $history->bash_points_total = $tribe['bash_points_total'];
                $history->members = $tribe['members'];
                $history->save();
            }
        }
        //Yii::app()->db->createCommand()->delete('history_tribe_'.$world, 'date<'.(time()-3600*24*15));
    }
    
    
    public function actionImport_characters()
    {
        $data = $_POST['data'];
        $world = $_POST['world'];
        if ( !in_array($world, $this->worlds) ) {
            Yii::app()->end();
        }
        foreach ( $data as $character ) {
            $model = new Character('character_'.$world);
            $model = $model->findByPk($character['character_id']);
            if ( !$model ) {
                $model = new Character('character_'.$world);
            }
            $model->id = $character['character_id'];
            $model->achievement_points = $character['achievement_points'];
            $model->bash_points_def = $character['bash_points_def'];
            $model->bash_points_off = $character['bash_points_off'];
            $model->bash_points_total = $character['bash_points_total'];
            $model->name = $character['name'];
            $model->villages = $character['villages'];
            $model->points = $character['points'];
            $model->points_per_villages = $character['points_per_villages'];
            $model->rank = $character['rank'];
            $model->tribe_id = $character['tribe_id'];
            if ( $model->save() ) {
                $history = new HistoryCharacter('history_character_'.$world);
                $history->date = time();
                $history->character_id = $character['character_id'];
                $history->bash_points_def = $character['bash_points_def'];
                $history->bash_points_off = $character['bash_points_off'];
                $history->bash_points_total = $character['bash_points_total'];
                $history->villages = $character['villages'];
                $history->points = $character['points'];
                $history->rank = $character['rank'];
                $history->tribe_id = $character['tribe_id'];
                $history->save();
            }
        }
        //Yii::app()->db->createCommand()->delete('history_character_'.$world, 'date<'.(time()-3600*24*15));
    }
    
    
    public function action_players()
    {
        if ( isset($_POST['q']) ) {
            $criteria = new CDbCriteria();
            $criteria->addCondition('`name` LIKE \''.$_POST['q'].'%\'');
            $criteria->limit = 10;
            $criteria->order = '`name` ASC';
            $model = new Character('character_'.$this->world);
            $model = $model->findAll($criteria);
            $result = array();
            foreach ( $model as $p ) {
                $result[$p->id] = $p->name;
            }
            echo json_encode($result);
        }
    }
    
    
    public function action_tribes()
    {
        if ( isset($_POST['q']) ) {
            $criteria = new CDbCriteria();
            $criteria->addCondition('`tag` LIKE \''.$_POST['q'].'%\'');
            $criteria->limit = 10;
            $criteria->order = '`tag` ASC';
            $model = new Tribe('tribe_'.$this->world);
            $model = $model->findAll($criteria);
            $result = array();
            foreach ( $model as $p ) {
                $result[$p->id] = $p->tag;
            }
            echo json_encode($result);
        }
    }
    
    
    public function action_ajax_info_tribe()
    {
        $model = new Tribe('tribe_'.$this->world);
        $model = $model->find('`tag`=\''.$_POST['tag'].'\'');
        if ( $model ) {
            $result = array(
                'id'=>$model->id,
                'rank'=>$model->rank,
                'points'=>$model->points,
                'villages'=>$model->villages,
                'bash_points_def'=>$model->bash_points_def,
                'bash_points_off'=>$model->bash_points_off,
                'bash_points_total'=>$model->bash_points_total,
                'members'=>$model->members,
                'name'=>$model->name,
                'tag'=>$model->tag,
            );
            echo json_encode($result);
        } else {
            echo '0';
        }
    }
    
    
    public function action_ajax_info_player()
    {
        $model = new Character('character_'.$this->world);
        $model = $model->find('`name`=\''.$_POST['name'].'\'');
        if ( $model ) {
            //$tribe = new Tribe('tribe_'.$this->world);
            //$tribe = $tribe->findByPk($model->tribe_id);
            $result = array(
                'id'=>$model->id,
                'name'=>$model->name,
                'achievement_points'=>$model->achievement_points,
                'bash_points_def'=>$model->bash_points_def,
                'bash_points_off'=>$model->bash_points_off,
                'bash_points_total'=>$model->bash_points_total,
                'villages'=>$model->villages,
                'points'=>$model->points,
                'points_per_villages'=>$model->points_per_villages,
                'rank'=>$model->rank,
                'tribe_tag'=>$model->tribe->tag,
                'tribe_name'=>$model->tribe->name,
            );
            echo json_encode($result);
        } else {
            echo '0';
        }
    }
    
    
    public function action_ajax_info_village()
    {
        $coords = $_POST['coords'];
        preg_match_all('/[\d]{1,3}/', $coords, $matches);
        $model = new Village('village_'.$this->world);
        $model = $model->find('`x`='.($matches[0][0]).' AND `y`='.($matches[0][1]));
        if ( $model ) {
            $result = array(
                'id'=>$model->id,
                'name'=>$model->name,
                'character_id'=>$model->character_id,
                'character_name'=>$model->character_name,
                'character_points'=>$model->character_points,
                'points'=>$model->points,
                'tribe_id'=>$model->tribe_id,
                'tribe_name'=>$model->tribe_name,
                'tribe_points'=>$model->tribe_points,
                'tribe_tag'=>$model->tribe_tag,
                'x'=>$model->x,
                'y'=>$model->y,
            );
            echo json_encode($result);
        } else {
            echo '0';
        }
    }
    
    
    public function actionHistory_player($id)
    {
        $criteria = new CDbCriteria();
        $criteria->compare('character_id', $id);
        $criteria->order = '`id` ASC';
        
        $model = new HistoryCharacter('history_character_'.$this->world);
        $model = $model->findAll($criteria);
        $criteria->order = '`id` DESC';
        $dataProvider = new CActiveDataProvider('HistoryCharacter', array(
            'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>100,
            ),
        ));
        $player = new Character('character_'.$this->world);
        $player = $player->findByPk($id);
        
        $this->render('history_player', array(
            'model'=>$model,
            'player'=>$player,
            'dataProvider'=>$dataProvider,
        ));
        //echo 'History deactivated';
    }
    
    
    public function actionHistory_tribe($id)
    {
        $criteria = new CDbCriteria();
        $criteria->compare('tribe_id', $id);
        $criteria->order = '`id` ASC';
        
        $model = new HistoryTribe('history_tribe_'.$this->world);
        $model = $model->findAll($criteria);
        $criteria->order = '`id` DESC';
        $dataProvider = new CActiveDataProvider('HistoryTribe', array(
            'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>100,
            ),
        ));
        $tribe = new Tribe('tribe_'.$this->world);
        $tribe = $tribe->findByPk($id);
        
        $this->render('history_tribe', array(
            'model'=>$model,
            'tribe'=>$tribe,
            'dataProvider'=>$dataProvider,
        ));
        //echo 'History deactivated';
    }
    
    
    public function actionStatistic()
    {
        $this->render('statistic');
    }
    
    
    public function actionXxx()
    {
        $this->render('xxx');
    }
    
    
    public function action_ajax_forUpdate()
    {
        $worlds = $this->worlds;
        $times = array();
        foreach ( $worlds as $world ) {
            $time = Yii::app()->db->createCommand()
                ->select('last_update_'.$world)
                ->from('config')
                ->queryAll();
            if ( $world=='ru1' ) {
                $times[$world] = $time[0]['last_update_'.$world];
            }  
        }
        asort($times);
        echo key($times);
        /*echo '<pre>';
        print_r($times);
        echo '</pre>';*/
    }
    
    
    public function action_info_update()
    {
        $worlds = $this->worlds;
        $times = array();
        foreach ( $worlds as $world ) {
            $time = Yii::app()->db->createCommand()
                ->select('last_update_'.$world)
                ->from('config')
                ->queryAll();
            $times[$world] = $time[0]['last_update_'.$world];
        }
        asort($times);
        echo key($times).' - '.(floor((time()-$times[key($times)])/60)).' mins ago';
    }
    
}