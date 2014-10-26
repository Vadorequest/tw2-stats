<?php $form=$this->beginWidget('bootstrap.widgets.BsActiveForm', array(
    'id'=>'review-form',
    'enableAjaxValidation'=>false,
    'layout' => BsHtml::FORM_LAYOUT_HORIZONTAL,
)); ?>

    <?//= BsHtml::alert(BsHtml::ALERT_COLOR_INFO, ''); ?>
    
    <?= $form->errorSummary($model); ?>

    <?php echo $form->textFieldControlGroup($model,'date',array('maxlength'=>11)); ?>
    <?php echo $form->textAreaControlGroup($model,'text'); ?>
    <?php echo $form->textFieldControlGroup($model,'user_id',array('maxlength'=>11)); ?>

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
