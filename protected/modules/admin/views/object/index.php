<?php
    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
        if ( !$(this).hasClass('_active') ) {
            $('.search-form').toggle();
            $(this).addClass('_active').html('<span class=\"glyphicon glyphicon-filter\"></span> Фильтр (сбросить)');
        } else {
            $.removeCookie('filter_object', { path: '/' });
            /*$(this).removeClass('_active').html('<span class=\"glyphicon glyphicon-filter\"></span> Фильтр');
            $('.search-form form')[0].reset();
            $('.search-form form').submit();*/
            location = $('.nav-special li.active a').attr('href');
        }
        return false;
    });
    $('.search-form form').submit(function(){
        $.cookie('filter_object', $(this).serialize(), { path: '/', expires: 30 });
        $('#object-grid').yiiGridView('update', {
            data: $(this).serialize()
        });
        return false;
    });
    $('.search-form input, .search-form select').change(function(){
        $('.search-form form').submit();
    });
    $(document).ready(function(){
    
        if ( $.cookie('filter_object')!==undefined ) {
            $('.search-form').toggle();
            $('.search-button').addClass('_active').html('<span class=\"glyphicon glyphicon-filter\"></span> Фильтр (сбросить)');
            $('#object-grid').yiiGridView('update', {
                data: $.cookie('filter_object')
            });
        }
        
        if ( $('#gridF').attr('num')=='1' ) {
            updateGrid();
        }
        
    });
    
