<?php $form=$this->beginWidget('bootstrap.widgets.BsActiveForm', array(
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
    'layout' => BsHtml::FORM_LAYOUT_HORIZONTAL,
)); ?>

    <div class="form-group">
        <div class="col-lg-6">
            <?= $form->textFieldControlGroup($model,'id', array(
                'groupOptions'=>array('class'=>'group_list group_list2'),
                'labelOptions'=>array('class'=>'col-lg-3'),
            )); ?>
            <?= $form->textFieldControlGroup($model,'phone', array(
                'groupOptions'=>array('class'=>'group_list group_list2'),
                'labelOptions'=>array('class'=>'col-lg-3'),
            )); ?>
            <?= $form->textFieldControlGroup($model,'fio', array(
                'groupOptions'=>array('class'=>'group_list group_list2'),
                'labelOptions'=>array('class'=>'col-lg-3'),
            )); ?>
            <?= $form->textFieldControlGroup($model,'contract', array(
                'groupOptions'=>array('class'=>'group_list group_list2'),
                'labelOptions'=>array('class'=>'col-lg-3'),
            )); ?>
            
        </div>
        
        <div class="col-lg-6">
            <?= $form->radioButtonListControlGroup($model,'populated', array(
                '1'=>'да',
                '0'=>'нет',
                '2'=>'через нас',
                ''=>'неважно',
            ), array(
                'groupOptions'=>array('class'=>'group_list group_list2'),
                'labelOptions'=>array('class'=>'col-lg-3'),
            )); ?>
            <?= $form->radioButtonListControlGroup($model,'problem', array(
                '1'=>'да',
                '0'=>'нет',
                ''=>'неважно',
            ), array(
                'groupOptions'=>array('class'=>'group_list group_list2'),
                'labelOptions'=>array('class'=>'col-lg-3'),
            )); ?>
            <?= $form->radioButtonListControlGroup($model,'origin', array(
                '0'=>'вручную',
                '1'=>'с сайта',
                '2'=>'с доски объявлений',
                ''=>'неважно',
            ), array(
                'groupOptions'=>array('class'=>'group_list group_list2'),
                'labelOptions'=>array('class'=>'col-lg-3'),
            )); ?>
            <?= $form->dropDownListControlGroup($model,'user_id', User::model()->_dropDownList/*Managers*/, array(
                'groupOptions'=>array('class'=>'group_list group_list2'),
                'labelOptions'=>array('class'=>'col-lg-3'),
            )); ?>
            <?/*= $form->dropDownListControlGroup($model,'objectType', ObjectType::model()->_dropDownList, array(
                'groupOptions'=>array('class'=>'group_list group_list2'),
                'labelOptions'=>array('class'=>'col-lg-3'),
            )); */?>
            <?/*= $form->dropDownListControlGroup($model,'areas', Area::model()->_dropDownList, array(
                'groupOptions'=>array('class'=>'group_list group_list2'),
                'labelOptions'=>array('class'=>'col-lg-3'),
            )); */?>
        </div>
    </div>

    <div class="form-actions" style="display: none;">
        <?php echo BsHtml::submitButton('Search',  array('color' => BsHtml::BUTTON_COLOR_PRIMARY,));?>
    </div>

<?php $this->endWidget(); ?>
