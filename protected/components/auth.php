<?php

    return array(
        '0' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'Пользователь',
            'bizRule' => null,
            'data' => null
        ),
        '1' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'Администратор',
            'children' => array(
                '0',
            ),
            'bizRule' => null,
            'data' => null
        ),
        /*'2' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'Менеджер/Стажер',
            'bizRule' => null,
            'data' => null
        ),*/
    );