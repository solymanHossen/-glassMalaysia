<?php
/**
 * Theme functions and definitions
 * 
 * @package Puchong_Glass
 * @version 2.0.0
 * @author Senior Engineer
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Define theme constants
define( 'PUCHONG_GLASS_VERSION', '2.0.0' );
define( 'PUCHONG_GLASS_DIR', get_template_directory() );
define( 'PUCHONG_GLASS_URI', get_template_directory_uri() );

// Load automatic page creator
require_once PUCHONG_GLASS_DIR . '/create-pages.php';

// Load complete setup script
require_once PUCHONG_GLASS_DIR . '/complete-setup.php';

// Load admin panel initialization
require_once PUCHONG_GLASS_DIR . '/admin-panel-init.php';

// Load authentication system
require_once PUCHONG_GLASS_DIR . '/admin-auth.php';

/**
 * Theme setup and features
 */
function puchong_glass_setup() {
	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	// Let WordPress manage the document title.
	add_theme_support( 'title-tag' );

	// Enable support for Post Thumbnails on posts and pages.
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 1200, 800, true );

	// Add custom image sizes
	add_image_size( 'puchong-hero', 1920, 1080, true );
	add_image_size( 'puchong-portfolio', 800, 600, true );
	add_image_size( 'puchong-card', 400, 300, true );
	add_image_size( 'puchong-testimonial', 100, 100, true );

	// HTML5 support
	add_theme_support( 'html5', array( 
		'search-form', 
		'comment-form', 
		'comment-list', 
		'gallery', 
		'caption', 
		'script', 
		'style' 
	) );

	// Register Navigation Menus
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Navigation', 'puchong-glass' ),
		'footer'  => esc_html__( 'Footer Navigation', 'puchong-glass' ),
	) );

	// Add support for core custom logo.
	add_theme_support( 'custom-logo', array(
		'height'      => 60,
		'width'       => 60,
		'flex-width'  => true,
		'flex-height' => true,
	) );

	// Support for responsive embeds
	add_theme_support( 'responsive-embeds' );

	// Add excerpt support for pages
	add_post_type_support( 'page', 'excerpt' );
}
add_action( 'after_setup_theme', 'puchong_glass_setup' );

/**
 * Image utility class for handling dummy images professionally
 */
class Puchong_Image_Helper {
	/**
	 * Get image URL with fallback to professional placeholder
	 * 
	 * @param int|object $post_id Post ID or post object
	 * @param string $size Image size
	 * @return string Image URL
	 */
	public static function get_image_url( $post_id, $size = 'medium' ) {
		if ( has_post_thumbnail( $post_id ) ) {
			$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), $size );
			return $image ? $image[0] : self::get_placeholder_image( $size );
		}
		return self::get_placeholder_image( $size );
	}

	/**
	 * Get professional placeholder image
	 * 
	 * @param string $size Image size
	 * @return string Placeholder image URL
	 */
	public static function get_placeholder_image( $size = 'medium' ) {
		$dimensions = self::get_size_dimensions( $size );
		$width = $dimensions['width'];
		$height = $dimensions['height'];
		
		// Use imgplaceholder.com for professional dummy images
		return esc_url( "https://imgplaceholder.com/{$width}x{$height}?text=Premium+Glass+Solutions&bg=3b82f6&textcolor=ffffff&fontsize=16" );
	}

	/**
	 * Get image dimensions by size
	 * 
	 * @param string $size Image size
	 * @return array Width and height
	 */
	private static function get_size_dimensions( $size ) {
		$sizes = array(
			'puchong-hero'       => array( 'width' => 1920, 'height' => 1080 ),
			'puchong-portfolio'  => array( 'width' => 800, 'height' => 600 ),
			'puchong-card'       => array( 'width' => 400, 'height' => 300 ),
			'puchong-testimonial' => array( 'width' => 100, 'height' => 100 ),
			'thumbnail'          => array( 'width' => 150, 'height' => 150 ),
			'medium'             => array( 'width' => 300, 'height' => 300 ),
			'large'              => array( 'width' => 1024, 'height' => 768 ),
			'full'               => array( 'width' => 1920, 'height' => 1080 ),
		);
		
		return isset( $sizes[ $size ] ) ? $sizes[ $size ] : $sizes['medium'];
	}

	/**
	 * Output image HTML with proper attributes
	 * 
	 * @param int $post_id Post ID
	 * @param string $size Image size
	 * @param string $class CSS classes
	 */
	public static function display_image( $post_id, $size = 'medium', $class = '' ) {
		$image_url = self::get_image_url( $post_id, $size );
		$dimensions = self::get_size_dimensions( $size );
		$post_title = get_the_title( $post_id );
		
		?>
		<img 
			src="<?php echo esc_url( $image_url ); ?>" 
			alt="<?php echo esc_attr( $post_title ); ?>"
			width="<?php echo esc_attr( $dimensions['width'] ); ?>"
			height="<?php echo esc_attr( $dimensions['height'] ); ?>"
			class="<?php echo esc_attr( $class ); ?>"
			loading="lazy"
			decoding="async"
		/>
		<?php
	}
}