function updateGrid()
{
    $('#object-grid tr:first').addClass('no_opacity');
    $('#object-grid tr').click(function(){
        if ( !$(this).hasClass('no_opacity') ) {
            if ( !$(this).hasClass('active') ) {
                window.tr = $(this);
                window.id = $(this).find('span._id').attr('num');
                tr.addClass('active');
                $.ajax({
                    url: '/admin/object/_ajax_info',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        id: id
                    },
                    success: function(data) {
                        tr.after('<tr class=\"active\"><td colspan=\"9\" id=\"object_id_'+id+'\"></td></tr>');
                        $('#test label').each(function(){
                            $(this).attr('for', $(this).attr('for')+id);
                        });
                        $('#test input').each(function(){
                            $(this).attr('name', $(this).attr('name')+id);
                            $(this).attr('id', $(this).attr('name'));
                        });
                        $('#test select').each(function(){
                            $(this).attr('name', $(this).attr('name')+id);
                            $(this).attr('id', $(this).attr('name'));
                        });
                        $('#object_id_'+id).html($('#test').html());
                        $('#test label').each(function(){
                            $(this).attr('for', $(this).attr('for')+Math.random());
                        });
                        $('#test input').each(function(){
                            $(this).attr('name', $(this).attr('name')+Math.random());
                            $(this).attr('id', $(this).attr('name'));
                        });
                        $('#test select').each(function(){
                            $(this).attr('name', $(this).attr('name')+Math.random());
                            $(this).attr('id', $(this).attr('name'));
                        });
                        //$('#test').remove();
                        $('#object_id_'+id+' ._desc').text(data.desc);
                        if ( data.daily=='1' ) {
                            $('#daily'+id).prop('checked', true);
                        } else {
                            $('#daily'+id).prop('checked', false);
                        }
                        jQuery('#object_id_'+id+' .with_dp').datepicker(jQuery.extend({showMonthAfterYear:false},jQuery.datepicker.regional['ru'],{'showAnim':'fold','changeMonth':true,'showButtonPanel':false,'dateFormat':'dd.mm.yy'}));
                        $('#object_id_'+id+' input').each(function(){
                            if ( $(this).attr('type')=='checkbox' && $(this).attr('name')!='daily' ) {
                                $(this).change(function(){
                                    if ( $(this).prop('checked') ) {
                                        $(this).parent().parent().parent().parent().parent().next().show();
                                    } else {
                                        $(this).parent().parent().parent().parent().parent().next().hide();
                                    }
                                });
                            }
                        });
                        $('#object_id_'+id+' button').attr('object_id', id);
                        $('#object_id_'+id+' ._goActual').click(function(){
                            var free = null;
                            var show = null;
                            var daily = null;
                            var coop = null;
                            if ( $('#free'+$(this).attr('object_id')).prop('checked') ) {
                                free = 1;
                            } else {
                                free = 0;
                            }
                            if ( $('#show'+$(this).attr('object_id')).prop('checked') ) {
                                show = 1;
                            } else {
                                show = 0;
                            }
                            if ( $('#daily'+$(this).attr('object_id')).prop('checked') ) {
                                daily = 1;
                            } else {
                                daily = 0;
                            }
                            if ( $('#coop'+$(this).attr('object_id')).prop('checked') ) {
                                coop = 1;
                            } else {
                                coop = 0;
                            }
                            $.ajax({
                                url: '/admin/object/_ajax_status_update',
                                type: 'POST',
                                data: {
                                    object_id: $(this).attr('object_id'),
                                    status: 1,
                                    free: free,
                                    free_date: $('#free_date'+$(this).attr('object_id')).val(),
                                    show: show,
                                    show_date: $('#show_date'+$(this).attr('object_id')).val(),
                                    show_type: $('#show_type'+$(this).attr('object_id')).val(),
                                    daily: daily,
                                    coop: coop
                                },
                                success: function(data) {
                                    $('#object_id_'+data).parent().prev().click().remove();
                                }
                            });
                        });
                        $('#object_id_'+id+' ._goBlack').click(function(){
                            $.ajax({
                                url: '/admin/object/_ajax_status_update',
                                type: 'POST',
                                data: {
                                    object_id: $(this).attr('object_id'),
                                    status: 3
                                },
                                success: function(data) {
                                    $('#object_id_'+data).parent().prev().click().remove();
                                }
                            });
                        });
                        $('#object_id_'+id+' ._goArch').click(function(){
                            $.ajax({
                                url: '/admin/object/_ajax_status_update',
                                type: 'POST',
                                data: {
                                    object_id: $(this).attr('object_id'),
                                    status: 2
                                },
                                success: function(data) {
                                    $('#object_id_'+data).parent().prev().click().remove();
                                }
                            });
                        });
                        $('#object_id_'+id+' ._goCall').click(function(){
                            $.ajax({
                                url: '/admin/object/_ajax_status_update',
                                type: 'POST',
                                data: {
                                    object_id: $(this).attr('object_id'),
                                    status: 4
                                },
                                success: function(data) {
                                    $('#object_id_'+data).parent().prev().click();
                                }
                            });
                        });
                    }
                });
            } else {
                $(this).removeClass('active').next().remove();
            }

            if ( $('#object-grid tr.active').length==0 ) {
                $('#object-grid tr').animate({opacity: 1});
            } else {
                $('#object-grid tr').each(function(){
                    if ( !$(this).hasClass('active') ) {
                        $(this).animate({opacity: .25});
                    } else {
                        $(this).animate({opacity: 1});
                    }
                });
            }
        }
    });
}

    ");
?>

