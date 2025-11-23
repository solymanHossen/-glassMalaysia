<?php get_header(); ?>

<div class="pt-24 pb-20 animate-in">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12 animate-in">
            <h4 class="font-bold tracking-widest text-sm mb-2 text-[#0A2342]">WHAT WE DO</h4>
            <h2 class="text-3xl md:text-5xl font-bold text-[#0A2342]">Complete Solutions</h2>
            <div class="w-20 h-1 mx-auto mt-4 rounded bg-[#0A2342]"></div>
        </div>

        <!-- Search -->
        <div class="max-w-md mx-auto mb-12">
            <form role="search" method="get" class="relative flex items-center" action="<?php echo home_url('/'); ?>">
                <input type="hidden" name="post_type" value="service" />
                <input type="search" class="w-full p-4 pl-12 rounded-full border border-gray-200 shadow-sm focus:border-[#D4AF37] focus:ring-1 focus:ring-[#D4AF37] outline-none" placeholder="Search services..." value="<?php echo get_search_query(); ?>" name="s" />
                <div class="absolute left-4 text-gray-400">
                    <i data-lucide="search" class="w-5 h-5"></i>
                </div>
                <button type="submit" class="absolute right-2 bg-[#0A2342] text-white p-2 rounded-full hover:bg-[#1E5A8E] transition-colors">
                    <i data-lucide="arrow-right" class="w-5 h-5"></i>
                </button>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php
            if ( have_posts() ) :
                while ( have_posts() ) : the_post();
                    $icon = get_post_meta( get_the_ID(), '_pg_icon', true ) ?: 'Shield';
                    $benefits = get_post_meta( get_the_ID(), '_pg_benefits', true );
                    $custom_image = get_post_meta( get_the_ID(), '_pg_custom_image', true );
                    $img_url = $custom_image ?: (get_the_post_thumbnail_url( get_the_ID(), 'large' ) ?: 'https://images.unsplash.com/photo-1600607686527-6fb886090705?auto=format&fit=crop&q=80&w=1200');
                    ?>
                    <div onclick="window.location.href='<?php the_permalink(); ?>'" class="group bg-white rounded-2xl overflow-hidden shadow-md hover:shadow-2xl transition-all cursor-pointer">
                        <div class="h-48 overflow-hidden relative">
                            <div class="absolute inset-0 bg-black/20 group-hover:bg-transparent transition-colors z-10"></div>
                            <img src="<?php echo esc_url($img_url); ?>" alt="<?php the_title(); ?>" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700" />
                            <div class="absolute top-4 right-4 bg-white/90 backdrop-blur p-2 rounded-lg text-[#0A2342] z-20">
                                <i data-lucide="<?php echo strtolower($icon); ?>"></i>
                            </div>
                        </div>
                        <div class="p-8">
                            <h3 class="text-2xl font-bold text-[#0A2342] mb-3"><?php the_title(); ?></h3>
                            <p class="text-gray-600 mb-6"><?php echo get_the_excerpt(); ?></p>
                            <ul class="space-y-2 mb-6">
                                <?php 
                                if ( is_array($benefits) ) {
                                    $benefits = array_slice($benefits, 0, 3);
                                    foreach($benefits as $benefit) {
                                        echo '<li class="flex items-center text-sm text-gray-500"><i data-lucide="check" class="w-4 h-4 text-green-500 mr-2"></i> ' . esc_html($benefit) . '</li>';
                                    }
                                }
                                ?>
                            </ul>
                            <button class="w-full py-3 bg-gray-50 text-[#0A2342] font-bold rounded-lg group-hover:bg-[#0A2342] group-hover:text-[#D4AF37] transition-colors">View Details</button>
                        </div>
                    </div>
                    <?php
                endwhile;
            else:
                echo '<p>No services found.</p>';
            endif;
            ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>