/**
 * Asset enqueue class for senior-level asset management
 */
class Puchong_Assets {
	/**
	 * Initialize asset management
	 */
	public static function init() {
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_scripts' ) );
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_styles' ) );
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue_admin_assets' ) );
	}

	/**
	 * Enqueue frontend scripts
	 */
	public static function enqueue_scripts() {
		// Tailwind CSS via CDN (Development - can be replaced with build process for production)
		wp_enqueue_script( 
			'tailwindcss', 
			'https://cdn.tailwindcss.com', 
			array(), 
			'3.4.0', 
			false 
		);
		
		// Tailwind configuration
		wp_add_inline_script( 'tailwindcss', self::get_tailwind_config() );

		// Lucide Icons
		wp_enqueue_script( 
			'lucide-icons', 
			'https://unpkg.com/lucide@latest', 
			array(), 
			null, 
			true 
		);

		// Initialize icons on page load
		wp_add_inline_script( 'lucide-icons', 'window.addEventListener("load", function() { if(typeof lucide !== "undefined") lucide.createIcons(); });' );

		// Theme main script
		wp_enqueue_script(
			'puchong-glass-main',
			PUCHONG_GLASS_URI . '/assets/js/main.js',
			array( 'lucide-icons' ),
			PUCHONG_GLASS_VERSION,
			true
		);

		// Pass PHP data to JavaScript
		wp_localize_script( 'puchong-glass-main', 'puchongGlass', array(
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
			'nonce' => wp_create_nonce( 'puchong_glass_nonce' ),
			'siteUrl' => home_url(),
		) );
	}

	/**
	 * Enqueue frontend styles
	 */
	public static function enqueue_styles() {
		// Google Fonts
		wp_enqueue_style( 
			'google-fonts', 
			'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap', 
			array(), 
			null 
		);

		// Theme styles
		wp_enqueue_style(
			'puchong-glass-style',
			get_stylesheet_uri(),
			array(),
			PUCHONG_GLASS_VERSION
		);
	}

	/**
	 * Enqueue admin assets
	 */
	public static function enqueue_admin_assets() {
		wp_enqueue_style(
			'puchong-glass-admin',
			PUCHONG_GLASS_URI . '/assets/css/admin.css',
			array(),
			PUCHONG_GLASS_VERSION
		);
	}

	/**
	 * Get Tailwind configuration
	 * 
	 * @return string JavaScript code for Tailwind config
	 */
	private static function get_tailwind_config() {
		return "
			tailwind.config = {
				theme: {
					extend: {
						fontFamily: {
							sans: ['Inter', 'sans-serif'],
							serif: ['Playfair Display', 'serif'],
						},
						colors: {
							primary: {
								50: '#eff6ff',
								100: '#dbeafe',
								200: '#bfdbfe',
								300: '#93c5fd',
								400: '#60a5fa',
								500: '#3b82f6',
								600: '#2563eb',
								700: '#1d4ed8',
								800: '#1e40af',
								900: '#1e3a8a',
								950: '#172554',
							}
						},
						animation: {
							'fade-in': 'fadeIn 0.6s ease-out forwards',
							'slide-in-left': 'slideInLeft 0.6s ease-out forwards',
							'slide-in-right': 'slideInRight 0.6s ease-out forwards',
						}
					}
				}
			};
		";
	}
}

// Initialize asset management
Puchong_Assets::init();

/**
 * Helper to check if a page is active
 * 
 * @param string $path Page path to check
 * @return bool
 */
function is_active_link( $path ) {
	if ( is_front_page() && $path === '/' ) {
		return true;
	}
	return is_page( trim( $path, '/' ) );
}

/**
 * Get site contact information
 * 
 * @return array Contact info
 */
function puchong_glass_get_contact_info() {
	return array(
		'phone' => get_option( 'puchong_glass_phone', '+60 12-345 6789' ),
		'email' => get_option( 'puchong_glass_email', 'hello@puchongglass.com' ),
		'address' => get_option( 'puchong_glass_address', 'Puchong, Selangor 58000' ),
		'whatsapp' => get_option( 'puchong_glass_whatsapp', 'https://wa.me/60123456789' ),
	);
}

