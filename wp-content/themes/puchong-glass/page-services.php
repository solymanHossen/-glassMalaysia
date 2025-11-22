<?php
/**
 * Template Name: Services Page
 */

get_header();
?>

<main class="min-h-screen bg-gradient-to-b from-white to-gray-50">

    <!-- Hero Section -->
    <section class="relative pt-32 pb-16 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="text-center">
                <h1 class="font-serif text-5xl sm:text-6xl font-bold text-gray-900 mb-4">
                    Premium Glass & Aluminium Services
                </h1>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Comprehensive solutions for all your glass, aluminium, and grill needs.
                </p>
            </div>
        </div>
    </section>

    <!-- Services List -->
    <section class="py-20 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <?php
            $args = array(
                'post_type' => 'service',
                'posts_per_page' => -1,
                'orderby' => 'menu_order',
                'order' => 'ASC'
            );
            $services = new WP_Query($args);
            $index = 0;

            if ( $services->have_posts() ) :
                while ( $services->have_posts() ) : $services->the_post();
                    $is_reverse = $index % 2 === 1;
                    $index++;
            ?>
                <div class="mb-20">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center <?php echo $is_reverse ? 'lg:flex-row-reverse' : ''; ?>">
                        <!-- Image -->
                        <div class="<?php echo $is_reverse ? 'lg:order-2' : ''; ?>">
                            <div class="relative rounded-2xl overflow-hidden glass h-96 sm:h-full shadow-lg">
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <?php the_post_thumbnail('large', ['class' => 'w-full h-full object-cover']); ?>
                                <?php else: ?>
                                    <img src="https://placehold.co/800x600?text=Service" alt="<?php the_title(); ?>" class="w-full h-full object-cover" />
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="<?php echo $is_reverse ? 'lg:order-1' : ''; ?>">
                            <div class="inline-block px-3 py-1 rounded-full bg-blue-50 border border-blue-200 mb-4">
                                <span class="text-sm font-semibold text-blue-600">Service #<?php echo $index; ?></span>
                            </div>

                            <h2 class="font-serif text-4xl font-bold text-gray-900 mb-3"><?php the_title(); ?></h2>
                            <div class="text-gray-600 text-lg mb-8 line-clamp-3">
                                <?php the_excerpt(); ?>
                            </div>

                            <div class="flex gap-4">
                                <a href="<?php the_permalink(); ?>" class="px-8 py-4 text-lg font-semibold smooth-transition rounded-full inline-flex items-center justify-center gap-2 bg-blue-500 text-white hover:bg-blue-600 hover:shadow-lg hover:shadow-blue-500/30">
                                    View Details <i data-lucide="arrow-right" class="w-5 h-5"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Divider -->
                    <?php if ( $index < $services->post_count ) : ?>
                        <div class="mt-20 h-px bg-gradient-to-r from-transparent via-gray-300 to-transparent"></div>
                    <?php endif; ?>
                </div>
            <?php
                endwhile;
                wp_reset_postdata();
            else :
            ?>
                <div class="text-center py-20">
                    <p class="text-xl text-gray-600">No services found. Please add some services in the admin dashboard.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-16 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto text-center glass rounded-2xl p-12 border border-gray-200">
            <h2 class="font-serif text-4xl font-bold text-gray-900 mb-4">Ready to Get Started?</h2>
            <p class="text-gray-600 mb-8">Contact our team for a consultation and free quote on your project.</p>
            <a href="<?php echo home_url('/contact'); ?>" class="px-8 py-4 text-lg font-semibold smooth-transition rounded-full inline-flex items-center justify-center gap-2 bg-blue-500 text-white hover:bg-blue-600 hover:shadow-lg hover:shadow-blue-500/30">
                Request Consultation <i data-lucide="arrow-right" class="w-5 h-5"></i>
            </a>
        </div>
    </section>

</main>

<?php get_footer(); ?>
