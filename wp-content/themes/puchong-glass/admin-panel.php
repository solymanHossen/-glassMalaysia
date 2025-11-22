<?php
/**
 * Modern Admin Panel with Authentication System
 * 
 * @package Puchong_Glass
 * @version 3.0.0
 * @author Puchong Glass Team
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Security: Check if user is logged in
if ( ! is_user_logged_in() ) {
	wp_die( wp_kses_post( '<div style="padding: 50px; text-align: center;"><h2>Access Denied</h2><p>You must be logged in to access the admin panel.</p><a href="' . wp_login_url() . '">Login</a></div>' ) );
}

// Security: Check admin capability
if ( ! current_user_can( 'manage_options' ) ) {
	wp_die( esc_html__( 'Access Denied - Admin privileges required', 'puchong-glass' ) );
}

// Get current page
$current_page = isset( $_GET['page'] ) ? sanitize_text_field( $_GET['page'] ) : 'dashboard';

// Get current user
$current_user = wp_get_current_user();

// Get statistics
$contact_count = wp_count_posts( 'contact' )->publish ?? 0;
$portfolio_count = wp_count_posts( 'portfolio' )->publish ?? 0;
$service_count = wp_count_posts( 'service' )->publish ?? 0;
$testimonial_count = wp_count_posts( 'testimonial' )->publish ?? 0;

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php esc_html_e( 'Admin Panel - Puchong Glass', 'puchong-glass' ); ?></title>
	<script src="https://cdn.tailwindcss.com"></script>
	<script src="https://unpkg.com/lucide@latest"></script>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
	
	<style>
		:root {
			--color-primary: #3b82f6;
			--color-primary-dark: #1e40af;
			--color-primary-light: #60a5fa;
			--color-secondary: #8b5cf6;
			--color-accent: #06b6d4;
			--color-success: #10b981;
			--color-warning: #f59e0b;
			--color-danger: #ef4444;
			--color-dark: #1f2937;
			--color-light: #f9fafb;
			--color-gray: #6b7280;
		}

		* {
			margin: 0;
			padding: 0;
			box-sizing: border-box;
		}

		html {
			scroll-behavior: smooth;
		}

		body {
			font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
			background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #334155 100%);
			min-height: 100vh;
			overflow-x: hidden;
			color: var(--color-dark);
		}

		/* ========== AUTHENTICATION SCREEN ========== */
		.auth-wrapper {
			position: fixed;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
			display: flex;
			align-items: center;
			justify-content: center;
			z-index: 9999;
			animation: gradientShift 15s ease infinite;
		}

		@keyframes gradientShift {
			0%, 100% { background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%); }
			50% { background: linear-gradient(135deg, #f093fb 0%, #667eea 50%, #764ba2 100%); }
		}

		.auth-container {
			background: rgba(255, 255, 255, 0.95);
			backdrop-filter: blur(20px);
			-webkit-backdrop-filter: blur(20px);
			border-radius: 24px;
			box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3), inset 0 1px 1px rgba(255, 255, 255, 0.6);
			padding: 48px;
			width: 100%;
			max-width: 480px;
			animation: slideUpAuth 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
			border: 1px solid rgba(255, 255, 255, 0.5);
		}

		@keyframes slideUpAuth {
			from {
				opacity: 0;
				transform: translateY(40px);
			}
			to {
				opacity: 1;
				transform: translateY(0);
			}
		}

		.auth-header {
			text-align: center;
			margin-bottom: 36px;
		}

		.auth-logo {
			width: 70px;
			height: 70px;
			margin: 0 auto 24px;
			background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary) 100%);
			border-radius: 18px;
			display: flex;
			align-items: center;
			justify-content: center;
			color: white;
			font-weight: 800;
			font-size: 32px;
			box-shadow: 0 12px 30px rgba(59, 130, 246, 0.4);
			position: relative;
			overflow: hidden;
		}

		.auth-logo::before {
			content: '';
			position: absolute;
			top: -50%;
			left: -50%;
			width: 200%;
			height: 200%;
			background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
			animation: shimmer 3s infinite;
		}

		@keyframes shimmer {
			0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
			100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
		}

		.auth-title {
			font-size: 32px;
			font-weight: 800;
			background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary) 100%);
			-webkit-background-clip: text;
			-webkit-text-fill-color: transparent;
			background-clip: text;
			margin-bottom: 8px;
			font-family: 'Playfair Display', serif;
		}

		.auth-subtitle {
			font-size: 15px;
			color: #9ca3af;
			font-weight: 500;
		}

		.auth-form {
			display: flex;
			flex-direction: column;
			gap: 20px;
		}

		.form-group {
			display: flex;
			flex-direction: column;
			gap: 10px;
		}

		.form-label {
			font-size: 13px;
			font-weight: 700;
			color: var(--color-dark);
			text-transform: uppercase;
			letter-spacing: 0.5px;
		}

		.form-input {
			padding: 14px 18px;
			border: 2px solid #e5e7eb;
			border-radius: 12px;
			font-size: 15px;
			transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
			background: white;
			font-family: 'Inter', sans-serif;
		}

		.form-input::placeholder {
			color: #d1d5db;
		}

		.form-input:focus {
			outline: none;
			border-color: var(--color-primary);
			box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1), inset 0 0 0 2px rgba(59, 130, 246, 0.05);
			background: #f0f9ff;
		}

		.auth-button {
			padding: 14px 18px;
			background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary) 100%);
			color: white;
			border: none;
			border-radius: 12px;
			font-weight: 700;
			cursor: pointer;
			transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
			margin-top: 12px;
			font-size: 15px;
			text-transform: uppercase;
			letter-spacing: 0.5px;
			box-shadow: 0 8px 16px rgba(59, 130, 246, 0.3);
			position: relative;
			overflow: hidden;
		}

		.auth-button:hover {
			transform: translateY(-2px);
			box-shadow: 0 12px 24px rgba(59, 130, 246, 0.4);
		}

		.auth-button:active {
			transform: translateY(0);
		}

		/* ========== MAIN INTERFACE ========== */
		.admin-layout {
			display: grid;
			grid-template-columns: 280px 1fr;
			grid-template-rows: auto 1fr;
			min-height: 100vh;
			gap: 0;
		}

		/* Sidebar */
		.glass-sidebar {
			grid-column: 1;
			grid-row: 1 / 3;
			background: linear-gradient(180deg, rgba(255, 255, 255, 0.88) 0%, rgba(248, 250, 252, 0.85) 100%);
			backdrop-filter: blur(25px);
			-webkit-backdrop-filter: blur(25px);
			border-right: 1px solid rgba(255, 255, 255, 0.6);
			box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
			overflow-y: auto;
			z-index: 40;
			padding: 24px 0;
		}

		.sidebar-content {
			padding: 0 16px;
		}

		.sidebar-header {
			padding: 0 16px 24px;
			margin-bottom: 24px;
			border-bottom: 1px solid rgba(0, 0, 0, 0.05);
		}

		.sidebar-brand {
			display: flex;
			align-items: center;
			gap: 12px;
			text-decoration: none;
		}

		.brand-logo {
			width: 44px;
			height: 44px;
			background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary) 100%);
			border-radius: 12px;
			display: flex;
			align-items: center;
			justify-content: center;
			color: white;
			font-weight: 700;
			font-size: 20px;
		}

		.brand-text {
			flex: 1;
		}

		.brand-name {
			font-size: 14px;
			font-weight: 700;
			color: var(--color-dark);
			display: block;
		}

		.brand-version {
			font-size: 11px;
			color: #9ca3af;
		}

		.nav-section {
			margin-bottom: 32px;
		}

		.nav-section-title {
			font-size: 11px;
			font-weight: 800;
			color: #9ca3af;
			text-transform: uppercase;
			letter-spacing: 1px;
			padding: 0 16px;
			margin-bottom: 12px;
		}

		.nav-link {
			display: flex;
			align-items: center;
			gap: 12px;
			padding: 12px 16px;
			margin: 4px 0;
			border-radius: 12px;
			transition: all 0.3s ease;
			color: #6b7280;
			text-decoration: none;
			font-weight: 500;
			font-size: 14px;
			position: relative;
		}

		.nav-link:hover {
			background: linear-gradient(135deg, rgba(59, 130, 246, 0.08) 0%, rgba(139, 92, 246, 0.08) 100%);
			color: var(--color-primary);
			transform: translateX(4px);
		}

		.nav-link.active {
			background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary) 100%);
			color: white;
			box-shadow: 0 8px 16px rgba(59, 130, 246, 0.25);
		}

		.nav-link.active::before {
			content: '';
			position: absolute;
			left: 0;
			top: 0;
			bottom: 0;
			width: 4px;
			background: white;
			border-radius: 0 4px 4px 0;
		}

		/* Header */
		.admin-header {
			grid-column: 2;
			grid-row: 1;
			background: linear-gradient(90deg, rgba(255, 255, 255, 0.9) 0%, rgba(248, 250, 252, 0.85) 100%);
			backdrop-filter: blur(20px);
			border-bottom: 1px solid rgba(255, 255, 255, 0.4);
			box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
			display: flex;
			align-items: center;
			justify-content: space-between;
			padding: 20px 32px;
			z-index: 30;
		}

		.header-left {
			flex: 1;
		}

		.page-title {
			font-size: 28px;
			font-weight: 800;
			color: var(--color-dark);
			margin-bottom: 4px;
			font-family: 'Playfair Display', serif;
		}

		.page-breadcrumb {
			font-size: 12px;
			color: #9ca3af;
			text-transform: uppercase;
			letter-spacing: 0.5px;
		}

		.header-right {
			display: flex;
			align-items: center;
			gap: 20px;
		}

		.user-info {
			display: flex;
			align-items: center;
			gap: 12px;
			padding: 8px 12px;
			background: rgba(59, 130, 246, 0.05);
			border-radius: 12px;
		}

		.user-avatar {
			width: 40px;
			height: 40px;
			border-radius: 10px;
			background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary) 100%);
			display: flex;
			align-items: center;
			justify-content: center;
			color: white;
			font-weight: 700;
			font-size: 16px;
		}

		.user-meta {
			display: flex;
			flex-direction: column;
			gap: 2px;
		}

		.user-name {
			font-size: 13px;
			font-weight: 700;
			color: var(--color-dark);
		}

		.user-role {
			font-size: 11px;
			color: #9ca3af;
		}

		.header-action {
			padding: 10px 20px;
			background: linear-gradient(135deg, var(--color-danger) 0%, #dc2626 100%);
			color: white;
			border: none;
			border-radius: 10px;
			cursor: pointer;
			font-weight: 600;
			transition: all 0.3s ease;
			font-size: 13px;
			text-transform: uppercase;
			letter-spacing: 0.5px;
		}

		.header-action:hover {
			transform: translateY(-2px);
			box-shadow: 0 8px 16px rgba(239, 68, 68, 0.3);
		}

		/* Main Content */
		.admin-content {
			grid-column: 2;
			grid-row: 2;
			padding: 32px;
			overflow-y: auto;
			background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
		}

		/* Stats Grid */
		.stats-grid {
			display: grid;
			grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
			gap: 24px;
			margin-bottom: 32px;
		}

		.stat-card {
			background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(248, 250, 252, 0.9) 100%);
			backdrop-filter: blur(10px);
			border: 1px solid rgba(255, 255, 255, 0.6);
			border-radius: 18px;
			padding: 28px;
			transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
			position: relative;
			overflow: hidden;
			box-shadow: 0 8px 16px rgba(0, 0, 0, 0.06);
		}

		.stat-card::before {
			content: '';
			position: absolute;
			top: -50%;
			right: -50%;
			width: 250px;
			height: 250px;
			background: radial-gradient(circle, rgba(59, 130, 246, 0.12) 0%, transparent 70%);
			border-radius: 50%;
		}

		.stat-card::after {
			content: '';
			position: absolute;
			top: 0;
			left: 0;
			right: 0;
			bottom: 0;
			background: linear-gradient(135deg, transparent 0%, rgba(255, 255, 255, 0.4) 100%);
			pointer-events: none;
		}

		.stat-card:hover {
			transform: translateY(-12px);
			box-shadow: 0 20px 40px rgba(59, 130, 246, 0.15);
			border-color: rgba(59, 130, 246, 0.3);
		}

		.stat-icon {
			width: 56px;
			height: 56px;
			border-radius: 14px;
			display: flex;
			align-items: center;
			justify-content: center;
			font-size: 28px;
			margin-bottom: 16px;
			box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
			position: relative;
			z-index: 1;
		}

		.stat-card:nth-child(1) .stat-icon {
			background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
			color: white;
		}

		.stat-card:nth-child(2) .stat-icon {
			background: linear-gradient(135deg, #34d399 0%, #10b981 100%);
			color: white;
		}

		.stat-card:nth-child(3) .stat-icon {
			background: linear-gradient(135deg, #818cf8 0%, #6366f1 100%);
			color: white;
		}

		.stat-card:nth-child(4) .stat-icon {
			background: linear-gradient(135deg, #f472b6 0%, #ec4899 100%);
			color: white;
		}

		.stat-card:nth-child(5) .stat-icon {
			background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
			color: white;
		}

		.stat-label {
			font-size: 13px;
			color: #9ca3af;
			font-weight: 600;
			text-transform: uppercase;
			letter-spacing: 0.5px;
			margin-bottom: 8px;
			position: relative;
			z-index: 1;
		}

		.stat-value {
			font-size: 32px;
			font-weight: 800;
			color: var(--color-dark);
			position: relative;
			z-index: 1;
		}

		.stat-change {
			font-size: 12px;
			margin-top: 12px;
			position: relative;
			z-index: 1;
		}

		.stat-change.positive {
			color: var(--color-success);
		}

		.stat-change.negative {
			color: var(--color-danger);
		}

		/* Cards */
		.card {
			background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(248, 250, 252, 0.9) 100%);
			backdrop-filter: blur(10px);
			border: 1px solid rgba(255, 255, 255, 0.6);
			border-radius: 18px;
			padding: 28px;
			box-shadow: 0 8px 16px rgba(0, 0, 0, 0.06);
			margin-bottom: 24px;
			transition: all 0.3s ease;
		}

		.card-header {
			display: flex;
			align-items: center;
			justify-content: space-between;
			margin-bottom: 24px;
			padding-bottom: 16px;
			border-bottom: 2px solid rgba(59, 130, 246, 0.1);
		}

		.card-title {
			font-size: 20px;
			font-weight: 700;
			color: var(--color-dark);
		}

		.card-action {
			padding: 8px 16px;
			background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary) 100%);
			color: white;
			border: none;
			border-radius: 8px;
			cursor: pointer;
			font-weight: 600;
			transition: all 0.3s ease;
			font-size: 12px;
		}

		/* Table */
		.data-table {
			width: 100%;
			border-collapse: collapse;
		}

		.data-table thead {
			background: rgba(59, 130, 246, 0.05);
		}

		.data-table th {
			padding: 16px;
			text-align: left;
			font-weight: 700;
			color: var(--color-dark);
			font-size: 12px;
			text-transform: uppercase;
			letter-spacing: 0.5px;
			border-bottom: 2px solid rgba(59, 130, 246, 0.1);
		}

		.data-table td {
			padding: 16px;
			border-bottom: 1px solid rgba(0, 0, 0, 0.05);
		}

		.data-table tbody tr {
			transition: all 0.3s ease;
		}

		.data-table tbody tr:hover {
			background: linear-gradient(90deg, rgba(59, 130, 246, 0.08) 0%, rgba(139, 92, 246, 0.08) 100%);
		}

		/* Badge */
		.badge {
			display: inline-block;
			padding: 6px 14px;
			border-radius: 20px;
			font-size: 11px;
			font-weight: 700;
			text-transform: uppercase;
			letter-spacing: 0.5px;
		}

		.badge-success {
			background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
			color: #065f46;
		}

		.badge-warning {
			background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
			color: #92400e;
		}

		.badge-danger {
			background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
			color: #7f1d1d;
		}

		.badge-info {
			background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
			color: #0c4a6e;
		}

		/* Button */
		.btn {
			padding: 12px 24px;
			border-radius: 10px;
			border: none;
			font-weight: 700;
			cursor: pointer;
			transition: all 0.3s ease;
			display: inline-flex;
			align-items: center;
			gap: 8px;
			font-size: 13px;
			text-transform: uppercase;
			letter-spacing: 0.5px;
		}

		.btn-primary {
			background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary) 100%);
			color: white;
			box-shadow: 0 8px 16px rgba(59, 130, 246, 0.3);
		}

		.btn-primary:hover {
			transform: translateY(-2px);
			box-shadow: 0 12px 24px rgba(59, 130, 246, 0.4);
		}

		.btn-danger {
			background: linear-gradient(135deg, var(--color-danger) 0%, #dc2626 100%);
			color: white;
		}

		.btn-danger:hover {
			transform: translateY(-2px);
			box-shadow: 0 8px 16px rgba(239, 68, 68, 0.3);
		}

		/* Animations */
		.fade-in {
			animation: fadeIn 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
		}

		@keyframes fadeIn {
			from {
				opacity: 0;
				transform: translateY(20px);
			}
			to {
				opacity: 1;
				transform: translateY(0);
			}
		}

		/* Scrollbar */
		::-webkit-scrollbar {
			width: 10px;
		}

		::-webkit-scrollbar-track {
			background: transparent;
		}

		::-webkit-scrollbar-thumb {
			background: linear-gradient(180deg, var(--color-primary) 0%, var(--color-secondary) 100%);
			border-radius: 5px;
		}

		::-webkit-scrollbar-thumb:hover {
			background: linear-gradient(180deg, var(--color-primary-dark) 0%, var(--color-secondary) 100%);
		}

		/* Dark Mode */
		@media (prefers-color-scheme: dark) {
			body {
				background: linear-gradient(135deg, #0f172a 0%, #1a1f2e 100%);
				color: #e5e7eb;
			}

			.glass-sidebar {
				background: linear-gradient(180deg, rgba(31, 41, 55, 0.8) 0%, rgba(17, 24, 39, 0.8) 100%);
				border-right-color: rgba(255, 255, 255, 0.1);
			}

			.admin-header {
				background: linear-gradient(90deg, rgba(31, 41, 55, 0.8) 0%, rgba(17, 24, 39, 0.8) 100%);
				border-bottom-color: rgba(255, 255, 255, 0.1);
			}

			.stat-card, .card {
				background: linear-gradient(135deg, rgba(31, 41, 55, 0.8) 0%, rgba(17, 24, 39, 0.8) 100%);
				border-color: rgba(255, 255, 255, 0.1);
			}

			.nav-link {
				color: #9ca3af;
			}

			.page-title, .card-title, .stat-label {
				color: #f9fafb;
			}

			.data-table tbody tr:hover {
				background: rgba(59, 130, 246, 0.1);
			}
		}

		/* Responsive */
		@media (max-width: 768px) {
			.admin-layout {
				grid-template-columns: 1fr;
				grid-template-rows: auto auto 1fr;
			}

			.glass-sidebar {
				grid-column: 1;
				grid-row: 2;
				height: auto;
				border-right: none;
				border-bottom: 1px solid rgba(255, 255, 255, 0.3);
				padding: 12px 0;
			}

			.admin-header {
				grid-column: 1;
				grid-row: 1;
				flex-direction: column;
				align-items: flex-start;
				gap: 12px;
			}

			.admin-content {
				grid-column: 1;
				grid-row: 3;
				padding: 20px;
			}

			.stats-grid {
				grid-template-columns: 1fr;
			}

			.header-right {
				width: 100%;
				flex-direction: column;
			}

			.auth-container {
				margin: 20px;
				padding: 30px;
			}
		}
	</style>
</head>
<body>
	<div class="admin-layout">
		<!-- Sidebar -->
		<aside class="glass-sidebar">
			<div class="sidebar-content">
				<div class="sidebar-header">
					<a href="?puchong-admin=1" class="sidebar-brand">
						<div class="brand-logo">🔷</div>
						<div class="brand-text">
							<span class="brand-name">Puchong</span>
							<span class="brand-version">v3.0</span>
						</div>
					</a>
				</div>

				<!-- Main Navigation -->
				<div class="nav-section">
					<div class="nav-section-title">Menu</div>
					<a href="?puchong-admin=1&page=dashboard" class="nav-link <?php echo ( 'dashboard' === $current_page ) ? 'active' : ''; ?>">
						<span>📊</span> Dashboard
					</a>
					<a href="?puchong-admin=1&page=contacts" class="nav-link <?php echo ( 'contacts' === $current_page ) ? 'active' : ''; ?>">
						<span>👥</span> Contacts
					</a>
					<a href="?puchong-admin=1&page=settings" class="nav-link <?php echo ( 'settings' === $current_page ) ? 'active' : ''; ?>">
						<span>⚙️</span> Settings
					</a>
				</div>

				<!-- Management -->
				<div class="nav-section">
					<div class="nav-section-title">Management</div>
					<a href="<?php echo admin_url( 'edit.php?post_type=portfolio' ); ?>" class="nav-link">
						<span>🎨</span> Portfolio
					</a>
					<a href="<?php echo admin_url( 'edit.php?post_type=service' ); ?>" class="nav-link">
						<span>⭐</span> Services
					</a>
					<a href="<?php echo admin_url( 'users.php' ); ?>" class="nav-link">
						<span>👤</span> Users
					</a>
				</div>
			</div>
		</aside>

		<!-- Header -->
		<header class="admin-header">
			<div class="header-left">
				<h1 class="page-title">
					<?php
					echo match ( $current_page ) {
						'dashboard' => esc_html__( 'Dashboard', 'puchong-glass' ),
						'contacts' => esc_html__( 'Contact Submissions', 'puchong-glass' ),
						'settings' => esc_html__( 'Settings', 'puchong-glass' ),
						default => esc_html__( 'Dashboard', 'puchong-glass' ),
					};
					?>
				</h1>
				<p class="page-breadcrumb">
					<?php
					echo match ( $current_page ) {
						'dashboard' => 'Home / Dashboard',
						'contacts' => 'Home / Contacts',
						'settings' => 'Home / Settings',
						default => 'Home',
					};
					?>
				</p>
			</div>

			<div class="header-right">
				<div class="user-info">
					<div class="user-avatar"><?php echo strtoupper( substr( $current_user->display_name, 0, 1 ) ); ?></div>
					<div class="user-meta">
						<div class="user-name"><?php echo esc_html( $current_user->display_name ); ?></div>
						<div class="user-role">Administrator</div>
					</div>
				</div>
				<a href="<?php echo wp_logout_url( home_url() ); ?>" class="header-action">Logout</a>
			</div>
		</header>

		<!-- Main Content -->
		<main class="admin-content fade-in">
			<?php
			// Load page content
			switch ( $current_page ) {
				case 'dashboard':
					include PUCHONG_GLASS_DIR . '/admin-pages/dashboard.php';
					break;
				case 'contacts':
					include PUCHONG_GLASS_DIR . '/admin-pages/contacts.php';
					break;
				case 'settings':
					include PUCHONG_GLASS_DIR . '/admin-pages/settings.php';
					break;
				default:
					include PUCHONG_GLASS_DIR . '/admin-pages/dashboard.php';
			}
			?>
		</main>
	</div>

	<script>
		// Lucide Icons Init
		if (window.lucide) {
			lucide.createIcons();
		}

		// Admin Panel Interactions
		document.addEventListener('DOMContentLoaded', function() {
			// Confirm Deletion
			const deleteButtons = document.querySelectorAll('[data-action="delete"]');
			deleteButtons.forEach(button => {
				button.addEventListener('click', function(e) {
					if (!confirm('<?php esc_attr_e( 'Are you sure you want to delete this item?', 'puchong-glass' ); ?>')) {
						e.preventDefault();
					}
				});
			});

			// Smooth Scroll
			document.querySelectorAll('a[href^="#"]').forEach(anchor => {
				anchor.addEventListener('click', function(e) {
					e.preventDefault();
					const target = document.querySelector(this.getAttribute('href'));
					if (target) {
						target.scrollIntoView({ behavior: 'smooth' });
					}
				});
			});
		});

		// Export to CSV
		function exportToCSV() {
			const table = document.querySelector('.data-table');
			if (!table) return;

			let csv = [];
			table.querySelectorAll('tr').forEach(row => {
				let cols = row.querySelectorAll('td, th');
				let csvRow = [];
				cols.forEach(col => {
					csvRow.push('"' + col.innerText.replace(/"/g, '""') + '"');
				});
				csv.push(csvRow.join(','));
			});

			const csvContent = 'data:text/csv;charset=utf-8,' + encodeURIComponent(csv.join('\n'));
			const link = document.createElement('a');
			link.setAttribute('href', csvContent);
			link.setAttribute('download', 'export_' + new Date().getTime() + '.csv');
			link.click();
		}

		// Toast Notification
		function showNotification(message, type = 'success') {
			const toast = document.createElement('div');
			toast.className = `toast toast-${type}`;
			toast.innerHTML = `
				<div class="toast-content">
					<span>${message}</span>
				</div>
			`;
			document.body.appendChild(toast);
			setTimeout(() => toast.remove(), 3000);
		}
	</script>

	<?php wp_footer(); ?>
</body>
</html>
