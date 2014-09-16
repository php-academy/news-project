<html>
    <head>
        <title>Наши новости</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="<?=PROJECT_PATH?>/css/style.css">
    </head>
    <body>
        <div class="header">
            <p>Это новостной портал!</p>
            <div class="login-form">
                <?php
                if (isset($_SESSION['userId']) && isset($users[$_SESSION['userId']])) {             // если в сессии существует id пользователя и в массиве $users существоует такой id, то выводим логин данного пользователя и ссылку на выход;
                    echo "<p class='text'>" . $users[$_SESSION['userId']]['login'] . "</p>";
                    echo "<a href='" . PROJECT_PATH . "/logout.php'>Выход</a>";
                } else {                                                                            // если в сессии не существует id пользователя, то предлагаем заполнить форму для входа;
                ?>
                <form action="<?=PROJECT_PATH?>/login.php" method="POST">
                    <input type="text" name="login">
                    <input type="password" name="password">
                    <input type="checkbox" name="rememberMe">
                    <input type="submit" value="Вход">
                </form>
                <?php
                }
                    if (isset($_SESSION['login_error_message'])) {                                  // если логин или пароль введены неверно, то вывести под формой login_error_message; 
                        echo "<p class='error-message'>" . $_SESSION['login_error_message'] . "</p>";
                        unset($_SESSION['login_error_message']);                                    // после вывода login_error_message убить сессию;
                    }
                ?>
            </div>
        </div>
        <div class="content">
