<?php
  if ( is_user_logged_in() ){
    echo '';
  } else {
    echo '
<script type="text/javascript" src="http://bim.vc/wp-content/plugins/login-with-ajax/widget/login-with-ajax.source.js"></script>
<div class="modal" role="dialog" id="login" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content" id="superform">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span> </button><img width="30px" height="30px" src="http://bim.vc/wp-content/themes/vysotsky_theme/img/VC.png"> </div> <span class="lwa-status"></span>
      <div class="form-group" style="margin-top:30px;">
        <form name="loginform" class="lwa-form" id="loginform" action="http://bim.vc/auth.php" method="post">
          <input class="lwa-ajax" name="lwa" type="hidden" value="1">
          <input placeholder="Электропочта" type="text" name="log" id="user_login" class="form-control" size="20" /> </label>
          <input placeholder="Пароль" type="password" name="pwd" id="user_pass" class="form-control" size="20" /> </label>
          <div class="col-sm-4 pull-right" style="text-align: right;margin-top: 27px;padding: 0;"><a id="rp" href="/auth.php?action=lostpassword">Забыли пароль?</a></div>
          <input type="submit" name="wp-submit" id="lwa_wp-submit" class="btn btn-success btn-lg margin" value="Войти" />
          <input type="hidden" name="login-with-ajax" value="login"> </form>
        <script>
        $("#rp").click(function() {
          $("#open").toggleClass("expand");
          $("#loginform").toggleClass("fclose")
        });
        </script> 
        </div>
    </div>
  </div>
</div>
<div class="modal lwa-register lwa-register-default" role="dialog" id="registration" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span> </button> <img width="30px" height="30px" src="http://bim.vc/wp-content/themes/vysotsky_theme/img/VC.png"> </div> <span class="lwa-status"></span>
      <div class="lwa">
        <form class="lwa-form" style="margin-top:30px;" name="lwa-register" id="registerform" action="http://bim.vc/auth.php?action=register" method="post" novalidate="novalidate">
          <div class="form-group" id="superform2">
            <input placeholder="Электропочта" class="form-control" type="email" name="user_email" id="user_email" class="input" size="25">
            <input placeholder="Придумайте пароль" type="password" name="cimy_uef_wp_PASSWORD" id="cimy_uef_wp_3" class="form-control cimy_uef_input_27" maxlength="100">
            <input placeholder="Имя" type="text" name="cimy_uef_wp_FIRSTNAME" id="cimy_uef_wp_5" class="form-control cimy_uef_input_27" maxlength="100">
            <input placeholder="Фамилия" type="text" name="cimy_uef_wp_LASTNAME" id="cimy_uef_wp_6" class="form-control cimy_uef_input_27" maxlength="100">
            <input placeholder="Компания/ВУЗ" type="text" name="cimy_uef_Компания" id="cimy_uef_6" class="form-control cimy_uef_input_27" maxlength="100">
            <input placeholder="Город" type="text" name="cimy_uef_Город" id="cimy_uef_2" class="form-control cimy_uef_input_27" maxlength="50">
            <div class="modal-footer">
              <p style="font-size:12px;">Нажимая <b>Регистрация</b> Вы подтверждаете корректность заполненных данных.</p>
              <input type="submit" name="wp-submit" id="wp-submit" class="btn btn-success btn-lg" value="Регистрация" />
              <input type="hidden" name="login-with-ajax" value="register"> </div>
              <input type="hidden" name="lang" value="'.get_locale().'">
          </div>
        </form>
      </div>
    </div>
  </div>
    ';}
?>
<?php
  if ($_GET["modal"] == "login") {
    echo ('<script type="text/javascript">window.onload=function(){$(\'#login\').modal(\'show\');};</script>');
  }else '' ;
?>