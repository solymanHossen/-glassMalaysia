<?php get_header(); ?>

<div class="container mx-auto px-4 py-20 animate-in pt-32">
    <?php
    while ( have_posts() ) : the_post();
        ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <header class="mb-8 text-center max-w-3xl mx-auto">
                <h1 class="text-4xl md:text-5xl font-bold text-[#0A2342] mb-6"><?php the_title(); ?></h1>
                <div class="w-20 h-1 mx-auto rounded bg-[#D4AF37]"></div>
            </header>

            <?php if ( has_post_thumbnail() ) : ?>
                <div class="rounded-2xl overflow-hidden shadow-xl mb-12 max-h-[60vh]">
                    <?php the_post_thumbnail('full', array('class' => 'w-full h-full object-cover')); ?>
                </div>
            <?php endif; ?>

            <div class="prose prose-lg max-w-4xl mx-auto text-gray-600">
                <?php the_content(); ?>
            </div>
        </article>
        <?php
    endwhile;
    ?>
</div>

<?php get_footer(); ?>
