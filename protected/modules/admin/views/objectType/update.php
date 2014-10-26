<div class="panel panel-default panel-special">
    <div class="panel-heading">
        <h3 class="panel-title">
            <div>
                <!-- -->
                <?= BsHtml::linkButton('Удалить', array(
                    'icon' => BsHtml::GLYPHICON_TRASH,
                    'color' => BsHtml::BUTTON_COLOR_WARNING,
                    'style' => 'float: right; margin-right: 0;',
                    'url' => array('/admin/objectType/delete', 'id'=>$model->id),
                    'onclick' => 'if (!confirm("Действительно удалить?")) return false;',
                )); ?>
                <div class="clear"></div>
            </div>
        </h3>
    </div>
    <div class="panel-body">
        <?php $this->renderPartial('_form', array('model'=>$model)); ?>
    </div>
</div>