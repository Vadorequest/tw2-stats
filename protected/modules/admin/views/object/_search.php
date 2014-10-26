<?php $form=$this->beginWidget('bootstrap.widgets.BsActiveForm', array(
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
    'layout' => BsHtml::FORM_LAYOUT_HORIZONTAL,
)); ?>

    <div class="form-group">
        <div class="col-lg-6">
            <div class="form-group">
                <label class="control-label col-lg-3">Цена</label>
                <div class="col-lg-9">
                    от <?= BsHtml::textField('price_from', '', array('class'=>'mini_input')) ?>
                    до <?= BsHtml::textField('price_to', '', array('class'=>'mini_input')) ?>
                </div>
            </div>
            
            <?= $form->radioButtonListControlGroup($model,'rented', array(
                '1'=>'да',
                '0'=>'нет',
                ''=>'неважно',
            ), array(
                'groupOptions'=>array('class'=>'group_list group_list2'),
                'labelOptions'=>array('class'=>'col-lg-3'),
            )); ?>
            
            <?= $form->radioButtonListControlGroup($model,'coop', array(
                '1'=>'да',
                '0'=>'нет',
                ''=>'неважно',
            ), array(
                'groupOptions'=>array('class'=>'group_list group_list2'),
                'labelOptions'=>array('class'=>'col-lg-3'),
            )); ?>
            
            <?= $form->radioButtonListControlGroup($model,'furniture', array(
                '1'=>'да',
                '0'=>'нет',
                ''=>'неважно',
            ), array(
                'groupOptions'=>array('class'=>'group_list group_list2'),
                'labelOptions'=>array('class'=>'col-lg-3'),
            )); ?>
            
            <?= $form->radioButtonListControlGroup($model,'repair', array(
                '0'=>'обычный',
                '1'=>'евро',
                '2'=>'черновой',
                ''=>'неважно',
            ), array(
                'groupOptions'=>array('class'=>'group_list group_list2'),
                'labelOptions'=>array('class'=>'col-lg-3'),
            )); ?>
            
            <?= $form->radioButtonListControlGroup($model,'show', array(
                '1'=>'да',
                '0'=>'нет',
                ''=>'неважно',
            ), array(
                'groupOptions'=>array('class'=>'group_list group_list2'),
                'labelOptions'=>array('class'=>'col-lg-3'),
            )); ?>
            
            <?= $form->dropDownListControlGroup($model,'user_id', User::model()->_dropDownList/*Managers*/, array(
                'groupOptions'=>array('class'=>'group_list group_list2'),
                'labelOptions'=>array('class'=>'col-lg-3'),
            )); ?>
            
            <?= $form->textFieldControlGroup($model,'id', array(
                'groupOptions'=>array('class'=>'group_list group_list2'),
                'labelOptions'=>array('class'=>'col-lg-3'),
                'class'=>'mini_input',
            )); ?>
            
            <?= $form->textFieldControlGroup($model,'phone', array(
                'groupOptions'=>array('class'=>'group_list group_list2'),
                'labelOptions'=>array('class'=>'col-lg-3'),
                'class'=>'mini_input',
            )); ?>
            
            <!--div class="form-group">
                <label class="control-label col-lg-3">Дата</label>
                <div class="col-lg-9">
                    с <?= BsHtml::textField('date_from', '', array('class'=>'mini_input')) ?>
                    по <?= BsHtml::textField('date_to', '', array('class'=>'mini_input')) ?>
                </div>
            </div-->
            
        </div>
        
        <div class="col-lg-6">
            <?= $form->/*dropDownListControlGroup*/inlineCheckBoxListControlGroup($model,'type_id', ObjectType::model()->_dropDownList2, array(
                'groupOptions'=>array('class'=>'group_list group_list2'),
                'labelOptions'=>array('class'=>'col-lg-3'),
                //'multiple'=>true,
            )); ?>
            
            <?= $form->inlineCheckBoxListControlGroup($model,'area_id', Area::model()->_dropDownList2, array(
                'groupOptions'=>array('class'=>'group_list group_list2'),
                'labelOptions'=>array('class'=>'col-lg-3'),
            )); ?>
            
            <?= $form->textFieldControlGroup($model,'street', array(
                'groupOptions'=>array('class'=>'group_list group_list2'),
                'labelOptions'=>array('class'=>'col-lg-3'),
            )); ?>
            
            <?= $form->textFieldControlGroup($model,'house', array(
                'groupOptions'=>array('class'=>'group_list group_list2'),
                'labelOptions'=>array('class'=>'col-lg-3'),
            )); ?>
            
            <?= $form->textFieldControlGroup($model,'name', array(
                'groupOptions'=>array('class'=>'group_list group_list2'),
                'labelOptions'=>array('class'=>'col-lg-3'),
            )); ?>
        </div>
    </div>

    <?= BsHtml::formActions(array(
        BsHtml::submitButton('Сохранить фильтр', array(
            'color' => BsHtml::BUTTON_COLOR_SUCCESS,
            'icon' => BsHtml::GLYPHICON_SEARCH,
        )),
    ), array('class'=>'form-actions2')); ?>

<?php $this->endWidget(); ?>
