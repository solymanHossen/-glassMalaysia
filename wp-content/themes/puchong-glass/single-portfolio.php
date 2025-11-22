<?php
/**
 * The template for displaying single portfolio projects
 */

get_header();
?>

<main class="min-h-screen bg-gradient-to-b from-white to-gray-50 pt-32 pb-16 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <?php while ( have_posts() ) : the_post(); ?>
            
            <!-- Breadcrumb -->
            <div class="mb-8 text-sm text-gray-500">
                <a href="<?php echo home_url('/'); ?>" class="hover:text-blue-600">Home</a>
                <span class="mx-2">/</span>
                <a href="<?php echo home_url('/portfolio'); ?>" class="hover:text-blue-600">Portfolio</a>
                <span class="mx-2">/</span>
                <span class="text-gray-900"><?php the_title(); ?></span>
            </div>

            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                    
                    <!-- Image Gallery / Featured Image -->
                    <div>
                        <?php if ( has_post_thumbnail() ) : ?>
                            <div class="rounded-2xl overflow-hidden shadow-lg mb-6 glass border border-gray-200">
                                <?php the_post_thumbnail('large', ['class' => 'w-full h-auto object-cover']); ?>
                            </div>
                        <?php endif; ?>
                        
                        <!-- If you had a gallery plugin or custom fields for more images, they would go here -->
                    </div>

                    <!-- Project Details -->
                    <div>
                        <h1 class="font-serif text-4xl md:text-5xl font-bold text-gray-900 mb-6"><?php the_title(); ?></h1>
                        
                        <!-- Categories -->
                        <?php
                        $terms = get_the_terms( get_the_ID(), 'portfolio_category' );
                        if ( $terms && ! is_wp_error( $terms ) ) : 
                        ?>
                            <div class="flex flex-wrap gap-2 mb-6">
                                <?php foreach ( $terms as $term ) : ?>
                                    <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-sm font-medium">
                                        <?php echo esc_html( $term->name ); ?>
                                    </span>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <div class="prose prose-lg prose-blue text-gray-600 mb-8">
                            <?php the_content(); ?>
                        </div>

                        <!-- Project Meta (Example fields) -->
                        <div class="grid grid-cols-2 gap-6 border-t border-gray-200 pt-8">
                            <div>
                                <h4 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-1">Client</h4>
                                <p class="text-gray-600">Private Client</p> <!-- Dynamic if using ACF -->
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-1">Date</h4>
                                <p class="text-gray-600"><?php echo get_the_date('F Y'); ?></p>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-1">Service</h4>
                                <p class="text-gray-600">Installation</p> <!-- Dynamic if using ACF -->
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-1">Location</h4>
                                <p class="text-gray-600">Puchong, Selangor</p> <!-- Dynamic if using ACF -->
                            </div>
                        </div>

                        <div class="mt-10">
                            <a href="<?php echo home_url('/contact'); ?>" class="w-full sm:w-auto px-8 py-4 text-lg font-semibold smooth-transition rounded-full inline-flex items-center justify-center gap-2 bg-blue-500 text-white hover:bg-blue-600 hover:shadow-lg">
                                Get a Quote Like This <i data-lucide="arrow-right" class="w-5 h-5"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </article>

            <!-- Related Projects -->
            <div class="mt-20 border-t border-gray-200 pt-16">
                <h2 class="font-serif text-3xl font-bold text-gray-900 mb-8">Other Projects</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <?php
                    $related = new WP_Query( array(
                        'post_type' => 'portfolio',
                        'posts_per_page' => 3,
                        'post__not_in' => array( get_the_ID() ),
                        'orderby' => 'rand'
                    ));

                    if ( $related->have_posts() ) :
                        while ( $related->have_posts() ) : $related->the_post();
                    ?>
                        <a href="<?php the_permalink(); ?>" class="group block">
                            <div class="rounded-xl overflow-hidden mb-4 h-48 relative">
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <?php the_post_thumbnail('medium', ['class' => 'w-full h-full object-cover group-hover:scale-110 smooth-transition']); ?>
                                <?php else: ?>
                                    <div class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-400">No Image</div>
                                <?php endif; ?>
                            </div>
                            <h3 class="font-bold text-gray-900 group-hover:text-blue-600 smooth-transition"><?php the_title(); ?></h3>
                        </a>
                    <?php
                        endwhile;
                        wp_reset_postdata();
                    endif;
                    ?>
                </div>
            </div>

        <?php endwhile; ?>
    </div>
</main>

<?php get_footer(); ?>
