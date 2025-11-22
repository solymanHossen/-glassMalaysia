<?php
/**
 * Admin Panel Authentication System
 * 
 * @package Puchong_Glass
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Initialize Authentication System
 */
function puchong_glass_init_auth_system() {
	// Add authentication hooks
	add_action( 'wp_ajax_puchong_admin_login', 'puchong_glass_handle_admin_login' );
	add_action( 'wp_ajax_nopriv_puchong_admin_login', 'puchong_glass_handle_admin_login' );
	add_action( 'wp_ajax_puchong_admin_logout', 'puchong_glass_handle_admin_logout' );
	
	// Add security headers
	add_action( 'send_headers', 'puchong_glass_add_security_headers' );
}

/**
 * Add Security Headers
 */
function puchong_glass_add_security_headers() {
	if ( isset( $_GET['puchong-admin'] ) && is_user_logged_in() && current_user_can( 'manage_options' ) ) {
		// Prevent clickjacking
		header( 'X-Frame-Options: SAMEORIGIN' );
		// Prevent MIME type sniffing
		header( 'X-Content-Type-Options: nosniff' );
		// Enable XSS protection
		header( 'X-XSS-Protection: 1; mode=block' );
		// Content Security Policy
		header( "Content-Security-Policy: default-src 'self' https:; script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.tailwindcss.com https://unpkg.com; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; font-src 'self' https://fonts.gstatic.com;" );
	}
}

/**
 * Handle Admin Login via AJAX
 */
function puchong_glass_handle_admin_login() {
	// Verify nonce
	$nonce = isset( $_POST['nonce'] ) ? sanitize_text_field( $_POST['nonce'] ) : '';
	if ( ! wp_verify_nonce( $nonce, 'puchong_admin_login_nonce' ) ) {
		wp_send_json_error( array( 'message' => __( 'Security verification failed', 'puchong-glass' ) ) );
	}

	$username = isset( $_POST['username'] ) ? sanitize_text_field( $_POST['username'] ) : '';
	$password = isset( $_POST['password'] ) ? sanitize_text_field( $_POST['password'] ) : '';

	if ( empty( $username ) || empty( $password ) ) {
		wp_send_json_error( array( 'message' => __( 'Username and password are required', 'puchong-glass' ) ) );
	}

	// Attempt to log in
	$creds = array(
		'user_login'    => $username,
		'user_password' => $password,
		'remember'      => true,
	);

	$user = wp_signon( $creds, false );

	if ( is_wp_error( $user ) ) {
		wp_send_json_error( array( 'message' => $user->get_error_message() ) );
	}

	// Check if user has admin capabilities
	if ( ! user_can( $user->ID, 'manage_options' ) ) {
		wp_clear_auth_cookie();
		wp_send_json_error( array( 'message' => __( 'Access denied. Admin privileges required.', 'puchong-glass' ) ) );
	}

	// Log the login
	do_action( 'puchong_admin_login_success', $user->ID );

	wp_send_json_success( array(
		'message' => __( 'Login successful!', 'puchong-glass' ),
		'redirect' => add_query_arg( 'puchong-admin', '1', admin_url() ),
	) );
}

/**
 * Handle Admin Logout
 */
function puchong_glass_handle_admin_logout() {
	// Verify nonce
	$nonce = isset( $_POST['nonce'] ) ? sanitize_text_field( $_POST['nonce'] ) : '';
	if ( ! wp_verify_nonce( $nonce, 'puchong_admin_logout_nonce' ) ) {
		wp_send_json_error( array( 'message' => __( 'Security verification failed', 'puchong-glass' ) ) );
	}

	wp_logout();
	wp_send_json_success( array( 'redirect' => home_url() ) );
}

/**
 * Validate Admin Access
 */
function puchong_glass_validate_admin_access() {
	if ( ! is_user_logged_in() ) {
		return false;
	}

	if ( ! current_user_can( 'manage_options' ) ) {
		return false;
	}

	return true;
}

/**
 * Get Admin Panel URL
 */
function puchong_glass_get_admin_url( $page = 'dashboard', $args = array() ) {
	$base_url = add_query_arg( 'puchong-admin', '1', admin_url() );
	$url = add_query_arg( 'page', $page, $base_url );

	if ( ! empty( $args ) ) {
		$url = add_query_arg( $args, $url );
	}

	return $url;
}

/**
 * Check if Current Page is Admin Panel
 */
function puchong_glass_is_admin_panel() {
	global $pagenow;
	return isset( $_GET['puchong-admin'] ) || ( $pagenow === 'admin-ajax.php' && isset( $_POST['action'] ) && strpos( $_POST['action'], 'puchong_' ) === 0 );
}

/**
 * Log Admin Action
 */
function puchong_glass_log_admin_action( $action, $details = array() ) {
	$user = wp_get_current_user();
	$log_entry = array(
		'timestamp' => current_time( 'mysql' ),
		'user_id'   => $user->ID,
		'action'    => $action,
		'details'   => $details,
		'ip_address' => puchong_glass_get_client_ip(),
	);

	// Store in options
	$logs = get_option( 'puchong_admin_logs', array() );
	$logs[] = $log_entry;

	// Keep only last 500 logs
	if ( count( $logs ) > 500 ) {
		$logs = array_slice( $logs, -500 );
	}

	update_option( 'puchong_admin_logs', $logs );
}

/**
 * Get Client IP Address
 */
function puchong_glass_get_client_ip() {
	$ip = 'UNKNOWN';

	if ( ! empty( $_SERVER['HTTP_CF_CONNECTING_IP'] ) ) {
		$ip = sanitize_text_field( $_SERVER['HTTP_CF_CONNECTING_IP'] );
	} elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
		$ip = sanitize_text_field( $_SERVER['HTTP_X_FORWARDED_FOR'] );
	} elseif ( ! empty( $_SERVER['REMOTE_ADDR'] ) ) {
		$ip = sanitize_text_field( $_SERVER['REMOTE_ADDR'] );
	}

	return $ip;
}

// Initialize on theme setup
add_action( 'after_setup_theme', 'puchong_glass_init_auth_system' );
