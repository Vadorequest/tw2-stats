<script>
    $(document).ready(function(){
        $('label[for="User_ip"]').html('IP <span class="required">*</span>');
        $('#User_check_ip').change(function(){
            if ( $(this).is(':checked') ) {
                $('#row_ip').show();
                $('#User_ip').attr('required', 'required');
            } else {
                $('#row_ip').hide();
                $('#User_ip').removeAttr('required');
            }
        });
        $('#User_type').change(function(){
            if ( $(this).val()=='4' ) {
                $('#row_manager_id').show();
                $('#User_manager_id').attr('required', 'required');
            } else {
                $('#row_manager_id').hide();
                $('#User_manager_id').removeAttr('required');
            }
        });
        
        //
        if ( $('#User_check_ip').is(':checked') ) {
            $('#row_ip').show();
            $('#User_ip').attr('required', 'required');
        }
        if ( $('#User_type').val()=='4' ) {
            $('#row_manager_id').show();
            $('#User_manager_id').attr('required', 'required');
        }
            
    });
</script>

<?php $form=$this->beginWidget('bootstrap.widgets.BsActiveForm', array(
    'id'=>'user-form',
    'enableAjaxValidation'=>false,
    'layout' => BsHtml::FORM_LAYOUT_HORIZONTAL,
)); ?>

    <?//= BsHtml::alert(BsHtml::ALERT_COLOR_INFO, ''); ?>
    
    <?= $form->errorSummary($model); ?>

    <?php echo $form->dropDownListControlGroup($model,'office_id', Office::model()->_dropDownList); ?>
    
    <?php echo $form->textFieldControlGroup($model,'login',array(
        'maxlength'=>32,
    )); ?>
    <?php if ( $model->isNewRecord ): ?>
        <?php echo $form->textFieldControlGroup($model,'password',array(
            'maxlength'=>32,
        )); ?>
    <?php else: ?>
        <?php echo $form->textFieldControlGroup($model,'password',array(
            'maxlength'=>32,
            'help'=>'Вводите пароль только если хотите его изменить.',
        )); ?>
    <?php endif; ?>
    <?php echo $form->dropDownListControlGroup($model,'type', array(
        '1'=>'Директор',
        '2'=>'Управляющий',
        '3'=>'Менеджер',
        '4'=>'Стажер',
    )); ?>
    
    <?php echo $form->dropDownListControlGroup($model,'manager_id', User::model()->_dropDownListManagers, array(
        'groupOptions'=>array('id'=>'row_manager_id', 'style'=>'display: none;'),
    )); ?>
    
    <?php echo $form->textFieldControlGroup($model,'name',array(
        'maxlength'=>128,
    )); ?>
    <?php echo $form->textFieldControlGroup($model,'phone',array(
        'maxlength'=>10,
        'prepend' => '+7',
    )); ?>
    <?php echo $form->textFieldControlGroup($model,'icq',array(
        'maxlength'=>14,
    )); ?>
    
    <?php echo $form->checkBoxControlGroup($model,'check_ip'); ?>
    <?php echo $form->textFieldControlGroup($model,'ip',array(
        'maxlength'=>16,
        'groupOptions'=>array('id'=>'row_ip', 'style'=>'display: none;'),
    )); ?>
    <?php echo $form->textAreaControlGroup($model,'parents',array('rows'=>6)); ?>
    <?php echo $form->textAreaControlGroup($model,'info',array('rows'=>6)); ?>
    <?php echo $form->textFieldControlGroup($model,'pasport_series',array('maxlength'=>4)); ?>
    <?php echo $form->textFieldControlGroup($model,'pasport_num',array('maxlength'=>6)); ?>
    
    <div class="form-group">
        <?= $form->labelEx($model, 'pasport_date', array('class'=>'control-label col-lg-2')); ?>
        <div class="col-lg-10">
            <?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                'model'=>$model,
                'attribute'=>'pasport_date',
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
                    'placeHolder'=>'Паспорт, дата выдачи',
                ),
            )); ?>
            <?= $form->error($model, 'pasport_date') ?>
        </div>
    </div>
    
    <?php echo $form->textAreaControlGroup($model,'pasport_place',array('rows'=>6)); ?>
    
    <?php echo $form->fileFieldControlGroup($model,'_img'); ?>
    
    <div class="form-group">
        <?= $form->labelEx($model, 'birthday_date', array('class'=>'control-label col-lg-2')); ?>
        <div class="col-lg-10">
            <?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                'model'=>$model,
                'attribute'=>'birthday_date',
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
                    'placeHolder'=>'Дата рождения',
                ),
            )); ?>
            <?= $form->error($model, 'birthday_date') ?>
        </div>
    </div>

    <?php echo $form->textAreaControlGroup($model,'birthday_place',array('rows'=>6)); ?>

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