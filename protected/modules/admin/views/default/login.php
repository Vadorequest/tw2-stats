<style>
    body {
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #eee;
    }
</style>

<div class="container">

    <?php if ( Yii::app()->user->hasFlash('error') ): ?>
        <?= BsHtml::blockAlert(BsHtml::TEXT_COLOR_DANGER, Yii::app()->user->getFlash('error'), array('class'=>'form-signin')) ?>
    <?php endif; ?>
    
    <form class="form-signin" method="POST" role="form">
        <h2 class="form-signin-heading">Авторизация</h2>
        <input type="text" class="form-control" placeholder="Логин" name="AdminLoginForm[username]" required="" autofocus="">
        <input type="password" class="form-control" placeholder="Пароль" name="AdminLoginForm[password]" required="">
        <button class="btn btn-lg btn-primary btn-block" type="submit">Вход</button>
        <?= CHtml::link('Забыли пароль?', '#', array('class'=>'link_remember')) ?>
    </form>

</div>