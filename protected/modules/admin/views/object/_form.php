<script>
    $(document).ready(function(){
        
        $('#Object_show_0').change(function(){
            if ( $(this).prop('checked') ) {
                $('.with_show').show();
            } else {
                $('.with_show').hide();
            }
        });
         
        $('#Object_free_0').change(function(){
            if ( $(this).prop('checked') ) {
                $('.with_free').show();
            } else {
                $('.with_free').hide();
            }
        });
        
        <?php if ( $model->show ): ?>
            $('.with_show').show();
        <?php endif; ?>
            
        <?php if ( $model->free ): ?>
            $('.with_free').show();
        <?php endif; ?>
        
    });
</script>

<?php $form=$this->beginWidget('bootstrap.widgets.BsActiveForm', array(
    'id'=>'object-form',
    'enableAjaxValidation'=>false,
    'layout' => BsHtml::FORM_LAYOUT_HORIZONTAL,
    'htmlOptions'=>array(
        'enctype'=>'multipart/form-data',
    ),
)); ?>

    <?php if ( Yii::app()->user->checkAccess('1') ): ?>
        <?= BsHtml::blockAlert(BsHtml::ALERT_COLOR_INFO, 'После редактирования объекта, вы будете назначены его менеджером.'
                . '<br />Вы можете назначить менеджера объекта вручную.'); ?>
    <?php else: ?>
        <?= BsHtml::blockAlert(BsHtml::ALERT_COLOR_INFO, 'После редактирования объекта, вы будете назначены его менеджером.'); ?>
    <?php endif; ?>
    
    
    <?= $form->errorSummary($model); ?>

    <div class="form_block">
        <legend>
            Информация об арендателе
        </legend>

        <?= $form->textFieldControlGroup($model,'name'); ?>
        <?= $form->radioButtonListControlGroup($model,'male', array(
            '1'=>'мужской',
            '0'=>'женский',
        ), array(
            'groupOptions'=>array('class'=>'group_list'),
        )); ?>
        <?= $form->textFieldControlGroup($model,'phone',array(
            'maxlength'=>10,
            'prepend' => '+7',
        )); ?>
        <?= $form->textFieldControlGroup($model,'phone2',array(
            'maxlength'=>10,
            'prepend' => '+7',
        )); ?>
        <?= $form->radioButtonListControlGroup($model,'coop', array(
            '0'=>'нет',
            '1'=>'да',
        ), array(
            'groupOptions'=>array('class'=>'group_list'),
        )); ?>
    </div>
    
    
    <div class="form_block">
        <legend>
            Расположение объекта
        </legend>
        
        <?= $form->dropDownListControlGroup($model,'area_id', Area::model()->_dropDownList); ?>
        <?= $form->textFieldControlGroup($model,'street',array('maxlength'=>255)); ?>
        <?= $form->textFieldControlGroup($model,'house',array('maxlength'=>8)); ?>
        <?= $form->textFieldControlGroup($model,'apartment',array('maxlength'=>8)); ?>
    </div>
    
    
    <div class="form_block">
        <legend>
            Описание объекта
        </legend>
        
        <?= $form->dropDownListControlGroup($model,'type_id', ObjectType::model()->_dropDownList); ?>
        <?= $form->textFieldControlGroup($model,'price'); ?>
        <?= $form->radioButtonListControlGroup($model,'repair', array(
            '0'=>'обычный',
            '1'=>'евро',
            '2'=>'черновой',
        ), array(
            'groupOptions'=>array('class'=>'group_list'),
        )); ?>
        <?= $form->radioButtonListControlGroup($model,'furniture', array(
            '0'=>'нет',
            '1'=>'есть',
        ), array(
            'groupOptions'=>array('class'=>'group_list'),
        )); ?>
        <div class="form-group">
            <?= $form->labelEx($model, 'daily', array('class'=>'control-label col-lg-2')); ?>
            <div class="col-lg-10">
                <span id="Object_daily">
                    <div class="checkbox">
                        <label>
                            <?= BsHtml::activeCheckBox($model, 'daily', array('id'=>'Object_daily_0')) ?>
                        </label>
                    </div>
                </span>
            </div>
        </div>
        <?= $form->textAreaControlGroup($model,'desc',array('rows'=>6)); ?>
        
        <?= $form->fileFieldControlGroup($model,'_img[]',array(
            'help'=>'До 12 изображений любого размера.'.( (!$model->isNewRecord)?' Выбор новых изображений удалит текущие (кол-во: '.count($model->objectImage).').':'' ),
            'multiple'=>'multiple',
        )); ?>
        
        <div class="form-group">
            <?= $form->labelEx($model, 'free', array('class'=>'control-label col-lg-2')); ?>
            <div class="col-lg-10">
                <span id="Object_free">
                    <div class="checkbox">
                        <label>
                            <?= BsHtml::activeCheckBox($model, 'free', array('id'=>'Object_free_0')) ?>
                        </label>
                    </div>
                </span>
            </div>
        </div>
        <div class="form-group with_free" style="display: none;">
            <?= $form->labelEx($model, 'free_date', array('class'=>'control-label col-lg-2')); ?>
            <div class="col-lg-2">
                <?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                    'model'=>$model,
                    'attribute'=>'free_date',
                    'options'=>array(
                        'showAnim'=>'fold',
                        'changeMonth'=> true,
                        'changeYear'=> true,
                        'showButtonPanel'=> false,
                        'yearRange'=> '-80:+0',
                        'dateFormat'=>'dd.mm.yy',
                    ),
                    'language'=>'ru',
                    'htmlOptions'=>array(
                        'class'=>'form-control',
                        'placeHolder'=>'',
                    ),
                )); ?>
            </div>
        </div>
        
        <div class="form-group">
            <?= $form->labelEx($model, 'show', array('class'=>'control-label col-lg-2')); ?>
            <div class="col-lg-10">
                <span id="Object_show">
                    <div class="checkbox">
                        <label>
                            <?= BsHtml::activeCheckBox($model, 'show', array('id'=>'Object_show_0')) ?>
                        </label>
                    </div>
                </span>
            </div>
        </div>
        <div class="form-group with_show" style="display: none;">
            <?= $form->labelEx($model, 'show_date', array('class'=>'control-label col-lg-2')); ?>
            <div class="col-lg-2">
                <?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                    'model'=>$model,
                    'attribute'=>'show_date',
                    'options'=>array(
                        'showAnim'=>'fold',
                        'changeMonth'=> true,
                        'changeYear'=> true,
                        'showButtonPanel'=> false,
                        'yearRange'=> '-80:+0',
                        'dateFormat'=>'dd.mm.yy',
                    ),
                    'language'=>'ru',
                    'htmlOptions'=>array(
                        'class'=>'form-control',
                        'placeHolder'=>'',
                    ),
                )); ?>
            </div>
            <div class="col-lg-2">
                <?= $form->dropDownList($model, 'show_type', array(
                    ''=>'-',
                    '0'=>'утром',
                    '1'=>'в обед',
                    '2'=>'вечером',
                    '3'=>'по звонку',
                )) ?>
            </div>
        </div>
    </div>
    
    
    <div class="form_block">
        <?php echo $form->dropDownListControlGroup($model,'status', array(
            '0'=>'новый',
            '1'=>'актуальный',
            '2'=>'сдана/архив',
            '3'=>'удаленный',
            '4'=>'недозвониться',
        ), array('help'=>'Если вы проверили это объявление, то измените его статус.')); ?>
        <?php if ( Yii::app()->user->checkAccess('1') ): ?>
            <?= $form->dropDownListControlGroup($model,'user_id', User::model()->_dropDownList); ?>
        <?php endif; ?>
    </div>
    
    <?= BsHtml::formActions(array(
        BsHtml::resetButton('Сброс', array(
            'color' => BsHtml::BUTTON_COLOR_WARNING,
            'icon' => BsHtml::GLYPHICON_REFRESH,
        )),
        BsHtml::submitButton('Готово', array(
            'color' => BsHtml::BUTTON_COLOR_SUCCESS,
            'icon' => BsHtml::GLYPHICON_OK,
        )),
    ), array('class'=>'form-actions')); ?>
    

<?php $this->endWidget(); ?>
