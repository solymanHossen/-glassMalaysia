<?php
/**
 * The template for displaying all single posts
 */

get_header();
?>

<main class="min-h-screen bg-gradient-to-b from-white to-gray-50 pt-32 pb-16 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <?php while ( have_posts() ) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden'); ?>>
                
                <?php if ( has_post_thumbnail() ) : ?>
                    <div class="w-full h-96 overflow-hidden">
                        <?php the_post_thumbnail('large', ['class' => 'w-full h-full object-cover']); ?>
                    </div>
                <?php endif; ?>

                <div class="p-8 md:p-12">
                    <header class="mb-8">
                        <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                            <span><?php echo get_the_date(); ?></span>
                            <span>•</span>
                            <span><?php the_author(); ?></span>
                        </div>
                        <h1 class="font-serif text-4xl md:text-5xl font-bold text-gray-900 mb-6"><?php the_title(); ?></h1>
                    </header>

                    <div class="prose prose-lg prose-blue max-w-none text-gray-600">
                        <?php the_content(); ?>
                    </div>

                    <footer class="mt-12 pt-8 border-t border-gray-100">
                        <div class="flex flex-wrap gap-2">
                            <?php the_tags('<span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-sm">', '</span><span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-sm">', '</span>'); ?>
                        </div>
                    </footer>
                </div>

            </article>

            <div class="mt-12">
                <?php
                if ( comments_open() || get_comments_number() ) :
                    comments_template();
                endif;
                ?>
            </div>
        <?php endwhile; ?>
    </div>
</main>

<?php get_footer(); ?>
