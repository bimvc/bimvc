<?php
  /*
  Template Name: MainPage
  */
  ?>
<?php get_header(); ?>
<link  href="http://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.css" rel="stylesheet">
<link href="<?php echo get_template_directory_uri().'/css/jquery.fullpage.min.css'; ?>" rel="stylesheet">
    <div id="fullpage" class="emerge">
      <div class="section" data-anchor="main">
        <div class="home-parallax bg-parallax blackout emerge" data-blackout-max="70">
          <div class="blackout__layer"></div>
          <div class="home-parallax__inner">
            <div class="container">
              <div class="row">
                <div class="col-xs-12 animated fadeInDown">
                  <h1> Мы &#8212; признанные эксперты по эффективному внедрению<br>BIM технологий</h1>
                  <p>Переведём вашу компанию на BIM быстро и результативно. Проверено.</p>
                  <a href="#7" class="btn btn-lg btn-theme-primary">Перейти на BIM</a>
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
              <li><img src="<?php echo get_template_directory_uri().'/img/logos/tebodin.png'; ?>" style="opacity: 0.5;"></li>
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
				<div class="col-md-6">
					<h2 class="headline-lg headline-lg_left first-child">Почему мы лучшие?</h2>
					<p class="text-muted">Мы добились уникальной для рынка BIM-консалтинга эффективности благодаря профессионализму и высочайшему качеству услуг.</p>
					<p class="text-muted"> Существенно повысим вашу производительность при проектировании, строительстве, эксплуатации или ведении экспертной деятельности.</p>
					<p class="text-muted">Накопленные нами знания и опыт позволяют решить любой вопрос, связанный с BIM: внедрение &laquo;под ключ&raquo;, обучение, аудит, поддержка, разработка документов и многое другое.</p>
				</div>
				<div class="col-md-6">
					<div class="youtube" id="W5NSFFwjlIk" style="background-image: url(&quot;http://i.ytimg.com/vi/W5NSFFwjlIk/sddefault.jpg&quot;); width: 100%; height: 300px; ">
					  <div class="play"></div>
					</div>
				</div>
			</div>
			<div class="row">
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
<div class="section" data-anchor="liders" style="background-image:url(<?php echo get_template_directory_uri().'/img/lider.png'; ?>); background-size:cover;">
	<div class="container">
	    <div class="row">
	      <div class="col-md-10 sm-margin">
	        <h2 class="headline-lg headline-lg_left first-child">Лидеры отрасли</h2>
	        <p class="text-muted">Добиваться высочайшего качества BIM-консалтинга нам позволяет команда лучших в России и СНГ BIM-экспертов.</p>
	        <p class="text-muted">Преподаватели Vysotskiy consulting &#8212; действующие проектировщики с многолетним стажем профильной работы. Отлично понимают нужды и проблемы реального проектного процесса, знают ответы на все практические вопросы и умеют легко объяснять даже самые сложные темы. </p>
	      </div>
	    </div>
	    <div class="row" style="margin-top:30px;">
	        <div class="col-md-6">
	          <div class="blog">
	            <img style="max-width:100%;" src="<?php echo get_template_directory_uri().'/img/pics/av.png'; ?>">
	            <div class="blog-desc">
	              <p class="text-muted"><b>Александр Высоцкий</b><br> BIM-опыт более 8 лет<br>Обучал и внедрял BIM <br>в ведущих компаниях России и СНГ<br>ТОП-100 лучших преподавателей BIM<br>Преподаватель СПбСТУ</p>
	            </div>
	          </div>
	        </div>
	        <div class="col-md-6">
	          <div class="blog">
	            <img style="max-width:100%;" src="<?php echo get_template_directory_uri().'/img/pics/sm.png'; ?>" >
	            <div class="blog-desc">
	              <p class="text-muted"><b>Сергей Макаров</b><br>5 лет BIM-менеджмента<br>Уникальный опыт создания BIM-среды<br>Авторский курс по BIM в Южно-Уральском государственном университете</p>
	            </div>
	          </div>
	        </div>
	    </div>
	</div>
