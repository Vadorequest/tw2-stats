<script>
    $(document).ready(function(){
        $('#Client_result').change(function(){
            $('.with_result').hide();
            if ( $(this).val()=='1' ) {
                $('.with_result_1').show();
            }
            if ( $(this).val()=='2' ) {
                $('.with_result_2').show();
            }
        });
        
        $('#Client_status').change(function(){
            $('.with_status').hide();
            if ( $(this).val()=='0' ) {
                $('.with_status_0').show();
            } else {
                $('.with_status_0_not').show();
            }
        });
        
        <?php if ( $model->result==1 ): ?>
            $('.with_result_1').show();
        <?php endif; ?>
            
        <?php if ( $model->result==2 ): ?>
            $('.with_result_2').show();
        <?php endif; ?>
            
        <?php if ( $model->status!=0 ): ?>
            $('.with_status_0_not').show();
        <?php else: ?>
            $('.with_status_0').show();
        <?php endif; ?>
    });
</script>

<?php $form=$this->beginWidget('bootstrap.widgets.BsActiveForm', array(
    'id'=>'client-form',
    'enableAjaxValidation'=>false,
    'layout' => BsHtml::FORM_LAYOUT_HORIZONTAL,
)); ?>

    <?//= BsHtml::alert(BsHtml::ALERT_COLOR_INFO, ''); ?>
    
    <?= $form->errorSummary($model); ?>

    <div class="form_block">
        <?= $form->textFieldControlGroup($model,'fio',array('maxlength'=>256)); ?>
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
    </div>
    
    <div class="form_block">
        <?php echo $form->dropDownListControlGroup($model,'status', array(
            '0'=>'потенциальный',
            '1'=>'проверенный',
            '2'=>'архив',
        )); ?>
        
        <div class="with_status with_status_0" style="display: none;">
            <?php echo $form->dropDownListControlGroup($model,'result', array(
                ''=>'-',
                //'0'=>'оплата через сайт',
                '1'=>'назначена встреча',
                '2'=>'перезвонить позже',
                '3'=>'передать на доработку',
            ), array(
                'help'=>'Выберите, если потенциальный клиент обработан',
            )); ?>
            <div class="form-group with_result with_result_1" style="display: none;">
                <?= $form->labelEx($model, 'date_meet', array('class'=>'control-label col-lg-2')); ?>
                <div class="col-lg-2">
                    <?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                        'model'=>$model,
                        'attribute'=>'date_meet',
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
            <div class="form-group with_result with_result_2" style="display: none;">
                <?= $form->labelEx($model, 'date_call', array('class'=>'control-label col-lg-2')); ?>
                <div class="col-lg-2">
                    <?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                        'model'=>$model,
                        'attribute'=>'date_call',
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
        </div>
        
        <div class="with_status with_status_0_not" style="display: none;">
            <?= $form->dropDownListControlGroup($model,'tariff_id', Tariff::model()->_dropDownList); ?>
            <div class="form-group">
                <?= $form->labelEx($model, 'cash', array('class'=>'control-label col-lg-2')); ?>
                <div class="col-lg-10">
                    <span id="Client_cash">
                        <div class="checkbox">
                            <label>
                                <?= BsHtml::activeCheckBox($model, 'cash', array('id'=>'Client_cash_0')) ?>
                            </label>
                        </div>
                    </span>
                </div>
            </div>
            <?= $form->textFieldControlGroup($model,'sum'); ?>
            <?= $form->textFieldControlGroup($model,'contract',array('maxlength'=>32)); ?>
        </div>
    
        <?= $form->dropDownListControlGroup($model,'user_id', User::model()->_dropDownList); ?>
    </div>
    
    <div class="form_block">
        <?= $form->textFieldControlGroup($model,'price'); ?>
        <div class="form-group">
                <?= $form->labelEx($model, 'daily', array('class'=>'control-label col-lg-2')); ?>
                <div class="col-lg-10">
                    <span id="Client_daily">
                        <div class="checkbox">
                            <label>
                                <?= BsHtml::activeCheckBox($model, 'daily', array('id'=>'Client_daily_0')) ?>
                            </label>
                        </div>
                    </span>
                </div>
            </div>
        <div class="form-group">
            <?= $form->labelEx($model, 'realtor', array('class'=>'control-label col-lg-2')); ?>
            <div class="col-lg-10">
                <span id="Client_realtor">
                    <div class="checkbox">
                        <label>
                            <?= BsHtml::activeCheckBox($model, 'realtor', array('id'=>'Client_realtor_0')) ?>
                        </label>
                    </div>
                </span>
            </div>
        </div>
        <?= $form->inlineCheckBoxListControlGroup($model,'areas', Area::model()->_dropDownList2, array(
            'groupOptions'=>array('class'=>'group_list'),
        )); ?>
        <?= $form->inlineCheckBoxListControlGroup($model,'objectTypes', ObjectType::model()->_dropDownList2, array(
            'groupOptions'=>array('class'=>'group_list'),
        )); ?>
    </div>
    
    <div class="form_block">
        <div class="form-group">
            <?= $form->labelEx($model, 'problem', array('class'=>'control-label col-lg-2')); ?>
            <div class="col-lg-10">
                <span id="Client_problem">
                    <div class="checkbox">
                        <label>
                            <?= BsHtml::activeCheckBox($model, 'problem', array('id'=>'Client_problem_0')) ?>
                        </label>
                    </div>
                </span>
            </div>
        </div>
        <?= $form->radioButtonListControlGroup($model,'populated', array(
            '0'=>'не заселен',
            '1'=>'заселен',
            '2'=>'заселен через нас',
        ), array(
            'groupOptions'=>array('class'=>'group_list'),
        )); ?>
    </div>
    
    <div class="form_block">
        <?= $form->textAreaControlGroup($model,'desc'); ?>
    </div>
    
    <div class="form_block">
        <legend>
            Предоставление доступа
        </legend>
        <?php if ( $model->_user_id===null ): ?>
            <?= BsHtml::blockAlert(BsHtml::TEXT_COLOR_INFO, 'Для предоставления доступа к базе придумайте клиенту логин и пароль.') ?>
            <div class="form-group">
                <label class="control-label col-lg-2" for="_login">Логин</label>
                <div class="col-lg-10">
                    <input maxlength="32" name="_login" id="_login" class="form-control" placeholder="Логин" type="text" />
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-lg-2" for="_password">Пароль</label>
                <div class="col-lg-10">
                    <input maxlength="32" name="_password" id="_password" class="form-control" placeholder="Пароль" type="text" />
                </div>
            </div>
        <?php else: ?>
            <?= BsHtml::blockAlert(BsHtml::TEXT_COLOR_INFO, 'Этому клиенту уже предоставлен доступ. Вы можете изменить пароль или закрыть доступ.') ?>
            <div class="form-group">
                <label class="control-label col-lg-2" for="_login">Логин</label>
                <div class="col-lg-10">
                    <input maxlength="32" name="_login" id="_login" class="form-control" value="<?= $model->_user->login ?>" placeholder="Логин" type="text" disabled="disabled" />
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-lg-2" for="_password">Пароль</label>
                <div class="col-lg-10">
                    <input maxlength="32" name="_password" id="_password" class="form-control" placeholder="Пароль" type="text" />
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-lg-2" for="_cancelAccess">Отменить доступ</label>
                <div class="col-lg-10">
                    <span>
                        <div class="checkbox">
                            <label>
                                <input id="_cancelAccess" name="_cancelAccess" value="1" type="checkbox">
                                <p class="help-block">Поставьте галочку и сохраните изменения, чтобы закрыть доступ этому клиенту.</p>
                            </label>
                        </div>
                    </span>
                </div>
            </div>
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
