<html>
    <head>
        <title>
            Наши новости
        </title>
        <meta charset="UTF-8" />
        <link href="<?=PROJECT_PATH?>/css/style.css" rel="stylesheet" />
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js">
        <script type="text/javascript">
            $(document).ready(function() {
                $('#auth_button').click(function() {
                    $.post('/news-project/login.php', {
                        login: $('#auth_login').val(),
                        password: $('#auth_password').val(),
                        rememberMe: true,
                    }).done(function(data) {
                        if(data == 'SUCCESS') {
                            
                        } else {
                            
                        }
                    });
                    return false;
                });
            });
        </script>
    </head>
    <body>
        <div class="header"> 
            Это новостной портал 
            <div class="login-area">
                <?php
                if( $user = $auth->getAuthorizedUser() ) {
                    ?><p class="login-line"><i><?=$user->login?></i> <a href="<?=PROJECT_PATH?>/logout.php">Выход</a></p><?php
                } else {
                    ?>
                        <form action="<?=PROJECT_PATH?>/login.php" method="POST" >
                            <input id='auth_login' type="text" name="login" >
                            <input id='auth_password' type="password" name="password" >
                            <input type="checkbox" name="rememberMe" >
                            <input type="submit" value="Вход" id="auth_button">
                        </form>
                <?php } ?>
                <?php
                if( isset($_SESSION['login_error_message']) && trim($_SESSION['login_error_message']) ){
                    ?><p class='error_message'><?=$_SESSION['login_error_message']?></p><?php
                    unset($_SESSION['login_error_message']);
                }
                ?>
            </div>
        </div>
        <div class="content">