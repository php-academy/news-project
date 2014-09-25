<html>
    <head>
        <title>
            Наши новости
        </title>
        <meta charset="UTF-8" />
        <link href="<?=PROJECT_PATH?>/css/style.css" rel="stylesheet" />
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $("#auth_button").click(function() {
                    $.post('login.php', {
                            login: $("#auth_login").val(),
                            password: $("#auth_password").val(),
                            rememberMe: $("#auth_remember").val()
                        }).done(function(response) {
                         response = JSON.parse(response);
                        if(response && response.result) {
                           $("#auth_area").html('<div id="auth_data"><i>' + response.data.login + '</i> <a href="<?=PROJECT_PATH?>/logout.php">Выход</a></p>');
                        } else {
                           $("#auth_error").text(response.message);
                        }
                });
                return false;
            });
        
        });
        </script>
    </head>
    <body>
        <div class="header"> 
            <span class="title">Это новостной портал </span>    
           
        
       <div id="auth_area" class="auth-area">
    
        <div id="auth_form" >
            <form>
                <input id="auth_login" type="text" name="login" >
                <input id="auth_password" type="password" name="password" >
                <input id="auth_remember" type="checkbox" name="rememberMe" >
                <input id="auth_button" type="button" value="Вход">
            </form>
            <div class="reg_link"><a href="<?=PROJECT_PATH?>/registration.php">Зарегистрироваться</a> 
            </div>
        </div>
       
           <div id="auth_error" class="error"></div>
       </div>
    </div>
        <div class="content">