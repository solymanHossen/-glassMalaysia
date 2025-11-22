<?php
/**
 * Template Name: Home Page
 */

get_header();
?>

<main class="min-h-screen bg-gradient-to-b from-gray-50 to-white">

    <!-- Hero Section -->
    <section class="relative pt-32 pb-20 px-4 sm:px-6 lg:px-8 overflow-hidden">
        <div class="absolute inset-0 opacity-5">
            <div class="absolute top-20 right-10 w-96 h-96 bg-blue-400 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-20 left-10 w-96 h-96 bg-blue-200 rounded-full blur-3xl"></div>
        </div>

        <div class="max-w-7xl mx-auto relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Content -->
                <div>
                    <div class="inline-block px-4 py-2 rounded-full bg-blue-50 border border-blue-200 mb-6">
                        <span class="text-sm font-semibold text-blue-600">Premium Glass Solutions</span>
                    </div>

                    <h1 class="text-balance font-serif text-5xl sm:text-6xl font-bold text-gray-900 mb-6 leading-tight">
                        Transform Your Spaces with Premium Glass & Aluminiumdd
                    </h1>

                    <p class="text-balance text-lg text-gray-600 mb-8 leading-relaxed max-w-xl">
                        Expert craftsmanship for residential and commercial projects. From custom glass installations to aluminium fabrication, we bring precision and elegance to every project.
                    </p>

                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="<?php echo home_url('/contact'); ?>" class="px-8 py-4 text-lg font-semibold smooth-transition rounded-full inline-flex items-center justify-center gap-2 bg-blue-500 text-white hover:bg-blue-600 hover:shadow-lg hover:shadow-blue-500/30">
                            Get Quote <i data-lucide="arrow-right" class="w-5 h-5"></i>
                        </a>
                        <a href="<?php echo home_url('/portfolio'); ?>" class="px-8 py-4 text-lg font-semibold smooth-transition rounded-full inline-flex items-center justify-center gap-2 bg-gray-200 text-gray-900 hover:bg-gray-300 hover:shadow-lg">
                            See Portfolio <i data-lucide="arrow-right" class="w-5 h-5"></i>
                        </a>
                    </div>

                    <!-- Trust Badges -->
                    <div class="mt-12 grid grid-cols-3 gap-6">
                        <div>
                            <div class="text-2xl font-bold text-blue-600">500+</div>
                            <p class="text-sm text-gray-600">Projects Completed</p>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-blue-600">15+</div>
                            <p class="text-sm text-gray-600">Years Experience</p>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-blue-600">100%</div>
                            <p class="text-sm text-gray-600">Client Satisfied</p>
                        </div>
                    </div>
                </div>

                <!-- Hero Image -->
                <div class="relative">
                    <div class="glass rounded-2xl overflow-hidden h-96 sm:h-full min-h-96">
                        <!-- Placeholder image -->
                        <img src="https://placehold.co/800x600?text=Premium+Glass+Installation" alt="Premium glass and aluminium installation" class="w-full h-full object-cover" />
                    </div>
                    <div class="absolute -bottom-8 -right-8 w-32 h-32 glass rounded-xl p-4 backdrop-blur-xl">
                        <div class="text-3xl font-bold text-blue-600 mb-1">5★</div>
                        <p class="text-xs text-gray-600">Rated by 480+ clients</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Preview Section -->
    <section class="py-20 px-4 sm:px-6 lg:px-8 bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="font-serif text-4xl font-bold text-gray-900 mb-4">Our Premium Services</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    Comprehensive glass and aluminium solutions tailored to your needs
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php
                $services_query = new WP_Query(array(
                    'post_type' => 'service',
                    'posts_per_page' => 6,
                    'orderby' => 'menu_order',
                    'order' => 'ASC'
                ));

                if ( $services_query->have_posts() ) :
                    while ( $services_query->have_posts() ) : $services_query->the_post();
                ?>
                    <a href="<?php the_permalink(); ?>" class="group p-6 rounded-xl glass smooth-hover border border-gray-200 hover:border-blue-300 hover:shadow-xl block">
                        <div class="text-blue-500 mb-4 group-hover:scale-110 smooth-transition">
                            <!-- Fallback icon if no custom field -->
                            <i data-lucide="zap" class="w-8 h-8"></i>
                        </div>
                        <h3 class="font-serif text-xl font-bold text-gray-900 mb-2"><?php the_title(); ?></h3>
                        <div class="text-gray-600 text-sm leading-relaxed line-clamp-3">
                            <?php the_excerpt(); ?>
                        </div>
                    </a>
                <?php 
                    endwhile;
                    wp_reset_postdata();
                else:
                    // Fallback if no services exist yet
                    $services = [
                        ['icon' => 'zap', 'title' => 'Glass Installation', 'desc' => 'Custom glass installations for windows, doors, and architectural elements with precision and durability.', 'link' => '/services#glass'],
                        ['icon' => 'wrench', 'title' => 'Aluminium Work', 'desc' => 'Professional aluminium fabrication, framing, and installation for modern and contemporary designs.', 'link' => '/services#aluminium'],
                        ['icon' => 'award', 'title' => 'Grill Installation', 'desc' => 'Premium grill designs and installations for security and aesthetics. Residential and commercial grade.', 'link' => '/services#grill'],
                    ];
                    foreach ($services as $service) : ?>
                        <a href="<?php echo home_url($service['link']); ?>" class="group p-6 rounded-xl glass smooth-hover border border-gray-200 hover:border-blue-300 hover:shadow-xl block">
                            <div class="text-blue-500 mb-4 group-hover:scale-110 smooth-transition">
                                <i data-lucide="<?php echo $service['icon']; ?>" class="w-8 h-8"></i>
                            </div>
                            <h3 class="font-serif text-xl font-bold text-gray-900 mb-2"><?php echo $service['title']; ?></h3>
                            <p class="text-gray-600 text-sm leading-relaxed"><?php echo $service['desc']; ?></p>
                        </a>
                    <?php endforeach; 
                endif;
                ?>
            </div>

            <div class="text-center mt-12">
                <a href="<?php echo home_url('/services'); ?>" class="px-8 py-4 text-lg font-semibold smooth-transition rounded-full inline-flex items-center justify-center gap-2 bg-blue-500 text-white hover:bg-blue-600 hover:shadow-lg hover:shadow-blue-500/30">
                    Explore All Services <i data-lucide="arrow-right" class="w-5 h-5"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Why Choose Us -->
    <section class="py-20 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <h2 class="font-serif text-4xl font-bold text-gray-900 mb-16 text-center">Why Choose Us</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <?php
                $reasons = [
                    ['title' => 'Expert Craftsmanship', 'desc' => 'Over 15 years of experience in precision glass and aluminium work.'],
                    ['title' => 'Quality Materials', 'desc' => 'Premium grade glass and aluminium sourced from trusted suppliers.'],
                    ['title' => 'On-Time Delivery', 'desc' => 'We respect your time and deliver projects on schedule, every time.'],
                    ['title' => 'Professional Installation', 'desc' => 'Certified installers ensuring perfect fit and finish on every project.'],
                    ['title' => 'Competitive Pricing', 'desc' => 'Best value for money without compromising on quality.'],
                    ['title' => '24/7 Support', 'desc' => 'Round-the-clock customer support for your peace of mind.'],
                ];

                foreach ($reasons as $reason) : ?>
                    <div class="p-6 rounded-xl border border-gray-200 smooth-transition hover:border-blue-300 hover:shadow-lg">
                        <h3 class="font-semibold text-gray-900 mb-2"><?php echo $reason['title']; ?></h3>
                        <p class="text-gray-600 text-sm"><?php echo $reason['desc']; ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 px-4 sm:px-6 lg:px-8 bg-gradient-to-r from-blue-600 to-blue-500">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="font-serif text-4xl font-bold text-white mb-4">Ready to Transform Your Space?</h2>
            <p class="text-blue-100 mb-8 text-lg">Get in touch with our team today for a free consultation and quote.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="https://wa.me/60123456789" class="px-8 py-3 rounded-full bg-white text-blue-600 font-semibold smooth-transition hover:shadow-lg hover:scale-105">
                    Chat on WhatsApp
                </a>
                <a href="<?php echo home_url('/contact'); ?>" class="px-8 py-3 rounded-full border-2 border-white text-white font-semibold smooth-transition hover:bg-white/10">
                    Contact Form
                </a>
            </div>
        </div>
    </section>

    <!-- Testimonials Section with Slider -->
    <section class="py-20 px-4 sm:px-6 lg:px-8 bg-gradient-to-b from-blue-50 to-white">
        <div class="max-w-7xl mx-auto">
            <h2 class="font-serif text-4xl font-bold text-gray-900 mb-4 text-center">Client Testimonials</h2>
            <p class="text-center text-gray-600 mb-16 max-w-2xl mx-auto">
                Hear what our satisfied clients have to say about our premium glass and aluminium solutions.
            </p>

            <div class="relative max-w-4xl mx-auto">
                <?php
                $testimonials_query = new WP_Query(array(
                    'post_type' => 'testimonial',
                    'posts_per_page' => -1,
                    'orderby' => 'date',
                    'order' => 'DESC'
                ));

                if ($testimonials_query->have_posts()) :
                ?>
                    <!-- Slider Container -->
                    <div class="testimonial-slider overflow-hidden">
                        <div class="testimonial-slides flex transition-transform duration-500 ease-in-out">
                            <?php while ($testimonials_query->have_posts()) : $testimonials_query->the_post();
                                $client_name = get_post_meta(get_the_ID(), 'client_name', true) ?: get_the_title();
                                $client_position = get_post_meta(get_the_ID(), 'client_position', true) ?: 'Client';
                                $rating = get_post_meta(get_the_ID(), 'rating', true) ?: 5;
                            ?>
                                <div class="testimonial-slide w-full flex-shrink-0">
                                    <div class="glass rounded-2xl border border-gray-200 p-8 sm:p-12 relative min-h-80">
                                        <div class="text-6xl text-blue-200 opacity-30 absolute top-4 left-6">"</div>
                                        <div class="relative z-10">
                                            <div class="flex gap-1 mb-6">
                                                <?php for($i=0; $i<$rating; $i++): ?>
                                                    <i data-lucide="star" class="w-5 h-5 fill-yellow-400 text-yellow-400"></i>
                                                <?php endfor; ?>
                                            </div>
                                            <div class="text-gray-700 text-lg mb-8 leading-relaxed italic">
                                                <?php the_content(); ?>
                                            </div>
                                            <div class="flex items-center gap-4">
                                                <?php if (has_post_thumbnail()) : ?>
                                                    <?php the_post_thumbnail('thumbnail', array('class' => 'w-12 h-12 rounded-full object-cover')); ?>
                                                <?php else: ?>
                                                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center flex-shrink-0">
                                                        <span class="text-white font-bold"><?php echo strtoupper(substr($client_name, 0, 1)); ?></span>
                                                    </div>
                                                <?php endif; ?>
                                                <div>
                                                    <p class="font-semibold text-gray-900"><?php echo esc_html($client_name); ?></p>
                                                    <p class="text-sm text-gray-600"><?php echo esc_html($client_position); ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    </div>

                    <!-- Slider Controls -->
                    <button id="prev-testimonial" class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-4 w-12 h-12 rounded-full bg-white shadow-lg smooth-transition hover:bg-blue-500 hover:text-white flex items-center justify-center z-10">
                        <i data-lucide="chevron-left" class="w-6 h-6"></i>
                    </button>
                    <button id="next-testimonial" class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-4 w-12 h-12 rounded-full bg-white shadow-lg smooth-transition hover:bg-blue-500 hover:text-white flex items-center justify-center z-10">
                        <i data-lucide="chevron-right" class="w-6 h-6"></i>
                    </button>

                    <!-- Dots Indicator -->
                    <div class="flex justify-center gap-2 mt-8" id="testimonial-dots">
                        <?php 
                        $count = $testimonials_query->post_count;
                        for($i = 0; $i < $count; $i++): 
                        ?>
                            <button class="testimonial-dot w-2 h-2 rounded-full bg-gray-300 smooth-transition hover:bg-blue-500 <?php echo $i === 0 ? 'active bg-blue-500 w-8' : ''; ?>" data-index="<?php echo $i; ?>"></button>
                        <?php endfor; ?>
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const slider = document.querySelector('.testimonial-slides');
                            const slides = document.querySelectorAll('.testimonial-slide');
                            const dots = document.querySelectorAll('.testimonial-dot');
                            const prevBtn = document.getElementById('prev-testimonial');
                            const nextBtn = document.getElementById('next-testimonial');
                            
                            let currentIndex = 0;
                            const totalSlides = slides.length;

                            function goToSlide(index) {
                                currentIndex = (index + totalSlides) % totalSlides;
                                slider.style.transform = `translateX(-${currentIndex * 100}%)`;
                                
                                // Update dots
                                dots.forEach((dot, i) => {
                                    if (i === currentIndex) {
                                        dot.classList.add('active', 'bg-blue-500', 'w-8');
                                        dot.classList.remove('bg-gray-300');
                                    } else {
                                        dot.classList.remove('active', 'bg-blue-500', 'w-8');
                                        dot.classList.add('bg-gray-300');
                                    }
                                });

                                lucide.createIcons();
                            }

                            nextBtn.addEventListener('click', () => goToSlide(currentIndex + 1));
                            prevBtn.addEventListener('click', () => goToSlide(currentIndex - 1));

                            dots.forEach((dot, index) => {
                                dot.addEventListener('click', () => goToSlide(index));
                            });

                            // Auto-play
                            let autoPlayInterval = setInterval(() => goToSlide(currentIndex + 1), 5000);

                            // Pause on hover
                            slider.parentElement.addEventListener('mouseenter', () => clearInterval(autoPlayInterval));
                            slider.parentElement.addEventListener('mouseleave', () => {
                                autoPlayInterval = setInterval(() => goToSlide(currentIndex + 1), 5000);
                            });
                        });
                    </script>
                <?php 
                    wp_reset_postdata();
                else:
                    // Fallback testimonial
                ?>
                    <div class="glass rounded-2xl border border-gray-200 p-8 sm:p-12 relative min-h-80">
                        <div class="text-6xl text-blue-200 opacity-30 absolute top-4 left-6">"</div>
                        <div class="relative z-10">
                            <div class="flex gap-1 mb-6">
                                <?php for($i=0; $i<5; $i++): ?>
                                    <i data-lucide="star" class="w-5 h-5 fill-yellow-400 text-yellow-400"></i>
                                <?php endfor; ?>
                            </div>
                            <p class="text-gray-700 text-lg mb-8 leading-relaxed italic">"Puchong Glass transformed our storefront with a stunning custom glass installation. The team was professional, punctual, and delivered exactly what we envisioned. Highly recommended!"</p>
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex-shrink-0"></div>
                                <div>
                                    <p class="font-semibold text-gray-900">David Tan</p>
                                    <p class="text-sm text-gray-600">Business Owner • Tan Retail Group</p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Stats -->
            <div class="mt-20 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="text-center">
                    <div class="text-3xl font-bold text-blue-600 mb-1">480+</div>
                    <p class="text-gray-600 text-sm">Satisfied Clients</p>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-blue-600 mb-1">4.9/5</div>
                    <p class="text-gray-600 text-sm">Average Rating</p>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-blue-600 mb-1">99%</div>
                    <p class="text-gray-600 text-sm">Repeat Business</p>
                </div>
            </div>
        </div>
    </section>

</main>

<?php get_footer(); ?>
