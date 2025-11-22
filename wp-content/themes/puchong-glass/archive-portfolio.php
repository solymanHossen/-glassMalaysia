<?php get_header(); ?>

<div class="pt-24 pb-20 animate-in">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12 animate-in">
            <h4 class="font-bold tracking-widest text-sm mb-2 text-[#0A2342]">OUR WORK</h4>
            <h2 class="text-3xl md:text-5xl font-bold text-[#0A2342]">Recent Projects</h2>
            <div class="w-20 h-1 mx-auto mt-4 rounded bg-[#0A2342]"></div>
        </div>
        
        <!-- Filter -->
        <div class="flex flex-wrap justify-center gap-2 mb-12" id="portfolio-filters">
            <button data-filter="all" class="filter-btn px-6 py-2 rounded-full text-sm font-bold transition-all bg-[#0A2342] text-white shadow-lg">All</button>
            <?php
            $terms = get_terms( array(
                'taxonomy' => 'portfolio_category',
                'hide_empty' => true,
            ) );
            if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
                foreach ( $terms as $term ) {
                    echo '<button data-filter="' . esc_attr( $term->slug ) . '" class="filter-btn px-6 py-2 rounded-full text-sm font-bold transition-all bg-gray-100 text-gray-600 hover:bg-gray-200">' . esc_html( $term->name ) . '</button>';
                }
            }
            ?>
        </div>

        <!-- Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="portfolio-grid">
            <?php
            $args = array(
                'post_type' => 'portfolio',
                'posts_per_page' => -1,
            );
            $query = new WP_Query( $args );
            if ( $query->have_posts() ) :
                while ( $query->have_posts() ) : $query->the_post();
                    $terms = get_the_terms( get_the_ID(), 'portfolio_category' );
                    $term_slugs = '';
                    if ( $terms && ! is_wp_error( $terms ) ) {
                        $term_slugs = join( ' ', wp_list_pluck( $terms, 'slug' ) );
                    }
                    $location = get_post_meta( get_the_ID(), '_pg_location', true );
                    $year = get_post_meta( get_the_ID(), '_pg_year', true );
                    $img_url = get_the_post_thumbnail_url( get_the_ID(), 'large' ) ?: 'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?auto=format&fit=crop&q=80&w=1200';
                    ?>
                    <div class="portfolio-item group cursor-pointer <?php echo esc_attr( $term_slugs ); ?>" onclick="window.location.href='<?php the_permalink(); ?>'">
                        <div class="relative overflow-hidden rounded-2xl aspect-[4/3] mb-4 shadow-md">
                            <img src="<?php echo esc_url($img_url); ?>" alt="<?php the_title(); ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" />
                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                <span class="bg-white text-[#0A2342] px-6 py-2 rounded-full font-bold transform translate-y-4 group-hover:translate-y-0 transition-transform">View Case Study</span>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold text-[#0A2342] group-hover:text-[#D4AF37] transition-colors"><?php the_title(); ?></h3>
                        <p class="text-sm text-gray-500"><?php echo esc_html($location); ?> • <?php echo esc_html($year); ?></p>
                    </div>
                    <?php
                endwhile;
                wp_reset_postdata();
            else:
                echo '<p>No projects found.</p>';
            endif;
            ?>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const buttons = document.querySelectorAll('.filter-btn');
    const items = document.querySelectorAll('.portfolio-item');

    buttons.forEach(btn => {
        btn.addEventListener('click', () => {
            // Active state
            buttons.forEach(b => {
                b.classList.remove('bg-[#0A2342]', 'text-white', 'shadow-lg');
                b.classList.add('bg-gray-100', 'text-gray-600');
            });
            btn.classList.remove('bg-gray-100', 'text-gray-600');
            btn.classList.add('bg-[#0A2342]', 'text-white', 'shadow-lg');

            const filter = btn.getAttribute('data-filter');
            items.forEach(item => {
                if (filter === 'all' || item.classList.contains(filter)) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });
});
</script>

<?php get_footer(); ?>
