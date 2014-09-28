<html>
    <head>
             <title>
            Наши новости
        </title>
        <meta charset="UTF-8" />
        <link href="<?=PROJECT_PATH?>/css/style.css" rel="stylesheet" />
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script type="text/javascript">
            $( document ).ready(function() {
                $("#auth_button").click(function(){
                    $.post('/news_project/login.php',{
                        login: $("#auth_login").val(),
                        password: $("#auth_password").val(),
                        rememberMe:  $("#auth_remember").val()
                    }).done(function(response){
                        response = JSON.parse(response);
                        if( response && response.result ){
                            $("#auth_area").html('<div id="auth_data"><i>' + response.data.login + '</i> <a id="auth_logout" href="<?=PROJECT_PATH?>/logout.php">выход</a></div>');
                        } else {
                            $("#auth_error").text(response.message);
                        }
                    });
                    return false;
                });
                $("#auth_logout").click(function(){
                    $.post('/news_project/logout.php',{}).done(function(response){
                        response = JSON.parse(response);
                        if( response && response.result ) {
                            $("#auth_area").html(
                                    "<div id='auth_form'><form action='<?=PROJECT_PATH?>/login.php' method='POST' ><input id='auth_login' type='text' name='login' ><input id='auth_password' type='password' name='password' ><input id='auth_remember' type='checkbox' name='rememberMe' ><input type='submit' value='вход' id='auth_button' ></form><div class='reg_link'><a  href='<?=PROJECT_PATH?>/registration.php'>зарегистрироваться</a></div></div><div id='auth_error' class='error'></div>"
                            );
                        }
                    });
                    return false;
                });

            });
        </script>

        <meta charset="UTF-8" />
        <link href="<?=PROJECT_PATH?>/css/style.css" rel="stylesheet" />
    </head>
    <body>
        <div class="header"> 
            Это новостной портал 
            <div class="login-area">
                <?php
                if( $user = $auth->getAuthorizedUser() ) {
                    ?><p class="login-line"><i><?=$user->login?></i> <a id="auth_logout" href="<?=PROJECT_PATH?>/logout.php">Выход</a></p><?php
                } else {
                    ?>
                        <form action="<?=PROJECT_PATH?>/login.php" method="POST" >
                            <input type="text" name="login" >
                            <input type="password" name="password" >
                            <input type="checkbox" name="rememberMe" >
                            <input type="submit" value="Вход">
                        </form>
                    <br><a href="<?=PROJECT_PATH?>/registration.php"</a>Зарегистрироваться
                <?php } ?>
                <?php
                if( isset($_SESSION['login_error_message']) && trim($_SESSION['login_error_message']) ){
                    ?><p class='login-error-message'><?=$_SESSION['login_error_message']?></p><?php
                    unset($_SESSION['login_error_message']);
                }
                ?>
            </div>
        </div>
        <div class="content">