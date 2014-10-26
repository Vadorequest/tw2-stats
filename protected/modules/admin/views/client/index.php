<?php
    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
        $('.search-form').toggle();
        if ( !$(this).hasClass('_active') ) {
            $(this).addClass('_active').html('<span class=\"glyphicon glyphicon-filter\"></span> Фильтр (сбросить)');
        } else {
            $(this).removeClass('_active').html('<span class=\"glyphicon glyphicon-filter\"></span> Фильтр');
            $('.search-form form')[0].reset();
            $('.search-form form').submit();
        }
        return false;
    });
    $('.search-form form').submit(function(){
        $('#client-grid').yiiGridView('update', {
                data: $(this).serialize()
        });
        return false;
    });
    $('.search-form input, .search-form select').change(function(){
        $('.search-form form').submit();
    });
    ");
?>

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
        <?php if ( !isset($_GET['status']) ): ?>
            <?= BsHtml::blockAlert(BsHtml::TEXT_COLOR_INFO, 'В данном разделе отображены все клиенты, кроме расположенных <i>в архиве</i>.') ?>
        <?php endif; ?>
        <?php if ( $_GET['status']==='0' ): ?>
            <?= BsHtml::blockAlert(BsHtml::TEXT_COLOR_INFO, 'В данном разделе отображены новые, <i>потенциальные</i> клиенты.') ?>
        <?php endif; ?>
        <?php $this->widget('bootstrap.widgets.BsGridView',array(
            'id'=>'client-grid',
            'dataProvider'=>$model->search(),
            //'filter'=>$model,
            //'type' => BsHtml::GRID_TYPE_CONDENSED,
            'type' => BsHtml::GRID_TYPE_HOVER,
            'template' => '{summary}{items}{pager}',
            'pagerCssClass'=>'pagination pagination-right',
            'columns'=>array(
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
                    'name'=>'fio',
                    'header'=>'Информация о клиенте',
                    'value'=>'$data->_info',
                    'type'=>'raw',
                ),
                array(
                    'name'=>'phone',
                    'value'=>'\'+7\'.$data->phone',
                ),
                array(
                    'header'=>'Что ищет',
                    'value'=>'$data->_objectTypes',
                    'type'=>'raw',
                ),
                array(
                    'name'=>'user_id',
                    'value'=>'CHtml::link($data->user->name, array(\'/admin/user/view\', \'id\'=>$data->user_id), array(\'target\'=>\'_blank\'))',
                    'type'=>'raw',
                    //'filter'=>BsHtml::activeDropDownList($model, 'user_id', User::model()->_dropDownList),
                ),
                array(
                    'name'=>'result',
                    'value'=>'$data->_result.\'<div>\'.Yii::app()->dateFormatter->format(\'dd MMMM yy г.\', $data->date_result).\'</div>\'',
                    'type'=>'raw',
                    'visible'=>$_GET['status']==='0',
                    'htmlOptions'=>array(
                        'class'=>'text-center line_height_20px',
                    ),
                ),
                
                array(
                    //'header'=>'Действия',
                    'class'=>'bootstrap.widgets.BsButtonColumn',
                ),
            ),
        )); ?>
    </div>
</div>