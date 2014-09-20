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
            <div class="login-area">
                <?php
                if( $user = $auth->getAuthorizedUser() ) {
                    ?><p class="login-line"><i><?=$user->login?></i> <a href="<?=PROJECT_PATH?>/logout.php">Выход</a></p><?php
                } else {
                    ?>
                        <form action="<?=PROJECT_PATH?>/login.php" method="POST" >
                            <input type="text" name="login" >
                            <input type="password" name="password" >
                            <input type="checkbox" name="rememberMe" >
                            <input type="submit" value="Вход">
                        </form>
                    <br><a href="<?=PROJECT_PATH?>/registration.php"</a>Registraciya;
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