<?php
/**
 * Template Name: Portfolio Page
 */

get_header();
?>

<main class="min-h-screen bg-gradient-to-b from-white to-gray-50">

    <!-- Hero -->
    <section class="pt-32 pb-16 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto text-center">
            <h1 class="font-serif text-5xl sm:text-6xl font-bold text-gray-900 mb-4">
                Our Portfolio
            </h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Explore our completed projects showcasing premium glass, aluminium, and grill installations.
            </p>
        </div>
    </section>

    <!-- Filter -->
    <section class="py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-wrap gap-3 justify-center" id="portfolio-filters">
                <a href="<?php echo home_url('/portfolio'); ?>" class="px-6 py-2 rounded-full font-medium smooth-transition <?php echo !isset($_GET['cat']) ? 'bg-blue-500 text-white shadow-lg' : 'bg-gray-200 text-gray-900 hover:bg-gray-300'; ?>">All</a>
                
                <?php
                $categories = get_terms(array(
                    'taxonomy' => 'portfolio_category',
                    'hide_empty' => true,
                ));
                
                if ( ! is_wp_error( $categories ) ) {
                    foreach ( $categories as $cat ) {
                        $is_active = isset($_GET['cat']) && $_GET['cat'] === $cat->slug;
                        $class = $is_active ? 'bg-blue-500 text-white shadow-lg' : 'bg-gray-200 text-gray-900 hover:bg-gray-300';
                        echo '<a href="' . esc_url(add_query_arg('cat', $cat->slug)) . '" class="px-6 py-2 rounded-full font-medium smooth-transition ' . $class . '">' . esc_html($cat->name) . '</a>';
                    }
                }
                ?>
            </div>
        </div>
    </section>

    <!-- Grid -->
    <section class="py-20 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php
                $args = array(
                    'post_type' => 'portfolio',
                    'posts_per_page' => 12,
                    'paged' => get_query_var('paged') ? get_query_var('paged') : 1,
                );

                if ( isset($_GET['cat']) ) {
                    $args['tax_query'] = array(
                        array(
                            'taxonomy' => 'portfolio_category',
                            'field'    => 'slug',
                            'terms'    => sanitize_text_field($_GET['cat']),
                        ),
                    );
                }

                $query = new WP_Query($args);

                if ( $query->have_posts() ) :
                    while ( $query->have_posts() ) : $query->the_post();
                        $terms = get_the_terms( get_the_ID(), 'portfolio_category' );
                        $cat_name = $terms && ! is_wp_error( $terms ) ? $terms[0]->name : 'Project';
                ?>
                    <a href="<?php the_permalink(); ?>" class="group block">
                        <div class="rounded-xl overflow-hidden glass border border-gray-200 smooth-transition hover:shadow-xl h-full flex flex-col">
                            <div class="relative h-64 overflow-hidden">
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <?php the_post_thumbnail('large', ['class' => 'w-full h-full object-cover group-hover:scale-110 smooth-transition']); ?>
                                <?php else: ?>
                                    <img src="https://placehold.co/600x400?text=Project" alt="<?php the_title(); ?>" class="w-full h-full object-cover group-hover:scale-110 smooth-transition">
                                <?php endif; ?>
                                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/40 smooth-transition flex items-end p-4">
                                    <div class="text-white opacity-0 group-hover:opacity-100 smooth-transition">
                                        <p class="text-sm font-semibold mb-1">View Details</p>
                                    </div>
                                </div>
                            </div>
                            <div class="p-6 flex-grow">
                                <p class="text-xs font-semibold text-blue-600 mb-2 uppercase"><?php echo esc_html($cat_name); ?></p>
                                <h3 class="font-serif text-xl font-bold text-gray-900 mb-2 group-hover:text-blue-600 smooth-transition"><?php the_title(); ?></h3>
                                <div class="text-gray-600 text-sm line-clamp-2">
                                    <?php the_excerpt(); ?>
                                </div>
                            </div>
                        </div>
                    </a>
                <?php
                    endwhile;
                    
                    // Pagination
                    echo '<div class="mt-12 flex justify-center">';
                    echo paginate_links(array(
                        'total' => $query->max_num_pages,
                        'prev_text' => '<i data-lucide="chevron-left" class="w-5 h-5"></i>',
                        'next_text' => '<i data-lucide="chevron-right" class="w-5 h-5"></i>',
                        'type' => 'list',
                        'class' => 'flex gap-2'
                    ));
                    echo '</div>';
                    
                    wp_reset_postdata();
                else :
                ?>
                    <div class="col-span-full text-center py-20">
                        <h3 class="text-xl font-semibold text-gray-900">No projects found.</h3>
                        <p class="text-gray-600 mt-2">Check back soon for updates!</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

</main>

<?php get_footer(); ?>
