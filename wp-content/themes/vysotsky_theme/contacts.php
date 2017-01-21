<?php
   /*
   Template Name: Contacts
   */
   ?>
<?php get_header(); ?>
<link href="<?php echo get_template_directory_uri().'/css/fonts/font-awesome/css/font-awesome.min.css'; ?>" rel="stylesheet">
<div class="container emerge" style="margin-top:100px;" data-effect="slide">
   <h1>Контакты</h1>
   <div class="row" >
      <div class="col-sm-6" style="line-height:2;">
         <p>Мы всегда открыты для диалога.</p>
         <p>С удовольствием поделимся опытом, подумаем над путями сотрудничества, обсудим современные технологии, подскажем, как лучше внедрить BIM именно в вашей ситуации.</p>
         <p>Наш единый адрес:</p>
         <h4 style="line-height:2; text-transform:uppercase;"><a href="mailto:contact@bim.vc">contact@bim.vc</a></h4>
         <br>
         <div class="ct">
            <img src="/wp-content/themes/vysotsky_theme/img/sasha2.png" class="img-rounded" style="margin-right:0 !important;">
         </div>
         <div class="col-sm-8">
            <h3>Александр Высоцкий</h3>
            <p>Генеральный директор</p>
            <h4 style="line-height:2; text-transform:uppercase;">+7 911 826-98-94
               </br><a href="mailto:av@bim.vc">av@bim.vc</a>
            </h4>
            <div class="social">
               <ul>
                  <li><a class="linkedin" href="http://vk.com/visik"><i class="fa fa-vk"></i></a></li>
                  <li><a class="facebook" href="http://www.facebook.com/AVysotskiy"><i class="fa fa-facebook"></i></a></li>
                  <li><a class="linkedin" href="http://ru.linkedin.com/pub/alexander-vysotskiy/36/432/48b"><i class="fa fa-linkedin"></i></a></li>
                  <li><a class="twitter" href="https://twitter.com/VisikPro"><i class="fa fa-twitter"></i></a></li>
               </ul>
            </div>
         </div>
      </div>
      <div class="form-group col-xs-6">
          <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
          <script src="http://bim.vc/script.js"></script>
          <form id="feedback" method="POST">
              <div id="simpleContactForm_input_email"><input class="email form-control" name="from" placeholder="Ваш e-mail"></div>
              <div id="simpleContactForm_input_name"><input class="name form-control" name="name" placeholder="Ваше Имя"></div>
              <div id="simpleContactForm_input_message"><textarea class="message form-control" placeholder="Ваше сообщение" name="message" cols="40" rows="10"></textarea></div>
              <div id="simpleContactForm_btn"><button type="submit" class="btn btn-theme-default">Отправить</button></div>
          </form>
      </div>
   </div>
   <!-- / .row -->
</div>
<!-- / .container -->
<!-- / .wrapper -->
<?php get_footer(); ?>