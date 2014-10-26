<div class="panel panel-default panel-special">
    <div class="panel-heading">
        <h3 class="panel-title" style="text-align: right;">
            <?/*= BsHtml::button('Кнопка', array(
                'class' =>'search-button',
                'icon' => BsHtml::GLYPHICON_FILTER,
                'color' => BsHtml::BUTTON_COLOR_SUCCESS
            ), '#');*/ ?>
        </h3>
    </div>
    <div class="panel-body">
        <?php $this->renderPartial('_form', array('model'=>$model)); ?>
    </div>
</div>