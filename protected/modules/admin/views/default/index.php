<?php
    $user = User::model()->findByPk(Yii::app()->user->id);
?>

<?//= BsHtml::blockAlert(BsHtml::TEXT_COLOR_INFO, 'История чата хранится 24 часа.') ?>

<iframe id="chat" src="/chat"></iframe>

<script>
    $(document).ready(function(){
        
        $('.page-header small').text('Здравствуйте, <?= $user->name ?>!');
        
        setTimeout(function(){
            if ( !$('#chat').contents().find('#submitForm').is(':visible') ) {
                $('#chat').contents().find('#name').val('<?= $user->name ?>');
                $('#chat').contents().find('#name').next().next().click();
            }
        }, 1000);
        
    });
</script>