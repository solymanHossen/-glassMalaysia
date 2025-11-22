<?php
/**
 * Admin Settings Page
 * 
 * @package Puchong_Glass
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Handle form submission
if ( isset( $_POST['submit'] ) && wp_verify_nonce( $_POST['_wpnonce'] ?? '', 'puchong_settings' ) ) {
	update_option( 'puchong_glass_phone', sanitize_text_field( $_POST['phone'] ?? '' ) );
	update_option( 'puchong_glass_email', sanitize_email( $_POST['email'] ?? '' ) );
	update_option( 'puchong_glass_address', sanitize_text_field( $_POST['address'] ?? '' ) );
	update_option( 'puchong_glass_whatsapp', esc_url( $_POST['whatsapp'] ?? '' ) );

	echo '<div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg text-green-800 flex items-center gap-2">';
	echo '<i data-lucide="check-circle" class="w-5 h-5"></i>';
	esc_html_e( 'Settings saved successfully', 'puchong-glass' );
	echo '</div>';
}

$phone = get_option( 'puchong_glass_phone', '+60 12-345 6789' );
$email = get_option( 'puchong_glass_email', 'hello@puchongglass.com' );
$address = get_option( 'puchong_glass_address', 'Puchong, Selangor 58000' );
$whatsapp = get_option( 'puchong_glass_whatsapp', 'https://wa.me/60123456789' );

?>

<div class="fade-in max-w-4xl">
	<!-- Contact Information Settings -->
	<div class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden mb-8">
		<div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
			<h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
				<i data-lucide="phone" class="w-5 h-5 text-blue-600"></i>
				<?php esc_html_e( 'Contact Information', 'puchong-glass' ); ?>
			</h3>
			<p class="text-sm text-gray-600 mt-1"><?php esc_html_e( 'Configure your business contact details displayed across the site', 'puchong-glass' ); ?></p>
		</div>

		<form method="post" class="p-6 space-y-6">
			<?php wp_nonce_field( 'puchong_settings' ); ?>

			<!-- Phone -->
			<div>
				<label class="block text-sm font-medium text-gray-700 mb-2">
					<i data-lucide="phone" class="w-4 h-4 inline mr-1"></i>
					<?php esc_html_e( 'Phone Number', 'puchong-glass' ); ?>
				</label>
				<input 
					type="tel" 
					name="phone" 
					value="<?php echo esc_attr( $phone ); ?>" 
					class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
					placeholder="+60 12-345 6789"
				>
				<p class="text-xs text-gray-500 mt-2"><?php esc_html_e( 'Used for contact links and information', 'puchong-glass' ); ?></p>
			</div>

			<!-- Email -->
			<div>
				<label class="block text-sm font-medium text-gray-700 mb-2">
					<i data-lucide="mail" class="w-4 h-4 inline mr-1"></i>
					<?php esc_html_e( 'Email Address', 'puchong-glass' ); ?>
				</label>
				<input 
					type="email" 
					name="email" 
					value="<?php echo esc_attr( $email ); ?>" 
					class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
					placeholder="hello@puchongglass.com"
				>
				<p class="text-xs text-gray-500 mt-2"><?php esc_html_e( 'Used for contact inquiries and footer', 'puchong-glass' ); ?></p>
			</div>

			<!-- Address -->
			<div>
				<label class="block text-sm font-medium text-gray-700 mb-2">
					<i data-lucide="map-pin" class="w-4 h-4 inline mr-1"></i>
					<?php esc_html_e( 'Business Address', 'puchong-glass' ); ?>
				</label>
				<input 
					type="text" 
					name="address" 
					value="<?php echo esc_attr( $address ); ?>" 
					class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
					placeholder="Puchong, Selangor 58000"
				>
				<p class="text-xs text-gray-500 mt-2"><?php esc_html_e( 'Displayed in footer and contact sections', 'puchong-glass' ); ?></p>
			</div>

			<!-- WhatsApp -->
			<div>
				<label class="block text-sm font-medium text-gray-700 mb-2">
					<i data-lucide="message-circle" class="w-4 h-4 inline mr-1"></i>
					<?php esc_html_e( 'WhatsApp URL', 'puchong-glass' ); ?>
				</label>
				<input 
					type="url" 
					name="whatsapp" 
					value="<?php echo esc_attr( $whatsapp ); ?>" 
					class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
					placeholder="https://wa.me/60123456789"
				>
				<p class="text-xs text-gray-500 mt-2"><?php esc_html_e( 'Direct WhatsApp link for quick messaging (format: https://wa.me/[country_code][number])', 'puchong-glass' ); ?></p>
			</div>

			<div class="border-t border-gray-200 pt-6">
				<button type="submit" name="submit" class="px-6 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all font-medium flex items-center gap-2">
					<i data-lucide="save" class="w-4 h-4"></i>
					<?php esc_html_e( 'Save Settings', 'puchong-glass' ); ?>
				</button>
			</div>
		</form>
	</div>

	<!-- Theme Information -->
	<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
		<!-- Theme Details -->
		<div class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden">
			<div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
				<h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
					<i data-lucide="info" class="w-5 h-5 text-purple-600"></i>
					<?php esc_html_e( 'Theme Information', 'puchong-glass' ); ?>
				</h3>
			</div>

			<div class="p-6 space-y-4 text-sm">
				<div>
					<p class="text-gray-600 font-medium"><?php esc_html_e( 'Theme Name:', 'puchong-glass' ); ?></p>
					<p class="text-gray-900 mt-1"><?php echo esc_html( wp_get_theme()->get( 'Name' ) ); ?></p>
				</div>
				<div>
					<p class="text-gray-600 font-medium"><?php esc_html_e( 'Version:', 'puchong-glass' ); ?></p>
					<p class="text-gray-900 mt-1"><?php echo esc_html( wp_get_theme()->get( 'Version' ) ); ?></p>
				</div>
				<div>
					<p class="text-gray-600 font-medium"><?php esc_html_e( 'Author:', 'puchong-glass' ); ?></p>
					<p class="text-gray-900 mt-1"><?php echo esc_html( wp_get_theme()->get( 'Author' ) ); ?></p>
				</div>
				<div>
					<p class="text-gray-600 font-medium"><?php esc_html_e( 'Description:', 'puchong-glass' ); ?></p>
					<p class="text-gray-900 mt-1"><?php echo esc_html( wp_get_theme()->get( 'Description' ) ); ?></p>
				</div>
			</div>
		</div>

		<!-- System Information -->
		<div class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden">
			<div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
				<h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
					<i data-lucide="server" class="w-5 h-5 text-green-600"></i>
					<?php esc_html_e( 'System Information', 'puchong-glass' ); ?>
				</h3>
			</div>

			<div class="p-6 space-y-4 text-sm">
				<div>
					<p class="text-gray-600 font-medium"><?php esc_html_e( 'WordPress Version:', 'puchong-glass' ); ?></p>
					<p class="text-gray-900 mt-1"><?php echo esc_html( get_bloginfo( 'version' ) ); ?></p>
				</div>
				<div>
					<p class="text-gray-600 font-medium"><?php esc_html_e( 'PHP Version:', 'puchong-glass' ); ?></p>
					<p class="text-gray-900 mt-1"><?php echo esc_html( phpversion() ); ?></p>
				</div>
				<div>
					<p class="text-gray-600 font-medium"><?php esc_html_e( 'MySQL Version:', 'puchong-glass' ); ?></p>
					<p class="text-gray-900 mt-1"><?php echo esc_html( mysqli_get_server_info() ?? 'N/A' ); ?></p>
				</div>
				<div>
					<p class="text-gray-600 font-medium"><?php esc_html_e( 'Site URL:', 'puchong-glass' ); ?></p>
					<p class="text-gray-900 mt-1 truncate"><a href="<?php echo home_url(); ?>" target="_blank" class="text-blue-600 hover:text-blue-800"><?php echo esc_html( home_url() ); ?></a></p>
				</div>
			</div>
		</div>
	</div>

	<!-- Documentation Links -->
	<div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border border-blue-200 p-6 mt-8">
		<h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
			<i data-lucide="book" class="w-5 h-5 text-blue-600"></i>
			<?php esc_html_e( 'Quick Links & Resources', 'puchong-glass' ); ?>
		</h3>

		<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
			<a href="<?php echo admin_url( 'themes.php' ); ?>" class="p-4 bg-white rounded-lg border border-blue-200 hover:shadow-md transition-all flex items-center gap-3">
				<div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center">
					<i data-lucide="palette" class="w-5 h-5 text-blue-600"></i>
				</div>
				<div>
					<p class="font-medium text-gray-900"><?php esc_html_e( 'Customize Theme', 'puchong-glass' ); ?></p>
					<p class="text-xs text-gray-600"><?php esc_html_e( 'Edit theme colors and settings', 'puchong-glass' ); ?></p>
				</div>
			</a>

			<a href="<?php echo admin_url( 'plugins.php' ); ?>" class="p-4 bg-white rounded-lg border border-blue-200 hover:shadow-md transition-all flex items-center gap-3">
				<div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center">
					<i data-lucide="zap" class="w-5 h-5 text-green-600"></i>
				</div>
				<div>
					<p class="font-medium text-gray-900"><?php esc_html_e( 'Manage Plugins', 'puchong-glass' ); ?></p>
					<p class="text-xs text-gray-600"><?php esc_html_e( 'Install and activate plugins', 'puchong-glass' ); ?></p>
				</div>
			</a>

			<a href="<?php echo admin_url( 'options-general.php' ); ?>" class="p-4 bg-white rounded-lg border border-blue-200 hover:shadow-md transition-all flex items-center gap-3">
				<div class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center">
					<i data-lucide="settings" class="w-5 h-5 text-purple-600"></i>
				</div>
				<div>
					<p class="font-medium text-gray-900"><?php esc_html_e( 'General Settings', 'puchong-glass' ); ?></p>
					<p class="text-xs text-gray-600"><?php esc_html_e( 'WordPress general settings', 'puchong-glass' ); ?></p>
				</div>
			</a>

			<a href="<?php echo home_url(); ?>" target="_blank" class="p-4 bg-white rounded-lg border border-blue-200 hover:shadow-md transition-all flex items-center gap-3">
				<div class="w-10 h-10 rounded-lg bg-orange-100 flex items-center justify-center">
					<i data-lucide="external-link" class="w-5 h-5 text-orange-600"></i>
				</div>
				<div>
					<p class="font-medium text-gray-900"><?php esc_html_e( 'View Site', 'puchong-glass' ); ?></p>
					<p class="text-xs text-gray-600"><?php esc_html_e( 'Visit your website', 'puchong-glass' ); ?></p>
				</div>
			</a>
		</div>
	</div>
</div>
