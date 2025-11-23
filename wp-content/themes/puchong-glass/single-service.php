<?php get_header(); ?>

<?php
while ( have_posts() ) : the_post();
    $icon = get_post_meta( get_the_ID(), '_pg_icon', true ) ?: 'Shield';
    $specs = get_post_meta( get_the_ID(), '_pg_specs', true );
    $benefits = get_post_meta( get_the_ID(), '_pg_benefits', true );
    $custom_image = get_post_meta( get_the_ID(), '_pg_custom_image', true );
    $img_url = $custom_image ?: (get_the_post_thumbnail_url( get_the_ID(), 'full' ) ?: 'https://images.unsplash.com/photo-1505691938895-1758d7bab58d?auto=format&fit=crop&q=80&w=1200');
?>

<div class="animate-in">
    <!-- Hero Header -->
    <div class="relative h-[50vh] flex items-center justify-center">
        <img src="<?php echo esc_url($img_url); ?>" alt="<?php the_title(); ?>" class="absolute inset-0 w-full h-full object-cover" />
        <div class="absolute inset-0 bg-[#0A2342]/80"></div>
        <div class="relative z-10 text-center container px-4">
            <a href="<?php echo home_url('/services'); ?>" class="mb-6 inline-flex items-center text-gray-300 hover:text-white transition-colors">
                <i data-lucide="chevron-left" class="mr-2"></i> Back to Services
            </a>
            <h1 class="text-5xl md:text-6xl font-bold text-white mb-4"><?php the_title(); ?></h1>
            <p class="text-xl text-gray-300 max-w-2xl mx-auto"><?php echo get_the_excerpt(); ?></p>
        </div>
    </div>

    <div class="container mx-auto px-4 py-16 grid md:grid-cols-3 gap-12">
        <!-- Main Content -->
        <div class="md:col-span-2 space-y-12">
            <div>
                <h3 class="text-2xl font-bold text-[#0A2342] mb-4">Overview</h3>
                <div class="text-gray-600 leading-relaxed text-lg">
                    <?php the_content(); ?>
                </div>
            </div>
            
            <?php if ( is_array($benefits) && !empty($benefits) ) : ?>
            <div>
                <h3 class="text-2xl font-bold text-[#0A2342] mb-6">Key Benefits</h3>
                <div class="grid grid-cols-2 gap-4">
                    <?php foreach($benefits as $benefit) : ?>
                    <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                        <i data-lucide="check" class="w-5 h-5 text-[#D4AF37] mr-3"></i>
                        <span class="font-medium text-gray-700"><?php echo esc_html($benefit); ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <?php if ( is_array($specs) && !empty($specs) ) : ?>
            <div>
                <h3 class="text-2xl font-bold text-[#0A2342] mb-6">Technical Specifications</h3>
                <div class="bg-white border rounded-xl overflow-hidden shadow-sm">
                    <table class="w-full">
                        <tbody>
                            <?php foreach($specs as $spec) : 
                                $parts = explode(':', $spec, 2);
                                $key = isset($parts[0]) ? $parts[0] : '';
                                $val = isset($parts[1]) ? $parts[1] : '';
                            ?>
                            <tr class="border-b last:border-0 hover:bg-gray-50">
                                <td class="p-4 font-bold text-[#0A2342] w-1/3"><?php echo esc_html($key); ?></td>
                                <td class="p-4 text-gray-600"><?php echo esc_html($val); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <!-- Sidebar -->
        <div class="space-y-8">
            <div class="bg-[#0A2342] text-white p-8 rounded-2xl shadow-xl">
                <h3 class="text-2xl font-bold mb-2">Interested?</h3>
                <p class="text-gray-300 mb-6">Get a custom quote for <?php the_title(); ?> today.</p>
                <button onclick="openQuote('<?php the_title(); ?>')" class="w-full py-4 bg-[#D4AF37] text-[#0A2342] font-bold rounded-lg mb-4 hover:bg-white transition-colors">Get Instant Quote</button>
                <a href="https://wa.me/60123456789" target="_blank" class="w-full py-4 bg-transparent border border-white/20 hover:bg-white/10 text-white font-bold rounded-lg flex items-center justify-center">
                    <i data-lucide="message-circle" class="mr-2"></i> WhatsApp Us
                </a>
            </div>
            
            <div class="bg-gray-100 p-8 rounded-2xl">
                <h4 class="font-bold text-[#0A2342] mb-4 flex items-center"><i data-lucide="zap" class="w-5 h-5 mr-2 text-[#D4AF37]"></i> Why Choose Us?</h4>
                <ul class="space-y-3 text-sm text-gray-600">
                    <li class="flex gap-2"><i data-lucide="check" class="w-4 h-4 text-green-500"></i> 10-Year Warranty</li>
                    <li class="flex gap-2"><i data-lucide="check" class="w-4 h-4 text-green-500"></i> Certified Installers</li>
                    <li class="flex gap-2"><i data-lucide="check" class="w-4 h-4 text-green-500"></i> Factory Direct Price</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php endwhile; ?>

<?php get_footer(); ?>
