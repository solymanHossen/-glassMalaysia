<?php get_header(); ?>

<div class="container mx-auto px-4 py-20 animate-in">
    <?php
    if ( have_posts() ) :
        while ( have_posts() ) : the_post();
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('mb-12'); ?>>
                <header class="mb-6">
                    <h1 class="text-4xl font-bold text-[#0A2342] mb-4"><?php the_title(); ?></h1>
                    <?php if ( has_post_thumbnail() ) : ?>
                        <div class="rounded-2xl overflow-hidden shadow-lg mb-6">
                            <?php the_post_thumbnail('full', array('class' => 'w-full h-auto object-cover')); ?>
                        </div>
                    <?php endif; ?>
                </header>

                <div class="prose prose-lg max-w-none text-gray-600">
                    <?php the_content(); ?>
                </div>
            </article>
            <?php
        endwhile;

        the_posts_navigation();

    else :
        ?>
        <div class="text-center py-20">
            <h2 class="text-2xl font-bold text-[#0A2342] mb-4">Page Not Found</h2>
            <p class="text-gray-600">It seems we can't find what you're looking for.</p>
            <a href="<?php echo home_url(); ?>" class="inline-block mt-6 px-6 py-3 bg-[#0A2342] text-white rounded-lg hover:bg-[#1E5A8E] transition-colors">Back Home</a>
        </div>
        <?php
    endif;
    ?>
</div>

<?php get_footer(); ?>
