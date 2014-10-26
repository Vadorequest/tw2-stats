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
        $('#parser-grid').yiiGridView('update', {
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
            <div class="search-form" style="display:none">
                <?php $this->renderPartial('_search_parser',array(
                    'model'=>$model,
                )); ?>
            </div>
        </h3>
    </div>
    <div class="panel-body">
        
        <?php $this->widget('bootstrap.widgets.BsGridView',array(
            'id'=>'parser-grid',
            'dataProvider'=>$model->search(),
            //'filter'=>$model,
            //'type' => BsHtml::GRID_TYPE_CONDENSED,
            'type' => BsHtml::GRID_TYPE_HOVER,
            'template' => '{summary}{items}{pager}',
            'pagerCssClass'=>'pagination pagination-right',
            'columns'=>array(
                array(
                    'name'=>'date',
                    'value'=>'Yii::app()->dateFormatter->format(\'dd MMMM HH:mm\', $data->date)',
                    'filter'=>false,
                ),
                array(
                    'name'=>'board_id',
                    'value'=>'$data->board->name." ".CHtml::link($data->board->url, $data->board->url, array("target"=>"_blank"))',
                    'type'=>'raw',
                    //'filter'=>BsHtml::activeDropDownList($model, 'board_id', Board::model()->_dropDownList),
                ),
                array(
                    'name'=>'count_total',
                    'filter'=>false,
                ),
                array(
                    'name'=>'count_black',
                    'filter'=>false,
                ),
                array(
                    'name'=>'not_address',
                    'filter'=>false,
                ),
                array(
                    'name'=>'not_type',
                    'filter'=>false,
                ),
                array(
                    'name'=>'not_phone',
                    'filter'=>false,
                ),
                /*array(
                    //'header'=>'Действия',
                    'class'=>'bootstrap.widgets.BsButtonColumn',
                    'template'=>(!Yii::app()->user->checkAccess('1'))?'{view}':'{view} {update} {delete}',
                ),*/
            ),
        )); ?>
        
    </div>
</div>