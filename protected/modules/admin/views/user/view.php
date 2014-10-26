<?php if ( Yii::app()->user->id==$model->id ): ?>
    <script>
        $(document).ready(function(){
            $('.page-header small').text('Это Ваш профиль').css('color', '<?= $model->_color ?>');
        });
    </script>
<?php endif; ?>
<div class="panel panel-default panel-special">
    <div class="panel-heading">
        <h3 class="panel-title">
            <div>
                <?php if ( Yii::app()->user->checkAccess('1') || Yii::app()->user->id==$model->id ): ?>
                    <?= BsHtml::linkButton('Логи авторизаций', array(
                        'color' => BsHtml::BUTTON_COLOR_DEFAULT,
                        'style' => 'float: left;',
                        'url' => array('/admin/user/log_auth', 'id'=>$model->id),
                    )); ?>
                <?php endif; ?>
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
        <?php $this->widget('zii.widgets.CDetailView',array(
            'htmlOptions' => array(
                'class' => 'table table-striped table-condensed table-hover',
            ),
            'data'=>$model,
            'attributes'=>array(
                'id',
                'login',
                //'password',
                //'hash',
                array(
                    'name'=>'type',
                    'value'=>'<span style="color: '.$model->_color.';">'.$model->_role.'</span>',
                    'type'=>'raw',
                ),
                'name',
                array(
                    'name'=>'phone',
                    'value'=>'+7'.$model->phone,
                ),
                array(
                    'name'=>'icq',
                ),
                array(
                    'name'=>'date_create',
                    'value'=>Yii::app()->dateFormatter->format('dd.MM.yyyy г. HH:mm', $model->date_create),
                ),
                array(
                    'name'=>'last_login',
                    'value'=>Yii::app()->dateFormatter->format('dd.MM.yyyy г. HH:mm', $model->date_create),
                ),
                array(
                    'name'=>'check_ip',
                    'value'=>($model->check_ip)?'да':'нет',
                ),
                array(
                    'name'=>'ip',
                    'visible'=>$model->check_ip,
                ),
                'parents',
                'info',
                'pasport_series',
                'pasport_num',
                array(
                    'name'=>'pasport_date',
                    'value'=>Yii::app()->dateFormatter->format('dd.MM.yyyy г.', $model->pasport_date),
                ),
                'pasport_place',
                array(
                    'name'=>'pasport_photocopy',
                    'value'=>CHtml::link('Открыть файл', array('/uploads/user/'.$model->pasport_photocopy), array('target'=>'_blank')),
                    'type'=>'raw',
                    'visible'=>( strlen($model->pasport_photocopy)!=0 && file_exists('./uploads/user/'.$model->pasport_photocopy) ),
                ),
                array(
                    'name'=>'birthday_date',
                    'value'=>Yii::app()->dateFormatter->format('dd.MM.yyyy г.', $model->birthday_date),
                ),
                'birthday_place',
                array(
                    'name'=>'manager_id',
                    'visible'=>$model->_role=='Стажер',
                    'value'=>CHtml::link($model->manager->name, array('/admin/user/view', 'id'=>$model->manager_id), array('target'=>'_blank')),
                    'type'=>'raw',
                ),
                array(
                    'name'=>'office_id',
                    'value'=>CHtml::link($model->office->address, array('/admin/office/view', 'id'=>$model->office_id), array('target'=>'_blank')),
                    'type'=>'raw',
                ),
            ),
        )); ?>
    </div>
</div>