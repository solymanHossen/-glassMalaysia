<?php get_header(); ?>

<?php
while ( have_posts() ) : the_post();
    $location = get_post_meta( get_the_ID(), '_pg_location', true );
    $year = get_post_meta( get_the_ID(), '_pg_year', true );
    $challenge = get_post_meta( get_the_ID(), '_pg_challenge', true );
    $solution = get_post_meta( get_the_ID(), '_pg_solution', true );
    $custom_image = get_post_meta( get_the_ID(), '_pg_custom_image', true );
    $img_url = $custom_image ?: (get_the_post_thumbnail_url( get_the_ID(), 'full' ) ?: 'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?auto=format&fit=crop&q=80&w=1200');
    
    $terms = get_the_terms( get_the_ID(), 'portfolio_category' );
    $category = ($terms && !is_wp_error($terms)) ? $terms[0]->name : 'Project';
?>

<div class="animate-in pt-24 pb-20">
    <div class="container mx-auto px-4">
        <a href="<?php echo home_url('/portfolio'); ?>" class="mb-8 inline-flex items-center text-gray-500 hover:text-[#0A2342] transition-colors">
            <i data-lucide="chevron-left" class="mr-2"></i> Back to Portfolio
        </a>

        <div class="grid lg:grid-cols-2 gap-12 mb-16">
            <div class="rounded-2xl overflow-hidden shadow-2xl">
                <img src="<?php echo esc_url($img_url); ?>" alt="<?php the_title(); ?>" class="w-full h-full object-cover" />
            </div>
            <div class="flex flex-col justify-center">
                <span class="text-[#D4AF37] font-bold tracking-widest uppercase mb-2"><?php echo esc_html($category); ?></span>
                <h1 class="text-4xl md:text-5xl font-bold text-[#0A2342] mb-6"><?php the_title(); ?></h1>
                
                <div class="grid grid-cols-2 gap-6 mb-8 border-y border-gray-100 py-6">
                    <div>
                        <span class="block text-gray-400 text-xs uppercase mb-1">Location</span>
                        <span class="font-medium text-[#0A2342] flex items-center"><i data-lucide="map-pin" class="w-4 h-4 mr-1"></i> <?php echo esc_html($location); ?></span>
                    </div>
                    <div>
                        <span class="block text-gray-400 text-xs uppercase mb-1">Year</span>
                        <span class="font-medium text-[#0A2342] flex items-center"><i data-lucide="calendar" class="w-4 h-4 mr-1"></i> <?php echo esc_html($year); ?></span>
                    </div>
                </div>

                <div class="space-y-6">
                    <div>
                        <h3 class="font-bold text-[#0A2342] mb-2">The Challenge</h3>
                        <p class="text-gray-600"><?php echo esc_html($challenge); ?></p>
                    </div>
                    <div>
                        <h3 class="font-bold text-[#0A2342] mb-2">The Solution</h3>
                        <p class="text-gray-600"><?php echo esc_html($solution); ?></p>
                    </div>
                </div>

                <button onclick="openQuote('Similar to <?php the_title(); ?>')" class="mt-8 px-8 py-4 bg-[#0A2342] text-white font-bold rounded-lg hover:bg-[#1E5A8E] transition-colors self-start">
                    Request Similar Project
                </button>
            </div>
        </div>
    </div>
</div>

<?php endwhile; ?>

<?php get_footer(); ?>