</div>
<div class="section" data-anchor="proj">
    <div class="container">
		<div class="row">
            <div class="fotorama" data-width="1200" data-height="400" data-maxwidth="100%">
                <div>
              <div class="col-lg-7" style="text-align:center;">
              <img style="max-height:100%;" src="http://bim.vc/img/slider/1.png">
              </div>
              <div class="col-xs-5 lg-margin">
              <h4>Завод соковой продукции</h4>
              <p>AECOM</p>
              <p>сокращение сроков проектирования на 30%</p>
              <p>упрощение согласований</p>
              <p>повышение точности на <b>300%</b></p>
              </div>
              </div>
              <div>
              <div class="col-lg-7" style="text-align:center;">
              <img style="max-height:100%;" src="http://bim.vc/img/slider/2.png">
              </div>
              <div class="col-xs-5 lg-margin">
              <h4>Жилой квартал &laquo;Северная столица&raquo;</h4>
              <p>VELLCOM group</p>
              <p>50% сокращение сроков проектирования</p>
              <p>на 300% выше скорость изменений</p>
              <p>в 4 раза меньше ошибок</p>
              </div>
              </div>
              <div>
              <div class="col-lg-7" style="text-align:center;">
              <img style="max-height:100%;" src="http://bim.vc/img/slider/3.png">
              </div>
              <div class="col-xs-5 lg-margin">
              <h4>Вокзал&laquo;Олимпийский парк&raquo; (г. Сочи)</h4>
              <p>Студия 44</p>
              <p>разработка уникальных несущих конструкций</p>
              <p>подготовка данных для производства</p>
              <p>точный и быстрый монтаж благодаря BIM-модели</p>
              </div>
              </div>
              <div>
              <div class="col-lg-7" style="text-align:center;">
              <img style="max-height:100%;" src="http://bim.vc/img/slider/4.png">
              </div>
              <div class="col-xs-5 lg-margin">
              <h4>Жилой дом в г. Челябинск</h4>
              <p>Легион-проект</p>
              <p>сокращение сроков проектирования на 30...70%</p>
              <p>ускорение внесения изменений в 3 раза</p>
              <p>отсутствие "монтажа по месту" при строительстве</p>
              </div>
              </div>
            </div>				
		</div>
        <div class="row">
              <div class="col-md-8">
					<h2 class="headline-lg headline-lg_left first-child">Проверенный результат</h2>
					<p class="text-muted">Лучший показатель профессиональной работы &#8212; результаты компаний, доверивших нам переход на BIM.</p>
					<p class="text-muted">После нашей поддержки организации выполняли с помощью BIM-технологий сложнейшие проекты, получали награды и признания.</p>
					<p class="text-muted">Со всеми заказчиками мы ориентируемся на долгосрочный результат, основанный на доверии и взаимной поддержке.</p>
              </div>
        </div>
	</div>
</div>

    <div class="section" data-anchor="buisness" style="background-image:url(<?php echo get_template_directory_uri().'/img/invest.png'; ?>); background-size:cover;">
        <div class="container">
			<div class="row">
				<div class="col-md-10 col-sm-12" style="font-size:16px;">
					<h2 class="headline-lg headline-lg_left first-child" style="padding-top:100px;">Инвестиция в бизнес</h2>
					<p style="font-size:16px;">Работа с нами - это инвестиция в бизнес. Мы экономим вам время и деньги при внедрении BIM технологий и делаем это лучше других. Мы бесплатно ведем обучение на ваших проектах, делаем видеозапись учебного курса и не ограничиваем размер учебной группы.</p>
				</div>
			</div>
	        <div class="row" style="margin-top:30px;">
		        <div class="col-md-4">
		          <div class="blog">
		            <img src="<?php echo get_template_directory_uri().'/img/people/alexandrov.jpg'; ?>" >
		            <div class="blog-desc">
		              <h5>А. В. Александров,</h5>
		              <h6>Начальник отдела проектирования ЗАО «СВЕКО Союз Инжиниринг»</h6>
		              <p>&laquo; Благодаря услугам Высоцкий Консалтинг ЗАО «ССИ» разработали внутренний BIM-стандарт компании, организовали эффективную коллективную работу, улучшили использование 4D-технологий (3D-ПОС)&raquo;<br>
		                <a href="#" data-toggle="modal" data-target="#3" style="color:#777777;">весь отзыв</a>
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
		              <h5>В. В. Леонов,</h5>
		              <h6>Руководитель <br>Мосгосэкспертизы</h6>
		              <p>&laquo;Преподаватели Высоцкий Консалтинг - высококвалифицированные практики, отвечавшие на все вопросы в максимально доступной форме&raquo;<br>
		                <a href="#" data-toggle="modal" data-target="#2" style="color:#777777;">весь отзыв</a>
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
		              <h5>С. Н. Тищенко,</h5>
		              <h6>Генеральный директор ЗАО «ТюменьНИПИнефть»</h6>
		              <p>&laquo;Гибкий подход компании Высоцкий Консалтинг к потребностям клиентов и высокая квалификация преподавателей в Revit дали возможность начать работу в программе буквально на следующий день после обучения&raquo;<br>
		                <a href="#" data-toggle="modal" data-target="#1" style="color:#777777;">весь отзыв</a>
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
	</div>
