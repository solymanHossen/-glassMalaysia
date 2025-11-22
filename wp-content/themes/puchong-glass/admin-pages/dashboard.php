<?php
/**
 * Admin Dashboard Page
 * 
 * @package Puchong_Glass
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Get statistics
$contact_count = wp_count_posts( 'contact' )->publish ?? 0;
$portfolio_count = wp_count_posts( 'portfolio' )->publish ?? 0;
$service_count = wp_count_posts( 'service' )->publish ?? 0;
$testimonial_count = wp_count_posts( 'testimonial' )->publish ?? 0;
$page_count = wp_count_posts( 'page' )->publish ?? 0;

// Get recent contacts
$recent_contacts = get_posts( array(
	'post_type' => 'contact',
	'posts_per_page' => 8,
	'orderby' => 'date',
	'order' => 'DESC',
) );

?>

<div class="fade-in">
	<!-- Stats Overview -->
	<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
		<!-- Total Contacts -->
		<div class="stat-card p-6">
			<div class="flex items-center justify-between">
				<div>
					<p class="text-sm text-gray-600 font-medium"><?php esc_html_e( 'Total Contacts', 'puchong-glass' ); ?></p>
					<p class="text-3xl font-bold text-gray-900 mt-2"><?php echo intval( $contact_count ); ?></p>
				</div>
				<div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center">
					<i data-lucide="mail" class="w-6 h-6 text-blue-600"></i>
				</div>
			</div>
		</div>

		<!-- Portfolio Items -->
		<div class="stat-card p-6">
			<div class="flex items-center justify-between">
				<div>
					<p class="text-sm text-gray-600 font-medium"><?php esc_html_e( 'Projects', 'puchong-glass' ); ?></p>
					<p class="text-3xl font-bold text-gray-900 mt-2"><?php echo intval( $portfolio_count ); ?></p>
				</div>
				<div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center">
					<i data-lucide="images" class="w-6 h-6 text-green-600"></i>
				</div>
			</div>
		</div>

		<!-- Services -->
		<div class="stat-card p-6">
			<div class="flex items-center justify-between">
				<div>
					<p class="text-sm text-gray-600 font-medium"><?php esc_html_e( 'Services', 'puchong-glass' ); ?></p>
					<p class="text-3xl font-bold text-gray-900 mt-2"><?php echo intval( $service_count ); ?></p>
				</div>
				<div class="w-12 h-12 rounded-lg bg-purple-100 flex items-center justify-center">
					<i data-lucide="briefcase" class="w-6 h-6 text-purple-600"></i>
				</div>
			</div>
		</div>

		<!-- Testimonials -->
		<div class="stat-card p-6">
			<div class="flex items-center justify-between">
				<div>
					<p class="text-sm text-gray-600 font-medium"><?php esc_html_e( 'Testimonials', 'puchong-glass' ); ?></p>
					<p class="text-3xl font-bold text-gray-900 mt-2"><?php echo intval( $testimonial_count ); ?></p>
				</div>
				<div class="w-12 h-12 rounded-lg bg-yellow-100 flex items-center justify-center">
					<i data-lucide="star" class="w-6 h-6 text-yellow-600"></i>
				</div>
			</div>
		</div>

		<!-- Pages -->
		<div class="stat-card p-6">
			<div class="flex items-center justify-between">
				<div>
					<p class="text-sm text-gray-600 font-medium"><?php esc_html_e( 'Pages', 'puchong-glass' ); ?></p>
					<p class="text-3xl font-bold text-gray-900 mt-2"><?php echo intval( $page_count ); ?></p>
				</div>
				<div class="w-12 h-12 rounded-lg bg-orange-100 flex items-center justify-center">
					<i data-lucide="file-text" class="w-6 h-6 text-orange-600"></i>
				</div>
			</div>
		</div>
	</div>

	<!-- Recent Activities -->
	<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
		<!-- Recent Contacts -->
		<div class="lg:col-span-2">
			<div class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden">
				<div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
					<h3 class="text-lg font-semibold text-gray-900"><?php esc_html_e( 'Recent Contact Submissions', 'puchong-glass' ); ?></h3>
					<a href="?page=contacts" class="text-blue-600 text-sm font-medium hover:text-blue-800">
						<?php esc_html_e( 'View All', 'puchong-glass' ); ?>
					</a>
				</div>

				<?php if ( ! empty( $recent_contacts ) ) : ?>
					<div class="overflow-x-auto">
						<table class="w-full">
							<thead class="bg-gray-50 border-b border-gray-200">
								<tr>
									<th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase"><?php esc_html_e( 'Name', 'puchong-glass' ); ?></th>
									<th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase"><?php esc_html_e( 'Email', 'puchong-glass' ); ?></th>
									<th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase"><?php esc_html_e( 'Phone', 'puchong-glass' ); ?></th>
									<th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase"><?php esc_html_e( 'Date', 'puchong-glass' ); ?></th>
									<th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase"><?php esc_html_e( 'Action', 'puchong-glass' ); ?></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ( $recent_contacts as $contact ) :
									$name = get_post_meta( $contact->ID, 'contact_name', true );
									$email = get_post_meta( $contact->ID, 'contact_email', true );
									$phone = get_post_meta( $contact->ID, 'contact_phone', true );
									?>
									<tr class="table-row-hover border-b border-gray-200">
										<td class="px-6 py-4 text-sm text-gray-900 font-medium"><?php echo esc_html( $name ); ?></td>
										<td class="px-6 py-4 text-sm text-gray-600"><?php echo esc_html( $email ); ?></td>
										<td class="px-6 py-4 text-sm text-gray-600">
											<a href="tel:<?php echo esc_attr( $phone ); ?>" class="text-blue-600 hover:text-blue-800">
												<?php echo esc_html( $phone ); ?>
											</a>
										</td>
										<td class="px-6 py-4 text-sm text-gray-600">
											<?php echo esc_html( date_i18n( 'M j, Y', strtotime( $contact->post_date ) ) ); ?>
										</td>
										<td class="px-6 py-4 text-sm">
											<a href="<?php echo admin_url( "post.php?post={$contact->ID}&action=edit" ); ?>" class="text-blue-600 hover:text-blue-800 font-medium">
												<?php esc_html_e( 'View', 'puchong-glass' ); ?>
											</a>
										</td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				<?php else : ?>
					<div class="px-6 py-12 text-center">
						<i data-lucide="inbox" class="w-12 h-12 text-gray-300 mx-auto mb-4"></i>
						<p class="text-gray-600"><?php esc_html_e( 'No contacts yet', 'puchong-glass' ); ?></p>
					</div>
				<?php endif; ?>
			</div>
		</div>

		<!-- Quick Actions -->
		<div>
			<div class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden">
				<div class="px-6 py-4 border-b border-gray-200">
					<h3 class="text-lg font-semibold text-gray-900"><?php esc_html_e( 'Quick Actions', 'puchong-glass' ); ?></h3>
				</div>

				<div class="p-6 space-y-3">
					<a href="<?php echo admin_url( 'post-new.php?post_type=portfolio' ); ?>" class="block px-4 py-3 bg-blue-50 text-blue-700 rounded-lg font-medium hover:bg-blue-100 transition-all text-center">
						<i data-lucide="plus" class="w-4 h-4 inline mr-2"></i>
						<?php esc_html_e( 'Add Project', 'puchong-glass' ); ?>
					</a>

					<a href="<?php echo admin_url( 'post-new.php?post_type=service' ); ?>" class="block px-4 py-3 bg-green-50 text-green-700 rounded-lg font-medium hover:bg-green-100 transition-all text-center">
						<i data-lucide="plus" class="w-4 h-4 inline mr-2"></i>
						<?php esc_html_e( 'Add Service', 'puchong-glass' ); ?>
					</a>

					<a href="<?php echo admin_url( 'post-new.php?post_type=testimonial' ); ?>" class="block px-4 py-3 bg-purple-50 text-purple-700 rounded-lg font-medium hover:bg-purple-100 transition-all text-center">
						<i data-lucide="plus" class="w-4 h-4 inline mr-2"></i>
						<?php esc_html_e( 'Add Testimonial', 'puchong-glass' ); ?>
					</a>

					<a href="<?php echo admin_url( 'options-general.php' ); ?>" class="block px-4 py-3 bg-gray-50 text-gray-700 rounded-lg font-medium hover:bg-gray-100 transition-all text-center">
						<i data-lucide="settings" class="w-4 h-4 inline mr-2"></i>
						<?php esc_html_e( 'Settings', 'puchong-glass' ); ?>
					</a>

					<a href="<?php echo home_url(); ?>" class="block px-4 py-3 bg-orange-50 text-orange-700 rounded-lg font-medium hover:bg-orange-100 transition-all text-center">
						<i data-lucide="external-link" class="w-4 h-4 inline mr-2"></i>
						<?php esc_html_e( 'View Site', 'puchong-glass' ); ?>
					</a>
				</div>
			</div>

			<!-- System Info -->
			<div class="bg-white rounded-lg shadow-md border border-gray-200 mt-6 overflow-hidden">
				<div class="px-6 py-4 border-b border-gray-200">
					<h3 class="text-lg font-semibold text-gray-900"><?php esc_html_e( 'System Info', 'puchong-glass' ); ?></h3>
				</div>

				<div class="px-6 py-4 space-y-3 text-sm">
					<div class="flex justify-between">
						<span class="text-gray-600"><?php esc_html_e( 'Site:', 'puchong-glass' ); ?></span>
						<span class="font-medium text-gray-900"><?php bloginfo( 'name' ); ?></span>
					</div>
					<div class="flex justify-between">
						<span class="text-gray-600"><?php esc_html_e( 'WordPress:', 'puchong-glass' ); ?></span>
						<span class="font-medium text-gray-900"><?php echo esc_html( get_bloginfo( 'version' ) ); ?></span>
					</div>
					<div class="flex justify-between">
						<span class="text-gray-600"><?php esc_html_e( 'Theme:', 'puchong-glass' ); ?></span>
						<span class="font-medium text-gray-900"><?php echo esc_html( wp_get_theme()->get( 'Name' ) ); ?></span>
					</div>
					<div class="flex justify-between">
						<span class="text-gray-600"><?php esc_html_e( 'PHP:', 'puchong-glass' ); ?></span>
						<span class="font-medium text-gray-900"><?php echo esc_html( phpversion() ); ?></span>
					</div>
					<div class="flex justify-between">
						<span class="text-gray-600"><?php esc_html_e( 'URL:', 'puchong-glass' ); ?></span>
						<span class="font-medium text-gray-900 text-xs truncate"><?php echo esc_html( home_url() ); ?></span>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
