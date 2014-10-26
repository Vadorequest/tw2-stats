<div class="panel panel-default panel-special">
    <div class="panel-heading">
        <h3 class="panel-title">
            <div>
                <!-- -->
                <?= BsHtml::linkButton('Удалить', array(
                    'icon' => BsHtml::GLYPHICON_TRASH,
                    'color' => BsHtml::BUTTON_COLOR_WARNING,
                    'style' => 'float: right; margin-right: 0;',
                    'url' => array('/admin/news/delete', 'id'=>$model->id),
                    'onclick' => 'if (!confirm("Действительно удалить?")) return false;',
                )); ?>
                <?= BsHtml::linkButton('Редактировать', array(
                    'icon' => BsHtml::GLYPHICON_PENCIL,
                    'color' => BsHtml::BUTTON_COLOR_SUCCESS,
                    'style' => 'float: right;',
                    'url' => array('/admin/news/update', 'id'=>$model->id),
                )); ?>
                <div class="clear"></div>
            </div>
        </h3>
    </div>
    <div class="panel-body">
        <?php $this->widget('zii.widgets.CDetailView',array(
            'htmlOptions' => array(
                'class' => 'table table-striped table-condensed table-hover',
            ),
            'data'=>$model,
            'attributes'=>array(
                'id',
                'date',
                'title',
                'text',
                'user_id',
            ),
        )); ?>
    </div>
</div>