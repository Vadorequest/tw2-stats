<?php
    $cs = Yii::app()->clientScript;
    $pt = Yii::app()->homeUrl;

    $cs
        ->registerCssFile($pt.'css/bootstrap.min.css')
        ->registerCssFile($pt.'css/bootstrap-theme.min.css')
        ->registerCssFile(Yii::app()->clientScript->getCoreScriptUrl().'/jui/css/base/jquery-ui.css')
        ->registerCssFile($pt.'css/main.css');

    $cs
        ->registerCoreScript('jquery',CClientScript::POS_END)
        ->registerCoreScript('jquery.ui',CClientScript::POS_END)
        ->registerScriptFile($pt.'js/jquery.cookie.js',CClientScript::POS_END)
        ->registerScriptFile($pt.'js/bootstrap.min.js',CClientScript::POS_END)
        ->registerScriptFile($pt.'js/main.js');

?>

<!DOCTYPE html>
<html>
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="language" content="" />

    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <meta name="copyright" content="" />
    <meta itemprop="image" content="" />

    <title><?= $this->pageTitle ?></title>

</head>

<body>
    
    <div class="container">
        
        <script>
            $(document).ready(function(){
                var currentWorld = $.cookie('world');
                $('#changeWorld ul a[href="#'+currentWorld+'"]').parent().addClass('active');
                $('#changeWorld ul a').click(function(){
                    $.cookie('world', $(this).attr('href').substr(1), {
                        expires: 7,
                        path: '/'
                    });
                    location = '/';
                    return false;
                });
            });
        </script>
        <div id="header">
            <?php
                $this->widget('bootstrap.widgets.BsNavbar', array(
                    //'position' => BsHtml::NAVBAR_POSITION_STATIC_TOP,
                    'brandLabel' => /*BsHtml::icon(BsHtml::GLYPHICON_HOME)*/Yii::app()->name,
                    'brandUrl' => Yii::app()->homeUrl,
                    'items' => array(
                        array(
                            'class' => 'bootstrap.widgets.BsNav',
                            'encodeLabel' => false,
                            'type' => 'navbar',
                            'activateParents' => true,
                            'items' => array(
                                array(
                                    'label'=>'World map: '.$this->worldName,
                                    'url'=>array('site/index'),
                                    'icon'=>BsHtml::GLYPHICON_GLOBE,
                                    'items'=>$this->worldList,
                                    'htmlOptions'=>array(
                                        'id'=>'changeWorld',
                                    ),
                                ),
                                array(
                                    'label'=>'Statistic',
                                    'url'=>array('site/statistic'),
                                    'icon'=>BsHtml::GLYPHICON_STATS,
                                ),
                                /*array(
                                    'label'=>'Tribe history',
                                    'url'=>array('site/history_tribe'),
                                    'icon'=>BsHtml::GLYPHICON_HDD,
                                ),
                                array(
                                    'label'=>'Player history',
                                    'url'=>array('site/history_player'),
                                    'icon'=>BsHtml::GLYPHICON_HDD,
                                ),*/
                            )
                        ),
                    ),
                ));
            ?>
        </div>
        
        <?php $this->beginWidget('bootstrap.widgets.BsPanel'); ?>
        
            <div class="row">
                <div class="col-md-6">
                    
                    <div class="input-group">
                        <span class="input-group-addon w200">Search tribe</span>
                        <?= BsHtml::textField('s_tribe', '', array('class'=>'form-control _s_search', 'placeHolder'=>'by tag', 'maxlength'=>10)) ?>
                        <span class="input-group-btn">
                            <?= BsHtml::button('', array(
                                'color' => BsHtml::BUTTON_COLOR_PRIMARY,
                                'icon' => BsHtml::GLYPHICON_SEARCH,
                                'id' => 'go_search_tribe',
                            )); ?>
                        </span>
                    </div>
                    
                    <div class="input-group" style="margin-top: 5px;">
                        <span class="input-group-addon w200">Search player</span>
                        <?= BsHtml::textField('s_player', '', array('class'=>'form-control _s_search', 'placeHolder'=>'by name')) ?>
                        <span class="input-group-btn">
                            <?= BsHtml::button('', array(
                                'color' => BsHtml::BUTTON_COLOR_PRIMARY,
                                'icon' => BsHtml::GLYPHICON_SEARCH,
                                'id' => 'go_search_player',
                            )); ?>
                        </span>
                    </div>
                    
                    <div class="input-group" style="margin-top: 5px;">
                        <span class="input-group-addon w200">Search village</span>
                        <?= BsHtml::textField('s_village', '', array('class'=>'form-control _s_search', 'placeHolder'=>'by coords in format 000|000 or 000/000', 'maxlength'=>7)) ?>
                        <span class="input-group-btn">
                            <?= BsHtml::button('', array(
                                'color' => BsHtml::BUTTON_COLOR_PRIMARY,
                                'icon' => BsHtml::GLYPHICON_SEARCH,
                                'id' => 'go_search_village',
                            )); ?>
                        </span>
                    </div>
                    
                    <script>
                        $(document).ready(function(){
                            
                            $('#go_search_tribe').click(function(){
                                $.ajax({
                                    url: '<?= $pt ?>site/_ajax_info_tribe',
                                    type: 'POST',
                                    dataType: 'json',
                                    data: {
                                        tag: $('#s_tribe').val()
                                    },
                                    success: function(data) {
                                        if ( data!=0 ) {
                                            $('.loadedInfo').hide();
                                            $('#loadedInfo_tribe .mini_header2, #loadedInfo_tribe .innerInfo').html('');
                                            $('#loadedInfo_tribe .mini_header2').html('Tribe: <b>['+data.tag+'] '+data.name+'</b>');
                                            $('#loadedInfo_tribe .innerInfo').append('<dl class="dl-horizontal"> <dt>Rank</dt><dd>'+data.rank+'</dd> <dt>Total points</dt><dd>'+data.points+'</dd> <dt>Average points</dt><dd>'+Math.round(data.points/data.villages)+'</dd> <dt>Members</dt><dd>'+data.members+'</dd> <dt>Villages</dt><dd>'+data.villages+'</dd> <dt>Opponents defeated (total)</dt><dd>'+data.bash_points_total+'</dd> <dt>Opponents defeated (off)</dt><dd>'+data.bash_points_off+'</dd> <dt>Opponents defeated (def)</dt><dd>'+data.bash_points_def+'</dd></dl>');
                                            $('#go_history_tribe').attr('href', '<?= $pt ?>site/history_tribe/'+data.id);
                                            $('#go_tribeI').attr('href', '<?= $pt ?>site/tribe/'+data.id);
                                            if ( $('#map').length ) {
                                                $('#go_addTribeOnMap').click(function(){
                                                    $('#add_tribe').val(data.tag);
                                                    $('html, body').animate({scrollTop: $('#add_tribe').offset().top-100}, 300);
                                                    $('#add_tribe')[0].color.showPicker();
                                                });
                                            } else {
                                                $('#go_addTribeOnMap').attr('disabled', 'disabled');
                                            }
                                            $('#loadedInfo_tribe').show();
                                        }
                                    }
                                });
                            });
                            
                            $('#go_search_player').click(function(){
                                $.ajax({
                                    url: '<?= $pt ?>site/_ajax_info_player',
                                    type: 'POST',
                                    dataType: 'json',
                                    data: {
                                        name: $('#s_player').val()
                                    },
                                    success: function(data) {
                                        if ( data!=0 ) {
                                            $('.loadedInfo').hide();
                                            $('#loadedInfo_plasyer .mini_header2, #loadedInfo_player .innerInfo').html('');
                                            $('#loadedInfo_player .mini_header2').html('Player: <b>'+data.name+'</b>');
                                            var tribe = (data.tribe_tag!=null && data.tribe_tag.length!=0) ? '<a href="#" class="chooseTribe" tag="'+data.tribe_tag+'">['+data.tribe_tag+'] '+data.tribe_name+'</a>' : 'none';
                                            $('#loadedInfo_player .innerInfo').append('<dl class="dl-horizontal"> <dt>Rank</dt><dd>'+data.rank+'</dd> <dt>Points</dt><dd>'+data.points+'</dd> <dt>Villages</dt><dd>'+data.villages+'</dd> <dt>Points per villages</dt><dd>'+data.points_per_villages+'</dd> <dt>Defeated enemies (total)</dt><dd>'+data.bash_points_total+'</dd> <dt>Defeated enemies (off)</dt><dd>'+data.bash_points_off+'</dd> <dt>Defeated enemies (def)</dt><dd>'+data.bash_points_def+'</dd> <dt>Achievement points</dt><dd>'+data.achievement_points+'</dd> <dt>Tribe</dt><dd>'+tribe+'</dd> </dl>');
                                            $('#go_history_player').attr('href', '<?= $pt ?>site/history_player/'+data.id);
                                            $('#go_playerI').attr('href', '<?= $pt ?>site/player/'+data.id);
                                            if ( $('#map').length ) {
                                                $('#go_addPlayerOnMap').click(function(){
                                                    $('#add_player').val(data.name);
                                                    $('html, body').animate({scrollTop: $('#add_player').offset().top-100}, 300);
                                                    $('#add_player')[0].color.showPicker();
                                                });
                                            } else {
                                                $('#go_addPlayerOnMap').attr('disabled', 'disabled');
                                            }
                                            $('#loadedInfo_player').show();
                                            $('.chooseTribe').click(function(){
                                                $('#s_tribe').val($(this).attr('tag'));
                                                $('#go_search_tribe').click();
                                                
                                                return false;
                                            });
                                        }
                                    }
                                });
                            });
                            
                            $('#go_search_village').click(function(){
                                $.ajax({
                                    url: '<?= $pt ?>site/_ajax_info_village',
                                    type: 'POST',
                                    dataType: 'json',
                                    data: {
                                        coords: $('#s_village').val()
                                    },
                                    success: function(data) {
                                        if ( data!=0 ) {
                                            $('.loadedInfo').hide();
                                            $('#loadedInfo_village .mini_header2, #loadedInfo_village .innerInfo').html('');
                                            $('#loadedInfo_village .mini_header2').html('Villlage: <b>'+data.x+'|'+data.y+' - '+data.name+'</b>');
                                            var tribe = (data.tribe_tag!=null && data.tribe_tag.length!=0) ? '<a href="#" class="chooseTribe" tag="'+data.tribe_tag+'">['+data.tribe_tag+'] '+data.tribe_name+'</a>' : 'none';
                                            var player = (data.character_name!=null && data.character_name.length!=0) ? '<a href="#" class="choosePlayer">'+data.character_name+'</a> (points: '+data.character_points+')' : 'none';
                                            $('#loadedInfo_village .innerInfo').append('<dl class="dl-horizontal"> <dt>Points</dt><dd>'+data.points+'</dd> <dt>Owner name</dt><dd>'+player+'</dd> <dt>Owner tribe</dt><dd>'+tribe+'</dd> </dl>');
                                            $('#go_history_village').attr('href', '<?= $pt ?>site/history_village/'+data.id);
                                            $('#loadedInfo_village').show();
                                            $('.choosePlayer').click(function(){
                                                $('#s_player').val(data.character_name);
                                                $('#go_search_player').click();
                                                
                                                return false;
                                            });
                                            $('.chooseTribe').click(function(){
                                                $('#s_tribe').val(data.tribe_tag);
                                                $('#go_search_tribe').click();
                                                
                                                return false;
                                            });
                                        }
                                    }
                                });
                            });
                            
                        });
                    </script>
                    
                </div>
                <div class="col-md-6">
                    
                    <div class="loadedInfo" id="loadedInfo_tribe">
                        <div class="mini_header2"></div>
                        <div class="innerInfo"></div>
                        <div class="specialButtons">
                            <div class="row">
                                <div class="col-md-6">
                                    <?= BsHtml::linkButton('Tribe history', array(
                                        'color' => BsHtml::BUTTON_COLOR_WARNING,
                                        //'disabled'=>'disabled',
                                        'block'=>true,
                                        'url'=>array('site/history_tribe'),
                                        'id'=>'go_history_tribe',
                                    )); ?>
                                </div>
                                <div class="col-md-6">
                                    <?= BsHtml::button('Add to map', array(
                                        'color' => BsHtml::BUTTON_COLOR_SUCCESS,
                                        'block'=>true,
                                        'id'=>'go_addTribeOnMap',
                                    )); ?>
                                </div>
                            </div>
                            <div class="row" style="margin-top: 5px;">
                                <div class="col-md-12">
                                    <?= BsHtml::linkButton('List of players', array(
                                        'color' => BsHtml::BUTTON_COLOR_PRIMARY,
                                        'block'=>true,
                                        'disabled'=>'disabled',
                                        'url'=>array('site/tribe'),
                                        'id'=>'go_tribeI',
                                    )); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="loadedInfo" id="loadedInfo_player">
                        <div class="mini_header2"></div>
                        <div class="innerInfo"></div>
                        <div class="specialButtons">
                            <div class="row">
                                <div class="col-md-6">
                                    <?= BsHtml::linkButton('Player history', array(
                                        'color' => BsHtml::BUTTON_COLOR_WARNING,
                                        //'disabled'=>'disabled',
                                        'block'=>true,
                                        'url'=>array('site/history_player'),
                                        'id'=>'go_history_player',
                                    )); ?>
                                </div>
                                <div class="col-md-6">
                                    <?= BsHtml::button('Add to map', array(
                                        'color' => BsHtml::BUTTON_COLOR_SUCCESS,
                                        'block'=>true,
                                        'id'=>'go_addPlayerOnMap',
                                    )); ?>
                                </div>
                            </div>
                            <div class="row" style="margin-top: 5px;">
                                <div class="col-md-12">
                                    <?= BsHtml::linkButton('List of villages', array(
                                        'color' => BsHtml::BUTTON_COLOR_PRIMARY,
                                        'block'=>true,
                                        'disabled'=>'disabled',
                                        'url'=>array('site/player'),
                                        'id'=>'go_playerI',
                                    )); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="loadedInfo" id="loadedInfo_village">
                        <div class="mini_header2"></div>
                        <div class="innerInfo"></div>
                        <div class="specialButtons">
                            <div class="row">
                                <div class="col-md-6">
                                    <?= BsHtml::linkButton('Village history', array(
                                        'color' => BsHtml::BUTTON_COLOR_WARNING,
                                        'disabled'=>'disabled',
                                        'block'=>true,
                                        'url'=>array('site/history_village'),
                                        'id'=>'go_history_village',
                                    )); ?>
                                </div>
                                <div class="col-md-6">

                                </div>
                            </div>
                            <div class="row" style="margin-top: 5px;">
                                <div class="col-md-12">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        
        <?php $this->endWidget(); ?>
        
        <div id="content">
            <?= $content ?>
        </div>
        
        <div id="footer" class="panel panel-footer panel-default">
            <div class="row">
                <div class="col-lg-4">
                    Last update '<?= $this->world ?>' completed: <?php
                        switch ($this->world) {
                            case 'zz2':
                                echo round((time()-$this->config->last_update_zz2)/60);
                                break;
                            case 'zz3':
                                echo round((time()-$this->config->last_update_zz3)/60);
                                break;
                            case 'en1':
                                echo round((time()-$this->config->last_update_en1)/60);
                                break;
                            case 'en2':
                                echo round((time()-$this->config->last_update_en2)/60);
                                break;
                            case 'de1':
                                echo round((time()-$this->config->last_update_de1)/60);
                                break;
                            case 'nl1':
                                echo round((time()-$this->config->last_update_nl1)/60);
                                break;
                            case 'fr1':
                                echo round((time()-$this->config->last_update_fr1)/60);
                                break;
                            case 'pl1':
                                echo round((time()-$this->config->last_update_pl1)/60);
                                break;
                            case 'ru1':
                                echo round((time()-$this->config->last_update_ru1)/60);
                                break;
                            
                            case 'br1':
                                echo round((time()-$this->config->last_update_br1)/60);
                                break;
                            case 'us1':
                                echo round((time()-$this->config->last_update_us1)/60);
                                break;
                            case 'es1':
                                echo round((time()-$this->config->last_update_es1)/60);
                                break;
                            case 'it1':
                                echo round((time()-$this->config->last_update_it1)/60);
                                break;
                            case 'gr1':
                                echo round((time()-$this->config->last_update_gr1)/60);
                                break;
                            case 'cz1':
                                echo round((time()-$this->config->last_update_cz1)/60);
                                break;
                            case 'pt1':
                                echo round((time()-$this->config->last_update_pt1)/60);
                                break;
                            case 'se1':
                                echo round((time()-$this->config->last_update_se1)/60);
                                break;
                            
                            case 'no1':
                                echo round((time()-$this->config->last_update_no1)/60);
                                break;
                            case 'dk1':
                                echo round((time()-$this->config->last_update_dk1)/60);
                                break;
                            case 'fi1':
                                echo round((time()-$this->config->last_update_fi1)/60);
                                break;
                            case 'sk1':
                                echo round((time()-$this->config->last_update_sk1)/60);
                                break;
                            case 'ro1':
                                echo round((time()-$this->config->last_update_ro1)/60);
                                break;
                            case 'hu1':
                                echo round((time()-$this->config->last_update_hu1)/60);
                                break;
                            case 'ar1':
                                echo round((time()-$this->config->last_update_ar1)/60);
                                break;
                            
                            default:
                                echo '?';
                        }
                    ?> mins ago.
                </div>
                <div class="col-lg-4" style="text-align: center;">
                    <?= Yii::powered() ?>
                </div>
                <div class="col-lg-4" style="text-align: right;">
                    <i>With questions and suggestions on Skype: <strong>firstalexxx</strong></i>
                </div>
            </div>
        </div>
        
    </div>
    
    <!--Openstat-->
    <span id="openstat2366224"></span>
    <script type="text/javascript">
    var openstat = { counter: 2366224, next: openstat };
    (function(d, t, p) {
    var j = d.createElement(t); j.async = true; j.type = "text/javascript";
    j.src = ("https:" == p ? "https:" : "http:") + "//openstat.net/cnt.js";
    var s = d.getElementsByTagName(t)[0]; s.parentNode.insertBefore(j, s);
    })(document, "script", document.location.protocol);
    </script>
    <!--/Openstat-->

</body>
</html>