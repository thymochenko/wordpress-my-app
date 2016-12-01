<div id="header" class="container-fluid headermain pdt10 pdb10 clearfix">
	<div class="container">
		<div class="row">
			<div class="col-md-4" >
				<?php
				if( has_custom_logo() )
				{
				?>
					<div id="logoasimg" itemscope itemtype="http://schema.org/Organization" >
						<?php the_custom_logo(); ?>
					</div>
				<?php
				}
				else
				{
					
					echo "<h3 id='logoastext'>";
					echo "<a href='" . esc_url( home_url( '/' ) ) . "' rel='home' >";
					echo esc_attr( get_bloginfo( 'name' ) );
					echo "</a>";
					echo "</h3>";
				}
				?>
				
			</div>
			
			<div class="col-md-8">
				<nav id="navbar" class="navbar navbar-default">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
								<span class="sr-only"><?php esc_attr_e( 'Toggle navigation', 'business-press' ); ?></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
						</div>
								
						<?php
						wp_nav_menu( array(
							'theme_location'    => 'primary',
							'depth'             =>  2,
							'container'         => 'div',
							'container_id'      => 'bs-example-navbar-collapse-1',
							'container_class'   => 'collapse navbar-collapse',
							'menu_id' 			=> 'primary-menu',
							'menu_class'        => 'nav navbar-nav',
							'fallback_cb'       => 'business_press_nav_fallback',
							'walker'            => new business_press_bootstrap_navwalker()
							));
						?>

				</nav>
			</div>

		</div>
	</div>
</div>