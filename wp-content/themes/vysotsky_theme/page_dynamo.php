<?php
/*
Template Name: Курс по Динамо
*/
?>
<?php get_header(); ?>
<script src="/css/emerge.js"></script>
<script src="/css/uikit/js/uikit.min.js"></script>
<link rel="stylesheet" href="/css/uikit/css/uikit.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.4.1/css/swiper.min.css">
<style>
	body{
	    background: linear-gradient(to left, #28a5f5, #1e87f0);
	}
	li{
	    line-height: 1.8;
	}
	.swiper-slide{
		width: 100%;
		background-repeat: no-repeat;
		background-position: center center;
	}
	.swiper-container{
		height: 500px;
		margin-top: 66px;
	}
	.dynamoblock{
		margin: 40px 0 40px 0;
		padding: 40px 60px;
		background-color: white;
		box-shadow: 0 5px 15px rgba(0,0,0,0.08);
	}
	.dynamoUpContainer{
		z-index:9;
		position: relative;
		top: -172px;
		background-color: white;
		box-shadow: 0 5px 15px rgba(0,0,0,0.08);
		padding: 40px 60px;
		min-height: 500px;
		margin-bottom: -170px;
	}
	.container{
		max-width: 950px !important;
	}
	.uk-article-title, .uk-article-meta{

	}
	.dynamoIcon{
		margin-left: 100px;
		position: relative;
	}
	.dynamoIcon:before{
		content: '';
		position: absolute;
		left: -115px;
		width: 100px;
		height: 100px;
		background-image: url('/img/dynamocourse/dynamo_icon.png');
		-webkit-background-size: cover;
		     -o-background-size: cover;
		        background-size: cover;
		background-repeat: no-repeat;
	}
</style>

<div class="swiper-container emerge" data-effect="slide">
    <div class="swiper-wrapper dynamo" style="opacity: 0.5;">
        <div class="swiper-slide" style="background-image: url('/img/dynamocourse/1.png')"></div>
        <div class="swiper-slide" style="background-image: url('/img/dynamocourse/2.png')"></div>
        <div class="swiper-slide" style="background-image: url('/img/dynamocourse/3.png')"></div>
        <div class="swiper-slide" style="background-image: url('/img/dynamocourse/4.png')"></div>
        <div class="swiper-slide" style="background-image: url('/img/dynamocourse/5.jpg')"></div>
    </div>
</div>

<div class="container">
	<div class="dynamoUpContainer emerge" data-effect="slide" data-hold="300">
		<article class="uk-article">
		    <h1 class="uk-article-title dynamoIcon">Dynamo: автоматизация рутины и новые функции для Revit</h1>
		    	<p class="uk-article-meta">Сделать недельную работу за один день</p>
				<h3>Dynamo — возможность добавить в Revit новые функции</h3>
		    	<p>Dynamo - это бесплатное дополнение для Autodesk Revit. С помощью Dynamo можно научить Revit новым действиям: строить геометрию, работать с данными, обновлять свойства и даже отправлять электронные письма.</p>

				<p>Обычно для программирования нужно писать сложный код, который понятен лишь избранным.</p> 

				<p>В Dynamo вместо сложного кода используются простые блоки, написанные человеческим языком. Из блоков собираются правила, по которым будет работать Revit. Такой подход называется визуальным программированием.</p> 

				<p>В курсе мы научим визуальному программированию в Dynamo под Autodesk Revit. Это поможет навсегда забыть про рутинные операции и откроет новый функционал.</p>

			    <div class="uk-text-center">
			        <div class="uk-inline-clip uk-transition-toggle">
			            <img class="uk-transition-opaque" src="/img/dynamocourse/3.png" alt="">
			        </div>
			    </div>

				<h3>Revit + Dynamo: ограничений нет</h3>
				<p>Функционал Dynamo очень широк и позволяет автоматизировать практически любую операцию.</p>
				<h4>Создание новых элементов</h4>
				<ul>
					<li>Построение сложной геометрии по формуле</li>
					<li>Размещение компонентов по правилам. Например, выключатели сбоку от двери, а радиаторы под окном</li>
					<li>Отделка в зависимости от параметров помещения</li>
					<li>Криволинейное армирование</li>
				</ul>
				<h4>Работа со свойствами и параметрами</h4>
				<ul>
					<li>Переименовка помещений, дверей, уровней</li>
					<li>Формирование ведомости отделки</li>
					<li>Расчет квартирографии</li>
					<li>Обновление семейств, подключение новых параметров сразу многим объектам</li>
					<li>Инженерные расчеты (теплотехнический, гидравлический, балансировочный расчёты, расчёт инсоляции)</li>
				</ul>
				<h4>Дополнительные возможности</h4>
				<ul>
					<li>Сравнение моделей</li>
					<li>Импорт/экспорт данных в Excel</li>
					<li>Автоматизированные проверки модели</li>
				</ul>

				<!-- text block two -->

				<h3>Курс для тех, кто знаком с Revit</h3>
				<p>Курс рекомендуется всем, кто хочет ускорить процесс проектирования, сократить ошибки и найти новые возможности в программе. Наибольшая отдача от курса будет  для продвинутых проектировщиков, BIM-менеджеров и IT’шников.</p>

				<p>Требуется опыт проектирования в Autodesk Revit хотя бы в объеме  курса «Autodesk Revit: начальный». Уметь программировать не нужно.</p>

				<!-- text block two -->

				<h3>У нас лучше</h3>
				<p>Особенность обучения в <b>Vysotskiy Consulting</b> - это результативность.</p>
				<p>Преподаватель - практик, один из ведущих экспертов по Dynamo в России. Разработал в Dynamo множество полезных решений - от анализа различий между BIM-моделями до автоматической расстановки оборудования и энергетического расчета здания.</p>
				<p>Благодаря опытному преподавателю вы получите ответы на все вопросы и научитесь инструментам, которые используют в работе профессионалы.</p>
				<p>В ходе курса мы поощряем вопросы и проводим специальные &#171;круглые столы&#187;, где разбираем проблемы участников. Поэтому еще в ходе обучения вы сможете составить план дальнейшего использования Dynamo в работе.</p>
				<p>Если есть конкретная задача - вы можете прислать нам её заранее и мы постараемся показать решение в ходе курса.</p>
				<p>Чтобы знания сохранились надолго, мы предоставим комплект раздаточных материалов:</p>
					<ul>
						<li>Разработанные скрипты - готовые решения для многих задач</li>
						<li>Фирменные блокноты с полезными BIM-советами</li>
						<li>Универсальный шаблон, который поможет писать свои программы для Dynamo</li>
					</ul>
				<div class="uk-panel">
				    <img class="uk-align-left uk-margin-remove-adjacent" src="/img/dynamocourse/cert.png" width="200" height"80" alt="">
				    <p>По окончании обучения мы предоставим каждому участнику именной сертификат международного образца. В любой стране мира он будет являться подтверждением ваших навыков.</p>
				</div>
		</article>
	</div>
	<div class="dynamoblock" data-expose="true" data-effect="slide">
		<article class="uk-article">
				<h2>Программа курса - решение реальных задач</h2>
				<ul uk-accordion>
				    <li class="uk-open">
				        <h3 class="uk-accordion-title">День 1: Главные принципы автоматизации</h3>
				        <div class="uk-accordion-content">
							<p>Введение</p>
							<ul>
								<li>Dynamo как инструмент расширения функционала Autodesk Revit. Понятие визуального программирования</li>
								<li>Типы задач, решаемых с помощью Dynamo</li>
								<li>Примеры применения Dynamo</li>
								<li>Способы расширения возможностей Revit</li>
							</ul>
							<p>Начало работы</p>
							<ul>
								<li>Интерфейс программы</li>
								<li>Типы данных</li>
								<li>Связь с моделью Revit и другими форматами</li>
								<li>Геометрия в Dynamo</li>
								<li>Особенности работы с нодами и оформление скриптов</li>
							</ul>
				        </div>
				    </li>
				    <li>
				        <h3 class="uk-accordion-title">День 2: Расширенные возможности</h3>
				        <div class="uk-accordion-content">
							<ul>
								<li>Пользовательские ноды и пакеты</li>
								<li>Язык Design Script</li>
								<li>Язык IronPython</li>
								<li>Работа со справочными ресурсами</li>
								<li>Dynamo Player</li>
							</ul>
				        </div>
				    </li>
				    <li>
				        <h3 class="uk-accordion-title">День 3: Решение практических задач</h3>
				        <div class="uk-accordion-content">
							<p>Общие задачи</p>
							<ul>
								<li>Удобный поиск элементов </li>
								<li>Перенос параметров между типами и экземплярами</li>
								<li>Случайная расстановка объектов</li>
								<li>Работа с оформлением и другие вопросы</li>
							</ul>
							<p>Dynamo для архитекторов</p>
							<ul>
								<li>Перемаркировка элементов</li>
								<li>Отслеживание отзеркаленных элементов</li>
								<li>Создание стены по сложной траектории</li>
								<li>Ведомость отделки</li>
							</ul>
							<p>Dynamo для инженеров</p>
							<ul>
								<li>Пакетная расстановка оборудования</li>
								<li>Расчёт теплопотерь, балансировочный расчёт</li>
								<li>Криволинейное армирование</li>
							</ul>
							<p>Dynamo для BIM-менеджеров</p>
							<ul>
								<li>Управление моделью как базой данных</li>
								<li>Автоматизированные проверки модели</li>
								<li>Связь с Nawisworks</li>
							</ul>
				        </div>
				    </li>
				    <li>
				        <h3 class="uk-accordion-title">Заключение</h3>
				        <div class="uk-accordion-content">
							<ul>
								<li>Внедрение Dynamo на предприятии</li>
								<li>Пути развития</li>
							</ul>
				        </div>
				    </li>
				</ul>
		</article>
	</div>
	<div class="dynamoblock" data-expose="true" data-effect="slide">
		<article class="uk-article">
			<h2 style="text-align: center;">Что? Где? Когда? Организационные вопросы</h2>
			<div class="uk-child-width-1-2@m uk-grid-match" uk-grid>
			    <div>
			        <div class="uk-card uk-card-default uk-card-body">
			            <h3 class="uk-card-title"><span class="uk-margin-small-right" uk-icon="icon: calendar"></span>Даты</h3>
			            <p>13-15 марта</p>
			            <p>Время обучения:<br>10:00 - 13:00, 14:00 - 17:00</p>
			            <p>Чтобы усваивать материал было легче предусмотрены кофе-брейки со сладкими закусками</p>
			        </div>
			    </div>
			    <div>
			        <div class="uk-card uk-card-default uk-card-body">
			            <h3 class="uk-card-title"><span class="uk-margin-small-right" uk-icon="icon: credit-card"></span>Стоимость</h3>
			            <p>30 000 ₽ / участник</p>
			        </div>
			    </div>
			    <div>
			        <div class="uk-card uk-card-default uk-card-body">
			            <h3 class="uk-card-title"><span class="uk-margin-small-right" uk-icon="icon: location"></span>Место</h3>
			            <p>Санкт-Петербург, Лиговский пр., 54, отель Ibis, зал «Казанский»</p>
			            <p>Самый центр города: до Невского проспекта 3 мин. пешком, от Сапсана до учебного класса - 10 мин пешком.</p>
			            <p>Участники из других городов после обучения смогут дойти до Эрмитажа, погулять по набережной Невы</p>
			        </div>
				</div>
				<div>
			        <div class="uk-card uk-card-default uk-card-body" style="padding: 0 !important;">
        				<script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?sid=j0PdJBYsdKdQTMYdqeaVQFT0XotoBoBB&amp;width=380&amp;height=389&amp;lang=ru_RU&amp;sourceType=constructor&amp;scroll=true"></script>
			        </div>
				</div>
			</div>
		</article>
	</div>
	<div class="dynamoblock" data-expose="true" data-effect="slide">
		<article class="uk-article">
			<h2 style="text-align: center;">Хочу обучиться Dynamo. Что делать?</h2>
			<ul style="list-style-type: none; ">
				<li><span class="uk-margin-small-right" uk-icon="icon: arrow-right"></span> Напишите нам на <a href="contact@bim.vc">contact@bim.vc</a> с темой «Курс Dynamo»</li>
				<li><span class="uk-margin-small-right" uk-icon="icon: arrow-right"></span> Мы подготовим документы</li>
				<li><span class="uk-margin-small-right" uk-icon="icon: happy"></span> Оплатите участие и приезжайте на курс</li>
			</ul>
		</article>
	</div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.4.1/js/swiper.min.js"></script>
<script>  
	var mySwiper = new Swiper ('.swiper-container', {
		autoplay: 3000,
		effect: 'fade',
	});        
</script>