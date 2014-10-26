<div class="panel panel-default panel-special">
    <div class="panel-heading">
        <h3 class="panel-title">
            <div>
                <!-- -->
                <?php if ( Yii::app()->user->checkAccess('1') ): ?>
                    <?= BsHtml::linkButton('Удалить', array(
                        'icon' => BsHtml::GLYPHICON_TRASH,
                        'color' => BsHtml::BUTTON_COLOR_WARNING,
                        'style' => 'float: right; margin-right: 0;',
                        'url' => array('/admin/user/delete', 'id'=>$model->id),
                        'onclick' => 'if (!confirm("Действительно удалить?")) return false;',
                    )); ?>
                    <?= BsHtml::linkButton('Редактировать', array(
                        'icon' => BsHtml::GLYPHICON_PENCIL,
                        'color' => BsHtml::BUTTON_COLOR_SUCCESS,
                        'style' => 'float: right;',
                        'url' => array('/admin/user/update', 'id'=>$model->id),
                    )); ?>
                <?php endif; ?>
                <div class="clear"></div>
            </div>
        </h3>
    </div>
    <div class="panel-body">
        <?= BsHtml::italics('Empty'); ?>
    </div>
</div>