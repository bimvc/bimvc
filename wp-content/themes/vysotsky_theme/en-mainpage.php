<?php
/*
Template Name: en_main
*/
?>

<?php get_header(); ?>

<link  href="http://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.css" rel="stylesheet">
<script src="http://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri().'/js/jquery.fullPage.min.js'; ?>"></script>
<script type="text/javascript">
  $(document).ready(function() {
  $('#fullpage').fullpage({
        animateAnchor: true,
        lockAnchors: false,
        anchors:['main', 'about', 'liders', 'proj', 'buisness', 'clients', 'callback' ],
        scrollBar: true,
        responsiveWidth: 900,
        responsiveHeight: 600,

  }); 
  });
</script>
<div id="fullpage" class="emerge">
  <div class="section" data-anchor="main">
    <div class="home-parallax bg-parallax blackout emerge" data-blackout-max="70">
      <div class="blackout__layer"></div>
      <div class="home-parallax__inner">
        <div class="container">
          <div class="row">
            <div class="col-xs-12 animated fadeInDown">
              <h1>We are recognized experts in effective implementation of BIM technologies</h1>
              <p>We will switch your company to BIM fast and effectively.</p>
              <a href="#7" class="btn btn-lg btn-theme-primary">Contact Us</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="col-md-10 col-md-offset-1">
        <ul class="logo emerge" data-effect="slide" data-continue="true">
          <li><img src="<?php echo get_template_directory_uri().'/img/main/aecom.jpg'; ?>"></li>
          <li><img src="<?php echo get_template_directory_uri().'/img/main/centromash.jpg'; ?>"></li>
          <li><img src="<?php echo get_template_directory_uri().'/img/main/etalon.jpg'; ?>"></li>
          <li style="margin-top:2px;"><img src="<?php echo get_template_directory_uri().'/img/main/au.jpg'; ?>"></li>
          <li><img src="<?php echo get_template_directory_uri().'/img/main/tebodin.jpg'; ?>"></li>
          <li><img src="<?php echo get_template_directory_uri().'/img/main/sveko.jpg'; ?>"></li>
          <li><img src="<?php echo get_template_directory_uri().'/img/main/spbgos.jpg'; ?>"></li>
          <li><img src="<?php echo get_template_directory_uri().'/img/main/tumen.jpg'; ?>"></li>
        </ul>
      </div>
    </div>
  </div>
  <div class="section" data-anchor="about">
    <div class="container">
      <div class="row">
        <div class="col-md-12" style="padding-top:50px;">
          <div class="col-md-6">
            <h2 class="headline-lg headline-lg_left first-child">Why are we the best?</h2>
            <p class="text-muted">We have achieved efficiency for the BIM – consulting market due to our expertise and the highest quality of the services provided.</p>
            <p class="text-muted">We will add value to your design, construction, maintenance and carrying out examination activities.</p>
            <p class="text-muted">Best practices and expertise let us solve any issues concerning BIM: implementation on turnkey basis, training, audit, support, document development and more.</p>
          </div>
          <div class="col-sm-6">
            <div class="youtube shadow" id="W5NSFFwjlIk" style="background-image: url(&quot;http://i.ytimg.com/vi/W5NSFFwjlIk/sddefault.jpg&quot;);width: 530px; height: 300px; ">
              <div class="play"></div>
            </div>
          </div>
          <div class="col-sm-12 text-center">
            <div class="ad text-center">            
              <img src="/wp-content/themes/vysotsky_theme/img/pl/ADAC.png">
              <img src="/wp-content/themes/vysotsky_theme/img/pl/ADAP.png">
              <img src="/wp-content/themes/vysotsky_theme/img/pl/ADT.png">
              <img src="/wp-content/themes/vysotsky_theme/img/pl/ee.jpg">
              <img src="/wp-content/themes/vysotsky_theme/img/pl/BL.png">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="section" data-anchor="liders" style="background-image:url(<?php echo get_template_directory_uri().'/img/lider.png'; ?>); background-size:cover;">
    <div class="container">
      <div class="col-lg-12">
        <div class="row">
          <div class="col-lg-8 sm-margin">
            <h2 class="headline-lg headline-lg_left first-child">Branch leaders</h2>
            <p class="text-muted">A team of the best BIM-experts in Russia and the CIS let us achieve the highest quality of BIM – consulting.</p>
            <p class="text-muted">Trainers at Vysotskiy Consulting  – practicing designers with the long record of experience in this field. They realize perfectly well needs and difficulties of the actual design process, provide answers to all practical questions and can explain the most complicated issues in simple terms.</p>
          </div>
        </div>
        <div class="col-lg-4"></div>
      </div>
      <div class="col-sm-12">
        <dic class="row">
        <div class="col-sm-4">
          <div class="blog">
            <img style="max-width:100%;" src="<?php echo get_template_directory_uri().'/img/pics/av.png'; ?>">
            <div class="blog-desc">
              <p class="text-muted"><b>Alexander Visotskiy</b><br>BIM–experience more than 8 years<br>Trained and implemented BIM 
