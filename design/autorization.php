
<div id="auth_area" class="auth-area">
    <?php
    if( $user = $auth->getAuthorizedUser() ) {
    ?><p class="login-line"><i><?=$user->login?></i> <a href="<?=PROJECT_PATH?>/logout.php">Выход</a></p>
        <?php
        } else {
        ?>
        <div id="auth_form" >
        <form>
            <input id="auth_login" type="text" name="login" >
            <input id="auth_password" type="password" name="password" >
            <input id="auth_remember" type="checkbox" name="rememberMe" >
            <input id="auth_button" type="submit" value="Вход">
        </form>
                
    <?php   
    if(isset($_SESSION['register_result']) && trim($_SESSION['register_result']))  {
                        
    ?><p class="login-success-message"><?= $_SESSION['register_result'];?></p> 
                    
    <?php
    unset($_SESSION['register_result']);
                    
    } else { ?>    
                    
    <div class="reg_link"><a href="<?=PROJECT_PATH?>/registration.php">Зарегистрироваться</a> </div>
    <?php } ?>
    <div id="auth_error" class="error"></div>
    <?php
    if( isset($_SESSION['login_error_message']) && trim($_SESSION['login_error_message']) ){
    ?>
    
    <p class='login-error-message'><?=$_SESSION['login_error_message']?></p>
    <?php
    unset($_SESSION['login_error_message']);
                   
        }
    }
    ?>
    </div>
</div>