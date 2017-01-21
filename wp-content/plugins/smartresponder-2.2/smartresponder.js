jQuery.noConflict();
jQuery(document).ready(function($){
	(function () {
		jQuery&&function(i){function t(t,o){var n=i('<span class="minicolors" />'),s=i.minicolors.defaultSettings;t.data("minicolors-initialized")||(o=i.extend(!0,{},s,o),n.addClass("minicolors-theme-"+o.theme).addClass("minicolors-swatch-position-"+o.swatchPosition).toggleClass("minicolors-swatch-left","left"===o.swatchPosition).toggleClass("minicolors-with-opacity",o.opacity),void 0!==o.position&&i.each(o.position.split(" "),function(){n.addClass("minicolors-position-"+this)}),t.addClass("minicolors-input").data("minicolors-initialized",!0).data("minicolors-settings",o).prop("size",7).prop("maxlength",7).wrap(n).after('<span class="minicolors-panel minicolors-slider-'+o.control+'"><span class="minicolors-slider"><span class="minicolors-picker"></span></span><span class="minicolors-opacity-slider"><span class="minicolors-picker"></span></span><span class="minicolors-grid"><span class="minicolors-grid-inner"></span><span class="minicolors-picker"><span></span></span></span></span>'),t.parent().find(".minicolors-panel").on("selectstart",function(){return!1}).end(),"left"===o.swatchPosition?t.before('<span class="minicolors-swatch"><span></span></span>'):t.after('<span class="minicolors-swatch"><span></span></span>'),o.textfield||t.addClass("minicolors-hidden"),o.inline&&t.parent().addClass("minicolors-inline"),c(t,!1,!0))}function o(i){var t=i.parent();i.removeData("minicolors-initialized").removeData("minicolors-settings").removeProp("size").removeProp("maxlength").removeClass("minicolors-input"),t.before(i).remove()}function n(i){c(i)}function s(i){var t=i.parent(),o=t.find(".minicolors-panel"),n=i.data("minicolors-settings");!i.data("minicolors-initialized")||i.prop("disabled")||t.hasClass("minicolors-inline")||t.hasClass("minicolors-focus")||(a(),t.addClass("minicolors-focus"),o.stop(!0,!0).fadeIn(n.showSpeed,function(){n.show&&n.show.call(i.get(0))}))}function a(){i(".minicolors-input").each(function(){var t=i(this),o=t.data("minicolors-settings"),n=t.parent();o.inline||n.find(".minicolors-panel").fadeOut(o.hideSpeed,function(){n.hasClass("minicolors-focus")&&o.hide&&o.hide.call(t.get(0)),n.removeClass("minicolors-focus")})})}function e(i,t,o){var n,s,a,e,c=i.parents(".minicolors").find(".minicolors-input"),l=c.data("minicolors-settings"),h=i.find("[class$=-picker]"),d=i.offset().left,p=i.offset().top,u=Math.round(t.pageX-d),g=Math.round(t.pageY-p),m=o?l.animationSpeed:0;t.originalEvent.changedTouches&&(u=t.originalEvent.changedTouches[0].pageX-d,g=t.originalEvent.changedTouches[0].pageY-p),0>u&&(u=0),0>g&&(g=0),u>i.width()&&(u=i.width()),g>i.height()&&(g=i.height()),i.parent().is(".minicolors-slider-wheel")&&h.parent().is(".minicolors-grid")&&(n=75-u,s=75-g,a=Math.sqrt(n*n+s*s),e=Math.atan2(s,n),0>e&&(e+=2*Math.PI),a>75&&(a=75,u=75-75*Math.cos(e),g=75-75*Math.sin(e)),u=Math.round(u),g=Math.round(g)),i.is(".minicolors-grid")?h.stop(!0).animate({top:g+"px",left:u+"px"},m,l.animationEasing,function(){r(c,i)}):h.stop(!0).animate({top:g+"px"},m,l.animationEasing,function(){r(c,i)})}function r(i,t){function o(i,t){var o,n;return i.length&&t?(o=i.offset().left,n=i.offset().top,{x:o-t.offset().left+i.outerWidth()/2,y:n-t.offset().top+i.outerHeight()/2}):null}var n,s,a,e,r,c,h,d=i.val(),u=i.attr("data-opacity"),m=i.parent(),f=i.data("minicolors-settings"),v=(m.find(".minicolors-panel"),m.find(".minicolors-swatch")),y=m.find(".minicolors-grid"),w=m.find(".minicolors-slider"),M=m.find(".minicolors-opacity-slider"),C=y.find("[class$=-picker]"),x=w.find("[class$=-picker]"),k=M.find("[class$=-picker]"),S=o(C,y),P=o(x,w),z=o(k,M);if(t.is(".minicolors-grid, .minicolors-slider")){switch(f.control){case"wheel":e=y.width()/2-S.x,r=y.height()/2-S.y,c=Math.sqrt(e*e+r*r),h=Math.atan2(r,e),0>h&&(h+=2*Math.PI),c>75&&(c=75,S.x=69-75*Math.cos(h),S.y=69-75*Math.sin(h)),s=g(c/.75,0,100),n=g(180*h/Math.PI,0,360),a=g(100-Math.floor(P.y*(100/w.height())),0,100),d=b({h:n,s:s,b:a}),w.css("backgroundColor",b({h:n,s:s,b:100}));break;case"saturation":n=g(parseInt(S.x*(360/y.width())),0,360),s=g(100-Math.floor(P.y*(100/w.height())),0,100),a=g(100-Math.floor(S.y*(100/y.height())),0,100),d=b({h:n,s:s,b:a}),w.css("backgroundColor",b({h:n,s:100,b:a})),m.find(".minicolors-grid-inner").css("opacity",s/100);break;case"brightness":n=g(parseInt(S.x*(360/y.width())),0,360),s=g(100-Math.floor(S.y*(100/y.height())),0,100),a=g(100-Math.floor(P.y*(100/w.height())),0,100),d=b({h:n,s:s,b:a}),w.css("backgroundColor",b({h:n,s:s,b:100})),m.find(".minicolors-grid-inner").css("opacity",1-a/100);break;default:n=g(360-parseInt(P.y*(360/w.height())),0,360),s=g(Math.floor(S.x*(100/y.width())),0,100),a=g(100-Math.floor(S.y*(100/y.height())),0,100),d=b({h:n,s:s,b:a}),y.css("backgroundColor",b({h:n,s:100,b:100}))}i.val(p(d,f.letterCase))}t.is(".minicolors-opacity-slider")&&(u=f.opacity?parseFloat(1-z.y/M.height()).toFixed(2):1,f.opacity&&i.attr("data-opacity",u)),v.find("SPAN").css({backgroundColor:d,opacity:u}),l(i,d,u)}function c(i,t,o){var n,s,a,e,r,c,h,d=i.parent(),m=i.data("minicolors-settings"),f=d.find(".minicolors-swatch"),y=d.find(".minicolors-grid"),w=d.find(".minicolors-slider"),M=d.find(".minicolors-opacity-slider"),C=y.find("[class$=-picker]"),x=w.find("[class$=-picker]"),k=M.find("[class$=-picker]");switch(n=p(u(i.val(),!0),m.letterCase),n||(n=p(u(m.defaultValue,!0))),s=v(n),t||i.val(n),m.opacity&&(a=""===i.attr("data-opacity")?1:g(parseFloat(i.attr("data-opacity")).toFixed(2),0,1),isNaN(a)&&(a=1),i.attr("data-opacity",a),f.find("SPAN").css("opacity",a),r=g(M.height()-M.height()*a,0,M.height()),k.css("top",r+"px")),f.find("SPAN").css("backgroundColor",n),m.control){case"wheel":c=g(Math.ceil(.75*s.s),0,y.height()/2),h=s.h*Math.PI/180,e=g(75-Math.cos(h)*c,0,y.width()),r=g(75-Math.sin(h)*c,0,y.height()),C.css({top:r+"px",left:e+"px"}),r=150-s.b/(100/y.height()),""===n&&(r=0),x.css("top",r+"px"),w.css("backgroundColor",b({h:s.h,s:s.s,b:100}));break;case"saturation":e=g(5*s.h/12,0,150),r=g(y.height()-Math.ceil(s.b/(100/y.height())),0,y.height()),C.css({top:r+"px",left:e+"px"}),r=g(w.height()-s.s*(w.height()/100),0,w.height()),x.css("top",r+"px"),w.css("backgroundColor",b({h:s.h,s:100,b:s.b})),d.find(".minicolors-grid-inner").css("opacity",s.s/100);break;case"brightness":e=g(5*s.h/12,0,150),r=g(y.height()-Math.ceil(s.s/(100/y.height())),0,y.height()),C.css({top:r+"px",left:e+"px"}),r=g(w.height()-s.b*(w.height()/100),0,w.height()),x.css("top",r+"px"),w.css("backgroundColor",b({h:s.h,s:s.s,b:100})),d.find(".minicolors-grid-inner").css("opacity",1-s.b/100);break;default:e=g(Math.ceil(s.s/(100/y.width())),0,y.width()),r=g(y.height()-Math.ceil(s.b/(100/y.height())),0,y.height()),C.css({top:r+"px",left:e+"px"}),r=g(w.height()-s.h/(360/w.height()),0,w.height()),x.css("top",r+"px"),y.css("backgroundColor",b({h:s.h,s:100,b:100}))}o||l(i,n,a)}function l(i,t,o){var n=i.data("minicolors-settings");t+o!==i.data("minicolors-lastChange")&&(i.data("minicolors-lastChange",t+o),n.change&&(n.changeDelay?(clearTimeout(i.data("minicolors-changeTimeout")),i.data("minicolors-changeTimeout",setTimeout(function(){n.change.call(i.get(0),t,o)},n.changeDelay))):n.change.call(i.get(0),t,o)))}function h(t){var o=u(i(t).val(),!0),n=w(o),s=i(t).attr("data-opacity");return n?(void 0!==s&&i.extend(n,{a:parseFloat(s)}),n):null}function d(t,o){var n=u(i(t).val(),!0),s=w(n),a=i(t).attr("data-opacity");return s?(void 0===a&&(a=1),o?"rgba("+s.r+", "+s.g+", "+s.b+", "+parseFloat(a)+")":"rgb("+s.r+", "+s.g+", "+s.b+")"):null}function p(i,t){return"uppercase"===t?i.toUpperCase():i.toLowerCase()}function u(i,t){return i=i.replace(/[^A-F0-9]/gi,""),3!==i.length&&6!==i.length?"":(3===i.length&&t&&(i=i[0]+i[0]+i[1]+i[1]+i[2]+i[2]),"#"+i)}function g(i,t,o){return t>i&&(i=t),i>o&&(i=o),i}function m(i){var t={},o=Math.round(i.h),n=Math.round(255*i.s/100),s=Math.round(255*i.b/100);if(0===n)t.r=t.g=t.b=s;else{var a=s,e=(255-n)*s/255,r=(a-e)*(o%60)/60;360===o&&(o=0),60>o?(t.r=a,t.b=e,t.g=e+r):120>o?(t.g=a,t.b=e,t.r=a-r):180>o?(t.g=a,t.r=e,t.b=e+r):240>o?(t.b=a,t.r=e,t.g=a-r):300>o?(t.b=a,t.g=e,t.r=e+r):360>o?(t.r=a,t.g=e,t.b=a-r):(t.r=0,t.g=0,t.b=0)}return{r:Math.round(t.r),g:Math.round(t.g),b:Math.round(t.b)}}function f(t){var o=[t.r.toString(16),t.g.toString(16),t.b.toString(16)];return i.each(o,function(i,t){1===t.length&&(o[i]="0"+t)}),"#"+o.join("")}function b(i){return f(m(i))}function v(i){var t=y(w(i));return 0===t.s&&(t.h=360),t}function y(i){var t={h:0,s:0,b:0},o=Math.min(i.r,i.g,i.b),n=Math.max(i.r,i.g,i.b),s=n-o;return t.b=n,t.s=0!==n?255*s/n:0,t.h=0!==t.s?i.r===n?(i.g-i.b)/s:i.g===n?2+(i.b-i.r)/s:4+(i.r-i.g)/s:-1,t.h*=60,t.h<0&&(t.h+=360),t.s*=100/255,t.b*=100/255,t}function w(i){return i=parseInt(i.indexOf("#")>-1?i.substring(1):i,16),{r:i>>16,g:(65280&i)>>8,b:255&i}}i.minicolors={defaultSettings:{animationSpeed:100,animationEasing:"swing",change:null,changeDelay:0,control:"hue",defaultValue:"",hide:null,hideSpeed:100,inline:!1,letterCase:"lowercase",opacity:!1,position:"default",show:null,showSpeed:100,swatchPosition:"left",textfield:!0,theme:"default"}},i.extend(i.fn,{minicolors:function(e,r){switch(e){case"destroy":return i(this).each(function(){o(i(this))}),i(this);case"hide":return a(),i(this);case"opacity":return void 0===r?i(this).attr("data-opacity"):(i(this).each(function(){n(i(this).attr("data-opacity",r))}),i(this));case"rgbObject":return h(i(this),"rgbaObject"===e);case"rgbString":case"rgbaString":return d(i(this),"rgbaString"===e);case"settings":return void 0===r?i(this).data("minicolors-settings"):(i(this).each(function(){var t=i(this).data("minicolors-settings")||{};o(i(this)),i(this).minicolors(i.extend(!0,t,r))}),i(this));case"show":return s(i(this).eq(0)),i(this);case"value":return void 0===r?i(this).val():(i(this).each(function(){n(i(this).val(r))}),i(this));case"create":default:return"create"!==e&&(r=e),i(this).each(function(){t(i(this),r)}),i(this)}}}),i(document).on("mousedown.minicolors touchstart.minicolors",function(t){i(t.target).parents().add(t.target).hasClass("minicolors")||a()}).on("mousedown.minicolors touchstart.minicolors",".minicolors-grid, .minicolors-slider, .minicolors-opacity-slider",function(t){var o=i(this);t.preventDefault(),i(document).data("minicolors-target",o),e(o,t,!0)}).on("mousemove.minicolors touchmove.minicolors",function(t){var o=i(document).data("minicolors-target");o&&e(o,t)}).on("mouseup.minicolors touchend.minicolors",function(){i(this).removeData("minicolors-target")}).on("mousedown.minicolors touchstart.minicolors",".minicolors-swatch",function(){var t=i(this).parent().find(".minicolors-input"),o=t.parent();o.hasClass("minicolors-focus")?a(t):s(t)}).on("focus.minicolors",".minicolors-input",function(){var t=i(this);t.data("minicolors-initialized")&&s(t)}).on("blur.minicolors",".minicolors-input",function(){var t=i(this),o=t.data("minicolors-settings");t.data("minicolors-initialized")&&(t.val(u(t.val(),!0)),""===t.val()&&t.val(u(o.defaultValue,!0)),t.val(p(t.val(),o.letterCase)))}).on("keydown.minicolors",".minicolors-input",function(t){var o=i(this);if(o.data("minicolors-initialized"))switch(t.keyCode){case 9:a();break;case 27:a(),o.blur()}}).on("keyup.minicolors",".minicolors-input",function(){var t=i(this);t.data("minicolors-initialized")&&c(t,!0)}).on("paste.minicolors",".minicolors-input",function(){var t=i(this);t.data("minicolors-initialized")&&setTimeout(function(){c(t,!0)},1)})}(jQuery);
		var f_exportAll = 0;
		//link
		var link = window.location.href;
			link = link.split('wp-admin');
			link = link[0]+'/wp-content/plugins/smartresponder-2.2/';
		// Synchronization
		$(document).on('click', 'input[name="sync_btn"]', function(){
			$('.sync_loading').css('display', 'block');
			$('.text-error').text('').css('display', 'none');
			var api_key = $('input[name="api_key"]').val();
			if(api_key.length > 0) {
				var sync_var = {
					action: 'sync',
					api_key: api_key
				}
				$.getJSON(ajaxurl, sync_var, function(json){
					$('.sync_loading').css('display', 'none');
					if(json.result == '0') {
						$('.text-error').text(json.error.message).css('display', 'block');
					}
					else {
						$('.sr-box').append('<input type="hidden" name="uid" value="'+json.id+'">');
						$('.form_generator').append('<div class="counter_key" style="display: none;"></div>');
						$('.api_key_li img').attr('src', link+'img/api_key_btn.png', '.png');
						$('.form_generator_li img').attr('src', link+'img/form_gen_btn_active.png', '.png');
						$('.export_li img').attr('src', link+'img/export_btn.png', '.png');
						// Get Deliveries
						var deliveries_var = {
							action: 'get_deliveries'                       
						}
						$.ajax({
							url: ajaxurl,
							data: deliveries_var,
							dataType: 'JSON',
							method: 'POST',
							success: function(json){                                                             
								 $.each(json.list.elements, function(i3, item3){
									 var id = item3.id;
									 var title = item3.title;
									 var counter_key = item3.counter_key;
									 var mySelect = jQuery('select[name="deliveries_select"]');
									 mySelect.append(
										 jQuery('<option style="color:black; background-color:white; "></option>').val(id).html(title)
									 );
									 $("select[name='deliveries_select'] option[value='undefined']").each(function() {
										 $(this).remove();
									 });
									 $('.counter_key').append('<input type="hidden" id="'+id+'" value="'+counter_key+'" />');
								 });                                                              
							}
						});
						// Get Tracks
						var tracks_var = {
							action: 'get_tracks'                       
						}
						$.ajax({
							url: ajaxurl,
							data: tracks_var,
							dataType: 'JSON',
							method: 'POST',
							success: function(json){                            
								 $.each(json.list.elements, function(i3, item3){
									 var id = item3.id;
									 var title = item3.title;
									 var mySelect = jQuery('select[name="trackId"]');
									 mySelect.append(
										 jQuery('<option style="color:black; background-color:white; "></option>').val(id).html(title)
									 );
									 $("select[name='trackId'] option[value='undefined']").each(function() {
										 $(this).remove();
									 });                                     
								 });
							}
						});
						$('.sync').css('display', 'none');
						$('.sync_success p').html('Вы зашли как: '+json.login+' ('+json.name_first+' '+json.name_last+')');
						$('.sync_success, .form_generator').css('display', 'block');
					}
				});
			}
			else {
				$('.sync_loading').css('display', 'none');
				$('.text-error').text('Введите API-ключ').css('display', 'block');
			}
		});
		$(document).on('click', '.api_key_li a',function(){
			$('.sync_success, .form_generator, .export').css('display', 'none');
			$('.sync').css('display', 'block');
			$('select[name="deliveries_select"] option, select[name="trackId"] option').remove();
			$('select[name="trackId"]').append('<option value="0">выбрать →</option>');
			$('input[name="api_key"]').val('');
			$('.api_key_li img').attr("src", link+"img/api_key_btn_active.png", ".png");
			$('.form_generator_li img').attr("src", link+"img/form_gen_btn.png", ".png");
			$('.export_li img').attr("src", link+"img/export_btn.png", ".png");
		});
		$(document).on('click', '#sr_menu li.form_generator_li', function(){
			if($('.sync').css('display') == 'block') {
				alert('Для использование Генератора Форм Подписки, вам нужно синхронизироваться.')
			} 
			else {
				$('.form_generator').css('display','block');
				$('.export').css('display', 'none');
				$('.api_key_li img').attr("src", link+"img/api_key_btn.png", ".png");
				$('.form_generator_li img').attr("src", link+"img/form_gen_btn_active.png", ".png");
				$('.export_li img').attr("src", link+"img/export_btn.png", ".png");
			}
		});
		// Form Generator
		// Default
		$('.ac-container input:checked ~ article').css('overflow', 'visible');
		$('.ac-container input[type="radio"]').click(function(){
		   $('.ac-container article').css('overflow', 'hidden');
		   setTimeout(function(){
			   $('.ac-container input:checked ~ article').css('overflow', 'visible');
		   }, 1000);
		});
		// Form width
		$('input[name="form_width"]').keyup(function(){
			if($.trim($('input[name="form_width"]').val() != '')) {
				var wf = parseInt($.trim($('input[name="form_width"]').val()));
				if(wf >= 200 && wf <=400){
					$('.sr-box').css('width',wf);
					$('#bg_image').css('width',wf);
					var field_name_first = $('input[name="field_name_first"]').css('width');
					$('select[name="field_charset_code"], select[name="field_country_id"]').css('width',field_name_first);
					if(wf >= 200 && wf < 260) {
						$('input[name="subscribe"]').css('width','150px');
					}
					else {
						$('input[name="subscribe"]').css('width','208px');
					}
				}
			}
		});
		// Form border
		$('select[name="fBorder"]').change(function(){
			var fBorder = $('select[name="fBorder"] option:selected').val();
			$('.sr-box').css('border',fBorder+'px '+$('#minicolor1').val());
			if($('input[name="f_dashed"]').is(':checked')) {
				$('form[name="SR_form"]').css('border-style', 'dashed');
			} else {
				$('form[name="SR_form"]').css('border-style', 'solid');
			}
		});
		$('INPUT#minicolor1').minicolors({
			animationSpeed: 100,
			animationEasing: 'swing',
			change: function(hex, rgb) {
				$('form[name="SR_form"]').css('border-color',hex);
			},
			changeDelay: 0,
			control: 'hue',
			defaultValue: '',
			hide: null,
			hideSpeed: 100,
			inline: false,
			letterCase: 'lowercase',
			opacity: false,
			position: 'default',
			show: null,
			showSpeed: 100,
			swatchPosition: 'left',
			textfield: true,
			theme: 'default'
		});
		$('INPUT#minicolor2').minicolors({
			animationSpeed: 100,
			animationEasing: 'swing',
			change: function(hex, rgb) {
				$('.sr-box li').css('background-color',hex);
			},
			changeDelay: 0,
			control: 'hue',
			defaultValue: '',
			hide: null,
			hideSpeed: 100,
			inline: false,
			letterCase: 'lowercase',
			opacity: false,
			position: 'default',
			show: null,
			showSpeed: 100,
			swatchPosition: 'left',
			textfield: true,
			theme: 'default'
		});
		// Form border dashed
		$('input[name="f_dashed"]').click(function(){
			var n = $('input[name="f_dashed"]:checked').length;
			if(n == 1) {
				$('form[name="SR_form"]').css('border-style', 'dashed');
			}
			else {
				$('form[name="SR_form"]').css('border-style', 'solid');
			}
		});
		// Show/Hide Form background
		$('input[name="bg_color"]').click(function(){
			var n = $('input[name="bg_color"]:checked').length;
			if(n == 1) {
				var color = $('#minicolor2').val();
				$('.sr-box li').css('background-color',color);
				$('.mc2').show();
			}
			else {
				$('.sr-box li').css('background-color','#FFFFFF');
				$('.mc2').hide();
			}
		});
		// Show/Hide Form head
		$('input[name="element_header"]').click(function(){
			if($('input[name="element_header"]:checked').length == 0) {
				$('.form-header').hide();
			}
			else {
				$('.form-header').show();
			}
		});
		// Element header title
		$('input[name="unique_element_header_title"]').keyup(function(){
			$('.header_title').text($(this).val());
		});
		// Element header font
		$('select[name="unique_element_header_font"]').change(function(){
			var header_font = $('select[name="unique_element_header_font"]').val();
			$('.header_title').css('font-family',header_font);
		});
		// Element header size
		$('select[name="unique_element_header_size"]').change(function(){
			var header_size = $('select[name="unique_element_header_size"]').val();
			$('.header_title').css('font-size',header_size);
		});
		// Element header type
		$('select[name="unique_element_header_type"]').change(function(){
			var header_type = $('select[name="unique_element_header_type"]').val();
			if(header_type == 'normal') {
				$('.header_title').css('font-weight','normal')
								  .css('font-style','normal');
			}
			if(header_type == 'bold') {
				$('.header_title').css('font-weight','bold')
								  .css('font-style','normal');
			}
			if(header_type == 'italic') {
				$('.header_title').css('font-weight','normal')
								  .css('font-style','italic');
			}
		});
		$('INPUT#minicolor3').minicolors({
			animationSpeed: 100,
			animationEasing: 'swing',
			change: function(hex, rgb) {
				$('.header_title').css('color',hex);
			},
			changeDelay: 0,
			control: 'hue',
			defaultValue: '',
			hide: null,
			hideSpeed: 100,
			inline: false,
			letterCase: 'lowercase',
			opacity: false,
			position: 'default',
			show: null,
			showSpeed: 100,
			swatchPosition: 'left',
			textfield: true,
			theme: 'default'
		});
		// Edit type
		$('input[name="edit_type"]').click(function(){
			if($(this).val() == 'field') {
				$('.remove_labels').show();
				$('input[name="field_name_first"], input[name="field_email"]').attr('placeholder','');
				$('.fields').css('height', 'auto');
				$('.sr_initial_field').hide();
				$('.sr_field').show();
			}
			else {
				$('.remove_labels').hide();
				$('input[name="field_name_first"]').attr('placeholder', $('.remove_labels:first').text());
				$('input[name="field_email"]').attr('placeholder', $('.remove_labels:last').text());
				$('.fields').css('height', '66px');
				$('.sr_initial_field').show();
				$('.sr_field').hide();
			}
		});
		// Under Unique Field Initial Forn
		$('select[name="under_unique_field_initial_font"]').change(function(){
			var font = $('select[name="under_unique_field_initial_font"]').val();
			$('.sr-box [type=text], .sr-box select, #sex_table p, #slyle_for_select, #slyle_for_p').css('font-family',font);
			$('input[name="under_field_initial_font"]').val(font);
		});
		// Under Unique Field Initial Size
		$('select[name="under_unique_field_initial_size"]').change(function(){
			var size = $('select[name="under_unique_field_initial_size"]').val();
			$('.sr-box [type=text], .sr-box select, #sex_table p, #slyle_for_select, #style_for_p').css('font-size',size);
			$('input[name="under_field_initial_size"]').val(size);
		});
		// Under Unique Field Initial Type
		$('select[name="under_unique_field_initial_type"]').change(function(){
			var type = $('select[name="under_unique_field_initial_type"]').val();
			if(type == 'normal') {
				$('.sr-box [type=text], .sr-box select, #sex_table p, #style_for_p, #slyle_for_select').css('font-weight','normal')
																									   .css('font-style','normal');
			}
			if(type == 'bold') {
				$('.sr-box [type=text], .sr-box select, #sex_table p, #style_for_p, #slyle_for_select').css('font-weight','bold')
																									   .css('font-style','normal');
			}
			if(type == 'italic') {
				$('.sr-box [type=text], .sr-box select, #sex_table p, #style_for_p, #slyle_for_select').css('font-weight','normal')
																									   .css('font-style','italic');
			}
			$('input[name="under_field_initial_type"]').val(type);
		});
		//add style block to the .sr-box with default placeholder css on page load
		var defaultColor = 'BDBDBD';
		var styleContent = '.sr-box input:-moz-placeholder {color: #' + defaultColor + ';} .sr-box input::-webkit-input-placeholder {color: #' + defaultColor + ';}';
		var styleBlock = '<style id="placeholder-style">' + styleContent + '</style>';
		$('.sr-box').append(styleBlock);
		$('INPUT#minicolor4').minicolors({
			animationSpeed: 100,
			animationEasing: 'swing',
			change: function(hex, rgb) {
				$('.sr-box input[type="text"]').css('color',hex);
				styleContent = '.sr-box input:-moz-placeholder {color: ' + hex + ';} .sr-box input::-webkit-input-placeholder {color: ' + hex + ';}'
				$('#placeholder-style').text(styleContent);
			},
			changeDelay: 0,
			control: 'hue',
			defaultValue: '',
			hide: null,
			hideSpeed: 100,
			inline: false,
			letterCase: 'lowercase',
			opacity: false,
			position: 'default',
			show: null,
			showSpeed: 100,
			swatchPosition: 'left',
			textfield: true,
			theme: 'default'
		});
		// Unique Field Border Weight
		$('select[name="unique_field_border_weight"]').change(function(){
			var border_weight = $('select[name="unique_field_border_weight"]').val();
			$('.sr-box [type=text], .sr-box select, #slyle_for_select').css('border-width',border_weight);
		});
		$('INPUT#minicolor6').minicolors({
			animationSpeed: 100,
			animationEasing: 'swing',
			change: function(hex, rgb) {
				$('.sr-box input[type=text]').css('background',hex);
			},
			changeDelay: 0,
			control: 'hue',
			defaultValue: '',
			hide: null,
			hideSpeed: 100,
			inline: false,
			letterCase: 'lowercase',
			opacity: false,
			position: 'default',
			show: null,
			showSpeed: 100,
			swatchPosition: 'left',
			textfield: true,
			theme: 'default'
		});
		// Over Unique Field Initial Font
		$('select[name="over_unique_field_initial_font"]').change(function(){
			var font = $('select[name="over_unique_field_initial_font"]').val();
			$('.remove_labels, .s_label').css('font-family',font);
			$('input[name="over_field_initial_font"]').val(font);
		});
		// Over Unique Field Initial Size
		$('select[name="over_unique_field_initial_size"]').change(function(){
			var size = $('select[name="over_unique_field_initial_size"]').val();
			$('.remove_labels, .s_label').css('font-size',size);
			$('input[name="over_field_initial_size"]').val(size);
		});
		// Over Unique Field Initial Type
		$('select[name="over_unique_field_initial_type"]').change(function(){
			var type = $('select[name="over_unique_field_initial_type"]').val();
			if(type == 'normal') {
				$('.remove_labels, .s_lebel').css('font-weight','normal')
											 .css('font-style','normal');
			}
			if(type == 'bold') {
				$('.remove_labels, .s_label').css('font-weight','bold')
											 .css('font-style','normal');
			}
			if(type == 'italic') {
				$('.remove_labels, .s_label').css('font-weight','normal')
											 .css('font-style','italic');
			}
			$('input[name="over_field_initial_type"]').val(type);
		});
		$('INPUT#minicolor7').minicolors({
			animationSpeed: 100,
			animationEasing: 'swing',
			change: function(hex, rgb) {
				$('.remove_labels').css('color',hex);
			},
			changeDelay: 0,
			control: 'hue',
			defaultValue: '',
			hide: null,
			hideSpeed: 100,
			inline: false,
			letterCase: 'lowercase',
			opacity: false,
			position: 'default',
			show: null,
			showSpeed: 100,
			swatchPosition: 'left',
			textfield: true,
			theme: 'default'
		});
		// Unique Subscribe Title
		$('input[name="unique_subscribe_title"]').keyup(function(){
			var btn_value = $('input[name="unique_subscribe_title"]').val();
			$('input[name="subscribe"]').val(btn_value);
		});
		// Unique Subscribe font
		$('select[name="unique_subscribe_font"]').change(function(){
			var btn_font_family = $('select[name="unique_subscribe_font"]').val();
			$('input[name="subscribe"]').css('font-family',btn_font_family);
		});
		// Unique Subscribe size
		$('select[name="unique_subscribe_size"]').change(function(){
			var btn_font_size = $('select[name="unique_subscribe_size"]').val();
			$('input[name="subscribe"]').css('font-size',btn_font_size);
			if(parseInt($('input[name="form_width"]').val()) < 260) {
				if($('select[name="unique_subscribe_size"]').val() == '23px' || $('select[name="unique_subscribe_size"]').val() == '24px') {
					$('input[name="subscribe"]').css('width','208px');
				}
				else {
					$('input[name="subscribe"]').css('width','150px');
				}
			}        
		});
		// Unique Subscribe Type
		$('select[name="unique_subscribe_type"]').change(function(){
			var btn_font_weight = $('select[name="unique_subscribe_type"]').val();
			if(btn_font_weight == 'normal') {
				$('input[name="subscribe"]').css('font-weight','normal')
											.css('font-style','normal');
			}
			if(btn_font_weight == 'bold') {
				$('input[name="subscribe"]').css('font-weight','bold')
											.css('font-style','normal');
			}
			if(btn_font_weight == 'italic') {
				$('input[name="subscribe"]').css('font-weight','normal')
											.css('font-style','italic');
			}
		});
		$('INPUT#minicolor8').minicolors({
			animationSpeed: 100,
			animationEasing: 'swing',
			change: function(hex, rgb) {
				$('.sr-box input[name="subscribe"]').css('color',hex);
			},
			changeDelay: 0,
			control: 'hue',
			defaultValue: '',
			hide: null,
			hideSpeed: 100,
			inline: false,
			letterCase: 'lowercase',
			opacity: false,
			position: 'default',
			show: null,
			showSpeed: 100,
			swatchPosition: 'left',
			textfield: true,
			theme: 'default'
		});
		$('INPUT#minicolor9').minicolors({
			animationSpeed: 100,
			animationEasing: 'swing',
			change: function(hex, rgb) {
				$('.sr-box input[name="subscribe"]').attr('style',$('.sr-box input[name="subscribe"]').attr('style')+'border-color: '+hex+' !important;');
			},
			changeDelay: 0,
			control: 'hue',
			defaultValue: '',
			hide: null,
			hideSpeed: 100,
			inline: false,
			letterCase: 'lowercase',
			opacity: false,
			position: 'default',
			show: null,
			showSpeed: 100,
			swatchPosition: 'left',
			textfield: true,
			theme: 'default'
		});
		$('INPUT#minicolor10').minicolors({
			animationSpeed: 100,
			animationEasing: 'swing',
			change: function(hex, rgb) {
				$('.sr-box input[name="subscribe"]').attr('style',$('.sr-box input[name="subscribe"]').attr('style')+'background-color: '+hex+' !important;');
			},
			changeDelay: 0,
			control: 'hue',
			defaultValue: '',
			hide: null,
			hideSpeed: 100,
			inline: false,
			letterCase: 'lowercase',
			opacity: false,
			position: 'default',
			show: null,
			showSpeed: 100,
			swatchPosition: 'left',
			textfield: true,
			theme: 'default'
		});
		// Unique Subscribe Border Weight
		$('select[name="unique_subscribe_border_weight"]').change(function(){
			var btn_border_width = $('select[name="unique_subscribe_border_weight"]').val();
			$('.sr-box input[name="subscribe"]').attr('style',$('.sr-box input[name="subscribe"]').attr('style')+'border-width: '+btn_border_width+'px !important;');
		});
		$('INPUT#minicolor11').minicolors({
			animationSpeed: 100,
			animationEasing: 'swing',
			change: function(hex, rgb) {
				$('#cnt').css('color',hex);
			},
			changeDelay: 0,
			control: 'hue',
			defaultValue: '',
			hide: null,
			hideSpeed: 100,
			inline: false,
			letterCase: 'lowercase',
			opacity: false,
			position: 'default',
			show: null,
			showSpeed: 100,
			swatchPosition: 'left',
			textfield: true,
			theme: 'default'
		});
		$('INPUT#minicolor12').minicolors({
			animationSpeed: 100,
			animationEasing: 'swing',
			change: function(hex, rgb) {
				var uid = $('input[name="uid"]').val();
				var did = $('select[name="deliveries_select"]').val();
				var counter_key = $('#'+did).val();
				var counter_font = $('#nubmer_font').val();
				var counter_size = $('#number_size').val().split('px');
				var counter_color = hex.split('#');
				var counter_bg = $('#minicolor13').val().split('#');
				if($('input[name="number_bg_color"]:checked').length == 0) {
					counter_bg = '0'+counter_bg[1];
				}
				else {
					counter_bg = '1'+counter_bg[1];
				}
				var counter_align = $('#number_alignment').val();
				var counter_img = 'http://smartresponder.ru/dcounter/'+uid+'_'+counter_key+'_'+did+'_1_'+counter_font+'_'+counter_size[0]+'_'+counter_color[1]+'_'+counter_bg+'_'+counter_align+'/counter.gif';
				$('#counter_li img').attr('src', counter_img);
			},
			changeDelay: 0,
			control: 'hue',
			defaultValue: '',
			hide: null,
			hideSpeed: 100,
			inline: false,
			letterCase: 'lowercase',
			opacity: false,
			position: 'default',
			show: null,
			showSpeed: 100,
			swatchPosition: 'left',
			textfield: true,
			theme: 'default'
		});
		$('INPUT#minicolor13').minicolors({
			animationSpeed: 100,
			animationEasing: 'swing',
			change: function(hex, rgb) {
				var uid = $('input[name="uid"]').val();
				var did = $('select[name="deliveries_select"]').val();
				var counter_key = $('#'+did).val();
				var counter_font = $('#nubmer_font').val();
				var counter_size = $('#number_size').val().split('px');
				var counter_color = $('#minicolor12').val().split('#');
				var counter_bg = hex.split('#');
				if($('input[name="number_bg_color"]:checked').length == 0) {
					counter_bg = '0'+counter_bg[1];
				}
				else {
					counter_bg = '1'+counter_bg[1];
				}
				var counter_align = $('#number_alignment').val();
				var counter_img = 'http://smartresponder.ru/dcounter/'+uid+'_'+counter_key+'_'+did+'_1_'+counter_font+'_'+counter_size[0]+'_'+counter_color[1]+'_'+counter_bg+'_'+counter_align+'/counter.gif';
				$('#counter_li img').attr('src', counter_img);
			},
			changeDelay: 0,
			control: 'hue',
			defaultValue: '',
			hide: null,
			hideSpeed: 100,
			inline: false,
			letterCase: 'lowercase',
			opacity: false,
			position: 'default',
			show: null,
			showSpeed: 100,
			swatchPosition: 'left',
			textfield: true,
			theme: 'default'
		});
		// Show/Hide Element counter
		$('input[name="element_counter"]').click(function(){
			if($('input[name="element_counter"]:checked').length == 1){
				var deliveries_length = $('select[name="deliveries_select"] option:selected').length;
				if(deliveries_length == 0){
					alert('Пожалуйста выберите одну рассылку в разделе "Обязательные настройки формы", на которую будет подписывать форма');
					$(this).attr('checked', false);
				}
				else {
					if(deliveries_length > 1){
						alert('Пожалуйста выберите ОДНУ рассылку в разделе "Обязательные настройки формы", на которую будет подписывать форма');
						$(this).attr('checked', false);
					}
					else {
						var uid = $('input[name="uid"]').val();
						var did = $('select[name="deliveries_select"]').val();
						var counter_key = $('#'+did).val();
						var counter_font = $('#number_font').val();
						var counter_size = $('#number_size').val().split('px');
						var counter_color = $('#minicolor12').val().split('#');
						var counter_bg = $('#minicolor13').val().split('#');
						if($('input[name="number_bg_color"]:checked').length == 0) {
							counter_bg = '0'+counter_bg[1];
						}
						else {
							counter_bg = '1'+counter_bg[1];
						}
						var counter_align = $('#number_alignment').val();
						var counter_img = 'http://smartresponder.ru/dcounter/'+uid+'_'+counter_key+'_'+did+'_1_'+counter_font+'_'+counter_size[0]+'_'+counter_color[1]+'_'+counter_bg+'_'+counter_align+'/counter.gif';
						$('#counter_li img').attr('src', counter_img);
						$('#counter_li').show();
					}
				}
			}
			else {
				$('#counter_li').hide();
			}
		});
		// Number Alignment
		$('#number_alignment').change(function(){
			var counter_title = 'Подписчиков';
			var counter_img_alignment = $('input[name="counter_img_alignment"]').val();
			var img_src = $('#cnt img').attr('src');
			var number_alignment = $('#number_alignment option:selected').val();
			var new_img_src = img_src.replace(counter_img_alignment,number_alignment);
			$('input[name="counter_img_alignment"]').val(number_alignment);
			$('#cnt img').attr('src',new_img_src);
			if(number_alignment == 'top') {
				$('#cnt').html('<img style="vertical-align: middle; " src="'+new_img_src+'"><br>'+counter_title);
				$('#counter_li').css('height','auto');
				$('#cnt').css('height','auto');
				var form_height = $('.sr-box').height();
				$('#bg_image').css('height',form_height);
			}
			if(number_alignment == 'right') {
				$('#cnt').html(counter_title+'<img style="vertical-align: middle; " src="'+new_img_src+'">');
				$('#counter_li').css('height','45px');
				$('#cnt').css('height','60px');
				var form_height = $('.sr-box').height();
				$('#bg_image').css('height',form_height);
			}
			if(number_alignment == 'bottom') {
				$('#cnt').html(counter_title+'<br /><img style="vertical-align: middle; " src="'+new_img_src+'">');
				$('#counter_li').css('height','auto');
				$('#cnt').css('height','auto');
				var form_height = $('.sr-box').height();
				$('#bg_image').css('height',form_height);
			}
			if(number_alignment == 'left') {
				$('#cnt').html('<img style="vertical-align: middle; " src="'+new_img_src+'">'+counter_title);
				$('#counter_li').css('height','45px');
				$('#cnt').css('height','60px');
				var form_height = $('.sr-box').height();
				$('#bg_image').css('height',form_height);
			}
		});
		// Unique Element Counter Font
		$('select[name="unique_element_counter_font"]').change(function(){
			var counter_font = $('select[name="unique_element_counter_font"]').val();
			$('#cnt').css('font-family',counter_font);
		});
		// Unique Element Counter Size
		$('select[name="unique_element_counter_size"]').change(function(){
			var counter_size = $('select[name="unique_element_counter_size"]').val();
			$('#cnt').css('font-size',counter_size);
		});
		// Element Counter Type
		$('select[name="unique_element_counter_type"]').change(function(){
			var counter_type = $('select[name="unique_element_counter_type"]').val();
			if(counter_type == 'normal') {
				$('#cnt').css('font-weight','normal')
						 .css('font-style','normal');
			}
			if(counter_type == 'bold') {
				$('#cnt').css('font-weight','bold')
						 .css('font-style','normal');
			}
			if(counter_type == 'italic') {
				$('#cnt').css('font-weight','normal')
						 .css('font-style','italic');
			}
		});
		// Number Font
		$('#number_font').change(function(){
			var uid = $('input[name="uid"]').val();
			var did = $('select[name="deliveries_select"]').val();
			var counter_key = $('#'+did).val();
			var counter_font = $(this).val();
			var counter_size = $('#number_size').val().split('px');
			var counter_color = $('#minicolor12').val().split('#');
			var counter_bg = $('#minicolor13').val().split('#');
			if($('input[name="number_bg_color"]:checked').length == 0) {
				counter_bg = '0'+counter_bg[1];
			}
			else {
				counter_bg = '1'+counter_bg[1];
			}
			var counter_align = $('#number_alignment').val();
			var counter_img = 'http://smartresponder.ru/dcounter/'+uid+'_'+counter_key+'_'+did+'_1_'+counter_font+'_'+counter_size[0]+'_'+counter_color[1]+'_'+counter_bg+'_'+counter_align+'/counter.gif';
			$('#counter_li img').attr('src', counter_img);
		});
		// Number Size
		$('#number_size').change(function(){
			var uid = $('input[name="uid"]').val();
			var did = $('select[name="deliveries_select"]').val();
			var counter_key = $('#'+did).val();
			var counter_font = $('#nubmer_font').val();
			var counter_size = $(this).val().split('px');
			var counter_color = $('#minicolor12').val().split('#');
			var counter_bg = $('#minicolor13').val().split('#');
			if($('input[name="number_bg_color"]:checked').length == 0) {
				counter_bg = '0'+counter_bg[1];
			}
			else {
				counter_bg = '1'+counter_bg[1];
			}
			var counter_align = $('#number_alignment').val();
			var counter_img = 'http://smartresponder.ru/dcounter/'+uid+'_'+counter_key+'_'+did+'_1_'+counter_font+'_'+counter_size[0]+'_'+counter_color[1]+'_'+counter_bg+'_'+counter_align+'/counter.gif';
			$('#counter_li img').attr('src', counter_img);
		});
		// Number bg color
		$('input[name="number_bg_color"]').click(function(){
			if($('input[name="number_bg_color"]:checked').length == 1) {
				$('.minicolor13').show();
				var uid = $('input[name="uid"]').val();
				var did = $('select[name="deliveries_select"]').val();
				var counter_key = $('#'+did).val();
				var counter_font = $('#nubmer_font').val();
				var counter_size = $('#number_size').val().split('px');
				var counter_color = $('#minicolor12').val().split('#');
				var counter_bg = $('#minicolor13').val().split('#');
				if($('input[name="number_bg_color"]:checked').length == 0) {
					counter_bg = '0'+counter_bg[1];
				}
				else {
					counter_bg = '1'+counter_bg[1];
				}
				var counter_align = $('#number_alignment').val();
				var counter_img = 'http://smartresponder.ru/dcounter/'+uid+'_'+counter_key+'_'+did+'_1_'+counter_font+'_'+counter_size[0]+'_'+counter_color[1]+'_'+counter_bg+'_'+counter_align+'/counter.gif';
				$('#counter_li img').attr('src', counter_img);    
			}
			else {
				$('.minicolor13').hide();
				var uid = $('input[name="uid"]').val();
				var did = $('select[name="deliveries_select"]').val();
				var counter_key = $('#'+did).val();
				var counter_font = $('#nubmer_font').val();
				var counter_size = $('#number_size').val().split('px');
				var counter_color = $('#minicolor12').val().split('#');
				var counter_bg = $('#minicolor13').val().split('#');
				if($('input[name="number_bg_color"]:checked').length == 0) {
					counter_bg = '0'+counter_bg[1];
				}
				else {
					counter_bg = '1'+counter_bg[1];
				}
				var counter_align = $('#number_alignment').val();
				var counter_img = 'http://smartresponder.ru/dcounter/'+uid+'_'+counter_key+'_'+did+'_1_'+counter_font+'_'+counter_size[0]+'_'+counter_color[1]+'_'+counter_bg+'_'+counter_align+'/counter.gif';
				$('#counter_li img').attr('src', counter_img);    
			}
		});
		// Deliveries Select
		$('select[name="deliveries_select"]').on('change', function(){
			$('input[name="did[]"]').remove();
			var deliveries_select = $('select[name="deliveries_select"]').val();
			var deliveries_select_t = [], lis = $('select[name="deliveries_select"] option:selected');
			for(var i=0, im=lis.length; im>i; i++){
				deliveries_select_t.push(lis[i].firstChild.nodeValue);
			}
			$('.subscribe-li').remove();
			if(deliveries_select.length > 1) {
				$('#counter_li').hide();
				$('input[name="element_counter"]').attr('checked', false);
				$('.form-header').after('<li class="subscribe-li" style="height: auto; "><label style="margin-top: 10px; font-size: 13px; color: rgb(189, 189, 189); font-family: arial; font-weight: bold; font-style: normal; height: auto;">Выберите рассылки:</label></li>');
				if(!$('.subscribe-li table').is('#d_tbl')) {
					var width = $('.fields').css('width');
					$('.subscribe-li').append('<table style="display:inline-table; width: '+width+'" cellpadding="4" id="d_tbl"><tbody></tbody></table>');
				}    
				for(var x=0;x<deliveries_select.length;x++) {
					$('input[name="uid"]').after('<input type="hidden" name="did[]" value="'+deliveries_select[x]+'">');
					$("#d_tbl > tbody").append('<tr><td><input type="checkbox" name="delivery_variant" checked="checked" value="'+deliveries_select[x]+'"></td><td>'+deliveries_select_t[x]+'</td></tr>');
				}
				$('.subscribe-li').css('background', $('#minicolor2').val());
			}
			else {
				$('input[name="uid"]').after('<input type="hidden" name="did[]" value="'+$(this).val()+'">');
				var uid = $('input[name="uid"]').val();
				var did = $('select[name="deliveries_select"]').val();
				var counter_key = $('#'+did).val();
				var counter_font = $('#number_font').val();
				var counter_size = $('#number_size').val().split('px');
				var counter_color = $('#minicolor12').val().split('#');
				var counter_bg = $('#minicolor13').val().split('#');
				if($('input[name="number_bg_color"]:checked').length == 0) {
					counter_bg = '0'+counter_bg[1];
				}
				else {
					counter_bg = '1'+counter_bg[1];
				}
				var counter_align = $('#number_alignment').val();
				var counter_img = 'http://smartresponder.ru/dcounter/'+uid+'_'+counter_key+'_'+did+'_1_'+counter_font+'_'+counter_size[0]+'_'+counter_color[1]+'_'+counter_bg+'_'+counter_align+'/counter.gif';
				$('#counter_li img').attr('src', counter_img);
			}
		});
		// Track ID
		$('select[name="trackId"]').change(function(){
			if($(this).val() != '0') {
				if($('input[name="tid"]').length == 0) {
					$('.sr-box').append('<input type="hidden" name="tid" value="'+$(this).val()+'">');
				}
				else {
					$('input[name="tid"]').val($(this).val());
				}
			}
			else {
				$('input[name="tid"]').remove();
			}
		});
		// Checks Level
		$('select[name="checksLevel"]').change(function(){
			switch($(this).val()) {
				case '0': 
					$('input[name="field_name_first"], input[name="field_email"]').removeClass('sr-required').removeClass('2');
				break;
				case '1': 
					$('input[name="field_name_first"], input[name="field_email"]').removeClass('sr-required').removeClass('2').addClass('sr-required');
				break;
				case '2': 
					$('input[name="field_name_first"], input[name="field_email"]').removeClass('sr-required').removeClass('2').addClass('sr-required').addClass('2');
				break;
			}
		});
		// Open Type
		$('input[name="openType"]').click(function(){
			if($(this).val() == '0') {
				$('input[name="for_openType"]').remove();
				$('.sr-subscribe-text').css('display','none');
			}
			else {
				if($('input[name="for_openType"]').length == 0) {
					$('.sr-box').append('<input type="hidden" name="for_openType" value="'+$('input[name="subscribe_text"]').val()+'">');
					$('.sr-subscribe-text').css('display','table-row');
				}
			}
		});
		// Get HTML function
		function get_html_form() {
			$.get(link+'for_form.html', function(json){
				$('.sr-box').css('margin-top','0px');
				var form_code = $('.scene-editor').html();
				$('.sr-box').css('margin-top','130px');
				$('.modal-body textarea').text(json+form_code);
			});
		}
		// Get HTML
		$('#get_html').click(function(){
			var deliveries_select = $('select[name="deliveries_select"] option:selected').length;
			if(deliveries_select == 0) {
				alert('Пожалуйста выберите одну рассылку в разделе "Обязательные настройки формы", на которую будет подписывать форма');
				return false;
			}
			else {
				get_html_form();
				return true;
			}
		});
		// Create Widget
		$('#create_widget').click(function(){
			var deliveries_select = $('select[name="deliveries_select"] option:selected').length;
			if(deliveries_select == 0) {
				alert('Пожалуйста выберите одну рассылку в разделе "Обязательные настройки формы", на которую будет подписывать форма');
				return false;
			}
			else {
				$('form[name="SR_form"]').css('margin-top','0px').css('margin-bottom','2.2em');
				var outer_alignment = $('select[name="outer_alignment"]').val();
				if(outer_alignment == 'left') {
					$('form.sr-box').css('margin-left','0px');
				}
				if(outer_alignment == 'right') {
					$('form.sr-box').css('margin-right','0px');
				}
				if(outer_alignment == 'center') {
					$('form.sr-box').css('margin','0 auto');
				}
				var form_code = $('.scene-editor').html();
				$('form.sr-box').css('margin','130px auto 0px');
				$('form[name="SR_form"]').css('margin-top','130px').css('margin-bottom','0px');
				var data = {
					action: 'widget',
					html: form_code
				}
				$.ajax({
					type: 'POST',
					url: ajaxurl,
					dataType: 'JSON',
					data: data,
					success: function(json){
						if(json == 'ok') {
							alert('Виджет был создан.');
						}
						else {
							alert('Виджет небыл создан.');
						}
					},
					error: function() {
						alert('Виджет небыл создан.');
					}
				});
			}
		});
		$('#number_alignment').change(function(){
			var counter_title = 'Подписчиков';
			var counter_img_alignment = $('input[name="counter_img_alignment"]').val();
			var img_src = $('#cnt img').attr('src');
			var number_alignment = $('#number_alignment option:selected').val();
			var new_img_src = img_src.replace(counter_img_alignment,number_alignment);
			$('input[name="counter_img_alignment"]').val(number_alignment);
			$('#cnt img').attr('src',new_img_src);
			if(number_alignment == 'top') {
				$('#cnt').html('<img style="vertical-align: middle; " src="'+new_img_src+'"><br>'+counter_title);
				$('#counter_li').css('height','auto');
				$('#cnt').css('height','auto');
				var form_height = $('.sr-box').height();
				$('#bg_image').css('height',form_height);
			}
			if(number_alignment == 'right') {
				$('#cnt').html(counter_title+'<img style="vertical-align: middle; " src="'+new_img_src+'">');
				$('#counter_li').css('height','45px');
				$('#cnt').css('height','60px');
				var form_height = $('.sr-box').height();
				$('#bg_image').css('height',form_height);
			}
			if(number_alignment == 'bottom') {
				$('#cnt').html(counter_title+'<br /><img style="vertical-align: middle; " src="'+new_img_src+'">');
				$('#counter_li').css('height','auto');
				$('#cnt').css('height','auto');
				var form_height = $('.sr-box').height();
				$('#bg_image').css('height',form_height);
			}
			if(number_alignment == 'left') {
				$('#cnt').html('<img style="vertical-align: middle; " src="'+new_img_src+'">'+counter_title);
				$('#counter_li').css('height','45px');
				$('#cnt').css('height','60px');
				var form_height = $('.sr-box').height();
				$('#bg_image').css('height',form_height);
			}
		});
		// /Form Generator
		$(document).on('click', '#sr_menu li.export_li',function(){
			if($('.sync').css('display') == 'block') {
				alert('Для использование Экспорта зарегистрированных пользователей, вам нужно синхронизироваться.')
			} 
			else {
				$('.api_key_li img').attr("src", link+"img/api_key_btn.png", ".png");
				$('.form_generator_li img').attr("src", link+"img/form_gen_btn.png", ".png");
				$('.export_li img').attr("src", link+"img/export_btn_active.png", ".png");
				$('.form_generator').css('display','none');
				$('.export').css('display', 'block');
				if($('#users_table tbody tr').length == 0) {
					$('#users_table thead input[name="check_all"]').css('display', 'none');
					$('#users_table tbody').append('<tr><td colspan="5" style="text-align: center;"><img src="'+link+'img/loading.gif"></td></tr>');
					// Get Deliveries
					var deliveries_var = {
						action: 'get_deliveries'                       
					}
					$.ajax({
						url: ajaxurl,
						data: deliveries_var,
						dataType: 'JSON',
						method: 'POST',
						success: function(json) {                                                    
							$.each(json.list.elements, function(i3, item3){
								var id = item3.id;
								var title = item3.title;
								var mySelect = jQuery('#rDestinationId_d');
								mySelect.append(
									jQuery('<option style="color:black; background-color:white; "></option>').val('d:'+id).html(title)
								);
								$("#rDestinationId_d option[value='undefined']").each(function() {
									$(this).remove();
								});
							});                         
						}
					});
					// Get Groups
					var getGroupsData = {
						action: 'get_groups'
					}
					$.ajax({
						url: ajaxurl,
						data: getGroupsData,
						dataType: 'JSON',
						method: 'POST',
						success: function(data) {                        
							$.each(data.list.elements, function(i3, item3){
								var id = item3.id;
								var title = item3.title;
								var mySelect = jQuery('#rDestinationId_g');
								mySelect.append(
									jQuery('<option style="color:black; background-color:white; "></option>').val('g:'+id).html(title)
								);
								$("#rDestinationId_g option[value='g:undefined']").each(function() {
									$(this).remove();
								});
							});                            
						}
					});
					// Get Users
					var getUsersData = {
						action: 'users'
					}
					usersRequest(getUsersData);
				}
			}
		});
	 
		$('#get_deliveries').click(function(){
			$('#get_groups').attr('checked', false);
			if(!$('.get_deliveries_select').is(':visible')) {
				$('input[name="get_groups"]').attr('checked', false);
				$('.get_deliveries_select').show();
				if($('.get_groups_select').is(':visible')) {
					$('.get_groups_select').hide(); 
				}
		}
		});
		$('#get_groups').click(function(){
			$('#get_deliveries').attr('checked', false);
			if(!$('.get_groups_select').is(':visible')) {
				$('input[name="get_deliveries"]').attr('checked', false);
				$('.get_groups_select').show();
				if($('.get_deliveries_select').is(':visible')) {
					$('.get_deliveries_select').hide(); 
				}
		}
		});
		$('#export_sr').click(function(){
			//Get users data
			var ind1 = 0;
			var ind2 = 0;
			var ind3 = 0;
			var checkbox_arr = [];
			var nickname_arr = [];
			var email_arr = [];
			//Get all checked checkbox
			$('#users_table input[type="checkbox"]:checked').each(function(){
				checkbox_arr[ind1] = $(this).attr('name');
				ind1++;
			});
			if(checkbox_arr.length == 0) {
				var rDestinationId = 0;
				if($('.import-request-options #get_deliveries:checked').length == 1) {
					rDestinationId = $('#rDestinationId_d').val();
				}
				if($('.import-request-options #get_groups:checked').length == 1) {
					rDestinationId = $('#rDestinationId_g').val();
				}
				if(rDestinationId == 0) {
					alert('Выберите, куда Вы хотите добавить импортируемый список.');
					$('.import-request-options').css('color','red');
					setTimeout(function(){ 
						$('.import-request-options').css('color','black'); 
					}, 1900);
				}
				else {
					$('.modal-footer span').css('display', 'block');
					//Get id
					var user_id_arr = [];
					$('#users_table tbody tr').each(function(){
						user_id_arr[ind1] = $(this).attr('class');
						ind1++;
					});
					$.each(user_id_arr.toString().split(','), function(number, item){
						//Get nickname 
						$('.is_nickname_'+item).each(function(){
							nickname_arr[ind2] = $(this).text();
							ind2++;
						});
						//Get email
						$('.is_email_'+item).each(function(){
							email_arr[ind3] = $(this).text();
							ind3++;
						}); 
					});				
					var rDestination = $('select[name="rDestinationId"]').val();
					var data = {
						action: 'import',
						destination: rDestination,
						nickname: nickname_arr.toString(),
						email: email_arr.toString()
					}				
					if(f_exportAll == 1){
						data.expartAll = 1;
						data.period = $('select[name="search[date_mode]"]').val();
						data.filter = $('input[name="email_filter"]').val();
					}
					$.ajax({
						type: 'POST',
						url: ajaxurl,
						dataType: 'JSON',
						data: data,
						success: function(json) {
							if(json.result == '0') {
								$.each(json.error, function(x1, item1) {
									if (typeof item1.message === 'undefined') {
										//
									}
									else {
										$('.modal-footer span').css('display', 'none');
										alert(item1.message);
									}
								});
							}
							else {
								var import_key = json.element.import_key;
								setTimeout(DisplayImportRequest(import_key), 3000);
							}
						},
						error: function() {
							alert('Ошибка импорта.');
						}
					});
				}
				
			}
			else {
				var rDestinationId = 0;
				if($('.import-request-options #get_deliveries:checked').length == 1) {
					rDestinationId = $('#rDestinationId_d').val();
				}
				if($('.import-request-options #get_groups:checked').length == 1) {
					rDestinationId = $('#rDestinationId_g').val();
				}
				if(rDestinationId == 0) {
					alert('Выберите, куда Вы хотите добавить импортируемый список.');
					$('.import-request-options').css('color','red');
					setTimeout(function(){ 
						$('.import-request-options').css('color','black'); 
					}, 1900);
				}
				else {
					$('.modal-footer span').css('display', 'block');
					//Get id
					var user_id_arr = checkbox_arr;
					$.each(user_id_arr.toString().split(','), function(number, item){
						//Get nickname 
						$('.is_nickname_'+item).each(function(){
							nickname_arr[ind2] = $(this).text();
							ind2++;
						});
						//Get email
						$('.is_email_'+item).each(function(){
							email_arr[ind3] = $(this).text();
							ind3++;
						}); 
					});
					var rDestination = $('select[name="rDestinationId"]').val();
					var data = {
						action: 'import',
						destination: rDestination,
						nickname: nickname_arr.toString(),
						email: email_arr.toString()
					}				
					if(f_exportAll == 1){
						data.expartAll = 1;
						data.period = $('select[name="search[date_mode]"]').val();
						data.filter = $('input[name="email_filter"]').val();
					}
					$.ajax({
						type: 'POST',
						url: ajaxurl,
						dataType: 'JSON',
						data: data,
						success: function(json) {
							if(json.result == '0') {
								$.each(json.error, function(x1, item1) {
									if (typeof item1.message === 'undefined') {
										//
									}
									else {
										$('.modal-footer span').css('display', 'none');
										alert(item1.message);
									}
								});
							}
							else {
								var import_key = json.element.import_key;
								setTimeout(DisplayImportRequest(import_key), 3000);
							}
						},
						error: function() {
							alert('Ошибка импорта.');
						}
					});
				}    
			}
		});
		function DisplayImportRequest(import_key) {
			var data = {
				action: 'result',
				import_key: import_key
			}
			$.ajax({
				type: 'POST',
				url: ajaxurl,
				dataType: 'JSON',
				data: data,
				success: function(json) {
					if(json.result == '1') {
						if(json.element.progress == '100') {
							$('.modal-footer span').css('display', 'none');
							alert('Заявка была отправлена. Пожалуйста дождитесь ответа нашего сотрудника. ID заявки: '+json.element.ticket);
						}
						else {
							setTimeout(DisplayImportRequest(import_key), 3000);
						}
					}
					else {
						$.each(json, function(x1, item1) {
							$.each(item1, function(x2, item2) {
								if (typeof item2.message === 'undefined') {
									//
								}
								else {
									alert(item2.message);
								}
							}); 
						});
					}
				},
				error: function() {
					alert('Ошибка импорта.');
				} 
			});
		}
		// Users Filter
		exportInit();
		
		function exportInit(){
			$('#export_all_btn').unbind('click').bind('click', function(){
				f_exportAll = 1;			
			});
			$('#export_btn').unbind('click').bind('click', function(){
				f_exportAll = 0;
			});
			$('input[name="users_filter_btn"]').unbind('click').bind('click', function(){			
				$('#users_table tbody tr').remove();
				$('#users_table tbody').append('<tr><td colspan="5" style="text-align: center;"><img src="'+link+'img/loading.gif"></td></tr>');
				var period = $('select[name="search[date_mode]"]').val();
				var email = $('input[name="email_filter"]').val();
				var recordsOnPage = $('#records_on_page').val();		
				// Get Users
				var getUsersData = getPagiData();			
				usersRequest(getUsersData);
			});
			//Pagination
			$(".nextPage").unbind('click').bind('click', function(){
				$('#users_table tbody').append('<tr><td colspan="5" style="text-align: center;"><img src="'+link+'img/loading.gif"></td></tr>');
				var getUsersData = getPagiData();	
				getUsersData.page = parseInt($(".currentPage").text())+1;			
				usersRequest(getUsersData);
				return false;
			});
			$(".prevPage").unbind('click').bind('click', function(){
				$('#users_table tbody').append('<tr><td colspan="5" style="text-align: center;"><img src="'+link+'img/loading.gif"></td></tr>');
				var getUsersData = getPagiData();	
				getUsersData.page = parseInt($(".currentPage").text())-1;			
				usersRequest(getUsersData);
				return false;
			});
			$(".lastPage").unbind('click').bind('click', function(){
				$('#users_table tbody').append('<tr><td colspan="5" style="text-align: center;"><img src="'+link+'img/loading.gif"></td></tr>');
				var getUsersData = getPagiData();	
				getUsersData.page = parseInt($(".totalPages").text());			
				usersRequest(getUsersData);
				return false;
			});
			$(".firstPage").unbind('click').bind('click', function(){
				$('#users_table tbody').append('<tr><td colspan="5" style="text-align: center;"><img src="'+link+'img/loading.gif"></td></tr>');
				var getUsersData = getPagiData();	
				getUsersData.page = 1;			
				usersRequest(getUsersData);
				return false;
			});
			$(".records_on_page").show();
			$("input[name='check_all']").change(function(){			
				var a = $("input[name='check_all']");
				if(a.length == a.filter(":checked").length){
					$('#users_table input[type="checkbox"]').attr('checked', true);
				}
				else {
					$('#users_table input[type="checkbox"]').attr('checked', false);
				}
			});
			
			$("#records_on_page").change(function(){
				$('#users_table tbody').append('<tr><td colspan="5" style="text-align: center;"><img src="'+link+'img/loading.gif"></td></tr>');
				var getUsersData = getPagiData();			
				usersRequest(getUsersData);
			});
		
		}
		
		function getPagiData(){
			var period = $('select[name="search[date_mode]"]').val();
			var email = $('input[name="email_filter"]').val();
			var recordsOnPage = $('#records_on_page').val();		
				
				// Get Users
			var getUsersData = {
				action: 'users',
				period: period,
				email: email,
				cnt: recordsOnPage,
				page: 0
			}  
			return getUsersData;
		}
		
		function usersRequest(getUsersData){
			$.ajax({
				url : ajaxurl,
				data : getUsersData,
				type : 'POST',
				dataType : 'json',
				success : function(json) {
					if(json.status == 1) {					
						$(".users_result").html(json.view);
						exportInit();
					}			
				} 
			});	
		}
	}());
});
