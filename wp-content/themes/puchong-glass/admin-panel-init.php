<?php
/**
 * Admin Panel Setup & Initialization Script
 * Run automatically when theme is activated
 * 
 * @package Puchong_Glass
 * @version 2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Initialize admin panel on theme activation
 */
function puchong_glass_admin_panel_init() {
	// Set default contact information if not already set
	if ( ! get_option( 'puchong_glass_phone' ) ) {
		update_option( 'puchong_glass_phone', '+60 12-345 6789' );
	}

	if ( ! get_option( 'puchong_glass_email' ) ) {
		update_option( 'puchong_glass_email', 'hello@puchongglass.com' );
	}

	if ( ! get_option( 'puchong_glass_address' ) ) {
		update_option( 'puchong_glass_address', 'Puchong, Selangor 58000' );
	}

	if ( ! get_option( 'puchong_glass_whatsapp' ) ) {
		update_option( 'puchong_glass_whatsapp', 'https://wa.me/60123456789' );
	}

	// Flush rewrite rules
	flush_rewrite_rules();
}

// Run on theme activation
add_action( 'after_setup_theme', 'puchong_glass_admin_panel_init' );

/**
 * Add admin notice for first-time setup
 */
function puchong_glass_admin_notices() {
	// Only show to administrators
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	// Check if notice has been dismissed
	if ( get_option( 'puchong_glass_setup_notice_dismissed' ) ) {
		return;
	}

	// Check if this is first visit to admin
	$setup_complete = get_option( 'puchong_glass_setup_complete' );
	
	if ( ! $setup_complete ) {
		?>
		<div class="notice notice-info is-dismissible" id="puchong-glass-notice">
			<p>
				<strong><?php esc_html_e( 'Welcome to Puchong Glass Admin Panel!', 'puchong-glass' ); ?></strong><br>
				<?php esc_html_e( 'Your modern admin panel is ready to use. Configure your contact information and start managing submissions.', 'puchong-glass' ); ?>
			</p>
			<p>
				<a href="<?php echo admin_url( 'admin.php?page=puchong-admin-panel' ); ?>" class="button button-primary">
					<?php esc_html_e( 'Open Admin Panel', 'puchong-glass' ); ?>
				</a>
				<a href="<?php echo admin_url( 'admin.php?page=puchong-admin-panel&page=settings' ); ?>" class="button">
					<?php esc_html_e( 'Configure Settings', 'puchong-glass' ); ?>
				</a>
			</p>
		</div>
		<script>
			document.addEventListener( 'DOMContentLoaded', function() {
				const notice = document.getElementById( 'puchong-glass-notice' );
				if ( notice ) {
					const closeBtn = notice.querySelector( '.notice-dismiss' );
					if ( closeBtn ) {
						closeBtn.addEventListener( 'click', function() {
							fetch( ajaxurl, {
								method: 'POST',
								headers: {
									'Content-Type': 'application/x-www-form-urlencoded',
								},
								body: 'action=puchong_dismiss_notice&nonce=' + ( typeof puchongNonce !== 'undefined' ? puchongNonce : '' )
							});
						});
					}
				}
			});
		</script>
		<?php
	}
}

add_action( 'admin_notices', 'puchong_glass_admin_notices' );

/**
 * Handle notice dismissal via AJAX
 */
function puchong_glass_dismiss_notice() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die();
	}

	update_option( 'puchong_glass_setup_notice_dismissed', 1 );
	update_option( 'puchong_glass_setup_complete', 1 );
	wp_die();
}

add_action( 'wp_ajax_puchong_dismiss_notice', 'puchong_glass_dismiss_notice' );

/**
 * Enqueue admin panel CSS
 */
function puchong_glass_admin_panel_styles() {
	wp_enqueue_style(
		'puchong-glass-admin-panel',
		PUCHONG_GLASS_URI . '/assets/css/admin-panel.css',
		array(),
		PUCHONG_GLASS_VERSION
	);
}

