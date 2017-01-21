<html>
<form class="lwa-remember" action="passreset.php" method="post" id="openform">
    <input class="lwa-ajax" name="lwa" value="1" type="hidden">
    <span class="lwa-status"></span> 
    <input name="user_login" id="user_login" class="lwa-user-remember form-control" value="Введите электропочту"  type="text">
    <input type="submit" value="Получить новый пароль" class="btn btn-success btn-lg lwa-button-remember">
    <input type="hidden" name="login-with-ajax" value="remember">
</form>
</html>
<?php

	$username = $_POST['user_login'];
	$to = $username;
	$subject = "Ваш пароль от базы знаний bim.vc";
	$headers = "";

	if username_exists( $username ) {
		$userinfo = get_user_by( 'email', $username );
		$new_user_id = $userinfo->ID;
		wp_new_user_notification( $new_user_id, $new_user_pass);
		echo "Пароль отправлен на Вашу электропочту";
	}
	else{
		echo "Такого пользователя не существует";
	};
?>