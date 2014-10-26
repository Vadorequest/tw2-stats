<div class="panel panel-default panel-special">
    <div class="panel-heading">
        <h3 class="panel-title" style="text-align: right;">
            <?= BsHtml::beginForm(null, 'GET', array(
                'class'=>'form-inline',
            )) ?>
                <div class="form-group">
                    <?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                        'name'=>'date_from',
                        'value'=>$_GET['date_from'],
                        'options'=>array(
                            'showAnim'=>'fold',
                            'changeMonth'=> true,
                            'changeYear'=> true,
                            'showButtonPanel'=> false,
                            'yearRange'=> '-10:+0',
                            'dateFormat'=>'dd.mm.yy',
                        ),
                        'language'=>'ru',
                        'htmlOptions'=>array(
                            'class'=>'form-control',
                            'placeHolder'=>'Дата, с',
                        ),
                    )); ?>
                </div>
                -
                <div class="form-group">
                    <?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                        'name'=>'date_to',
                        'value'=>$_GET['date_to'],
                        'options'=>array(
                            'showAnim'=>'fold',
                            'changeMonth'=> true,
                            'changeYear'=> true,
                            'showButtonPanel'=> false,
                            'yearRange'=> '-10:+0',
                            'dateFormat'=>'dd.mm.yy',
                        ),
                        'language'=>'ru',
                        'htmlOptions'=>array(
                            'class'=>'form-control',
                            'placeHolder'=>'Дата, до',
                        ),
                    )); ?>
                </div>
                <?= BsHtml::submitButton('Показать', array('color' => BsHtml::BUTTON_COLOR_SUCCESS, 'name'=>'')) ?>
            <?= BsHtml::endForm() ?>
        </h3>
    </div>
    <div class="panel-body">
        
        <?= BsHtml::blockAlert(BsHtml::TEXT_COLOR_INFO, 'Информация за выбранный интервал <i>(по-умолчанию, за сегодня)</i>:<ul>'
                . '<li><strong>Новые клиенты</strong> - кол-во клиентов, созданных пользователем <i>(после 07.07.2014)</i></li>'
                . '<li><strong>Обработка потенциального клиента</strong> - кол-во прозвоненных потенциальных клиентов (в результате чего была назначена встреча, перезвонить позже или передан на обработку)</li>'
                . '<li><strong>Актуальные клиенты</strong> - кол-во клиентов, которым был задан статус "актуальный" этим пользователем</li>'
                . '<li><strong>Новые объекты</strong> - кол-во объектов, созданных пользователем <i>(после 07.07.2014)</i></li>'
                . '<li><strong>Актуальные объекты</strong> - кол-во объектов, которым был задан статус "актуальный" этим пользователем</li>'
                . '<li><strong>Удаленные объекты</strong> - кол-во объектов, удаленных пользователем</li>'
                . '<li><strong>Архив объектов</strong> - кол-во объектов, отправленных в архив</li>'
                . '<li><strong>Черный список</strong> - кол-во добавленных в черный список номеров</li>'
                . '</ul>') ?>
        
        <?php $this->widget('bootstrap.widgets.BsGridView',array(
            'id'=>'user-grid',
            'dataProvider'=>$model->search(),
            'type' => BsHtml::GRID_TYPE_HOVER,
            'template' => '{summary}{items}{pager}',
            'pagerCssClass'=>'pagination pagination-right',
            'columns'=>array(
                array(
                    'name'=>'name',
                    'value'=>'CHtml::link($data->name, array("/admin/user/view", "id"=>$data->id), array("target"=>"_blank"))',
                    'type'=>'raw',
                ),
                
                array(
                    'header'=>'Новые клиенты',
                    'value'=>'$data->_stat_clientCreate',
                ),
                array(
                    'header'=>'Обработка потенциального клиента',
                    'value'=>'$data->_stat_clientResult',
                ),
                array(
                    'header'=>'Актуальные клиенты',
                    'value'=>'"<strong>".$data->_stat_clientAdmin."</strong>"',
                    'type'=>'raw',
                ),
                
                array(
                    'header'=>'Новые объекты',
                    'value'=>'$data->_stat_objectCreate',
                ),
                array(
                    'header'=>'Актуальные объекты',
                    'value'=>'"<strong>".$data->_stat_objectAdmin."</strong>"',
                    'type'=>'raw',
                ),
                array(
                    'header'=>'Удаленные объекты',
                    'value'=>'$data->_stat_objectDelete',
                ),
                array(
                    'header'=>'Архив объектов',
                    'value'=>'$data->_stat_objectArch',
                ),
                
                array(
                    'header'=>'Черный список',
                    'value'=>'$data->_stat_blackList',
                ),
            ),
        )); ?>
        
    </div>
</div>