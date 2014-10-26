<?php
    $cs = Yii::app()->clientScript;
    
    /**
     * StyleSHeets
     */
    $cs
        ->registerCssFile('/css/bootstrap.css')
        ->registerCssFile('/css/bootstrap-theme.css')
        ->registerCssFile(Yii::app()->clientScript->getCoreScriptUrl().'/jui/css/base/jquery-ui.css')
        ->registerCssFile('/css/admin.css');

    /**
     * JavaScripts
     */
    $cs
        ->registerCoreScript('jquery',CClientScript::POS_END)
        ->registerCoreScript('jquery.ui',CClientScript::POS_END)
        ->registerScriptFile('/js/jquery.cookie.js',CClientScript::POS_END)
        ->registerScriptFile('/js/bootstrap.min.js',CClientScript::POS_END)
        ->registerScriptFile('/js/admin.js',CClientScript::POS_END)

        ->registerScript('tooltip',
            "$('[data-toggle=\"tooltip\"]').tooltip();
            $('[data-toggle=\"popover\"]').tooltip()"
            ,CClientScript::POS_READY);

?>

<!DOCTYPE html>
<html>
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="language" content="" />

    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <meta name="copyright" content="" />
    <meta itemprop="image" content="" />

    <title><?= CHtml::encode($this->pageTitle); ?></title>

</head>

<body>
    
    <?= $content ?>

</body>
</html>