<?php
/**
 * Theme functions and definitions
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Load automatic page creator
require_once get_template_directory() . '/create-pages.php';

// Load complete setup script
require_once get_template_directory() . '/complete-setup.php';

function puchong_glass_setup() {
	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	// Let WordPress manage the document title.
	add_theme_support( 'title-tag' );

	// Enable support for Post Thumbnails on posts and pages.
	add_theme_support( 'post-thumbnails' );

    // HTML5 support
    add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'script', 'style' ) );

	// Register Navigation Menus
	register_nav_menus(
		array(
			'primary' => esc_html__( 'Primary Menu', 'puchong-glass' ),
            'footer'  => esc_html__( 'Footer Menu', 'puchong-glass' ),
		)
	);

	// Add support for core custom logo.
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 60,
			'width'       => 60,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'puchong_glass_setup' );

/**
 * Enqueue scripts and styles.
 */
function puchong_glass_scripts() {
	// Enqueue Tailwind CSS (Development Mode)
	wp_enqueue_script( 'tailwindcss', 'https://cdn.tailwindcss.com', array(), '3.4.0', false );
    
    // Configure Tailwind Theme
    wp_add_inline_script( 'tailwindcss', "
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        serif: ['Playfair Display', 'serif'],
                    },
                    colors: {
                        blue: {
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
                    }
                }
            }
        }
    ");

	// Enqueue Google Fonts
	wp_enqueue_style( 'google-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap', array(), null );

	// Enqueue Lucide Icons
	wp_enqueue_script( 'lucide-icons', 'https://unpkg.com/lucide@latest', array(), null, true );

	// Theme Main Style
	wp_enqueue_style( 'puchong-glass-style', get_stylesheet_uri(), array(), '1.0.0' );

    // Initialize Lucide Icons after page load
    wp_add_inline_script( 'lucide-icons', 'window.addEventListener("load", function() { lucide.createIcons(); });' );
}
add_action( 'wp_enqueue_scripts', 'puchong_glass_scripts' );

/**
 * Helper to check if a page is active
 */
function is_active_link($path) {
    if (is_front_page() && $path === '/') return true;
    return is_page(trim($path, '/'));
}

/**
 * Handle Contact Form Submissions
 */
function puchong_glass_handle_contact_form() {
    if ( isset($_POST['contact_form_nonce']) && wp_verify_nonce($_POST['contact_form_nonce'], 'contact_form_submit') ) {
        
        // Sanitize form inputs
        $name = sanitize_text_field($_POST['name']);
        $email = sanitize_email($_POST['email']);
        $phone = sanitize_text_field($_POST['phone']);
        $service = sanitize_text_field($_POST['service']);
        $message = sanitize_textarea_field($_POST['message']);
        
        // Create contact submission post
        $post_id = wp_insert_post(array(
            'post_title' => 'Contact from ' . $name,
            'post_type' => 'contact',
            'post_status' => 'publish',
            'meta_input' => array(
                'contact_name' => $name,
                'contact_email' => $email,
                'contact_phone' => $phone,
                'contact_service' => $service,
                'contact_message' => $message,
                'contact_date' => current_time('mysql'),
            )
        ));
        
        if ($post_id) {
            // Send email notification
            $to = get_option('admin_email');
            $subject = 'New Contact Form Submission - ' . get_bloginfo('name');
            $body = "New contact form submission:\n\n";
            $body .= "Name: $name\n";
            $body .= "Email: $email\n";
            $body .= "Phone: $phone\n";
            $body .= "Service Interest: $service\n";
            $body .= "Message:\n$message\n";
            
            wp_mail($to, $subject, $body);
            
            wp_redirect(add_query_arg('success', '1', wp_get_referer()));
            exit;
        }
    }
}
add_action('admin_post_nopriv_contact_form', 'puchong_glass_handle_contact_form');
add_action('admin_post_contact_form', 'puchong_glass_handle_contact_form');

/**
 * Register Custom Post Types
 */
