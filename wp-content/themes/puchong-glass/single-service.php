<?php
/**
 * The template for displaying single services
 */

get_header();
?>

<main class="min-h-screen bg-gradient-to-b from-white to-gray-50 pt-32 pb-16 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <?php while ( have_posts() ) : the_post(); ?>
            
            <div class="text-center max-w-3xl mx-auto mb-16">
                <div class="inline-block px-3 py-1 rounded-full bg-blue-50 border border-blue-200 mb-4">
                    <span class="text-sm font-semibold text-blue-600">Our Services</span>
                </div>
                <h1 class="font-serif text-5xl font-bold text-gray-900 mb-6"><?php the_title(); ?></h1>
                <div class="text-xl text-gray-600">
                    <?php the_excerpt(); ?>
                </div>
            </div>

            <div class="relative rounded-2xl overflow-hidden h-96 mb-16 shadow-xl">
                <?php if ( has_post_thumbnail() ) : ?>
                    <?php the_post_thumbnail('full', ['class' => 'w-full h-full object-cover']); ?>
                <?php else: ?>
                    <img src="https://placehold.co/1200x600?text=Service+Image" class="w-full h-full object-cover" alt="<?php the_title(); ?>">
                <?php endif; ?>
                <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                <div class="lg:col-span-2">
                    <div class="prose prose-lg prose-blue max-w-none text-gray-600">
                        <?php the_content(); ?>
                    </div>
                </div>

                <div class="lg:col-span-1">
                    <div class="glass p-8 rounded-xl border border-gray-200 sticky top-32">
                        <h3 class="font-serif text-2xl font-bold text-gray-900 mb-6">Interested in this service?</h3>
                        <p class="text-gray-600 mb-6">Contact us today for a free consultation and quote.</p>
                        
                        <ul class="space-y-4 mb-8">
                            <li class="flex items-center gap-3 text-gray-700">
                                <i data-lucide="check-circle" class="text-green-500 w-5 h-5"></i>
                                <span>Professional Installation</span>
                            </li>
                            <li class="flex items-center gap-3 text-gray-700">
                                <i data-lucide="check-circle" class="text-green-500 w-5 h-5"></i>
                                <span>Quality Materials</span>
                            </li>
                            <li class="flex items-center gap-3 text-gray-700">
                                <i data-lucide="check-circle" class="text-green-500 w-5 h-5"></i>
                                <span>Warranty Included</span>
                            </li>
                        </ul>

                        <a href="<?php echo home_url('/contact'); ?>" class="block w-full py-3 rounded-lg bg-blue-500 text-white font-semibold text-center smooth-transition hover:bg-blue-600 mb-3">
                            Get a Quote
                        </a>
                        <a href="https://wa.me/60123456789" class="block w-full py-3 rounded-lg border-2 border-green-500 text-green-600 font-semibold text-center smooth-transition hover:bg-green-50">
                            WhatsApp Us
                        </a>
                    </div>
                </div>
            </div>

        <?php endwhile; ?>
    </div>
</main>

<?php get_footer(); ?>
