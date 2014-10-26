<?php $this->beginContent('/layouts/admin'); ?>

    <?php
        $user = User::model()->findByPk(Yii::app()->user->id);
    ?>

    <?php
        $this->widget('bootstrap.widgets.BsNavbar', array(
            //'color' => BsHtml::NAVBAR_COLOR_INVERSE,
            'position' => BsHtml::NAVBAR_POSITION_STATIC_TOP,
            'brandLabel' => BsHtml::icon(BsHtml::GLYPHICON_HOME),
            'brandUrl' => array('/admin/default/index'),
            'items' => array(
                array(
                    'class' => 'bootstrap.widgets.BsNav',
                    'type' => 'navbar',
                    //'activateParents' => true,
                    'items' => array(
                        array(
                            'label' => 'Клиенты на аренду',
                            'url' => array('/admin/client/index'),
                            'items' => array(
                                array(
                                    'label' => 'Все клиенты',
                                    'url' => array('/admin/client/index'),
                                ),
                                array(
                                    'label' => 'Потенциальные клиенты',
                                    'url' => array('/admin/client/index', 'status'=>'0'),
                                ),
                                array(
                                    'label' => 'Актуальные клиенты',
                                    'url' => array('/admin/client/index', 'status'=>'1'),
                                ),
                                array(
                                    'label' => 'Архив клиентов',
                                    'url' => array('/admin/client/index', 'status'=>'2'),
                                ),
                                array(
                                    'label' => 'Заявления от клиентов',
                                    'url' => array('/admin/clientStatement/index'),
                                    'visible' => Yii::app()->user->checkAccess('1'),
                                ),
                                BsHtml::menuDivider(),
                                array(
                                    'label' => 'Добавить клиента',
                                    'url' => array('/admin/client/create'),
                                    'icon' => BsHtml::GLYPHICON_PLUS,
                                ),
                                array(
                                    'label' => 'Добавить потенциального клиента',
                                    'url' => array('/admin/client/create', 'status'=>'0'),
                                    'icon' => BsHtml::GLYPHICON_PLUS,
                                ),
                            ),
                        ),
                        array(
                            'label' => 'Объекты на аренду',
                            'url' => array('/admin/object/index'),
                            'items' => array(
                                array(
                                    'label' => 'Все объекты',
                                    'url' => array('/admin/object/index'),
                                ),
                                array(
                                    'label' => 'Новые объекты',
                                    'url' => array('/admin/object/index', 'status'=>'0'),
                                ),
                                array(
                                    'label' => 'Актуальные объекты',
                                    'url' => array('/admin/object/index', 'status'=>'1'),
                                ),
                                /*array(
                                    'label' => 'Посуточные объекты',
                                    'url' => array('/admin/object/index', 'daily'=>'1'),
                                ),*/
                                array(
                                    'label' => 'Архив объектов',
                                    'url' => array('/admin/object/index', 'status'=>'2'),
                                ),
                                array(
                                    'label' => 'Удаленные объекты',
                                    'url' => array('/admin/object/index', 'status'=>'3'),
                                ),
                                BsHtml::menuDivider(),
                                array(
                                    'label' => 'Добавить объект',
                                    'url' => array('/admin/object/create'),
                                    'icon' => BsHtml::GLYPHICON_PLUS,
                                ),
                            ),
                        ),
                        array(
                            'label' => 'Справочники',
                            'url' => '#',
                            'items' => array(
                                array(
                                    'label' => 'Черный список',
                                    'url' => array('/admin/blackList/index'),
                                    'icon' => BsHtml::GLYPHICON_EARPHONE,
                                ),
                                array(
                                    'label' => 'Офисы',
                                    'url' => array('/admin/office/index'),
                                    'icon' => BsHtml::GLYPHICON_GLOBE,
                                ),
                                array(
                                    'label' => 'Сотрудники',
                                    'url' => array('/admin/user/index'),
                                    'icon' => BsHtml::GLYPHICON_USER,
                                ),
                                BsHtml::menuDivider(),
                                array(
                                    'label' => 'Районы для поиска',
                                    'url' => array('/admin/area/index'),
                                ),
                                array(
                                    'label' => 'Типы недвижимости',
                                    'url' => array('/admin/objectType/index'),
                                ),
                                array(
                                    'label' => 'Тарифы',
                                    'url' => array('/admin/tariff/index'),
                                ),
                            ),
                        ),
                        array(
                            'label' => 'Статистика',
                            'url' => '#',
                            'items' => array(
                                array(
                                    'label' => 'Полезные действия',
                                    'url' => array('/admin/statistic/useful'),
                                    'icon' => BsHtml::GLYPHICON_CERTIFICATE,
                                ),
                                array(
                                    'label' => 'Статистика финансов',
                                    'url' => array('/admin/statistic/money'),
                                    'icon' => BsHtml::GLYPHICON_USD,
                                ),
                                array(
                                    'label' => 'Статистика парсера',
                                    'url' => array('/admin/statistic/parser'),
                                    'icon' => BsHtml::GLYPHICON_STATS,
                                ),
                            ),
                            'visible' => Yii::app()->user->checkAccess('1'),
                        ),
                        /*array(
                            'label' => 'Разное',
                            'url' => '#',
                            'items' => array(
                                array(
                                    'label' => 'Новости',
                                    'url' => array('/admin/news/index'),
                                    'icon' => BsHtml::GLYPHICON_BULLHORN,
                                ),*/
                                /*array(
                                    'label' => 'Отзывы',
                                    'url' => array('/admin/review/index'),
                                    'icon' => BsHtml::GLYPHICON_PENCIL,
                                ),*/
                                /*array(
                                    'label' => 'Резюме',
                                    'url' => '#',
                                    'icon' => BsHtml::GLYPHICON_BRIEFCASE,
                                    'visible' => Yii::app()->user->checkAccess('1'),
                                ),*/
                                /*BsHtml::menuDivider(),
                                array(
                                    'label' => 'Добавить отзыв',
                                    'url' => array('/admin/review/create'),
                                ),*/
                         /*   ),
                        ),*/
                        
                        // test
                        /*array(
                            'label' => 'Парсинг',
                            'url' => array('/admin/parser/test'),
                            'icon' => BsHtml::GLYPHICON_BULLHORN,
                        ),*/
                        
                    ),
                ),
                array(
                    'class' => 'bootstrap.widgets.BsNav',
                    'type' => 'navbar',
                    'activateParents' => true,
                    'items' => array(
                        array(
                            'label' => $user->_login,
                            'url' => '#',
                            'items' => array(
                                BsHtml::menuHeader($user->_role, array(
                                    'class' => 'text-center',
                                    'style' => 'color:'.$user->_color.';font-size:16px;',
                                )),
                                BsHtml::menuHeader(BsHtml::icon(BsHtml::GLYPHICON_BOOKMARK), array(
                                    'class' => 'text-center',
                                    'style' => 'color:'.$user->_color.';font-size:32px;'
                                )),
                                array(
                                    'label' => 'Мой профиль',
                                    'icon' => BsHtml::GLYPHICON_CREDIT_CARD,
                                    'url' => array('/admin/default/profile'),
                                ),
                                array(
                                    'label' => 'Настройки',
                                    'icon' => BsHtml::GLYPHICON_WRENCH,
                                    'url' => array('/admin/default/settings'),
                                ),
                                BsHtml::menuDivider(),
                                array(
                                    'label' => 'Выход',
                                    'icon' => BsHtml::GLYPHICON_LOG_OUT,
                                    'url' => array('/admin/default/logout'),
                                ),
                            ),
                        ),
                    ),
                    'htmlOptions' => array(
                        'pull' => BsHtml::NAVBAR_NAV_PULL_RIGHT
                    )
                )

            )
        ));
    ?>

    <div class="container">
        
        <?php $this->beginWidget('bootstrap.widgets.BsPanel'); ?>
        
            <div class="row">
                <div class="col-md-4">
                    <?= BsHtml::linkButton('Добавить клиента', array(
                        'block' => true,
                        'color' => BsHtml::BUTTON_COLOR_PRIMARY,
                        'url' => array('/admin/client/create'),
                    )); ?>
                    <?= BsHtml::linkButton('Добавить потенциального клиента', array(
                        'block' => true,
                        'color' => BsHtml::BUTTON_COLOR_INFO,
                        'url' => array('/admin/client/create', 'status'=>'0'),
                    )); ?>
                </div>
                <div class="col-md-4">
                    <?= BsHtml::linkButton('Добавить объект', array(
                        'block' => true,
                        'color' => BsHtml::BUTTON_COLOR_PRIMARY,
                        'url' => array('/admin/object/create'),
                    )); ?>
                    <?= BsHtml::linkButton('Объекты для прозвона', array(
                        'block' => true,
                        'color' => BsHtml::BUTTON_COLOR_SUCCESS,
                        'url' => array('/admin/object/index', 'status'=>0),
                    )); ?>
                </div>
                <div class="col-md-4">
                    <script>
                        $(document).ready(function(){
                            $('#go_phone_search').click(function(){
                                if ( $('#phone_search').val().length==0 ) {
                                    return false;
                                }
                                $.ajax({
                                    url: '/admin/blackList/search',
                                    type: 'POST',
                                    data: {
                                        phone: $('#phone_search').val()
                                    },
                                    success: function(data) {
                                        if ( data=='1' ) {
                                            alert('Номер ЕСТЬ в черном списке.');
                                        } 
                                        if ( data=='0' ) {
                                            alert('Номера НЕТ в черном списке.');
                                        }
                                        $('#phone_search').val('');
                                    }
                                });
                            });
                            
                            $('#go_phone_add').click(function(){
                                if ( $('#phone_add').val().length==0 ) {
                                    return false;
                                }
                                $.ajax({
                                    url: '/admin/blackList/add',
                                    type: 'POST',
                                    data: {
                                        phone: $('#phone_add').val()
                                    },
                                    success: function(data) {
                                        if ( data=='1' ) {
                                            alert('Номер добавлен в черный список.');
                                        } 
                                        if ( data=='0' ) {
                                            alert('Номер уже есть в черном списке.');
                                        }
                                        $('#phone_add').val('');
                                    }
                                });
                            });
                        });
                    </script>
                    <div class="input-group">
                        <span class="input-group-addon">+7</span>
                        <?= BsHtml::textField('phone_search', '', array('class'=>'form-control', 'placeHolder'=>'Поиск по телефону', 'maxlength'=>10)) ?>
                        <span class="input-group-btn">
                            <?= BsHtml::button('', array(
                                'color' => BsHtml::BUTTON_COLOR_DEFAULT,
                                'icon' => BsHtml::GLYPHICON_SEARCH,
                                'id' => 'go_phone_search',
                            )); ?>
                        </span>
                    </div>
                    <div class="input-group" style="margin-top: 5px;">
                        <span class="input-group-addon">+7</span>
                        <?= BsHtml::textField('phone_add', '', array('class'=>'form-control', 'placeHolder'=>'В черный список', 'maxlength'=>10)) ?>
                        <span class="input-group-btn">
                            <?= BsHtml::button('', array(
                                'color' => BsHtml::BUTTON_COLOR_DEFAULT,
                                'icon' => BsHtml::GLYPHICON_PLUS,
                                'id' => 'go_phone_add',
                            )); ?>
                        </span>
                    </div>
                </div>
            </div>
        
        <?php $this->endWidget(); ?>
        
        <?= BsHtml::pageHeader($this->header) ?>

        <?php $this->widget('bootstrap.widgets.BsNav', array(
            'stacked' => false,
            'type' => 'tabs',
            'items' => $this->getMenu(),
            'htmlOptions'=>array(
                'class'=>'nav-special',
            ),
        )); ?>
        
        <?= $content; ?>
        
        <div id="footer">
            Ваш IP - <?= $_SERVER['REMOTE_ADDR'] ?>
            <div id="c" class="well" style="margin-bottom: 0;">
                <?= BsHtml::button('Общение', array(
                    'block' => true,
                    'color' => BsHtml::BUTTON_COLOR_PRIMARY,
                    'id' => 'c_button',
                )); ?>
                <div id="c_inner">
                    <ul>
                        
                    </ul>
                </div>
            </div>
            <?php $this->beginWidget('zii.widgets.jui.CJuiDialog',array(
                'id'=>'c_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                    'title'=>'Диалог',
                    'autoOpen'=>false,
                    'width'=>600,
                    'height'=>400,
                ),
            )); ?>
                <input type="hidden" value="<?= User::model()->findByPk(Yii::app()->user->id)->name ?>" id="_user_name" />
                <table style="width: 100%; height: 100%;">
                    <tr style="height: 100%;">
                        <td style="vertical-align: top;" colspan="2"><div id="c_area_dialog"></div></td>
                    </tr>
                    <tr>
                        <td style="width: 100%;">
                            <textarea id="c_textarea" class="form-control" style="height: 100px;"></textarea>
                        </td>
                        <td style="width: 100px; padding-left: 10px;">
                            <?= BsHtml::button('Отправить', array(
                                'block' => true,
                                'color' => BsHtml::BUTTON_COLOR_SUCCESS,
                                'id' => 'c_goChat',
                            )); ?>
                        </td>
                    </tr>
                </table>
            <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
        </div>
    </div>

<?php $this->endContent(); ?>