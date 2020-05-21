<?php
/**
 * Ample Admin Class.
 *
 * @author  ThemeGrill
 * @package Ample
 * @since   1.1.5
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Ample_Admin' ) ) :

	/**
	 * Ample_Admin Class.
	 */
	class Ample_Admin {

		/**
		 * Constructor.
		 */
		public function __construct() {
			add_action( 'admin_menu', array( $this, 'admin_menu' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		}

		/**
		 * Localize array for import button AJAX request.
		 */
		public function enqueue_scripts() {
			wp_enqueue_style( 'ample-admin-style', get_template_directory_uri() . '/inc/admin/css/admin.css', array(), AMPLE_THEME_VERSION );

			wp_enqueue_script( 'ample-plugin-install-helper', get_template_directory_uri() . '/inc/admin/js/plugin-handle.js', array( 'jquery' ), AMPLE_THEME_VERSION, true );

			$welcome_data = array(
				'uri'      => esc_url( admin_url( '/themes.php?page=demo-importer&browse=all&ample-hide-notice=welcome' ) ),
				'btn_text' => esc_html__( 'Processing...', 'ample' ),
				'nonce'    => wp_create_nonce( 'ample_demo_import_nonce' ),
			);

			wp_localize_script( 'ample-plugin-install-helper', 'ampleRedirectDemoPage', $welcome_data );
		}

		/**
		 * Add admin menu.
		 */
		public function admin_menu() {
			$theme = wp_get_theme( get_template() );

			$page = add_theme_page(
				esc_html__( 'About', 'ample' ) . ' ' . $theme->display( 'Name' ),
				esc_html__( 'About', 'ample' ) . ' ' . $theme->display( 'Name' ),
				'activate_plugins',
				'ample-welcome',
				array(
					$this,
					'welcome_screen',
				)
			);
			add_action( 'admin_print_styles-' . $page, array( $this, 'enqueue_scripts' ) );
		}

		/**
		 * Intro text/links shown to all about pages.
		 *
		 * @access private
		 */
		private function intro() {

			$theme = wp_get_theme( get_template() );

			// Drop minor version if 0
			$major_version = substr( AMPLE_THEME_VERSION, 0, 3 );
			?>
			<div class="ample-theme-info">
				<h1>
					<?php esc_html_e( 'About', 'ample' ); ?>
					<?php echo $theme->display( 'Name' ); ?>
					<?php printf( '%s', $major_version ); ?>
				</h1>

				<div class="welcome-description-wrap">
					<div class="about-text"><?php echo $theme->display( 'Description' ); ?></div>

					<div class="ample-screenshot">
						<img src="<?php echo esc_url( get_template_directory_uri() ) . '/screenshot.png'; ?>" />
					</div>
				</div>
			</div>

			<p class="ample-actions">
				<a href="<?php echo esc_url( 'https://themegrill.com/themes/ample/?utm_source=ample-about&utm_medium=theme-info-link&utm_campaign=theme-info' ); ?>" class="button button-secondary" target="_blank"><?php esc_html_e( 'Theme Info', 'ample' ); ?></a>

				<a href="<?php echo esc_url( apply_filters( 'ample_pro_theme_url', 'https://demo.themegrill.com/ample/' ) ); ?>" class="button button-secondary docs" target="_blank"><?php esc_html_e( 'View Demo', 'ample' ); ?></a>

				<a href="<?php echo esc_url( apply_filters( 'ample_pro_theme_url', 'https://themegrill.com/themes/ample/?utm_source=ample-about&utm_medium=view-pro-link&utm_campaign=view-pro#free-vs-pro' ) ); ?>" class="button button-primary docs" target="_blank"><?php esc_html_e( 'View PRO version', 'ample' ); ?></a>

				<a href="<?php echo esc_url( apply_filters( 'ample_pro_theme_url', 'https://wordpress.org/support/theme/ample/reviews/?filter=5' ) ); ?>" class="button button-secondary docs" target="_blank"><?php esc_html_e( 'Rate this theme', 'ample' ); ?></a>
			</p>

			<h2 class="nav-tab-wrapper">
				<a class="nav-tab
				<?php
				if ( empty( $_GET['tab'] ) && $_GET['page'] == 'ample-welcome' ) {
					echo 'nav-tab-active';
				}
				?>
				" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'ample-welcome' ), 'themes.php' ) ) ); ?>">
					<?php echo $theme->display( 'Name' ); ?>
				</a>
				<a class="nav-tab
				<?php
				if ( isset( $_GET['tab'] ) && $_GET['tab'] == 'supported_plugins' ) {
					echo 'nav-tab-active';
				}
				?>
				" href="
				<?php
				echo esc_url(
					admin_url(
						add_query_arg(
							array(
								'page' => 'ample-welcome',
								'tab'  => 'supported_plugins',
							),
							'themes.php'
						)
					)
				);
				?>
				">
					<?php esc_html_e( 'Supported Plugins', 'ample' ); ?>
				</a>
				<a class="nav-tab
				<?php
				if ( isset( $_GET['tab'] ) && $_GET['tab'] == 'free_vs_pro' ) {
					echo 'nav-tab-active';
				}
				?>
				" href="
				<?php
				echo esc_url(
					admin_url(
						add_query_arg(
							array(
								'page' => 'ample-welcome',
								'tab'  => 'free_vs_pro',
							),
							'themes.php'
						)
					)
				);
				?>
				">
					<?php esc_html_e( 'Free Vs Pro', 'ample' ); ?>
				</a>
				<a class="nav-tab
				<?php
				if ( isset( $_GET['tab'] ) && $_GET['tab'] == 'changelog' ) {
					echo 'nav-tab-active';
				}
				?>
				" href="
				<?php
				echo esc_url(
					admin_url(
						add_query_arg(
							array(
								'page' => 'ample-welcome',
								'tab'  => 'changelog',
							),
							'themes.php'
						)
					)
				);
				?>
				">
					<?php esc_html_e( 'Changelog', 'ample' ); ?>
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
				return $this->{$current_tab . '_screen'}();
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

				<?php $this->intro(); ?>

				<div class="changelog point-releases">
					<div class="under-the-hood two-col">
						<div class="col">
							<h3><?php esc_html_e( 'Theme Customizer', 'ample' ); ?></h3>
							<p><?php esc_html_e( 'All Theme Options are available via Customize screen.', 'ample' ); ?></p>
							<p>
								<a href="<?php echo admin_url( 'customize.php' ); ?>" class="button button-secondary"><?php esc_html_e( 'Customize', 'ample' ); ?></a>
							</p>
						</div>

						<div class="col">
							<h3><?php esc_html_e( 'Documentation', 'ample' ); ?></h3>
							<p><?php esc_html_e( 'Please view our documentation page to setup the theme.', 'ample' ); ?></p>
							<p>
								<a href="<?php echo esc_url( 'https://docs.themegrill.com/ample/?utm_source=ample-about&utm_medium=documentation-link&utm_campaign=documentation' ); ?>" class="button button-secondary" target="_blank"><?php esc_html_e( 'Documentation', 'ample' ); ?></a>
							</p>
						</div>

						<div class="col">
							<h3><?php esc_html_e( 'Got theme support question?', 'ample' ); ?></h3>
							<p><?php esc_html_e( 'Please put it in our dedicated support forum.', 'ample' ); ?></p>
							<p>
								<a href="<?php echo esc_url( 'https://themegrill.com/support-forum/?utm_source=ample-about&utm_medium=support-forum-link&utm_campaign=support-forum' ); ?>" class="button button-secondary" target="_blank"><?php esc_html_e( 'Support', 'ample' ); ?></a>
							</p>
						</div>

						<div class="col">
							<h3><?php esc_html_e( 'Need more features?', 'ample' ); ?></h3>
							<p><?php esc_html_e( 'Upgrade to PRO version for more exciting features.', 'ample' ); ?></p>
							<p>
								<a href="<?php echo esc_url( 'https://themegrill.com/themes/ample/?utm_source=ample-about&utm_medium=view-pro-link&utm_campaign=view-pro#free-vs-pro' ); ?>" class="button button-secondary" target="_blank"><?php esc_html_e( 'View PRO version', 'ample' ); ?></a>
							</p>
						</div>

						<div class="col">
							<h3><?php esc_html_e( 'Got sales related question?', 'ample' ); ?></h3>
							<p><?php esc_html_e( 'Please send it via our sales contact page.', 'ample' ); ?></p>
							<p>
								<a href="<?php echo esc_url( 'https://themegrill.com/contact/?utm_source=ample-about&utm_medium=contact-page-link&utm_campaign=contact-page' ); ?>" class="button button-secondary" target="_blank"><?php esc_html_e( 'Contact Page', 'ample' ); ?></a>
							</p>
						</div>

						<div class="col">
							<h3>
								<?php
								esc_html_e( 'Translate', 'ample' );
								echo ' ' . $theme->display( 'Name' );
								?>
							</h3>
							<p><?php esc_html_e( 'Click below to translate this theme into your own language.', 'ample' ); ?></p>
							<p>
								<a href="<?php echo esc_url( 'http://translate.wordpress.org/projects/wp-themes/ample' ); ?>" class="button button-secondary">
									<?php
									esc_html_e( 'Translate', 'ample' );
									echo ' ' . $theme->display( 'Name' );
									?>
								</a>
							</p>
						</div>
					</div>
				</div>

				<div class="return-to-dashboard ample">
					<?php if ( current_user_can( 'update_core' ) && isset( $_GET['updated'] ) ) : ?>
						<a href="<?php echo esc_url( self_admin_url( 'update-core.php' ) ); ?>">
							<?php is_multisite() ? esc_html_e( 'Return to Updates', 'ample' ) : esc_html_e( 'Return to Dashboard &rarr; Updates', 'ample' ); ?>
						</a> |
					<?php endif; ?>
					<a href="<?php echo esc_url( self_admin_url() ); ?>"><?php is_blog_admin() ? esc_html_e( 'Go to Dashboard &rarr; Home', 'ample' ) : esc_html_e( 'Go to Dashboard', 'ample' ); ?></a>
				</div>
			</div>
			<?php
		}

		/**
		 * Output the changelog screen.
		 */
		public function changelog_screen() {
			global $wp_filesystem;

			?>
			<div class="wrap about-wrap">

				<?php $this->intro(); ?>

				<p class="about-description"><?php esc_html_e( 'View changelog below:', 'ample' ); ?></p>

				<?php
				$changelog_file = apply_filters( 'ample_changelog_file', get_template_directory() . '/readme.txt' );

				// Check if the changelog file exists and is readable.
				if ( $changelog_file && is_readable( $changelog_file ) ) {
					WP_Filesystem();
					$changelog      = $wp_filesystem->get_contents( $changelog_file );
					$changelog_list = $this->parse_changelog( $changelog );

					echo wp_kses_post( $changelog_list );
				}
				?>
			</div>
			<?php
		}

		/**
		 * Parse changelog from readme file.
		 *
		 * @param  string $content
		 *
		 * @return string
		 */
		private function parse_changelog( $content ) {
			$matches   = null;
			$regexp    = '~==\s*Changelog\s*==(.*)($)~Uis';
			$changelog = '';

			if ( preg_match( $regexp, $content, $matches ) ) {
				$changes = explode( '\r\n', trim( $matches[1] ) );

				$changelog .= '<pre class="changelog">';

				foreach ( $changes as $index => $line ) {
					$changelog .= wp_kses_post( preg_replace( '~(=\s*Version\s*(\d+(?:\.\d+)+)\s*=|$)~Uis', '<span class="title">${1}</span>', $line ) );
				}

				$changelog .= '</pre>';
			}

			return wp_kses_post( $changelog );
		}


		/**
		 * Output the supported plugins screen.
		 */
		public function supported_plugins_screen() {
			?>
			<div class="wrap about-wrap">

				<?php $this->intro(); ?>

				<p class="about-description"><?php esc_html_e( 'This theme recommends following plugins:', 'ample' ); ?></p>
				<ol>
					<li>
						<a href="<?php echo esc_url( 'https://wordpress.org/plugins/social-icons/' ); ?>" target="_blank"><?php esc_html_e( 'Social Icons', 'ample' ); ?></a>
						<?php esc_html_e( ' by ThemeGrill', 'ample' ); ?>
					</li>
					<li>
						<a href="<?php echo esc_url( 'https://wordpress.org/plugins/easy-social-sharing/' ); ?>" target="_blank"><?php esc_html_e( 'Easy Social Sharing', 'ample' ); ?></a>
						<?php esc_html_e( ' by ThemeGrill', 'ample' ); ?>
					</li>
					<li>
						<a href="<?php echo esc_url( 'https://wordpress.org/plugins/contact-form-7/' ); ?>" target="_blank"><?php esc_html_e( 'Contact Form 7', 'ample' ); ?></a>
					</li>
					<li>
						<a href="<?php echo esc_url( 'https://wordpress.org/plugins/wp-pagenavi/' ); ?>" target="_blank"><?php esc_html_e( 'WP-PageNavi', 'ample' ); ?></a>
					</li>
					<li>
						<a href="<?php echo esc_url( 'https://wordpress.org/plugins/woocommerce/' ); ?>" target="_blank"><?php esc_html_e( 'WooCommerce', 'ample' ); ?></a>
					</li>
					<li>
						<a href="<?php echo esc_url( 'https://wordpress.org/plugins/polylang/' ); ?>" target="_blank"><?php esc_html_e( 'Polylang', 'ample' ); ?></a>
						<?php esc_html_e( 'Fully Compatible in Pro Version', 'ample' ); ?>
					</li>
					<li>
						<a href="<?php echo esc_url( 'https://wpml.org/' ); ?>" target="_blank"><?php esc_html_e( 'WPML', 'ample' ); ?></a>
						<?php esc_html_e( 'Fully Compatible in Pro Version', 'ample' ); ?>
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

				<?php $this->intro(); ?>

				<p class="about-description"><?php esc_html_e( 'Upgrade to PRO version for more exciting features.', 'ample' ); ?></p>

				<table>
					<thead>
					<tr>
						<th class="table-feature-title"><h3><?php esc_html_e( 'Features', 'ample' ); ?></h3></th>
						<th><h3><?php esc_html_e( 'Ample', 'ample' ); ?></h3></th>
						<th><h3><?php esc_html_e( 'Ample Pro', 'ample' ); ?></h3></th>
					</tr>
					</thead>
					<tbody>
					<tr>
						<td><h3><?php esc_html_e( 'Price', 'ample' ); ?></h3></td>
						<td><?php esc_html_e( 'Free', 'ample' ); ?></td>
						<td><?php esc_html_e( '$69', 'ample' ); ?></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'Use as One Page theme', 'ample' ); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'Slider', 'ample' ); ?></h3></td>
						<td><?php esc_html_e( '4 Slides', 'ample' ); ?></td>
						<td><?php esc_html_e( 'Unlimited Slides', 'ample' ); ?></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'Slider Settings', 'ample' ); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><?php esc_html_e( 'Slides type, duration & delay time', 'ample' ); ?></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'Google Fonts', 'ample' ); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><?php esc_html_e( '600+', 'ample' ); ?></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'Color Palette', 'ample' ); ?></h3></td>
						<td><?php esc_html_e( 'Primary Color Option', 'ample' ); ?></td>
						<td><?php esc_html_e( 'Primary color option & 35+', 'ample' ); ?></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'Font Size options', 'ample' ); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'Business Template', 'ample' ); ?></h3></td>
						<td><?php esc_html_e( '1', 'ample' ); ?></td>
						<td><?php esc_html_e( '5', 'ample' ); ?></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'Social Links', 'ample' ); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'Additional Top Header', 'ample' ); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><?php esc_html_e( 'Social Links + Header text option', 'ample' ); ?></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'Translation Ready', 'ample' ); ?></h3></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'Woocommerce Compatible', 'ample' ); ?></h3></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'Woocommerce archive page Layout', 'ample' ); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'WPML/Polylang Compatible', 'ample' ); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'Custom Widgets', 'ample' ); ?></h3></td>
						<td><?php esc_html_e( '4', 'ample' ); ?></td>
						<td><?php esc_html_e( '9', 'ample' ); ?></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'TG: Testimonial', 'ample' ); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'TG: Our Clients', 'ample' ); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'TG: Fun Facts', 'ample' ); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'TG: Team', 'ample' ); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'TG: Pricing Table', 'ample' ); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'Footer Copyright Editor', 'ample' ); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'Demo Content', 'ample' ); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'Support', 'ample' ); ?></h3></td>
						<td><?php esc_html_e( 'Forum', 'ample' ); ?></td>
						<td><?php esc_html_e( 'Emails/Priority Support Ticket', 'ample' ); ?></td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td class="btn-wrapper">
							<a href="<?php echo esc_url( apply_filters( 'ample_pro_theme_url', 'https://themegrill.com/themes/ample/?utm_source=ample-free-vs-pro-table&utm_medium=view-pro-link&utm_campaign=view-pro#free-vs-pro' ) ); ?>" class="button button-secondary docs" target="_blank"><?php _e( 'View Pro', 'ample' ); ?></a>
						</td>
					</tbody>
				</table>

			</div>
			<?php
		}
	}

endif;

return new Ample_Admin();