/**
 * Sanitize and validate contact information
 * 
 * @param array $data Contact form data
 * @return array|WP_Error Sanitized data or error
 */
function puchong_glass_validate_contact_data( $data ) {
	$errors = new WP_Error();

	// Validate name
	$name = isset( $data['name'] ) ? sanitize_text_field( $data['name'] ) : '';
	if ( empty( $name ) || strlen( $name ) < 2 ) {
		$errors->add( 'invalid_name', __( 'Name must be at least 2 characters long', 'puchong-glass' ) );
	}

	// Validate email
	$email = isset( $data['email'] ) ? sanitize_email( $data['email'] ) : '';
	if ( empty( $email ) || ! is_email( $email ) ) {
		$errors->add( 'invalid_email', __( 'Please provide a valid email address', 'puchong-glass' ) );
	}

	// Validate phone
	$phone = isset( $data['phone'] ) ? sanitize_text_field( $data['phone'] ) : '';
	if ( empty( $phone ) ) {
		$errors->add( 'invalid_phone', __( 'Phone number is required', 'puchong-glass' ) );
	}

	// Validate message
	$message = isset( $data['message'] ) ? sanitize_textarea_field( $data['message'] ) : '';
	if ( empty( $message ) || strlen( $message ) < 10 ) {
		$errors->add( 'invalid_message', __( 'Message must be at least 10 characters long', 'puchong-glass' ) );
	}

	if ( count( $errors->get_error_codes() ) > 0 ) {
		return $errors;
	}

	return array(
		'name' => $name,
		'email' => $email,
		'phone' => $phone,
		'service' => isset( $data['service'] ) ? sanitize_text_field( $data['service'] ) : '',
		'message' => $message,
	);
}

/**
 * Modern Admin Panel Router
 */
function puchong_glass_admin_panel_router() {
	// Check if user has capability and access the admin panel URL
	if ( current_user_can( 'manage_options' ) && isset( $_GET['puchong-admin'] ) ) {
		require_once PUCHONG_GLASS_DIR . '/admin-panel.php';
		exit;
	}
}
add_action( 'init', 'puchong_glass_admin_panel_router', 1 );

/**
 * Add admin panel menu item
 */
function puchong_glass_admin_menu() {
	add_menu_page(
		esc_html__( 'Puchong Glass', 'puchong-glass' ),
		esc_html__( 'Puchong Glass', 'puchong-glass' ),
		'manage_options',
		'puchong-admin-panel',
		function() {
			$_GET['puchong-admin'] = 1;
			require_once PUCHONG_GLASS_DIR . '/admin-panel.php';
		},
		'dashicons-building',
		3
	);
}
add_action( 'admin_menu', 'puchong_glass_admin_menu' );

/**
 * Add custom admin panel link in WordPress admin bar
 */
function puchong_glass_admin_bar() {
	global $wp_admin_bar;

	if ( current_user_can( 'manage_options' ) ) {
		$wp_admin_bar->add_menu( array(
			'id'    => 'puchong-glass-admin',
			'title' => esc_html__( 'Admin Panel', 'puchong-glass' ),
			'href'  => admin_url( 'admin.php?page=puchong-admin-panel' ),
			'meta'  => array(
				'class' => 'puchong-admin-menu',
			),
		) );
	}
}
add_action( 'admin_bar_menu', 'puchong_glass_admin_bar', 999 );

/**
 * Handle Contact Form Submissions
 */
