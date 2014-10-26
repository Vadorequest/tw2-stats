<?php
    $this->widget('application.extensions.fancybox.EFancyBox', array(
        'target'=>'a[rel]',
        'config'=>array(),
    ));
?>

<div class="panel panel-default panel-special">
    <div class="panel-heading">
        <h3 class="panel-title">
            <div>
                <?php
                    $_status = '';
                    switch ($model->status) {
                        case 0:
                            $_status = 'Из <strong>новых</strong> объектов';
                            break;
                        case 1:
                            $_status = 'Из <strong>актуальных</strong> объектов';
                            break;
                        case 2:
                            $_status = 'Из объектов <strong>в архиве</strong>';
                            break;
                        case 3:
                            $_status = 'Из <strong>удаленных</strong> объектов';
                            break;
                        case 4:
                            $_status = 'Из объектов, до которых <strong>не удалось дозвониться</strong>';
                            break;

                        default:
                            break;
                    }
                ?>
                <?= BsHtml::buttonDropdown('Предыдущий объект', array(
                    array(
                        'label' => 'Из всех объектов',
                        'url' => array('/admin/object/view', 'id'=>$model->id, 'dest'=>'prev'),
                    ),
                    array(
                        'label' => $_status,
                        'url' => array('/admin/object/view', 'id'=>$model->id, 'dest'=>'prev', 'spec'=>'status'),
                    ),
                ), array(
                    'icon' => BsHtml::GLYPHICON_ARROW_LEFT,
                )); ?>
                <?= BsHtml::buttonDropdown('Следующий объект', array(
                    array(
                        'label' => 'Из всех объектов',
                        'url' => array('/admin/object/view', 'id'=>$model->id, 'dest'=>'next'),
                    ),
                    array(
                        'label' => $_status,
                        'url' => array('/admin/object/view', 'id'=>$model->id, 'dest'=>'next', 'spec'=>'status'),
                    ),
                ), array(
                    'icon' => BsHtml::GLYPHICON_ARROW_RIGHT,
                )); ?>
                <!-- -->
                <?= BsHtml::linkButton('Удалить', array(
                    'icon' => BsHtml::GLYPHICON_TRASH,
                    'color' => BsHtml::BUTTON_COLOR_WARNING,
                    'style' => 'float: right; margin-right: 0;',
                    'url' => array('/admin/object/delete', 'id'=>$model->id),
                    'onclick' => 'if (!confirm("Действительно удалить?")) return false;',
                )); ?>
                <?= BsHtml::linkButton('Редактировать', array(
                    'icon' => BsHtml::GLYPHICON_PENCIL,
                    'color' => BsHtml::BUTTON_COLOR_SUCCESS,
                    'style' => 'float: right;',
                    'url' => array('/admin/object/update', 'id'=>$model->id),
                )); ?>
                <?= BsHtml::linkButton('В черный список', array(
                    'icon' => BsHtml::GLYPHICON_TRASH,
                    'color' => BsHtml::BUTTON_COLOR_DEFAULT,
                    'style' => 'float: right;',
                    'url' => array('/admin/object/toBlackList', 'id'=>$model->id),
                )); ?>
                <div class="clear"></div>
            </div>
        </h3>
    </div>
    <div class="panel-body">
        <?php if ( Yii::app()->user->hasFlash('warning') ): ?>
            <?= BsHtml::blockAlert(BsHtml::TEXT_COLOR_WARNING, Yii::app()->user->getFlash('warning')) ?>
        <?php endif; ?>
        <?= BsHtml::blockAlert(BsHtml::TEXT_COLOR_INFO, 'При нажатии на кнопку "В черный список" - объект удаляется, номер арендатора добавляется в черный список, удаляются все новые и актуальные объекты с этим же номером телефона.'
                . '<br />При редактировании объявления - вы будете назначены его менеджером.') ?>
        <div class="info_block">
            <?php $this->widget('zii.widgets.CDetailView',array(
                'htmlOptions' => array(
                    'class' => 'table table-striped table-condensed table-hover',
                ),
                'data'=>$model,
                'attributes'=>array(
                    array(
                        'name'=>'status',
                        'value'=>$model->_status,
                    ),
                    array(
                        'name'=>'date_create',
                        'value'=>Yii::app()->dateFormatter->format('dd.MM.yyyy', $model->date_create),
                    ),
                    array(
                        'name'=>'date_update',
                        'value'=>Yii::app()->dateFormatter->format('dd.MM.yyyy', $model->date_update),
                    ),
                    array(
                        'name'=>'user_id',
                        'value'=>CHtml::link($model->user->name, array('/admin/user/view', 'id'=>$model->user_id), array('target'=>'_blank')),
                        'type'=>'raw',
                    ),
                    array(
                        'name'=>'date_admin',
                        'value'=>Yii::app()->dateFormatter->format('dd.MM.yyyy', $model->date_admin),
                    ),
                    array(
                        'name'=>'origin',
                        'value'=>$model->_origin,
                        'visible'=>Yii::app()->user->checkAccess('1'),
                    ),
                    array(
                        'name'=>'board_id',
                        'value'=>$model->board->name,
                        'visible'=>( $model->origin==2 && Yii::app()->user->checkAccess('1') ),
                    ),
                    array(
                        'name'=>'url',
                        'value'=>CHtml::link($model->url, $model->url, array('target'=>'_blank')),
                        'type'=>'raw',
                    ),
                ),
            )); ?>
        </div>
        
        <div class="info_block">
            <legend>
                Информация об арендателе
            </legend>
            <?php $this->widget('zii.widgets.CDetailView',array(
                'htmlOptions' => array(
                    'class' => 'table table-striped table-condensed table-hover',
                ),
                'data'=>$model,
                'attributes'=>array(
                    'name',
                    array(
                        'name'=>'male',
                        'value'=>$model->_male,
                    ),
                    array(
                        'name'=>'phone',
                        'value'=>(strlen($model->phone)!=0)?('+7'.$model->phone):'<span class="null">Не задан</span>',
                        'type'=>'raw',
                    ),
                    array(
                        'name'=>'phone2',
                        'value'=>(strlen($model->phone2)!=0)?'+7'.$model->phone2:'<span class="null">Не задан</span>',
                        'type'=>'raw',
                    ),
                    array(
                        'name'=>'coop',
                        'value'=>($model->coop)?'да':'нет',
                    ),
                ),
            )); ?>
        </div>
        
        <div class="info_block">
            <legend>
                Расположение объекта
            </legend>
            <?php $this->widget('zii.widgets.CDetailView',array(
                'htmlOptions' => array(
                    'class' => 'table table-striped table-condensed table-hover',
                ),
                'data'=>$model,
                'attributes'=>array(
                    array(
                        'name'=>'area_id',
                        'value'=>$model->area->name,
                    ),
                    'street',
                    'house',
                    'apartment',
                ),
            )); ?>
        </div>
        
        <div class="info_block">
            <legend>
                Описание объекта
            </legend>
            <?php $this->widget('zii.widgets.CDetailView',array(
                'htmlOptions' => array(
                    'class' => 'table table-striped table-condensed table-hover',
                ),
                'data'=>$model,
                'attributes'=>array(
                    array(
                        'name'=>'type_id',
                        'value'=>$model->objectType->name,
                    ),
                    array(
                        'name'=>'price',
                        'value'=>$model->price,
                    ),
                    array(
                        'name'=>'repair',
                        'value'=>$model->_repair,
                    ),
                    array(
                        'name'=>'furniture',
                        'value'=>($model->furniture)?'да':'нет',
                    ),
                    array(
                        'name'=>'daily',
                        'value'=>($model->daily)?'да':'нет',
                    ),
                    'desc',
                    array(
                        'name'=>'_img[]',
                        'value'=>$model->_images,
                        'type'=>'raw',
                    ),
                    array(
                        'label'=>'Освободится',
                        'value'=>Yii::app()->dateFormatter->format('dd.MM.yyyy', $model->free_date),
                        'visible'=>$model->free,
                    ),
                    array(
                        'label'=>'Показ',
                        'value'=>Yii::app()->dateFormatter->format('dd.MM.yyyy', $model->show_date).' '.$model->_show_type,
                        'visible'=>$model->show,
                    ),
                ),
            )); ?>
        </div>
    </div>
</div>