<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">
            <div>
                <?= BsHtml::linkButton('Логи авторизаций', array(
                    'color' => BsHtml::BUTTON_COLOR_DEFAULT,
                    'style' => 'float: left;',
                    'url' => array('/admin/user/log_auth', 'id'=>$model->id),
                )); ?>
                <!-- -->
                <?= BsHtml::linkButton('Мой профиль', array(
                    'color' => BsHtml::BUTTON_COLOR_SUCCESS,
                    'style' => 'float: right;',
                    'url' => array('/admin/user/view', 'id'=>$model->id),
                )); ?>
                <div class="clear"></div>
            </div>
        </h3>
    </div>
    <div class="panel-body">

        <?php $form=$this->beginWidget('bootstrap.widgets.BsActiveForm', array(
            'id'=>'user-form',
            'enableAjaxValidation'=>false,
            'layout' => BsHtml::FORM_LAYOUT_HORIZONTAL,
        )); ?>

            <?//= BsHtml::alert(BsHtml::ALERT_COLOR_INFO, ''); ?>

            <?= $form->errorSummary($model); ?>
            
            <?php echo $form->textFieldControlGroup($model,'password',array(
                'maxlength'=>32,
                'help'=>'Вводите пароль только если хотите его изменить.',
            )); ?>

            <?php echo $form->textFieldControlGroup($model,'name',array(
                'maxlength'=>128,
            )); ?>
            <?php echo $form->textFieldControlGroup($model,'phone',array(
                'maxlength'=>10,
                'prepend' => '+7',
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

            <div class="form-actions">
                <?php echo BsHtml::resetButton('Сброс', array(
                    'color' => BsHtml::BUTTON_COLOR_WARNING,
                    'icon' => BsHtml::GLYPHICON_REFRESH,
                )); ?>
                <?php echo BsHtml::submitButton('Готово', array(
                    'color' => BsHtml::BUTTON_COLOR_SUCCESS,
                    'icon' => BsHtml::GLYPHICON_OK,
                )); ?>
            </div>

        <?php $this->endWidget(); ?>
        
    </div>
</div>