<div class="section" data-anchor="clients">
	<div class="container">
	  <div class="row">
	    <div class="col-md-7 hidden-sm hidden-xs" style="display:block; text-align:center; margin:0 auto;">
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
	    <div class="col-md-5 lg-margin text-center">
	    	<div class="row">
				<h2 class="headline-lg headline-lg_center first-child">Будьте среди лидеров</h2>
				<p class="text-muted">
				Нам доверяют лидеры отрасли: архитектурные бюро, проектные и строительные компании, государственные учреждения. Они уже повысили свою эффективность благодаря нашим услугам.
				</p>
	    	</div>
	    	<div class="row">
				<div class="col-md-4 text-center">
					<h4><span id="num" style="font-size: 50px;">750</span><br> обученных</h2>
				</div>
				<div class="col-md-4 text-center">
					<h4><span style="font-size: 50px;">84</span><br> компании - лидера</h2>
				</div>
				<div class="col-md-4 text-center">
					<h4><span style="font-size: 50px;">23</span><br> доклада по BIM</h2>
				</div>	    	
			</div>
	    </div>
	  </div>
	</div>
</div>
<div class="section" data-anchor="callback">
	<div class="maincnt">
		<div class="container">
			<div class="row">
			      <div class="col-lg-6 text-center flex">
			        <h2>Александр Высоцкий</h2>
			        <p>Генеральный директор</p>
			      </div>
			</div>
		</div>
	</div>
	<div class="container" style="margin-top:20px;">
		<div class="row">
		    <div class="col-md-6 col-sm-6 text-center lg-margin">
				<h3>+ 7 911 826-98-94 | <a href="mailto:contact@bim.vc">av@bim.vc</a></h3>
		    </div>
		    <div class="col-md-6 col-sm-6">
				<h2>Мы всегда поможем</h2>
				<p class="text-muted margin">Свяжитесь со мной напрямую - я расскажу о том, как правильно организовать процесс внедрения, построить вашу работу и добиться впечатляющих результатов.
				</p>
		    </div>
		</div>
	</div>
</div>
</body>
<script src="http://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri().'/js/jquery.fullPage.min.js'; ?>"></script>
<script type="text/javascript">
  $(document).ready(function() {
      $('#fullpage').fullpage({
      	animateAnchor: true, 
      	lockAnchors: false, 
      	anchors: ['main', 'about', 'liders', 'proj', 'buisness', 'clients', 'callback' ], 
      	scrollBar: true, 
      	responsiveWidth: 900, 
      	responsiveHeight: 600, 
      }); 
  });
</script>
<!-- Yandex.Metrika counter -->
<script type="text/javascript"> (function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter34006360 = new Ya.Metrika({ id:34006360, clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true }); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = "https://mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks");</script>
<noscript>
  <div><img src="https://mc.yandex.ru/watch/34006360" style="position:absolute; left:-9999px;" alt="" /></div>
</noscript>
<!-- /Yandex.Metrika counter -->
</html>