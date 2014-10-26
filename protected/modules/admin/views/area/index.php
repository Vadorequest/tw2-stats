<div class="panel panel-default panel-special">
    <div class="panel-heading">
        
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BsGridView',array(
            'id'=>'area-grid',
            'dataProvider'=>$model->search(),
            'filter'=>$model,
            //'type' => BsHtml::GRID_TYPE_CONDENSED,
            'type' => BsHtml::GRID_TYPE_HOVER,
            'template' => '{summary}{items}{pager}',
            'pagerCssClass'=>'pagination pagination-right',
            'columns'=>array(
                'id',
                'name',
                array(
                    //'header'=>'Действия',
                    'class'=>'bootstrap.widgets.BsButtonColumn',
                    'template'=>(!Yii::app()->user->checkAccess('1'))?'{view}':'{view} {update} {delete}',
                ),
            ),
        )); ?>
    </div>
</div>