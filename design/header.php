<html>
    <head>
        <title>
            Наши новости
        </title>
        <meta charset="UTF-8" />
        <link href="<?=PROJECT_PATH?>/css/style.css" rel="stylesheet" />
    </head>
    <body>
        <div class="header"> 
            Это новостной портал 
            <div class="login-form">
                <?php
                if( $user = $auth->getAuthorizedUser() ) {
                    echo "<br>". $user->login;
                    echo "<a href='".PROJECT_PATH."/logout.php'>Выход</a>";
                }    
                else {
                    ?>
                    <form action="<?=PROJECT_PATH?>/login.php" method="POST" >
                        <input type="text" name="login" > 
                        <input type="password" name="password" >
                        <input type="checkbox" name="rememberMe" >
                        <input type="submit" value="Вход">
                    </form>
                <?php } ?>
                <?php
                    if( isset($_SESSION['login_error_message']) ){
                        echo "<p class='error-message'>".$_SESSION['login_error_message'] ."</p>";
                        unset($_SESSION['login_error_message']);
                    }
                ?>
            </div>
        </div>
        <div class="content">