<div class="topic emerge" data-effect="slide">
	<div id="sidebar">
	<?php 
	   if ( is_active_sidebar( 'header-widget-area' ) ){
	            dynamic_sidebar( 'header-widget-area' ); 
	      };
	?>
	</div>
    <div class="container">
      <div class="row">
        <div class="col-sm-9" style="padding-left:15px;">
          <ol class="breadcrumb hidden-xs">
		    <?php if(function_exists('bcn_display'))
		    {
		        bcn_display();
		    }?>
          </ol>
        </div>     	
        <div class="col-sm-3 pull-right" style="padding: 16px 14px 0 12px; text-align:right; max-width: 250px;">
	        	<div style="float: left;">
			        <h6><?php if ( is_user_logged_in() ) : ?>
					<span class="glyphicon glyphicon-user" aria-hidden="true"></span>&ensp;	
					<?php $current_user = wp_get_current_user();
					echo '<b>' . $current_user->user_firstname . '</b> ';
					echo '<b>' . $current_user->user_lastname . '</b> ';
					?>
	        	</div>
	        	<div style="float: right;">
					<a href="/auth.php?action=logout&redirect_to=http://bim.vc/" class="btn btn-default btn-xs" title="Выход" style="margin-left: 6px; margin-top: 7px;">
						<span class="glyphicon glyphicon-log-out"></span>
						&ensp;Выход
					</a>
	        	</div>
			<?php else : ?>
			<a href="#" class ="btn btn-theme-primary btn-xs" data-toggle="modal" data-target="#registration">
			Регистрация</a>&ensp;
			<a href="#" class="btn btn-default btn-xs" data-toggle="modal" data-target="#login" title="Войти">
				<span class="glyphicon glyphicon-log-in" aria-hidden="true"></span>
				&ensp;Вход
			</a>
			<?php endif; ?>	
			</h6>
        </div>
      </div>
    </div>
</div>