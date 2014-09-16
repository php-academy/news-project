<html>
    <head>
        <meta charset="UTF-8">
        <link href="<?=PROJECT_PATH?>/css/index.css"  type="text/css" rel="stylesheet"/>
        <title>Наши новости</title>
    </head>
    <body>
        <div class="header">Это новостной портал</div>
        <div class="login-form">
                <?php
                    if(isset($_SESSION['userId']) && isset($users[$_SESSION['userId']])) {
                        echo "<br>" . $users[$_SESSION['userId']]['login'];
                        echo "<a href='" . PROJECT_PATH ."/logout.php'>Выход</a>";
                    } 
                    else { 
                        ?> 
                    <form action="<?=PROJECT_PATH?>/login.php" method="POST">
                        <input type="text" name="login">
                        <input type="password" name="password">
                        <input type="submit" value="Вход">
                        <input type="checkbox" name="rememberMe">
                    </form>
                    <?php } ?>
                <?php
                    if(isset($_SESSION['login_error_message'])) {
                        echo "<p class='error_message'>" . $_SESSION['login_error_message'] . "</p>";
                        unset($_SESSION['login_error_message']);
                    }
                ?>
            </div>
        <div class="content">