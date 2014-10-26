<?php $form=$this->beginWidget('bootstrap.widgets.BsActiveForm', array(
    'id'=>'office-form',
    'enableAjaxValidation'=>false,
    'layout' => BsHtml::FORM_LAYOUT_HORIZONTAL,
)); ?>

    <?//= BsHtml::alert(BsHtml::ALERT_COLOR_INFO, ''); ?>
    
    <?= $form->errorSummary($model); ?>

    <?php echo $form->textAreaControlGroup($model,'address',array('rows'=>6)); ?>
    <?php echo $form->textFieldControlGroup($model,'phone',array(
        'maxlength'=>10,
        'prepend' => '+7',
    )); ?>

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
