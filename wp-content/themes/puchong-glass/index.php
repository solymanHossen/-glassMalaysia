<?php
/**
 * The main template file
 */

get_header();
?>

<main class="min-h-screen bg-gradient-to-b from-white to-gray-50 pt-32 pb-16 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <?php if ( have_posts() ) : ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php while ( have_posts() ) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('glass p-6 rounded-xl border border-gray-200 smooth-transition hover:shadow-lg'); ?>>
                        <?php if ( has_post_thumbnail() ) : ?>
                            <div class="mb-4 rounded-lg overflow-hidden h-48">
                                <?php the_post_thumbnail('medium', ['class' => 'w-full h-full object-cover']); ?>
                            </div>
                        <?php endif; ?>
                        
                        <h2 class="text-xl font-bold text-gray-900 mb-2">
                            <a href="<?php the_permalink(); ?>" class="hover:text-blue-600 smooth-transition"><?php the_title(); ?></a>
                        </h2>
                        
                        <div class="text-gray-600 mb-4 line-clamp-3">
                            <?php the_excerpt(); ?>
                        </div>
                        
                        <a href="<?php the_permalink(); ?>" class="text-blue-500 font-semibold hover:text-blue-600 inline-flex items-center gap-1">
                            Read More <i data-lucide="arrow-right" class="w-4 h-4"></i>
                        </a>
                    </article>
                <?php endwhile; ?>
            </div>
            
            <div class="mt-12">
                <?php the_posts_pagination(); ?>
            </div>
        <?php else : ?>
            <p><?php esc_html_e( 'Sorry, no posts matched your criteria.', 'puchong-glass' ); ?></p>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>
