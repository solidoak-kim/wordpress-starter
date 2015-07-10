<header id="header-main" class="header-main">
	<h1 class="brand-link">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" class="logo hidetext">
			<?php bloginfo( 'name' ); ?>
		</a>
	</h1>

	<div id="nav-container" class="nav-container">
		<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu' ) ); ?>
	</div>
</header>