add_action( 'admin_enqueue_scripts', 'puchong_glass_admin_panel_styles' );

/**
 * Enqueue admin panel JavaScript
 */
function puchong_glass_admin_panel_scripts() {
	wp_enqueue_script(
		'puchong-glass-admin-js',
		PUCHONG_GLASS_URI . '/assets/js/admin.js',
		array(),
		PUCHONG_GLASS_VERSION,
		true
	);

	// Localize script with nonce
	wp_localize_script(
		'puchong-glass-admin-js',
		'puchongNonce',
		wp_create_nonce( 'puchong_admin_nonce' )
	);
}

add_action( 'admin_enqueue_scripts', 'puchong_glass_admin_panel_scripts' );

/**
 * Add custom admin styles
 */
function puchong_glass_custom_admin_styles() {
	?>
	<style>
		#adminmenu #toplevel_page_puchong-admin-panel > .wp-menu-image {
			background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18M3 6v12a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6"/></svg>');
			background-repeat: no-repeat;
			background-position: center;
			background-size: contain;
		}

		.puchong-admin-menu {
			background-color: #2563eb !important;
			color: white !important;
		}

		/* Highlight contact submissions in post list */
		.post-type-contact .column-email,
		.post-type-contact .column-phone {
			color: #2563eb;
			font-weight: 500;
		}
	</style>
	<?php
}

add_action( 'admin_head', 'puchong_glass_custom_admin_styles' );

/**
 * Add admin panel link to admin bar
 */
function puchong_glass_admin_bar_link() {
	global $wp_admin_bar;

	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$wp_admin_bar->add_menu( array(
		'id'     => 'puchong-glass-admin',
		'parent' => 'top-secondary',
		'title'  => __( 'Puchong Admin', 'puchong-glass' ),
		'href'   => admin_url( 'admin.php?page=puchong-admin-panel' ),
		'meta'   => array(
			'class' => 'puchong-admin-bar-item',
		),
	) );
}

add_action( 'admin_bar_menu', 'puchong_glass_admin_bar_link', 999 );

/**
 * Clean up old contacts (optional maintenance)
 */
function puchong_glass_cleanup_old_contacts() {
	// Delete contacts older than 90 days
	$args = array(
		'post_type'      => 'contact',
		'posts_per_page' => -1,
		'date_query'     => array(
			array(
				'before' => '90 days ago',
			),
		),
	);

	$old_contacts = get_posts( $args );

	foreach ( $old_contacts as $contact ) {
		wp_delete_post( $contact->ID, true );
	}
}

// Optionally schedule cleanup (commented out - uncomment if needed)
// add_action( 'wp_scheduled_delete', 'puchong_glass_cleanup_old_contacts' );

/**
 * Add plugin/theme update notifications
 */
function puchong_glass_admin_footer() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$current_screen = get_current_screen();
	if ( isset( $current_screen->id ) && strpos( $current_screen->id, 'puchong' ) !== false ) {
		?>
		<div id="puchong-footer-text">
			<p>
				<?php
				printf(
					esc_html__( 'Puchong Glass Admin Panel v%s', 'puchong-glass' ),
					esc_html( PUCHONG_GLASS_VERSION )
				);
				?>
				|
				<a href="<?php echo home_url(); ?>" target="_blank" rel="noopener noreferrer">
					<?php esc_html_e( 'View Site', 'puchong-glass' ); ?>
				</a>
			</p>
		</div>
		<?php
	}
}

add_action( 'admin_footer', 'puchong_glass_admin_footer' );

/**
 * Log admin panel access for security
 */
function puchong_glass_log_admin_access() {
	if ( current_user_can( 'manage_options' ) && isset( $_GET['page'] ) && strpos( $_GET['page'], 'puchong' ) !== false ) {
		// You can add logging here if needed
		// error_log( 'Admin panel accessed by ' . wp_get_current_user()->user_email . ' at ' . current_time( 'mysql' ) );
	}
}

add_action( 'admin_init', 'puchong_glass_log_admin_access' );