function puchong_glass_handle_contact_form() {
	// Verify nonce
	if ( ! isset( $_POST['contact_form_nonce'] ) || ! wp_verify_nonce( $_POST['contact_form_nonce'], 'contact_form_submit' ) ) {
		wp_die( esc_html__( 'Security check failed', 'puchong-glass' ) );
	}

	// Validate and sanitize data
	$data = puchong_glass_validate_contact_data( $_POST );
	if ( is_wp_error( $data ) ) {
		wp_redirect( add_query_arg( array( 'error' => '1', 'message' => $data->get_error_message() ), wp_get_referer() ) );
		exit;
	}

	// Create contact submission post
	$post_id = wp_insert_post( array(
		'post_title' => sanitize_text_field( sprintf( 'Contact from %s', $data['name'] ) ),
		'post_type' => 'contact',
		'post_status' => 'publish',
		'meta_input' => array(
			'contact_name' => $data['name'],
			'contact_email' => $data['email'],
			'contact_phone' => $data['phone'],
			'contact_service' => $data['service'],
			'contact_message' => $data['message'],
			'contact_date' => current_time( 'mysql' ),
			'contact_ip' => sanitize_text_field( $_SERVER['REMOTE_ADDR'] ?? '' ),
		),
	) );

	if ( is_wp_error( $post_id ) ) {
		wp_redirect( add_query_arg( 'error', '2', wp_get_referer() ) );
		exit;
	}

	// Send email notification to admin
	$admin_email = get_option( 'admin_email' );
	$subject = sprintf( __( 'New Contact Form Submission - %s', 'puchong-glass' ), get_bloginfo( 'name' ) );
	$body = sprintf(
		__( "New contact form submission:\n\nName: %s\nEmail: %s\nPhone: %s\nService Interest: %s\nMessage:\n%s\n\nView submission: %s", 'puchong-glass' ),
		$data['name'],
		$data['email'],
		$data['phone'],
		$data['service'],
		$data['message'],
		admin_url( "post.php?post={$post_id}&action=edit" )
	);

	wp_mail( $admin_email, $subject, $body );

	// Send confirmation email to user
	$user_subject = __( 'We received your inquiry', 'puchong-glass' );
	$user_body = sprintf(
		__( "Hi %s,\n\nThank you for contacting us. We have received your inquiry and will get back to you as soon as possible.\n\nBest regards,\n%s", 'puchong-glass' ),
		$data['name'],
		get_bloginfo( 'name' )
	);

	wp_mail( $data['email'], $user_subject, $user_body );

	wp_redirect( add_query_arg( 'success', '1', wp_get_referer() ) );
	exit;
}

add_action( 'admin_post_nopriv_contact_form', 'puchong_glass_handle_contact_form' );
add_action( 'admin_post_contact_form', 'puchong_glass_handle_contact_form' );

/**
 * Register Custom Post Types and Taxonomies
 */
function puchong_glass_register_cpts() {
	$cpt_args = array(
		'public' => true,
		'show_in_rest' => true, // Enable Gutenberg
		'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
		'has_archive' => true,
	);

	// Portfolio Post Type
	register_post_type( 'portfolio', array_merge( $cpt_args, array(
		'labels' => array(
			'name' => __( 'Portfolio', 'puchong-glass' ),
			'singular_name' => __( 'Project', 'puchong-glass' ),
			'add_new' => __( 'Add New Project', 'puchong-glass' ),
			'add_new_item' => __( 'Add New Project', 'puchong-glass' ),
			'edit_item' => __( 'Edit Project', 'puchong-glass' ),
		),
		'menu_icon' => 'dashicons-images-alt2',
		'rewrite' => array( 'slug' => 'project' ),
	) ) );

	// Portfolio Categories Taxonomy
	register_taxonomy( 'portfolio_category', 'portfolio', array(
		'labels' => array(
			'name' => __( 'Project Categories', 'puchong-glass' ),
			'singular_name' => __( 'Category', 'puchong-glass' ),
		),
		'hierarchical' => true,
		'show_in_rest' => true,
	) );

	// Services Post Type
	register_post_type( 'service', array_merge( $cpt_args, array(
		'labels' => array(
			'name' => __( 'Services', 'puchong-glass' ),
			'singular_name' => __( 'Service', 'puchong-glass' ),
			'add_new' => __( 'Add New Service', 'puchong-glass' ),
			'add_new_item' => __( 'Add New Service', 'puchong-glass' ),
			'edit_item' => __( 'Edit Service', 'puchong-glass' ),
		),
		'menu_icon' => 'dashicons-hammer',
		'rewrite' => array( 'slug' => 'service' ),
	) ) );

	// FAQ Post Type
	register_post_type( 'faq', array(
		'labels' => array(
			'name' => __( 'FAQs', 'puchong-glass' ),
			'singular_name' => __( 'FAQ', 'puchong-glass' ),
			'add_new' => __( 'Add New FAQ', 'puchong-glass' ),
			'add_new_item' => __( 'Add New FAQ', 'puchong-glass' ),
			'edit_item' => __( 'Edit FAQ', 'puchong-glass' ),
		),
		'public' => false,
		'show_ui' => true,
		'show_in_rest' => true,
		'menu_icon' => 'dashicons-format-chat',
		'supports' => array( 'title', 'editor' ),
	) );

	// Contact Submissions Post Type
	register_post_type( 'contact', array(
		'labels' => array(
			'name' => __( 'Contact Submissions', 'puchong-glass' ),
			'singular_name' => __( 'Contact', 'puchong-glass' ),
		),
		'public' => false,
		'show_ui' => true,
		'menu_icon' => 'dashicons-email',
		'supports' => array( 'title' ),
		'capabilities' => array(
			'create_posts' => false,
		),
		'map_meta_cap' => true,
	) );

	// Testimonials Post Type
	register_post_type( 'testimonial', array(
		'labels' => array(
			'name' => __( 'Testimonials', 'puchong-glass' ),
			'singular_name' => __( 'Testimonial', 'puchong-glass' ),
			'add_new' => __( 'Add New Testimonial', 'puchong-glass' ),
		),
		'public' => false,
		'show_ui' => true,
		'show_in_rest' => true,
		'menu_icon' => 'dashicons-testimonial',
		'supports' => array( 'title', 'editor', 'thumbnail' ),
	) );
}
add_action( 'init', 'puchong_glass_register_cpts' );