function puchong_glass_register_cpts() {
    // Portfolio Post Type
    register_post_type('portfolio', array(
        'labels' => array(
            'name' => __('Portfolio', 'puchong-glass'),
            'singular_name' => __('Project', 'puchong-glass'),
            'add_new' => __('Add New Project', 'puchong-glass'),
            'add_new_item' => __('Add New Project', 'puchong-glass'),
            'edit_item' => __('Edit Project', 'puchong-glass'),
        ),
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-images-alt2',
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'rewrite' => array('slug' => 'project'),
        'show_in_rest' => true, // Enable Gutenberg
    ));

    // Portfolio Categories Taxonomy
    register_taxonomy('portfolio_category', 'portfolio', array(
        'labels' => array(
            'name' => __('Project Categories', 'puchong-glass'),
            'singular_name' => __('Category', 'puchong-glass'),
        ),
        'hierarchical' => true,
        'show_in_rest' => true,
    ));

    // Services Post Type
    register_post_type('service', array(
        'labels' => array(
            'name' => __('Services', 'puchong-glass'),
            'singular_name' => __('Service', 'puchong-glass'),
            'add_new' => __('Add New Service', 'puchong-glass'),
            'add_new_item' => __('Add New Service', 'puchong-glass'),
            'edit_item' => __('Edit Service', 'puchong-glass'),
        ),
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-hammer',
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'rewrite' => array('slug' => 'service'),
        'show_in_rest' => true,
    ));

    // FAQ Post Type
    register_post_type('faq', array(
        'labels' => array(
            'name' => __('FAQs', 'puchong-glass'),
            'singular_name' => __('FAQ', 'puchong-glass'),
            'add_new' => __('Add New FAQ', 'puchong-glass'),
            'add_new_item' => __('Add New FAQ', 'puchong-glass'),
            'edit_item' => __('Edit FAQ', 'puchong-glass'),
        ),
        'public' => false, // Not publicly queryable as single pages
        'show_ui' => true, // Show in admin
        'menu_icon' => 'dashicons-format-chat',
        'supports' => array('title', 'editor'),
        'show_in_rest' => true,
    ));

    // Contact Submissions Post Type
    register_post_type('contact', array(
        'labels' => array(
            'name' => __('Contact Submissions', 'puchong-glass'),
            'singular_name' => __('Contact', 'puchong-glass'),
        ),
        'public' => false,
        'show_ui' => true,
        'menu_icon' => 'dashicons-email',
        'supports' => array('title'),
        'capabilities' => array(
            'create_posts' => false, // Removes "Add New" button
        ),
        'map_meta_cap' => true,
    ));

    // Testimonials Post Type
    register_post_type('testimonial', array(
        'labels' => array(
            'name' => __('Testimonials', 'puchong-glass'),
            'singular_name' => __('Testimonial', 'puchong-glass'),
            'add_new' => __('Add New Testimonial', 'puchong-glass'),
        ),
        'public' => false,
        'show_ui' => true,
        'menu_icon' => 'dashicons-testimonial',
        'supports' => array('title', 'editor'),
        'show_in_rest' => true,
    ));
}
add_action('init', 'puchong_glass_register_cpts');

/**
 * Include sample data installer
 */
require_once get_template_directory() . '/sample-data.php';

/**
 * Add custom columns to Contact Submissions list
 */
function puchong_glass_contact_columns($columns) {
    return array(
        'cb' => $columns['cb'],
        'title' => __('Name', 'puchong-glass'),
        'email' => __('Email', 'puchong-glass'),
        'phone' => __('Phone', 'puchong-glass'),
        'service' => __('Service', 'puchong-glass'),
        'date' => __('Date', 'puchong-glass'),
    );
}
add_filter('manage_contact_posts_columns', 'puchong_glass_contact_columns');

function puchong_glass_contact_column_content($column, $post_id) {
    switch ($column) {
        case 'email':
            echo esc_html(get_post_meta($post_id, 'contact_email', true));
            break;
        case 'phone':
            echo esc_html(get_post_meta($post_id, 'contact_phone', true));
            break;
        case 'service':
            echo esc_html(get_post_meta($post_id, 'contact_service', true));
            break;
    }
}
add_action('manage_contact_posts_custom_column', 'puchong_glass_contact_column_content', 10, 2);

/**
 * Add meta box for contact details
 */
function puchong_glass_contact_meta_box() {
    add_meta_box(
        'contact_details',
        __('Contact Details', 'puchong-glass'),
        'puchong_glass_contact_meta_box_callback',
        'contact',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'puchong_glass_contact_meta_box');

function puchong_glass_contact_meta_box_callback($post) {
    $name = get_post_meta($post->ID, 'contact_name', true);
    $email = get_post_meta($post->ID, 'contact_email', true);
    $phone = get_post_meta($post->ID, 'contact_phone', true);
    $service = get_post_meta($post->ID, 'contact_service', true);
    $message = get_post_meta($post->ID, 'contact_message', true);
    $date = get_post_meta($post->ID, 'contact_date', true);
    ?>
    <table class="form-table">
        <tr>
            <th><strong>Name:</strong></th>
            <td><?php echo esc_html($name); ?></td>
        </tr>
        <tr>
            <th><strong>Email:</strong></th>
            <td><a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a></td>
        </tr>
        <tr>
            <th><strong>Phone:</strong></th>
            <td><a href="tel:<?php echo esc_attr($phone); ?>"><?php echo esc_html($phone); ?></a></td>
        </tr>
        <tr>
            <th><strong>Service Interest:</strong></th>
            <td><?php echo esc_html($service); ?></td>
        </tr>
        <tr>
            <th><strong>Submitted:</strong></th>
            <td><?php echo esc_html($date); ?></td>
        </tr>
        <tr>
            <th><strong>Message:</strong></th>
            <td><?php echo nl2br(esc_html($message)); ?></td>
        </tr>
    </table>
    <?php
}
