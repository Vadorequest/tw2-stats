<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form BSActiveForm */
?>

<?php $form=$this->beginWidget('bootstrap.widgets.BsActiveForm', array(
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
    'layout' => BsHtml::FORM_LAYOUT_HORIZONTAL,
)); ?>

    <?= $form->dropDownListControlGroup($model,'office_id', Office::model()->_dropDownList, array('controlOptions' => array(
        'class' => 'col-lg-4',
    ))); ?>

    <div class="form-actions" style="display: none;">
        <?php echo BsHtml::submitButton('Search',  array('color' => BsHtml::BUTTON_COLOR_PRIMARY,));?>
    </div>

<?php $this->endWidget(); ?>
