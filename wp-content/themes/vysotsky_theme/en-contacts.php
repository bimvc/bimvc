<?php
   /*
   Template Name: en_contacts
   */
   ?>
<?php get_header(); ?>
  <!-- / .navigation -->
<link href="<?php echo get_template_directory_uri().'/css/fonts/font-awesome/css/font-awesome.min.css'; ?>" rel="stylesheet">
<div class="container emerge" style="margin-top:100px;" data-effect="slide">
   <h1>Contacts</h1>
   <div class="row" >
      <div class="col-sm-6" style="line-height:2;">
         <p>We are always open to dialogue.</p>
         <p>We will share our experience with pleasure, think over the possible ways of cooperation, discuss new technologies, give You tips how to implement BIM in your particular situation in a better way.</p>
         <p>Email us at::</p>
         <h4 style="line-height:2; text-transform:uppercase;"><a href="mailto:contact@bim.vc">contact@bim.vc</a></h4>
         <br>
         <div class="ct">
            <img src="/wp-content/themes/vysotsky_theme/img/sasha2.png" class="img-rounded" style="margin-right:0 !important;">
         </div>
         <div class="col-sm-8">
            <h3>Alexandr Vysotskiy</h3>
            <p>CEO</p>
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
<!--       <div class="col-sm-6 hidden-xs hidden-sm">
         <?php echo do_shortcode( '[contact-form-7 id="1429" title="Contacts"]' ); ?>
      </div> -->
   </div>
   <!-- / .row -->
</div>
<!-- / .container -->
<!-- / .wrapper -->
<?php get_footer(); ?>