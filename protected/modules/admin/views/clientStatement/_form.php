<?php $form=$this->beginWidget('bootstrap.widgets.BsActiveForm', array(
    'id'=>'clientStatement-form',
    'enableAjaxValidation'=>false,
    'layout' => BsHtml::FORM_LAYOUT_HORIZONTAL,
)); ?>

    <?//= BsHtml::alert(BsHtml::ALERT_COLOR_INFO, ''); ?>
    
    <?= $form->errorSummary($model); ?>

    <?php echo $form->textFieldControlGroup($model,'client_id'); ?>
    <?php echo $form->textFieldControlGroup($model,'date_create'); ?>
    <?php echo $form->textFieldControlGroup($model,'user_id'); ?>
    <?php echo $form->textFieldControlGroup($model,'admin_id'); ?>
    <?php echo $form->textAreaControlGroup($model,'text',array('rows'=>6)); ?>
    <?php echo $form->textFieldControlGroup($model,'file',array('maxlength'=>32)); ?>
    <?php echo $form->textFieldControlGroup($model,'date_admin'); ?>
    <?php echo $form->textFieldControlGroup($model,'status'); ?>

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
