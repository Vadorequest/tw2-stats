<div class="panel panel-default panel-special">
    <div class="panel-heading">
        
    </div>
    <div class="panel-body">
        <?php if ( !Yii::app()->user->checkAccess('1') ): ?>
            <?= BsHtml::alert(BsHtml::ALERT_COLOR_WARNING, 'Вы можете удалять номера из черного списка, только если они были добавлены Вами.'); ?>
        <?php endif; ?>
        <?php $this->widget('bootstrap.widgets.BsGridView',array(
            'id'=>'blackList-grid',
            'dataProvider'=>$model->search(),
            'filter'=>$model,
            //'type' => BsHtml::GRID_TYPE_CONDENSED,
            'type' => BsHtml::GRID_TYPE_HOVER,
            'template' => '{summary}{items}{pager}',
            'pagerCssClass'=>'pagination pagination-right',
            'columns'=>array(
                'id',
                array(
                    'name'=>'date',
                    'value'=>'Yii::app()->dateFormatter->format(\'dd.MM.yyyy г. HH:mm\', $data->date)',
                    'filter'=>false,
                ),
                array(
                    'name'=>'phone',
                    'value'=>'\'+7\'.$data->phone',
                ),
                array(
                    'name'=>'user_id',
                    'value'=>'CHtml::link($data->user->name, array(\'/admin/user/view\', \'id\'=>$model->user_id), array(\'target\'=>\'_blank\'))',
                    'type'=>'raw',
                    'filter'=>BsHtml::activeDropDownList($model, 'user_id', User::model()->_dropDownList),
                ),
                array(
                    //'header'=>'Действия',
                    'class'=>'bootstrap.widgets.BsButtonColumn',
                    'template'=>'{delete}',
                ),
            ),
        )); ?>
    </div>
</div>