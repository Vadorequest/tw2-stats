<?php
    Yii::app()->clientScript->registerScriptFile(Yii::app()->homeUrl.'js/jscolor/jscolor.js',CClientScript::POS_END);
    $tribes = new Tribe('tribe_'.$this->world);
    $characters = new Character('character_'.$this->world);
    $villages = new Village('village_'.$this->world);
?>

<?php $this->beginWidget('bootstrap.widgets.BsPanel', array(
    'title' => 'World map'.' - <b>'.$this->worldName.'</b> <span style="float: right;">Number of <b>tribes: '.$tribes->count().'</b> | Number of <b>players: '.$characters->count().'</b> | Number of <b>villages: '.$villages->count().'</b></span>',
)); ?>

    
    <div class="row well">

        <?= BsHtml::beginForm(array('site/index'), 'GET', array(
            'class'=>'form-horizontal',
            'role'=>'form',
            'id'=>'world-map',
        )) ?>

            <div class="col-md-6">
                <div class="form-group">
                    <?= BsHtml::label('The X coordinate of the center', 'x', array(
                        'class'=>'col-sm-7 control-label',
                    )) ?>
                    <div class="col-sm-5">
                        <?= BsHtml::textField('x', $data['x'], array('class'=>'input-sm')) ?>
                    </div>
                </div>
                <div class="form-group">
                    <?= BsHtml::label('The Y coordinate of the center', 'y', array(
                        'class'=>'col-sm-7 control-label',
                    )) ?>
                    <div class="col-sm-5">
                        <?= BsHtml::textField('y', $data['y'], array('class'=>'input-sm')) ?>
                    </div>
                </div>
                <div class="form-group">
                    <?= BsHtml::label('Zoom', 'z', array(
                        'class'=>'col-sm-7 control-label',
                    )) ?>
                    <div class="col-sm-5">
                        <?= BsHtml::textField('z', $data['z'], array('class'=>'input-sm')) ?>
                    </div>
                </div>
                
                <br />
                
                <div class="form-group">
                    <?= BsHtml::label('The MINimum number of points villages', 'min', array(
                        'class'=>'col-sm-7 control-label',
                    )) ?>
                    <div class="col-sm-5">
                        <?= BsHtml::textField('min', $data['min'], array('class'=>'input-sm')) ?>
                    </div>
                </div>
                
                <br />

                <div class="form-group">
                    <div class="col-sm-offset-7 col-sm-5">
                        <div class="checkbox">
                            <label>
                                <?= BsHtml::checkBox('show_barbarians', $data['show_barbarians'], array('class'=>'input-sm')) ?> Show barbarian villages
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group form-actions">
                    <div class="col-sm-offset-7 col-sm-5">
                        <?= BsHtml::submitButton('Generate', array(
                            'color' => BsHtml::BUTTON_COLOR_SUCCESS,
                            'icon' => BsHtml::GLYPHICON_EYE_OPEN,
                            'name'=>'',
                            'block'=>true,
                        )) ?>
                    </div>
                </div>
            </div>
        
            <div class="hiddenFormData">
                <?= BsHtml::hiddenField('provincies', (isset($_GET['provincies']))?strtolower($_GET['provincies']):'') ?>
                <?= BsHtml::hiddenField('players', $data['players']) ?>
                <?= BsHtml::hiddenField('tribes', $data['tribes']) ?>
                <?= BsHtml::hiddenField('increase_size', $data['increase_size']) ?>
                <?= BsHtml::hiddenField('world', $this->world) ?>
            </div>

        <?= BsHtml::endForm() ?>
        
        <div class="col-md-6">
            <div class="row">
                <div class="mini_header">Can be set after generation</div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group input-group-sm">
                        <span class="input-group-addon">Add player</span>
                        <?= BsHtml::textField('add_player', '', array('class'=>'input-sm color {valueElement:\'player_color\',slider:false}', 'placeHolder'=>'by name')) ?>
                        <?= BsHtml::hiddenField('player_color') ?>
                        <span class="input-group-btn">
                            <?= BsHtml::button('', array(
                                'color' => BsHtml::BUTTON_COLOR_DEFAULT,
                                'icon' => BsHtml::GLYPHICON_PLUS,
                                'id' => 'go_add_player',
                            )); ?>
                        </span>
                    </div>
                    <div id="_players"></div>
                </div>

                <div class="col-md-6">
                    <div class="input-group input-group-sm">
                        <span class="input-group-addon">Add tribe</span>
                        <?= BsHtml::textField('add_tribe', '', array('class'=>'input-sm color {valueElement:\'tribe_color\',slider:false}', 'placeHolder'=>'by tag')) ?>
                        <?= BsHtml::hiddenField('tribe_color') ?>
                        <span class="input-group-btn">
                            <?= BsHtml::button('', array(
                                'color' => BsHtml::BUTTON_COLOR_DEFAULT,
                                'icon' => BsHtml::GLYPHICON_PLUS,
                                'id' => 'go_add_tribe',
                            )); ?>
                        </span>
                    </div>
                    <div id="_tribes"></div>
                </div>
            </div>
            <div class="row">
                <div class="mini_header" style="margin-top: 5px;">Additional options</div>
                <div class="form-group">
                    <div class="checkbox checkbox_right">
                        <label>
                            <?= BsHtml::checkBox('_increase_size', $data['increase_size'], array('class'=>'input-sm')) ?> Increase the size of the named players/tribes
                        </label>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        
        $(document).ready(function(){
            
            $('#go_add_player').click(function(){
                coloringPlayer($('#add_player').val(), $('#player_color').val(), true);
                $('#add_player')[0].color.hidePicker();
            });

            $('#go_add_tribe').click(function(){
                coloringTribe($('#add_tribe').val(), $('#tribe_color').val(), true);
                $('#add_tribe')[0].color.hidePicker();
            });
            
            $('.vil').click(function(){
                $('#s_village').val($(this).attr('x')+'|'+$(this).attr('y'));
                $('#go_search_village').click();
                $('html, body').animate({scrollTop: $('#header').offset().top-100}, 300);
            });
            
            /* coloring players and tribes on map from generate data */
            if ( $('#provincies').val().length!=0 ) {
                var provincies = $('#provincies').val().split(';');
                for ( var i in provincies ) {
                    $('.vil[province="'+provincies[i]+'"]').css('background', '#0f0');
                }
            }
            if ( $('#players').val().length!=0 ) {
                var players = $('#players').val().split(';');
                for ( var i in players ) {
                    coloringPlayer((players[i].split('|'))[0], (players[i].split('|'))[1], false);
                }
            }
            if ( $('#tribes').val().length!=0 ) {
                var tribes = $('#tribes').val().split(';');
                for ( var i in tribes ) {
                    coloringTribe((tribes[i].split('|'))[0], (tribes[i].split('|'))[1], false);
                }
            }
            /* increase size */
            if ( $('#increase_size').val()==1 ) {
                increaseSize(true);
            }

            $('#_increase_size').change(function(){
                if ( $(this).prop('checked') ) {
                    increaseSize(true);
                    $('#increase_size').val('1');
                } else {
                    increaseSize(false);
                    $('#increase_size').val('0');
                }
            });
            
        });
        
        function increaseSize(plus)
        {
            if ( plus ) {
                $('.vil[color_player], .vil[color_tribe]').css({
                    'width': <?= $data['z']*2 ?>,
                    'height': <?= $data['z']*2 ?>,
                    'margin-top': <?= -($data['z']*2-$data['z'])/2 ?>,
                    'margin-left': <?= -($data['z']*2-$data['z'])/2 ?>,
                    'zIndex': 1000
                });
            } else {
                $('.vil[color_player], .vil[color_tribe]').css({
                    'width': <?= $data['z'] ?>,
                    'height': <?= $data['z'] ?>,
                    'margin-top': 0,
                    'margin-left': 0,
                    'zIndex': 1
                });
            }
        }
        
        function decreaseSizePlayer(name)
        {
            $('.vil[character_name="'+name+'"]').css({
                'width': <?= $data['z'] ?>,
                'height': <?= $data['z'] ?>,
                'margin-top': 0,
                'margin-left': 0,
                'zIndex': 1
            });
        }
        
        function decreaseSizeTribe(tag)
        {
            $('.vil[tribe_tag="'+tag+'"]').css({
                'width': <?= $data['z'] ?>,
                'height': <?= $data['z'] ?>,
                'margin-top': 0,
                'margin-left': 0,
                'zIndex': 1
            });
        }
        
        function coloringPlayer(name, color, handly)
        {
            if ( name.length!=0 ) {
                $('.vil[character_name="'+name+'"]').css({
                    'background-color': '#'+color
                }).attr({
                    'color_player': '1'
                });

                $('#_players').append('<div class="input-group input-group-sm" style="margin-top: 5px;" character_name="'+name+'"><span class="__color" __color="'+color+'"></span><span class="input-group-addon">'+name+'</span><input class="input-sm form-control" type="text" value="" disabled="disabled" style="background: #'+color+'; color: #333;"><span class="input-group-btn"><button class="btn btn-default go_player_delete" type="button"><span class="glyphicon glyphicon-minus"></span></button></span></div>');

                if ( handly ) {
                    $('#add_player')[0].color.fromString('fff');
                    $('#add_player').val('');
                    addInGenerate();
                }
                if ( $('#increase_size').val()==1 ) {
                    increaseSize(true);
                }

                $('.go_player_delete').click(function(){
                    $('.vil[character_name="'+$(this).parent().prev().prev().text()+'"]').css({
                        'background-color': ''
                    }).removeAttr('color_player');
                    $('#_players > div[character_name="'+$(this).parent().prev().prev().text()+'"]').remove();
                    addInGenerate();
                    decreaseSizePlayer($(this).parent().prev().prev().text());
                });
            }
        }

        function coloringTribe(tag, color, handly)
        {
            if ( tag.length!=0 ) {
                $('.vil[tribe_tag="'+tag+'"]:not([color_player])').css({
                    'background-color': '#'+color
                }).attr({
                    'color_tribe': '1'
                });

                $('#_tribes').append('<div class="input-group input-group-sm" style="margin-top: 5px;" tribe_tag="'+tag+'"><span class="__color" __color="'+color+'"></span><span class="input-group-addon">'+tag+'</span><input class="input-sm form-control" type="text" value="" disabled="disabled" style="background: #'+color+';"><span class="input-group-btn"><button class="btn btn-default go_tribe_delete" type="button"><span class="glyphicon glyphicon-minus"></span></button></span></div>');

                if ( handly ) {
                    $('#add_tribe')[0].color.fromString('fff');
                    $('#add_tribe').val('');
                    addInGenerate();
                }
                if ( $('#increase_size').val()==1 ) {
                    increaseSize(true);
                }

                $('.go_tribe_delete').click(function(){
                    $('.vil[tribe_tag="'+$(this).parent().prev().prev().text()+'"]').css({
                        'background-color': ''
                    }).removeAttr('color_tribe');
                    $('#_tribes > div[tribe_tag="'+$(this).parent().prev().prev().text()+'"]').remove();
                    addInGenerate();
                    decreaseSizeTribe($(this).parent().prev().prev().text());
                });
            }
        }

        function addInGenerate()
        {
            var players = '';
            var tribes = '';
            $('#_players .input-group-addon').each(function(){
                players += $(this).text()+'|'+$(this).prev().attr('__color')+';';
            });
            $('#_tribes .input-group-addon').each(function(){
                tribes += $(this).text()+'|'+$(this).prev().attr('__color')+';';
            });
            $('#players').val(players);
            $('#tribes').val(tribes);
        }
        
    </script>
    
    <div id="map">
        <?php foreach ( $vils as $vil ) : ?>
            <?php
                $top = ($vil['y']-($data['y']-$data['radius']))*$data['z'];
                $left = ($vil['x']-($data['x']-$data['radius']))*$data['z'];
                $size = $data['z'];
                $class = 'vil';
                if ( $vil['character_id']==null ) {
                    $class .= ' vil_barbarian';
                }
                $title = '<span class=gray>Village name:</span> '.$vil['name'].'<br /><span class=gray>Coords:</span> '.$vil['x'].'|'.$vil['y'].'<br /><span class=gray>Village points:</span> '.$vil['points'].'<br /><span class=gray>Player:</span> '.$vil['character_name'].'<br /><span class=gray>Player points:</span> '.$vil['character_points'].'<br /><span class=gray>Tribe:</span> ['.$vil['tribe_tag'].'] '.$vil['tribe_name'].'<br /><span class=gray>Tribe points:</span> ~'.floor($vil['tribe_points']/1000).'k'.'<br /><span class=gray>Province:</span> '.$vil['province_name'];
            ?>
        <div x="<?= $vil['x'] ?>" y="<?= $vil['y'] ?>" title="<?= $title ?>" province="<?= strtolower($vil['province_name']) ?>" class="<?= $class ?>" style="top: <?= $top ?>px; left: <?= $left ?>px; width: <?= $size ?>px; height: <?= $size ?>px;" character_name="<?= $vil['character_name'] ?>" tribe_tag="<?= $vil['tribe_tag'] ?>"></div>
        <?php endforeach; ?>
    </div>

<?php $this->endWidget(); ?>