<script>

    $(document).ready(function(){
        $('#user-grid tr').each(function(){
            var sum = 0;
            $(this).find('.for_sum').each(function(){
                sum += $(this).find('span').text()*1 * $(this).find('font').text()*1;
            });
            $(this).find('.this_sum').text(sum);
        });
    });

</script>

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
                . '<li><strong>Потенциальных клиентов</strong> - кол-во потенциальных клиентов, закрепленных за пользователем</i></li>'
                . '<li><strong>Назначенных встреч</strong> - кол-во встреч, назначенных пользователем</li>'
                . '<li><strong>Заключенных договоров</strong> - кол-во договоров, заключенных пользователем</li>'
                . '</ul>') ?>
        
        <?php
            /*$columns = array(
                array(
                    'name'=>'name',
                    'value'=>'CHtml::link($data->name, array("/admin/user/view", "id"=>$data->id), array("target"=>"_blank"))',
                    'type'=>'raw',
                ),
                
                array(
                    'header'=>'Потенциальных клиентов',
                    'value'=>'$data->_money_clientPotencial',
                ),
                array(
                    'header'=>'Назначенных встреч',
                    'value'=>'$data->_money_clientMeet',
                ),
                array(
                    'header'=>'Заключенных договоров',
                    'value'=>'$data->_money_clientContract',
                    'type'=>'raw',
                ),
            );
        
            $tariffs = Tariff::model()->findAll('1 ORDER BY `id` ASC');
            foreach ( $tariffs as $val ) {
                
                $criteria = new CDbCriteria();
                $model->preStatistic();
                $criteria->addBetweenCondition('date_admin', $model->date_from, $model->date_to);
                $criteria->compare('user_id', $model->id);
                $criteria->compare('status', 1);
                $criteria->compare('tariff_id', $val->id);
                $_v = Client::model()->count($criteria);
                
                $columns[] = array(
                    'header'=>$val->name,
                    'value'=>(string)($_v*$val->sum),
                    'htmlOptions'=>array(
                        'class'=>'for_sum',
                    ),
                );
            }
            
            $columns[] = array(
                'header'=>'Сумма',
                'value'=>'0',
                'htmlOptions'=>array(
                    'class'=>'this_sum',
                ),
            );*/
        ?>
        
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
                    'header'=>'Потенциальных клиентов',
                    'value'=>'$data->_money_clientPotencial',
                ),
                array(
                    'header'=>'Назначенных встреч',
                    'value'=>'$data->_money_clientMeet',
                ),
                array(
                    'header'=>'Заключенных договоров',
                    'value'=>'$data->_money_clientContract',
                    'type'=>'raw',
                ),
                
                array(
                    'header'=>'Мини',
                    'value'=>'$data->get_tInfo(4)',
                    'htmlOptions'=>array(
                        'class'=>'for_sum',
                    ),
                    'type'=>'raw',
                ),
                array(
                    'header'=>'Стандарт',
                    'value'=>'$data->get_tInfo(5)',
                    'htmlOptions'=>array(
                        'class'=>'for_sum',
                    ),
                    'type'=>'raw',
                ),
                array(
                    'header'=>'Семейный',
                    'value'=>'$data->get_tInfo(6)',
                    'htmlOptions'=>array(
                        'class'=>'for_sum',
                    ),
                    'type'=>'raw',
                ),
                array(
                    'header'=>'Супер',
                    'value'=>'$data->get_tInfo(7)',
                    'htmlOptions'=>array(
                        'class'=>'for_sum',
                    ),
                    'type'=>'raw',
                ),
                array(
                    'header'=>'Мега',
                    'value'=>'$data->get_tInfo(8)',
                    'htmlOptions'=>array(
                        'class'=>'for_sum',
                    ),
                    'type'=>'raw',
                ),
                array(
                    'header'=>'Премиум',
                    'value'=>'$data->get_tInfo(9)',
                    'htmlOptions'=>array(
                        'class'=>'for_sum',
                    ),
                    'type'=>'raw',
                ),
                array(
                    'header'=>'VIP',
                    'value'=>'$data->get_tInfo(10)',
                    'htmlOptions'=>array(
                        'class'=>'for_sum',
                    ),
                    'type'=>'raw',
                ),
                
                array(
                    'header'=>'Сумма',
                    'value'=>'0',
                    'htmlOptions'=>array(
                        'class'=>'this_sum',
                    ),
                ),
            ),
        )); ?>
        
    </div>
</div>