/**
 * Admin columns for Contact Submissions
 */
function puchong_glass_contact_columns( $columns ) {
	return array(
		'cb' => $columns['cb'],
		'title' => __( 'Name', 'puchong-glass' ),
		'email' => __( 'Email', 'puchong-glass' ),
		'phone' => __( 'Phone', 'puchong-glass' ),
		'service' => __( 'Service', 'puchong-glass' ),
		'date' => __( 'Date', 'puchong-glass' ),
	);
}
add_filter( 'manage_contact_posts_columns', 'puchong_glass_contact_columns' );

/**
 * Display custom column content for contacts
 */
function puchong_glass_contact_column_content( $column, $post_id ) {
	switch ( $column ) {
		case 'email':
			echo esc_html( get_post_meta( $post_id, 'contact_email', true ) );
			break;
		case 'phone':
			$phone = get_post_meta( $post_id, 'contact_phone', true );
			if ( $phone ) {
				echo '<a href="tel:' . esc_attr( $phone ) . '">' . esc_html( $phone ) . '</a>';
			}
			break;
		case 'service':
			echo esc_html( get_post_meta( $post_id, 'contact_service', true ) );
			break;
	}
}
add_action( 'manage_contact_posts_custom_column', 'puchong_glass_contact_column_content', 10, 2 );

/**
 * Add meta box for contact details
 */
function puchong_glass_contact_meta_box() {
	add_meta_box(
		'contact_details',
		__( 'Contact Details', 'puchong-glass' ),
		'puchong_glass_contact_meta_box_callback',
		'contact',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'puchong_glass_contact_meta_box' );

/**
 * Contact meta box callback
 */
function puchong_glass_contact_meta_box_callback( $post ) {
	$name = get_post_meta( $post->ID, 'contact_name', true );
	$email = get_post_meta( $post->ID, 'contact_email', true );
	$phone = get_post_meta( $post->ID, 'contact_phone', true );
	$service = get_post_meta( $post->ID, 'contact_service', true );
	$message = get_post_meta( $post->ID, 'contact_message', true );
	$date = get_post_meta( $post->ID, 'contact_date', true );
	$ip = get_post_meta( $post->ID, 'contact_ip', true );
	?>
	<table class="form-table">
		<tr>
			<th><strong><?php esc_html_e( 'Name:', 'puchong-glass' ); ?></strong></th>
			<td><?php echo esc_html( $name ); ?></td>
		</tr>
		<tr>
			<th><strong><?php esc_html_e( 'Email:', 'puchong-glass' ); ?></strong></th>
			<td><a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a></td>
		</tr>
		<tr>
			<th><strong><?php esc_html_e( 'Phone:', 'puchong-glass' ); ?></strong></th>
			<td><a href="tel:<?php echo esc_attr( $phone ); ?>"><?php echo esc_html( $phone ); ?></a></td>
		</tr>
		<tr>
			<th><strong><?php esc_html_e( 'Service Interest:', 'puchong-glass' ); ?></strong></th>
			<td><?php echo esc_html( $service ); ?></td>
		</tr>
		<tr>
			<th><strong><?php esc_html_e( 'Submitted:', 'puchong-glass' ); ?></strong></th>
			<td><?php echo esc_html( $date ); ?></td>
		</tr>
		<?php if ( $ip ) : ?>
		<tr>
			<th><strong><?php esc_html_e( 'IP Address:', 'puchong-glass' ); ?></strong></th>
			<td><?php echo esc_html( $ip ); ?></td>
		</tr>
		<?php endif; ?>
		<tr>
			<th><strong><?php esc_html_e( 'Message:', 'puchong-glass' ); ?></strong></th>
			<td><?php echo nl2br( esc_html( $message ) ); ?></td>
		</tr>
	</table>
	<?php
}

// Load sample data installer
require_once PUCHONG_GLASS_DIR . '/sample-data.php';
