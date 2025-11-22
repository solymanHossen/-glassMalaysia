<?php
/**
 * Template Name: FAQ Page
 */

get_header();
?>

<main class="min-h-screen bg-gradient-to-b from-white to-gray-50">

    <section class="pt-32 pb-16 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto text-center">
            <h1 class="font-serif text-5xl sm:text-6xl font-bold text-gray-900 mb-4">
                Frequently Asked Questions
            </h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Get answers to your questions about our premium glass and aluminium services.
            </p>
        </div>
    </section>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <section class="py-20 px-4 sm:px-6 lg:px-8 bg-white">
            <div class="max-w-4xl mx-auto">
                
                <div class="space-y-4">
                    <?php
                    $args = array(
                        'post_type' => 'faq',
                        'posts_per_page' => -1,
                    );
                    $faqs = new WP_Query($args);

                    if ( $faqs->have_posts() ) :
                        while ( $faqs->have_posts() ) : $faqs->the_post();
                    ?>
                        <div class="border border-gray-200 rounded-lg overflow-hidden smooth-transition hover:border-blue-300 faq-item">
                            <button class="w-full px-6 py-4 flex items-center justify-between bg-white hover:bg-gray-50 smooth-transition faq-button" onclick="toggleFaq(this)">
                                <h3 class="text-lg font-semibold text-gray-900 text-left"><?php the_title(); ?></h3>
                                <i data-lucide="chevron-down" class="w-6 h-6 flex-shrink-0 text-blue-500 smooth-transition faq-icon"></i>
                            </button>

                            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 hidden faq-answer prose prose-blue max-w-none">
                                <?php the_content(); ?>
                            </div>
                        </div>
                    <?php
                        endwhile;
                        wp_reset_postdata();
                    else :
                    ?>
                        <p class="text-center text-gray-600">No FAQs found.</p>
                    <?php endif; ?>
                </div>

                <!-- Still have questions -->
                <div class="mt-12 text-center glass rounded-xl border border-gray-200 p-8">
                    <h3 class="font-semibold text-gray-900 mb-3">Didn't find your answer?</h3>
                    <p class="text-gray-600 mb-6">
                        Our team is ready to help. Reach out to us for any additional questions.
                    </p>
                    <a href="<?php echo home_url('/contact'); ?>" class="inline-block px-6 py-3 rounded-full bg-blue-500 text-white font-semibold smooth-transition hover:bg-blue-600">
                        Contact Us
                    </a>
                </div>
            </div>
        </section>
    </div>

    <script>
        function toggleFaq(button) {
            const answer = button.nextElementSibling;
            const icon = button.querySelector('.faq-icon');
            
            if (answer.classList.contains('hidden')) {
                answer.classList.remove('hidden');
                icon.style.transform = 'rotate(180deg)';
            } else {
                answer.classList.add('hidden');
                icon.style.transform = 'rotate(0deg)';
            }
        }
    </script>

</main>

<?php get_footer(); ?>
