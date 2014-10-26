<?php $form=$this->beginWidget('bootstrap.widgets.BsActiveForm', array(
    'id'=>'objectType-form',
    'enableAjaxValidation'=>false,
    'layout' => BsHtml::FORM_LAYOUT_HORIZONTAL,
)); ?>

    <?//= BsHtml::alert(BsHtml::ALERT_COLOR_INFO, ''); ?>
    
    <?= $form->errorSummary($model); ?>

    <?php echo $form->textFieldControlGroup($model,'name',array('maxlength'=>128)); ?>

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
