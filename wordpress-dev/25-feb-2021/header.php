<!doctype html>
<html <?php language_attributes();?>>
  	<head>
		<!-- Required meta tags -->
	    <meta charset="<?php bloginfo('charset');?>">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <title>
            <?php
                if(is_front_page()){
                    echo "Home";
                    echo "|"; echo bloginfo("name");
                }else{
                    wp_title("");
                    echo "|"; echo bloginfo("name");
                }
            ?>
        </title>
        <?php wp_head('')?>
	</head>
	<body <?php body_class();?>>
		<div id="sidr" class="mobile-header d-none">
			<div class="navbar-header d-flex align-items-center justify-content-between">
				<div class="logo">
				 	<a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
					 		<?php
								$logo = get_field( 'logo', 'options' );

								if ( $logo ) 
								{
									printf( '<img src="%s" class="img-fluid" alt="%s">', esc_url( $logo['url'] ), $logo['alt'] );
								}
								else
								{
									printf( '<img src="%s" class="img-fluid" alt="%s">', esc_url( get_theme_file_uri( 'images/logo.png' ) ), get_bloginfo( 'name') );
								}
							?>
				 	</a>
				</div>

			 	<a class="navbar-toggle in">
					<span class="icon-bar"></span>
				  	<span class="icon-bar"></span>
				  	<span class="icon-bar"></span>
			  	</a>
			</div>

			<div class="navigation">
					<?php
				  		wp_nav_menu( array(
		                    'menu'               => 'Primary Menu',
		                    'theme_location'     => 'menu',
		                    'depth'              => 1,
		                    'container'          => false,
		                    'menu_class'         => 'nav navbar-nav',
		                    'menu_id'            => '',
		                    'fallback_cb'        => 'wp_bootstrap_navwalker::fallback',
		                    'walker'             => new wp_bootstrap_navwalker(),
		                ));
					?>
		  	</div><!-- /navigation -->
		</div> <!-- /mobile-header -->

		<header class="header transparent">
			<nav class="navbar navbar-expand">
			  	<div class="container d-flex justify-content-between">
					<div class="navbar-header">
					  	<div class="logo">
						 	<a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
								<?php
									$logo = get_field( 'logo', 'options' );

									if ( $logo ) 
									{
										printf( '<img src="%s" class="img-fluid" alt="%s">', esc_url( $logo['url'] ), $logo['alt'] );
									}
									else
									{
										printf( '<img src="%s" class="img-fluid" alt="%s">', esc_url( get_theme_file_uri( 'images/logo.png' ) ), get_bloginfo( 'name') );
									}
								?>
						 	</a>
						</div>
					</div>

					<div class="collapse navbar-collapse">
					<?php
					  		wp_nav_menu( array(
			                    'menu'               => 'Primary Menu',
			                    'theme_location'     => 'menu-1',
			                    'depth'              => 1,
			                    'container'          => false,
			                    'menu_class'         => 'navbar-nav',
			                    'menu_id'            => '',
			                    'fallback_cb'        => 'wp_bootstrap_navwalker::fallback',
			                    'walker'             => new wp_bootstrap_navwalker(),
			                ));
						?>
						<ul class="navbar-nav navbar-right ml-auto">
							<li><a href="#"><span class="icon-play-store"></span></a></li>
							<li><a href="#"><span class="icon-apple"></span></a></li>
							<li class="btn-menu"><a href="#">Login</a></li>
							<li class="mobile-navbar-toggler d-xl-none d-lg-none">
								<a href="#sidr" class="navbar-toggle">
									<span class="icon-bar"></span>
								  	<span class="icon-bar"></span>
								  	<span class="icon-bar"></span>
							  	</a>
							</li>
						</ul>
					</div>
			  	</div><!-- /container -->
			</nav><!--/ Navbar -->
		</header>
		<div class="header_gutter"></div>