In leading companies in Russia and the CIS<br>TOP–100 of the best BIM trainers<br>Lecturer in Peter the Great St. Petersburg  Polytechnic University</p>
            </div>
          </div>
        </div>
        <div class="col-sm-4">
          <div class="blog">
            <img style="max-width:100%;" src="<?php echo get_template_directory_uri().'/img/pics/sm.png'; ?>" >
            <div class="blog-desc">
              <p class="text-muted"><b>Sergey Makarov</b><br>5 years in BIM management<br>Unique expertise in creating BIM-environment<br>Proprietary course on BIM in South Ural State University (National Research University)</p>
            </div>
          </div>
        </div>
        <div class="col-sm-4 ">
          <div class="blog">
            <img style="max-width:100%;" src="<?php echo get_template_directory_uri().'/img/pics/mch.png'; ?>">
            <div class="blog-desc">
              <p class="text-muted"><b>Mikhail Cherviakov</b><br>Specialist in recent trends of BIM<br>Network and Web technologies<br>Dynamo</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="section" data-anchor="proj">
      <div class="container">
          <div class="col-sm-12">
            <div class="fotorama" data-width="1200" data-height="400" data-maxwidth="100%">
                <div>
              <div class="col-lg-7" style="text-align:center;">
              <img style="max-height:100%;" src="http://bim.vc/img/slider/1.png">
              </div>
              <div class="col-xs-5 lg-margin">
              <h4>Juice factory</h4>
              <p>AECOM</p>
              <p>overall reduction of the design period by 50%</p>
              <p>dramatic simplification of the approval process for design options</p>
              <p>accuracy increase by 200%</p>
              </div>
              </div>
              <div>
              <div class="col-lg-7" style="text-align:center;">
              <img style="max-height:100%;" src="http://bim.vc/img/slider/2.png">
              </div>
              <div class="col-xs-5 lg-margin">
              <h4>Residential area &laquo;Northern Capital&raquo;</h4>
              <p>VELLCOM group</p>
              <p>50% design period reduction</p>
              <p>the rate of change is higher by 300%</p>
              <p>4 times less mistakes</p>
              </div>
              </div>
              <div>
              <div class="col-lg-7" style="text-align:center;">
              <img style="max-height:100%;" src="http://bim.vc/img/slider/3.png">
              </div>
              <div class="col-xs-5 lg-margin">
              <h4>Train station &laquo;Olympic Park&raquo; (Sochi City)</h4>
              <p>Studio 44</p>
              <p>development of the supporting frames</p>
              <p>data pre-processing for the production</p>
              <p>accurate and fast assembling</p>
              </div>
              </div>
              <div>
              <div class="col-lg-7" style="text-align:center;">
              <img style="max-height:100%;" src="http://bim.vc/img/slider/4.png">
              </div>
              <div class="col-xs-5 lg-margin">
              <h4>Block of flats in Chelyabinsk City</h4>
              <p>Legion – project</p>
              <p>overall design period reduction by 30...70%</p>
              <p>3 times faster amendments</p>
              <p>no “field assembly” during the construction</p>
              </div>
              </div>
            </div>
        </div>
        <div class="col-sm-12">
          <div class="col-sm-8">
            <h2 class="headline-lg headline-lg_left first-child">Proven results</h2>
            <p class="text-muted">The best indicator of the professionalism  –  the results achieved by the companies that had committed to us their switch to BIM.</p>
            <p class="text-muted">The companies carried out the most difficult projects with the help of BIM technologies.</p>
            <p class="text-muted">Together with all our clients we head for a long-term result based on the trust and mutual support.</p>
          </div>
        </div>
    </div>
  </div>

  <div class="section" data-anchor="buisness" style="background-image:url(<?php echo get_template_directory_uri().'/img/invest.png'; ?>); background-size:cover;">
    <div class="container">
      <div class="col-sm-12">
      <div class="col-sm-8" style="font-size:16px;">
        <h2 class="headline-lg headline-lg_left first-child" style="padding-top:100px;">Business investments</h2>
        <p style="font-size:16px;">Cooperation with us means investments in your business. We save your  time and money while implementing BIM technologies and do it a lot better than others.</p>
        <p style="font-size:16px;">We provide free training applied to your projects, record videos of the training and do not limit the size of a study group.</p>
      </div>
      <div class="col-md-12 sm-margin hidden-xs hidden-sm" >
        <div class="col-lg-4">
          <div class="blog">
            <img src="<?php echo get_template_directory_uri().'/img/people/alexandrov.jpg'; ?>" >
            <div class="blog-desc">
              <h5>А. V. Alexandrov,</h5>
              <h6>Head of the Design Department CJSC “SVEKO Engineering”</h6>
              <p>&laquo;Thanks to Vysotskiy Consulting services CJSC “SSI” has developed an internal BIM -standard for the company, has provided effective teamwork and developed the use of 4 D-technologies (3D-construction method statement) &raquo;<br>
                <a href="#" data-toggle="modal" data-target="#3" style="color:#777777;">all text</a>
              <div class="modal " id="3" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="img" style="width:600px !important;">
                  <img src="<?php echo get_template_directory_uri().'/img/otz/3.png'; ?>" >
                </div>
              </div>
              </p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="blog">
            <img src="<?php echo get_template_directory_uri().'/img/people/leonov.jpg'; ?>">
            <div class="blog-desc">
              <h5>V.V.Leonov,</h5>
              <h6>CEO <br>Mosgosexpertiza (Moscow State Expertise Agency)</h6>
              <p>&laquo;Highly-qualified practicing trainers of Vysotskiy Consulting can answer any question in simple terms &raquo;<br>
                <a href="#" data-toggle="modal" data-target="#2" style="color:#777777;">all text</a>
              <div class="modal " id="2" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="img" style="width:600px !important;">
                  <img src="<?php echo get_template_directory_uri().'/img/otz/2.png'; ?>" >
                </div>
              </div>
              </p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="blog">
            <img src="<?php echo get_template_directory_uri().'/img/people/tischenko.jpg'; ?>">
            <div class="blog-desc">
              <h5>S.N.Tishchenko,</h5>
              <h6>Managing Director of “TumenNIPIneft” (“Tumen Research and Design Institute”)</h6>
              <p>&laquo;Flexible approach of Vysotskiy Consulting to customer needs and highly-qualified Revit trainers have provided an opportunity to start using the program on the next day after completing the training &raquo;<br>
                <a href="#" data-toggle="modal" data-target="#1" style="color:#777777;">all text</a>
              <div class="modal " id="1" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="img" style="width:600px !important;">
                  <img src="<?php echo get_template_directory_uri().'/img/otz/1.png'; ?>" >
                </div>
              </div>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div></div>
  <div class="section" data-anchor="clients">
    <div class="container">
      <div class="row">
        <div class="col-lg-7 text-center hidden-xs hidden-sm" style="display:block; text-align:center; margin:0 auto;">
          <div class="s_item"><img src="<?php echo get_template_directory_uri().'/img/main/aecom.jpg'; ?>"></div>
          <div class="s_item"><img src="<?php echo get_template_directory_uri().'/img/main/centromash.jpg'; ?>"></div>
          <div class="s_item"><img src="<?php echo get_template_directory_uri().'/img/main/etalon.jpg'; ?>"></div>
          <div class="s_item"><img src="<?php echo get_template_directory_uri().'/img/main/au.jpg'; ?>"></div>
          <div class="s_item"><img src="<?php echo get_template_directory_uri().'/img/main/tebodin.jpg'; ?>"></div>
          <div class="s_item"><img src="<?php echo get_template_directory_uri().'/img/main/sveko.jpg'; ?>"></div>
          <div class="s_item"><img src="<?php echo get_template_directory_uri().'/img/main/spbgos.jpg'; ?>"></div>
          <div class="s_item"><img src="<?php echo get_template_directory_uri().'/img/main/tumen.jpg'; ?>"></div>
          <div class="s_item"><img src="<?php echo get_template_directory_uri().'/img/logos/vips.png'; ?>" ></div>
          <div class="s_item"><img src="<?php echo get_template_directory_uri().'/img/logos/ytong.png'; ?>" ></div>
          <div class="s_item"><img src="<?php echo get_template_directory_uri().'/img/logos/mosgos.png'; ?>" ></div>
          <div class="s_item"><img src="<?php echo get_template_directory_uri().'/img/logos/studio44.png'; ?>" ></div>
          <div class="s_item"><img src="<?php echo get_template_directory_uri().'/img/logos/spbstu.png'; ?>" ></div>
          <div class="s_item"><img src="<?php echo get_template_directory_uri().'/img/logos/semeren.png'; ?>" ></div>
          <div class="s_item"><img src="<?php echo get_template_directory_uri().'/img/logos/rosjeldor.png'; ?>" ></div>
          <div class="s_item"><img src="<?php echo get_template_directory_uri().'/img/logos/nic.png'; ?>" ></div>
          <div class="s_item"><img src="<?php echo get_template_directory_uri().'/img/logos/minsk.png'; ?>" ></div>
          <div class="s_item"><img src="<?php echo get_template_directory_uri().'/img/logos/metallimpress.png'; ?>" ></div>
          <div class="s_item"><img src="<?php echo get_template_directory_uri().'/img/logos/legion.png'; ?>" ></div>
          <div class="s_item"><img src="<?php echo get_template_directory_uri().'/img/logos/intellect.png'; ?>" ></div>
          <div class="s_item"><img src="<?php echo get_template_directory_uri().'/img/logos/esk.png'; ?>" ></div>
          <div class="s_item"><img src="<?php echo get_template_directory_uri().'/img/logos/buroteh.png'; ?>" ></div>
          <div class="s_item"><img src="<?php echo get_template_directory_uri().'/img/logos/vips.png'; ?>" ></div>
        </div>
        <div class="col-lg-5 lg-margin text-center">
          <h2 class="headline-lg headline-lg_center first-child">Stay leading</h2>
          <p class="text-muted">Leaders in such branches as: architect bureau, project and construction companies, government organizations. They have improved their efficiency due to our services.</p>
          <div class="col-sm-4 text-center">
            <h4>
            <span id="num" style="font-size: 50px;">750</span><br> trained</h2>
          </div>
          <div class="col-sm-4 text-center">
            <h4>
            <span style="font-size: 50px;">84</span><br> leading companies</h2>
          </div>
          <div class="col-sm-4 text-center">
            <h4>
            <span style="font-size: 50px;">23</span><br> BIM reports</h2>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="section" data-anchor="callback">
    <div class="maincnt" style="display: flex;">
        <div class="container">
          <div class="col-lg-6 text-center flex">
            <h2>Alexandr Vysotskiy</h2>
            <p>CEO</p>
          </div>
        </div>
      </div>
    <div class="container nz margin">
      <div class="col-lg-6 text-center lg-margin">
        <h3>+ 7 911 826-98-94 | <a href="mailto:contact@bim.vc">av@bim.vc</a></h3>
      </div>
      <div class="col-lg-6">
        <h2>We are always at your service</h2>
        <p class="text-muted margin">Contact me directly and I will tell You how to organize the implementation as well as your work and achieve impressive results.
          <br><br>
        </p>
        <br>    
      </div>
    </div>
  </div>
</div>
</body>
<!-- Yandex.Metrika counter -->
<script type="text/javascript"> (function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter34006360 = new Ya.Metrika({ id:34006360, clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true }); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = "https://mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks");</script>
<noscript>
  <div><img src="https://mc.yandex.ru/watch/34006360" style="position:absolute; left:-9999px;" alt="" /></div>
</noscript>
<!-- /Yandex.Metrika counter -->
</html>