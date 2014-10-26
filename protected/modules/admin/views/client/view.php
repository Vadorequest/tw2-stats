<div class="panel panel-default panel-special">
    <div class="panel-heading">
        <h3 class="panel-title">
            <div>
                <!-- -->
                <?= BsHtml::linkButton('Удалить', array(
                    'icon' => BsHtml::GLYPHICON_TRASH,
                    'color' => BsHtml::BUTTON_COLOR_WARNING,
                    'style' => 'float: right; margin-right: 0;',
                    'url' => array('/admin/client/delete', 'id'=>$model->id),
                    'onclick' => 'if (!confirm("Действительно удалить?")) return false;',
                )); ?>
                <?= BsHtml::linkButton('Редактировать', array(
                    'icon' => BsHtml::GLYPHICON_PENCIL,
                    'color' => BsHtml::BUTTON_COLOR_SUCCESS,
                    'style' => 'float: right;',
                    'url' => array('/admin/client/update', 'id'=>$model->id),
                )); ?>
                <div class="clear"></div>
            </div>
        </h3>
    </div>
    <div class="panel-body">
        <?php if ( Yii::app()->user->hasFlash('success') ): ?>
            <?= BsHtml::blockAlert(BsHtml::TEXT_COLOR_SUCCESS, Yii::app()->user->getFlash('success')) ?>
        <?php endif; ?>
        <?php if ( Yii::app()->user->hasFlash('info') ): ?>
            <?= BsHtml::blockAlert(BsHtml::TEXT_COLOR_INFO, Yii::app()->user->getFlash('info')) ?>
        <?php endif; ?>
        <?php $this->widget('zii.widgets.CDetailView',array(
            'htmlOptions' => array(
                'class' => 'table table-striped table-condensed table-hover',
            ),
            'data'=>$model,
            'attributes'=>array(
                'id',
                'fio',
                array(
                    'name'=>'male',
                    'value'=>$model->_male,
                ),
                array(
                    'name'=>'phone',
                    'value'=>'+7'.$model->phone,
                ),
                array(
                    'name'=>'status',
                    'value'=>$model->_status,
                ),
                array(
                    'name'=>'result',
                    'value'=>$model->_result,
                    'type'=>'raw',
                ),
                array(
                    'name'=>'wantType',
                    'value'=>$model->_wantType,
                ),
                array(
                    'name'=>'object_id',
                    'value'=>CHtml::link($model->object_id, array('/admin/object/view', 'id'=>$model->object_id), array('target'=>'_blank')),
                    'type'=>'raw',
                ),
                array(
                    'name'=>'date_result',
                    'value'=>Yii::app()->dateFormatter->format('dd MMMM yy г.', $model->date_result),
                ),
                array(
                    'name'=>'date_meet',
                    'value'=>(strlen($model->date_meet)>1)?Yii::app()->dateFormatter->format('dd.MM.yyyy', $model->date_meet):'<span class="null">Не задан</span>',
                    'type'=>'raw',
                ),
                array(
                    'name'=>'date_call',
                    'value'=>(strlen($model->date_call)>1)?Yii::app()->dateFormatter->format('dd.MM.yyyy', $model->date_call):'<span class="null">Не задан</span>',
                    'type'=>'raw',
                ),
                array(
                    'name'=>'tariff_id',
                    'value'=>(isset($model->tariff))?CHtml::link($model->tariff->name.' ('.$model->tariff->sum.' руб.)', array('/admin/tariff/view', 'id'=>$model->tariff_id), array('target'=>'_blank')):'<span class="null">Не задан</span>',
                    'type'=>'raw',
                ),
                array(
                    'name'=>'cash',
                    'value'=>($model->cash)?'да':'нет',
                ),
                array(
                    'name'=>'sum',
                ),
                array(
                    'name'=>'contract',
                ),
                array(
                    'name'=>'user_id',
                    'value'=>CHtml::link($model->user->name, array('/admin/user/view', 'id'=>$model->user_id), array('target'=>'_blank')),
                    'type'=>'raw',
                ),
                array(
                    'name'=>'price',
                ),
                array(
                    'name'=>'daily',
                    'value'=>($model->daily)?'да':'нет',
                ),
                array(
                    'name'=>'realtor',
                    'value'=>($model->realtor)?'да':'нет',
                ),
                array(
                    'name'=>'areas',
                    'value'=>$model->_areas,
                    'type'=>'raw',
                ),
                array(
                    'name'=>'objectTypes',
                    'value'=>$model->_objectTypes,
                    'type'=>'raw',
                ),
                array(
                    'name'=>'problem',
                    'value'=>($model->problem)?'да':'нет',
                ),
                array(
                    'name'=>'populated',
                    'value'=>$model->_populated,
                ),
                'desc',
                array(
                    'name'=>'date_create',
                    'value'=>Yii::app()->dateFormatter->format('dd MMMM yy г.', $model->date_create),
                ),
                array(
                    'name'=>'date_update',
                    'value'=>Yii::app()->dateFormatter->format('dd MMMM yy г.', $model->date_update),
                ),
                array(
                    'name'=>'date_admin',
                    'value'=>Yii::app()->dateFormatter->format('dd MMMM yy г.', $model->date_admin),
                ),
                array(
                    'name'=>'origin',
                    'value'=>$model->_origin,
                ),
                array(
                    'name'=>'board_id',
                    'value'=>$model->board->name,
                    'visible'=>$model->origin==2,
                ),
                array(
                    'label'=>'Доступ к базе',
                    'value'=>($model->_user_id===null)?'нет':'да',
                ),
                array(
                    'label'=>'Логин доступа к базе',
                    'value'=>$model->_user->login,
                    'visible'=>$model->_user_id!==null,
                ),
            ),
        )); ?>
    </div>
</div>