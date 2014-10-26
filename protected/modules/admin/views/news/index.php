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
        $('#news-grid').yiiGridView('update', {
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
        <?php $this->widget('bootstrap.widgets.BsGridView',array(
            'id'=>'news-grid',
            'dataProvider'=>$model->search(),
            'filter'=>$model,
            //'type' => BsHtml::GRID_TYPE_CONDENSED,
            'type' => BsHtml::GRID_TYPE_HOVER,
            'template' => '{summary}{items}{pager}',
            'pagerCssClass'=>'pagination pagination-right',
            'columns'=>array(

                array(
                    //'header'=>'Действия',
                    'class'=>'bootstrap.widgets.BsButtonColumn',
                ),
            ),
        )); ?>
    </div>
</div>