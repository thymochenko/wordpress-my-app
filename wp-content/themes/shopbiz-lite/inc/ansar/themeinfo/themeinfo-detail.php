<?php
/**
 * shopbiz Admin Class.
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'shopbiz_Admin' ) ) :

/**
 * shopbiz_Admin Class.
 */
class shopbiz_Admin {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'shopbiz_admin_menu' ) );
		add_action( 'wp_loaded', array( __CLASS__, 'shopbiz_hide_notices' ) );
	}

	/**
	 * Add admin menu.
	 */
	public function shopbiz_admin_menu() {
		$theme = wp_get_theme( get_template() );

		$page = add_theme_page( esc_html__( 'About', 'shopbiz' ) . ' ' . $theme->display( 'Name' ), esc_html__( 'About', 'shopbiz' ) . ' ' . $theme->display( 'Name' ), 'activate_plugins', 'shopbiz-welcome', array( $this, 'welcome_screen' ) );
		add_action( 'admin_print_styles-' . $page, array( $this, 'shopbiz_enqueue_styles' ) );
	}

	/**
	 * Enqueue styles.
	 */
	public function shopbiz_enqueue_styles() {
		global $shopbiz_version;

		wp_enqueue_style( 'shopbiz-welcome', get_template_directory_uri() . '/css/themeinfo.css', array(), $shopbiz_version );
	}

	/**
	 * Hide a notice if the GET variable is set.
	 */
	public static function shopbiz_hide_notices() {
		if ( isset( $_GET['shopbiz-hide-notice'] ) && isset( $_GET['_shopbiz_notice_nonce'] ) ) {
			if ( ! wp_verify_nonce( $_GET['_shopbiz_notice_nonce'], 'shopbiz_shopbiz_hide_notices_nonce' ) ) {
				wp_die( __( 'Action failed. Please refresh the page and retry.', 'shopbiz' ) );
			}

			if ( ! current_user_can( 'manage_options' ) ) {
				wp_die( __( 'Cheatin&#8217; huh?', 'shopbiz' ) );
			}

			$hide_notice = sanitize_text_field( $_GET['shopbiz-hide-notice'] );
		}
	}

	/**
	 * Show welcome notice.
	 */
	public function shopbiz_welcome_notice() {
		?>
		<div id="message" class="updated shopbiz-message">
			<a class="shopbiz-message-close notice-dismiss" href="<?php echo esc_url( wp_nonce_url( remove_query_arg( array( 'activated' ), add_query_arg( 'shopbiz-hide-notice', 'welcome' ) ), 'shopbiz_shopbiz_hide_notices_nonce', '_shopbiz_notice_nonce' ) ); ?>"><?php _e( 'Dismiss', 'shopbiz' ); ?></a>
			<p><?php printf( esc_html__( 'Welcome! Thank you for choosing shopbiz! To fully take advantage of the best our theme can offer please make sure you visit our %swelcome page%s.', 'shopbiz' ), '<a href="' . esc_url( admin_url( 'themes.php?page=shopbiz-welcome' ) ) . '">', '</a>' ); ?></p>
			<p class="submit">
				<a class="button-secondary" href="<?php echo esc_url( admin_url( 'themes.php?page=shopbiz-welcome' ) ); ?>"><?php esc_html_e( 'Get started with shopbiz', 'shopbiz' ); ?></a>
			</p>
		</div>
		<?php
	}

	/**
	 * shopbiz_intro text/links shown to all about pages.
	 *
	 * @access private
	 */
	private function shopbiz_intro() {
		global $shopbiz_version;

		$theme = wp_get_theme( get_template() );

		// Drop minor version if 0
		$major_version = substr( $shopbiz_version, 0, 3 );
		?>
		<div class="shopbiz-theme-info">
			<h1>
				<?php esc_html_e('About', 'shopbiz'); ?>
				<?php echo $theme->display( 'Name' ); ?>
				<?php printf( '%s', $major_version ); ?>
			</h1>

			<div class="welcome-description-wrap">
				<div class="about-text"><?php echo $theme->display( 'Description' ); ?></div>

				<div class="shopbiz-screenshot">
					<img src="<?php echo esc_url( get_template_directory_uri() ) . '/screenshot.png'; ?>" />
				</div>
			</div>
		</div>

		<p class="shopbiz-actions">
			<a href="<?php echo esc_url( 'https://themeansar.com/themes/shopbiz/' ); ?>" class="button button-secondary" target="_blank"><?php esc_html_e( 'Theme Info', 'shopbiz' ); ?></a>

			<a href="<?php echo esc_url( 'https://themeansar.com/demo/wp/shopbiz/' ); ?>" class="button button-secondary docs" target="_blank"><?php esc_html_e( 'View Demo', 'shopbiz' ); ?></a>

			<a href="<?php echo esc_url( 'https://themeansar.com/demo/wp/shopbiz/default/' ); ?>" class="button button-primary docs" target="_blank"><?php esc_html_e( 'View PRO version', 'shopbiz' ); ?></a>

			<a href="<?php echo esc_url( 'https://wordpress.org/support/theme/shopbiz-lite/reviews/#new-post' ); ?>" class="button button-secondary docs" target="_blank"><?php esc_html_e( 'Rating this theme', 'shopbiz' ); ?></a>
		</p>

		<h2 class="nav-tab-wrapper">
			<a class="nav-tab <?php if ( empty( $_GET['tab'] ) && $_GET['page'] == 'shopbiz-welcome' ) echo 'nav-tab-active'; ?>" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'shopbiz-welcome' ), 'themes.php' ) ) ); ?>">
				<?php echo $theme->display( 'Name' ); ?>
			</a>
			<a class="nav-tab <?php if ( isset( $_GET['tab'] ) && $_GET['tab'] == 'supported_plugins' ) echo 'nav-tab-active'; ?>" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'shopbiz-welcome', 'tab' => 'supported_plugins' ), 'themes.php' ) ) ); ?>">
				<?php esc_html_e( 'Supported Plugins', 'shopbiz' ); ?>
			</a>
			<a class="nav-tab <?php if ( isset( $_GET['tab'] ) && $_GET['tab'] == 'free_vs_pro' ) echo 'nav-tab-active'; ?>" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'shopbiz-welcome', 'tab' => 'free_vs_pro' ), 'themes.php' ) ) ); ?>">
				<?php esc_html_e( 'Free Vs Pro', 'shopbiz' ); ?>
			</a>
		</h2>
		<?php
	}

	/**
	 * Welcome screen page.
	 */
	public function welcome_screen() {
		$current_tab = empty( $_GET['tab'] ) ? 'about' : sanitize_title( $_GET['tab'] );

		// Look for a {$current_tab}_screen method.
		if ( is_callable( array( $this, $current_tab . '_screen' ) ) ) {
			return $this->{ $current_tab . '_screen' }();
		}

		// Fallback to about screen.
		return $this->about_screen();
	}

	/**
	 * Output the about screen.
	 */
	public function about_screen() {
		$theme = wp_get_theme( get_template() );
		?>
		<div class="wrap about-wrap">

			<?php $this->shopbiz_intro(); ?>

			<div class="changelog point-releases">
				<div class="under-the-hood two-col">
					<div class="col">
						<h3><?php esc_html_e( 'Theme Customizer', 'shopbiz' ); ?></h3>
						<p><?php esc_html_e( 'Theme Cusomization features availbale in Customizer setting : -   Appearance → Customize', 'shopbiz' ) ?></p>
						<p><a href="<?php echo admin_url( 'customize.php' ); ?>" class="button button-secondary"><?php esc_html_e( 'Customize', 'shopbiz' ); ?></a></p>
					</div>

					<div class="col">
						<h3><?php esc_html_e( 'Documentation', 'shopbiz' ); ?></h3>
						<p><?php esc_html_e( 'Please view our documentation page to setup the theme.', 'shopbiz' ) ?></p>
						<p><a href="<?php echo esc_url( 'https://themeansar.com/docs/wp/shopbiz/' ); ?>" class="button button-secondary"><?php esc_html_e( 'Documentation', 'shopbiz' ); ?></a></p>
					</div>

					<div class="col">
						<h3><?php esc_html_e( 'Got theme support question?', 'shopbiz' ); ?></h3>
						<p><?php esc_html_e( 'Please Put your question / query on support forum.', 'shopbiz' ) ?></p>
						<p><a href="<?php echo esc_url( 'https://wordpress.org/support/theme/shopbiz-lite' ); ?>" class="button button-secondary"><?php esc_html_e( 'Support Forum', 'shopbiz' ); ?></a></p>
					</div>

					<div class="col">
						<h3><?php esc_html_e( 'Need more functionality / features?', 'shopbiz' ); ?></h3>
						<p><?php esc_html_e( 'Upgrade to PRO version for more exciting features and functionlaity.', 'shopbiz' ) ?></p>
						<p><a href="<?php echo esc_url( 'https://themeansar.com/demo/wp/shopbiz/' ); ?>" class="button button-secondary"><?php esc_html_e( 'View Pro', 'shopbiz' ); ?></a></p>
					</div>

					<div class="col">
						<h3><?php esc_html_e( 'Got sales related question?', 'shopbiz' ); ?></h3>
						<p><?php esc_html_e( 'Please send it via our sales contact page.', 'shopbiz' ) ?></p>
						<p><a href="<?php echo esc_url( 'https://themeansar.com/contact/' ); ?>" class="button button-secondary"><?php esc_html_e( 'Contact Page', 'shopbiz' ); ?></a></p>
					</div>

					<div class="col">
						<h3>
							<?php
							esc_html_e( 'Translate', 'shopbiz' );
							echo ' ' . $theme->display( 'Name' );
							?>
						</h3>
						<p><?php esc_html_e( 'Click below to translate this theme into your own language.', 'shopbiz' ) ?></p>
						<p>
							<a href="<?php echo esc_url( 'http://translate.wordpress.org/projects/wp-themes/shopbiz' ); ?>" class="button button-secondary">
								<?php
								esc_html_e( 'Translate', 'shopbiz' );
								echo ' ' . $theme->display( 'Name' );
								?>
							</a>
						</p>
					</div>
				</div>
			</div>

			<div class="return-to-dashboard shopbiz">
				<?php if ( current_user_can( 'update_core' ) && isset( $_GET['updated'] ) ) : ?>
					<a href="<?php echo esc_url( self_admin_url( 'update-core.php' ) ); ?>">
						<?php is_multisite() ? esc_html_e( 'Return to Updates', 'shopbiz' ) : esc_html_e( 'Return to Dashboard &rarr; Updates', 'shopbiz' ); ?>
					</a> |
				<?php endif; ?>
				<a href="<?php echo esc_url( self_admin_url() ); ?>"><?php is_blog_admin() ? esc_html_e( 'Go to Dashboard &rarr; Home', 'shopbiz' ) : esc_html_e( 'Go to Dashboard', 'shopbiz' ); ?></a>
			</div>
		</div>
		<?php
	}

	/**
	 * Output the supported plugins screen.
	 */
	public function supported_plugins_screen() {
		?>
		<div class="wrap about-wrap">

			<?php $this->shopbiz_intro(); ?>

			<p class="about-description"><?php esc_html_e( 'This theme recommends following plugins:', 'shopbiz' ); ?></p>
			<ol>
				<li><a href="<?php echo esc_url( 'https://wordpress.org/plugins/contact-form-7/' ); ?>" target="_blank"><?php esc_html_e( 'Contact Form 7', 'shopbiz' ); ?></a></li>
				<li><a href="<?php echo esc_url( 'https://wordpress.org/plugins/woocommerce/' ); ?>" target="_blank"><?php esc_html_e( 'WooCommerce', 'shopbiz' ); ?></a></li>
				<li><a href="<?php echo esc_url( 'https://wordpress.org/plugins/polylang/' ); ?>" target="_blank"><?php esc_html_e( 'Polylang', 'shopbiz' ); ?></a>
					<?php esc_html_e('Fully Compatible in Pro Version', 'shopbiz'); ?>
				</li>
				<li><a href="<?php echo esc_url( 'https://wpml.org/' ); ?>" target="_blank"><?php esc_html_e( 'WPML', 'shopbiz' ); ?></a>
					<?php esc_html_e('Fully Compatible in Pro Version', 'shopbiz'); ?>
				</li>
			</ol>

		</div>
		<?php
	}

	/**
	 * Output the free vs pro screen.
	 */
	public function free_vs_pro_screen() {
		?>
		<div class="wrap about-wrap">

			<?php $this->shopbiz_intro(); ?>

			<p class="about-description"><?php esc_html_e( 'Upgrade to PRO version for more exciting features.', 'shopbiz' ); ?></p>

			<table>
				<thead>
					<tr>
						<th class="table-feature-title"><h3><?php esc_html_e('Features', 'shopbiz'); ?></h3></th>
						<th><h3><?php esc_html_e('shopbiz Lite', 'shopbiz'); ?></h3></th>
						<th><h3><?php esc_html_e('shopbiz Pro', 'shopbiz'); ?></h3></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><h3><?php esc_html_e('Slider', 'shopbiz'); ?></h3></td>
						<td><?php esc_html_e('3', 'shopbiz'); ?></td>
						<td><?php esc_html_e('Unlimited Slides', 'shopbiz'); ?></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Slider Settings', 'shopbiz'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><?php esc_html_e('Slides type, duration & delay time', 'shopbiz'); ?></td>
					</tr>
					
					<tr>
						<td><h3><?php esc_html_e('Color Palette', 'shopbiz'); ?></h3></td>
						<td><?php esc_html_e('Primary Color Option', 'shopbiz'); ?></td>
						<td><?php esc_html_e('Multiple Color Options', 'shopbiz'); ?></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Additional Top Header', 'shopbiz'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><?php esc_html_e('Social Icons + Menu + Header text option', 'shopbiz'); ?></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Social Icons', 'shopbiz'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Boxed & Wide layout option', 'shopbiz'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Light & Dark Color skin', 'shopbiz'); ?></h3></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Woocommerce Compatible', 'shopbiz'); ?></h3></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Woocommerce Page Layouts', 'shopbiz'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Translation Ready', 'shopbiz'); ?></h3></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('WPML Compatible', 'shopbiz'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Polylang Compatible', 'shopbiz'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Footer Copyright Editor', 'shopbiz'); ?></h3></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Demo Content', 'shopbiz'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Support', 'shopbiz'); ?></h3></td>
						<td><?php esc_html_e('Forum', 'shopbiz'); ?></td>
						<td><?php esc_html_e('Forum + Emails/Support Ticket', 'shopbiz'); ?></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('MailChimp Subscriber', 'shopbiz'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					
					<tr>
						<td><h3><?php esc_html_e('Services widget', 'shopbiz'); ?></h3></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Call to Action widget', 'shopbiz'); ?></h3></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Featured Single page widget', 'shopbiz'); ?></h3></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Featured widget (Recent Work/Portfolio)', 'shopbiz'); ?></h3></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Testimonial Widget', 'shopbiz'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Featured Posts', 'shopbiz'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Our Clients widget', 'shopbiz'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					
					<tr>
						<td><h3><?php esc_html_e('Prizing Widget', 'shopbiz'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					
					<tr>
						<td><h3><?php esc_html_e('About us Template', 'shopbiz'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					
					<tr>
						<td><h3><?php esc_html_e('Teams Widget', 'shopbiz'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					
					<tr>
						<td><h3><?php esc_html_e('Portfolio 2 , 3 , 4 Column Template', 'shopbiz'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					
					<tr>
						<td><h3><?php esc_html_e('Prizing Template Template', 'shopbiz'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					
					<tr>
						<td><h3><?php esc_html_e('Contact us Template', 'shopbiz'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					
					
					<tr>
						<td></td>
						<td></td>
						<td class="btn-wrapper">
							<a href="<?php echo esc_url( apply_filters( 'shopbiz_pro_theme_url', 'https://themeansar.com/themes/shopbiz-pro/' ) ); ?>" class="button button-secondary docs" target="_blank"><?php esc_html_e( 'View Pro', 'shopbiz' ); ?></a>
						</td>
					</tr>
				</tbody>
			</table>

		</div>
		<?php
	}
}

endif;

return new shopbiz_Admin();