<div style="display: none;" id="test">
    
    <div class="row">
        <div class="col-lg-8">
            <div class="row">
                <div class="control-label col-lg-3" style="text-align: right; font-weight: bold;">Описание:</div>
                <div class="col-lg-9 _desc"></div>
            </div>
            <div class="row">
                <?= BsHtml::beginForm('', 'GET', array('class' => 'form-horizontal col-lg-6')) ?>
                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="control-label col-lg-6" for="daily">Посуточная:</label>
                        <div class="col-lg-6">
                            <span>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="daily" />
                                    </label>
                                </div>
                            </span>
                        </div>
                    </div>
                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="control-label col-lg-6" for="coop">Сотрудничество:</label>
                        <div class="col-lg-6">
                            <span>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="coop" />
                                    </label>
                                </div>
                            </span>
                        </div>
                    </div>
                <?= BsHtml::endForm(); ?>
            </div>
            <div class="row">
                <?= BsHtml::beginForm('', 'GET', array('class' => 'form-horizontal col-lg-6')) ?>
                    <div class="form-group">
                        <label class="control-label col-lg-6" for="free">Должна осободится:</label>
                        <div class="col-lg-6">
                            <span>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="free" />
                                    </label>
                                </div>
                            </span>
                        </div>
                    </div>
                    <div style="display: none;">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="control-label col-lg-6" for="free_date">Освободится до:</label>
                            <div class="col-lg-6">
                                <input class="form-control with_dp" type="text" value="<?= Yii::app()->dateFormatter->format('dd.MM.yyyy', time()) ?>" name="free_date" />
                            </div>
                        </div>
                    </div>
                <?= BsHtml::endForm(); ?>
                <?= BsHtml::beginForm('', 'GET', array('class' => 'form-horizontal col-lg-6')) ?>
                    <div class="form-group">
                        <label class="control-label col-lg-6" for="show" >Показ:</label>
                        <div class="col-lg-6">
                            <span>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="show" />
                                    </label>
                                </div>
                            </span>
                        </div>
                    </div>
                    <div style="display: none;">
                        <div class="form-group">
                            <label class="control-label col-lg-6" for="show_date">Дата показа:</label>
                            <div class="col-lg-6">
                                <input class="form-control with_dp" type="text" value="<?= Yii::app()->dateFormatter->format('dd.MM.yyyy', time()) ?>" name="show_date" />
                            </div>
                        </div>
                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="control-label col-lg-6" for="show_type"></label>
                            <div class="col-lg-6">
                                <select class="form-control" name="show_type">
                                    <option value="" selected="selected">-</option>
                                    <option value="0">утром</option>
                                    <option value="1">в обед</option>
                                    <option value="2">вечером</option>
                                    <option value="3">по звонку</option>
                                </select>
                            </div>
                        </div>
                    </div>
                <?= BsHtml::endForm(); ?>
            </div>
        </div>
        <div class="col-lg-4">
            <?= BsHtml::button('Актуальный', array(
                'block'=>true,
                'color'=>BsHtml::BUTTON_COLOR_SUCCESS,
                'icon'=>BsHtml::GLYPHICON_OK,
                'class'=>'_goActual',
            )) ?>
            <?= BsHtml::button('В черный список', array(
                'block'=>true,
                'color'=>BsHtml::BUTTON_COLOR_DEFAULT,
                'icon'=>BsHtml::GLYPHICON_TRASH,
                'class'=>'_goBlack',
            )) ?>
            <?= BsHtml::button('Сдана / В архив', array(
                'block'=>true,
                'color'=>BsHtml::BUTTON_COLOR_WARNING,
                'icon'=>BsHtml::GLYPHICON_FOLDER_OPEN,
                'class'=>'_goArch',
            )) ?>
            <?= BsHtml::button('Недозвониться', array(
                'block'=>true,
                'color'=>BsHtml::BUTTON_COLOR_DANGER,
                'icon'=>BsHtml::GLYPHICON_PHONE_ALT,
                'class'=>'_goCall',
            )) ?>
        </div>
    </div>
    
</div>

