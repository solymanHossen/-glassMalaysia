<?php
/**
 * The template for displaying all pages
 */

get_header();
?>

<main class="min-h-screen bg-gradient-to-b from-white to-gray-50 pt-32 pb-16 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <?php while ( have_posts() ) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="text-center mb-16">
                    <h1 class="font-serif text-5xl font-bold text-gray-900 mb-4"><?php the_title(); ?></h1>
                </header>

                <div class="prose prose-lg prose-blue max-w-none mx-auto">
                    <?php the_content(); ?>
                </div>
            </article>
        <?php endwhile; ?>
    </div>
</main>

<?php get_footer(); ?>
