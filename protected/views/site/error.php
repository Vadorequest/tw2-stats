<?php $this->beginWidget('bootstrap.widgets.BsPanel', array(
    'title' => 'Error '.$code,
)); ?>

    <?= CHtml::encode($message); ?>

<?php $this->endWidget(); ?>