<div class="panel panel-default panel-special">
    <div class="panel-heading">
        <h3 class="panel-title" style="text-align: right;">
            <?= BsHtml::button('Фильтр', array(
                'class' =>'search-button',
                'icon' => BsHtml::GLYPHICON_FILTER,
                'color' => BsHtml::BUTTON_COLOR_SUCCESS
            ), '#'); ?>
        </h3>
        <div class="search-form" style="display:none">
            <?php $this->renderPartial('_search',array(
                'model'=>$model,
            )); ?>
        </div>
    </div>
    <div class="panel-body">
        <?php if ( !isset($_GET['status']) && !isset($_GET['daily']) ): ?>
            <?= BsHtml::blockAlert(BsHtml::TEXT_COLOR_INFO, 'В данном разделе отображены все объекты, кроме <i>удаленных</i> и расположенных <i>в архиве</i>.') ?>
        <?php endif; ?>
        <?php if ( $_GET['status']==='0' ): ?>
            <?= BsHtml::blockAlert(BsHtml::TEXT_COLOR_INFO, 'В данном разделе отображены новые, <i>необработанные</i> объекты (для прозвона).'
                    . '<br />Вы можете кликнуть по строке объекта для быстрого изменения его статуса.') ?>
        <?php endif; ?>
        <?php if ( $_GET['daily']==='1' ): ?>
            <?= BsHtml::blockAlert(BsHtml::TEXT_COLOR_INFO, 'В данном разделе отображены <i>посуточные</i> объекты, за исключением <i>удаленных</i> и расположенных <i>в архиве</i>.') ?>
        <?php endif; ?>
        <?php if ( $_GET['status']==='1' ): ?>
            <?= BsHtml::blockAlert(BsHtml::TEXT_COLOR_INFO, 'В данном разделе отображены <i>актуальные</i> объекты (проверенные).') ?>
        <?php endif; ?>
        <?php
            $gridF = '';
            $elemF = '<div id="gridF" style="display: none;" num="0"></div>';
            if ( $_GET['status']==='0' ) {
                $gridF = 'updateGrid();';
                $elemF = '<div id="gridF" style="display: none;" num="1"></div>';
            }
            echo $elemF;
        ?>
        <?php $this->widget('bootstrap.widgets.BsGridView',array(
            'id'=>'object-grid',
            'dataProvider'=>$model->search(),
            //'filter'=>$model,
            //'type' => BsHtml::GRID_TYPE_CONDENSED,
            'type' => BsHtml::GRID_TYPE_HOVER,
            'template' => '{summary}{items}{pager}',
            'pagerCssClass'=>'pagination pagination-right',
            'selectableRows'=>0,
            'afterAjaxUpdate'=>'function(){'.$gridF.'}',
            'columns'=>array(
                /*array(
                    'class'=>'CCheckBoxColumn',            
                ),*/
                array(
                    'name'=>'date_create',
                    'value'=>'Yii::app()->dateFormatter->format(\'dd MMMM HH:mm\', $data->date_create)',
                    'visible'=>$_GET['status']==='0',
                ),
                array(
                    'name'=>'date_admin',
                    'value'=>'Yii::app()->dateFormatter->format(\'dd MMMM HH:mm\', $data->date_admin)',
                    'visible'=>$_GET['status']!=='0',
                ),
                array(
                    'name'=>'street',
                    'header'=>'Информация об объекте',
                    'value'=>'$data->_info.\'<span style="display: none;" class="_id" num="\'.$data->id.\'"></span>\'',
                    'type'=>'raw',
                ),
                array(
                    'name'=>'phone',
                    'value'=>'(strlen($data->phone)!=0)?(\'+7\'.$data->phone):\'\'',
                ),
                array(
                    'name'=>'type_id',
                    'value'=>'$data->objectType->name',
                ),
                array(
                    'name'=>'furniture',
                    'value'=>'($data->furniture)?\'да\':\'нет\'',
                ),
                array(
                    'name'=>'repair',
                    'value'=>'$data->_repair',
                ),
                array(
                    'name'=>'user_id',
                    'value'=>'CHtml::link($data->user->name, array(\'/admin/user/view\', \'id\'=>$data->user_id), array(\'target\'=>\'_blank\'))',
                    'type'=>'raw',
                    //'filter'=>BsHtml::activeDropDownList($model, 'user_id', User::model()->_dropDownList),
                ),
                array(
                    'name'=>'status',
                    'value'=>'$data->_status',
                    'visible'=>!isset($_GET['status']),
                ),
                array(
                    //'header'=>'Действия',
                    'class'=>'bootstrap.widgets.BsButtonColumn',
                    //'template'=>'{view}',
                ),
            ),
        )); ?>
    </div>
</div>