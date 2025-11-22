<?php
/**
 * Admin Contact List Page
 * 
 * @package Puchong_Glass
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Handle contact actions
if ( isset( $_POST['action'] ) && isset( $_POST['contact_id'] ) && wp_verify_nonce( $_POST['_wpnonce'] ?? '', 'contact_action' ) ) {
	$contact_id = intval( $_POST['contact_id'] );
	$action = sanitize_text_field( $_POST['action'] );

	if ( $action === 'delete' ) {
		wp_delete_post( $contact_id, true );
		echo '<div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg text-green-800">';
		esc_html_e( 'Contact deleted successfully', 'puchong-glass' );
		echo '</div>';
	}
}

// Get filters
$current_page = isset( $_GET['paged'] ) ? max( 1, intval( $_GET['paged'] ) ) : 1;
$per_page = 20;
$offset = ( $current_page - 1 ) * $per_page;

$search = isset( $_GET['s'] ) ? sanitize_text_field( $_GET['s'] ) : '';

// Query contacts
$args = array(
	'post_type' => 'contact',
	'posts_per_page' => $per_page,
	'paged' => $current_page,
	'orderby' => 'date',
	'order' => 'DESC',
);

if ( ! empty( $search ) ) {
	$args['s'] = $search;
}

$contacts_query = new WP_Query( $args );
$contacts = $contacts_query->posts;
$total_contacts = $contacts_query->found_posts;

// Export functionality
if ( isset( $_GET['action'] ) && $_GET['action'] === 'export' && current_user_can( 'manage_options' ) ) {
	header( 'Content-Type: text/csv; charset=utf-8' );
	header( 'Content-Disposition: attachment; filename=contacts-' . date( 'Y-m-d-H-i-s' ) . '.csv' );

	$output = fopen( 'php://output', 'w' );
	fprintf( $output, chr( 0xEF ) . chr( 0xBB ) . chr( 0xBF ) );

	// Headers
	fputcsv( $output, array( 'Name', 'Email', 'Phone', 'Service', 'Message', 'Date', 'IP Address' ) );

	// Data
	$all_contacts = new WP_Query( array(
		'post_type' => 'contact',
		'posts_per_page' => -1,
		'orderby' => 'date',
		'order' => 'DESC',
	) );

	foreach ( $all_contacts->posts as $contact ) {
		fputcsv( $output, array(
			get_post_meta( $contact->ID, 'contact_name', true ),
			get_post_meta( $contact->ID, 'contact_email', true ),
			get_post_meta( $contact->ID, 'contact_phone', true ),
			get_post_meta( $contact->ID, 'contact_service', true ),
			get_post_meta( $contact->ID, 'contact_message', true ),
			$contact->post_date,
			get_post_meta( $contact->ID, 'contact_ip', true ),
		) );
	}

	fclose( $output );
	exit;
}

?>

<div class="fade-in">
	<!-- Search and Controls -->
	<div class="bg-white rounded-lg shadow-md border border-gray-200 p-6 mb-6">
		<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
			<div class="md:col-span-2">
				<form method="get" class="flex gap-2">
					<input type="hidden" name="page" value="contacts">
					<input 
						type="text" 
						name="s" 
						placeholder="<?php esc_attr_e( 'Search by name, email, or phone...', 'puchong-glass' ); ?>" 
						value="<?php echo esc_attr( $search ); ?>" 
						class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
					>
					<button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all font-medium flex items-center gap-2">
						<i data-lucide="search" class="w-4 h-4"></i>
						<?php esc_html_e( 'Search', 'puchong-glass' ); ?>
					</button>
					<?php if ( ! empty( $search ) ) : ?>
						<a href="?page=contacts" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition-all font-medium">
							<?php esc_html_e( 'Clear', 'puchong-glass' ); ?>
						</a>
					<?php endif; ?>
				</form>
			</div>
			<div class="flex gap-2">
				<a href="?page=contacts&action=export" class="flex-1 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-all font-medium text-center flex items-center justify-center gap-2">
					<i data-lucide="download" class="w-4 h-4"></i>
					<?php esc_html_e( 'Export CSV', 'puchong-glass' ); ?>
				</a>
			</div>
		</div>
	</div>

	<!-- Contacts Table -->
	<div class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden">
		<div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
			<div>
				<h3 class="text-lg font-semibold text-gray-900"><?php esc_html_e( 'Contact Submissions', 'puchong-glass' ); ?></h3>
				<p class="text-sm text-gray-600 mt-1">
					<?php 
					echo sprintf(
						esc_html__( 'Total: %d contacts', 'puchong-glass' ),
						intval( $total_contacts )
					);
					?>
				</p>
			</div>
			<span class="badge badge-info">
				<?php echo intval( count( $contacts ) ); ?> <?php esc_html_e( 'per page', 'puchong-glass' ); ?>
			</span>
		</div>

		<?php if ( ! empty( $contacts ) ) : ?>
			<div class="overflow-x-auto">
				<table class="w-full">
					<thead class="bg-gray-50 border-b border-gray-200">
						<tr>
							<th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase"><?php esc_html_e( 'Name', 'puchong-glass' ); ?></th>
							<th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase"><?php esc_html_e( 'Email', 'puchong-glass' ); ?></th>
							<th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase"><?php esc_html_e( 'Phone', 'puchong-glass' ); ?></th>
							<th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase"><?php esc_html_e( 'Service', 'puchong-glass' ); ?></th>
							<th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase"><?php esc_html_e( 'Date', 'puchong-glass' ); ?></th>
							<th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase"><?php esc_html_e( 'Actions', 'puchong-glass' ); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ( $contacts as $contact ) :
							$name = get_post_meta( $contact->ID, 'contact_name', true );
							$email = get_post_meta( $contact->ID, 'contact_email', true );
							$phone = get_post_meta( $contact->ID, 'contact_phone', true );
							$service = get_post_meta( $contact->ID, 'contact_service', true );
							?>
							<tr class="table-row-hover border-b border-gray-200">
								<td class="px-6 py-4 text-sm font-medium text-gray-900">
									<div class="flex items-center gap-2">
										<div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-xs font-bold text-blue-600">
											<?php echo esc_html( substr( $name, 0, 1 ) ); ?>
										</div>
										<?php echo esc_html( $name ); ?>
									</div>
								</td>
								<td class="px-6 py-4 text-sm text-gray-600">
									<a href="mailto:<?php echo esc_attr( $email ); ?>" class="text-blue-600 hover:text-blue-800">
										<?php echo esc_html( $email ); ?>
									</a>
								</td>
								<td class="px-6 py-4 text-sm text-gray-600">
									<a href="tel:<?php echo esc_attr( $phone ); ?>" class="text-blue-600 hover:text-blue-800">
										<?php echo esc_html( $phone ); ?>
									</a>
								</td>
								<td class="px-6 py-4 text-sm text-gray-600">
									<?php if ( ! empty( $service ) ) : ?>
										<span class="badge badge-success"><?php echo esc_html( $service ); ?></span>
									<?php else : ?>
										<span class="text-gray-400"><?php esc_html_e( 'N/A', 'puchong-glass' ); ?></span>
									<?php endif; ?>
								</td>
								<td class="px-6 py-4 text-sm text-gray-600">
									<span class="text-gray-700"><?php echo esc_html( date_i18n( 'M j, Y \a\t g:i a', strtotime( $contact->post_date ) ) ); ?></span>
								</td>
								<td class="px-6 py-4 text-sm space-x-2">
									<a href="<?php echo admin_url( "post.php?post={$contact->ID}&action=edit" ); ?>" class="inline-block px-3 py-1 bg-blue-50 text-blue-600 rounded hover:bg-blue-100 transition-all font-medium">
										<?php esc_html_e( 'View', 'puchong-glass' ); ?>
									</a>
									<form method="post" class="inline-block">
										<?php wp_nonce_field( 'contact_action' ); ?>
										<input type="hidden" name="contact_id" value="<?php echo intval( $contact->ID ); ?>">
										<button type="submit" name="action" value="delete" class="px-3 py-1 bg-red-50 text-red-600 rounded hover:bg-red-100 transition-all font-medium" onclick="return confirm('<?php esc_attr_e( 'Are you sure?', 'puchong-glass' ); ?>')">
											<?php esc_html_e( 'Delete', 'puchong-glass' ); ?>
										</button>
									</form>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>

			<!-- Pagination -->
			<?php if ( $contacts_query->max_num_pages > 1 ) : ?>
				<div class="px-6 py-4 border-t border-gray-200 flex items-center justify-between">
					<div class="text-sm text-gray-600">
						<?php 
						echo sprintf(
							esc_html__( 'Showing %d-%d of %d', 'puchong-glass' ),
							$offset + 1,
							min( $offset + $per_page, $total_contacts ),
							$total_contacts
						);
						?>
					</div>
					<div class="flex gap-2">
						<?php if ( $current_page > 1 ) : ?>
							<a href="?page=contacts&paged=<?php echo intval( $current_page - 1 ); ?><?php echo ! empty( $search ) ? '&s=' . urlencode( $search ) : ''; ?>" class="px-3 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-all">
								<?php esc_html_e( 'Previous', 'puchong-glass' ); ?>
							</a>
						<?php endif; ?>

						<?php for ( $i = max( 1, $current_page - 2 ); $i <= min( $contacts_query->max_num_pages, $current_page + 2 ); $i++ ) : ?>
							<a href="?page=contacts&paged=<?php echo intval( $i ); ?><?php echo ! empty( $search ) ? '&s=' . urlencode( $search ) : ''; ?>" class="px-3 py-2 <?php echo $i === $current_page ? 'bg-blue-600 text-white' : 'border border-gray-300 hover:bg-gray-50'; ?> rounded-lg transition-all">
								<?php echo intval( $i ); ?>
							</a>
						<?php endfor; ?>

						<?php if ( $current_page < $contacts_query->max_num_pages ) : ?>
							<a href="?page=contacts&paged=<?php echo intval( $current_page + 1 ); ?><?php echo ! empty( $search ) ? '&s=' . urlencode( $search ) : ''; ?>" class="px-3 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-all">
								<?php esc_html_e( 'Next', 'puchong-glass' ); ?>
							</a>
						<?php endif; ?>
					</div>
				</div>
			<?php endif; ?>
		<?php else : ?>
			<div class="px-6 py-12 text-center">
				<i data-lucide="inbox" class="w-16 h-16 text-gray-300 mx-auto mb-4"></i>
				<p class="text-gray-600 text-lg"><?php esc_html_e( 'No contacts found', 'puchong-glass' ); ?></p>
				<?php if ( ! empty( $search ) ) : ?>
					<p class="text-gray-500 mt-2"><?php esc_html_e( 'Try adjusting your search terms', 'puchong-glass' ); ?></p>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</div>
</div>
