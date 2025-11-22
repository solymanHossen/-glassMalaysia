<?php
/**
 * Template Name: Contact Page
 */

get_header();
?>

<main class="min-h-screen bg-gradient-to-b from-white to-gray-50">

    <!-- Hero -->
    <section class="pt-32 pb-16 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto text-center">
            <h1 class="font-serif text-5xl sm:text-6xl font-bold text-gray-900 mb-4">
                Get in Touch
            </h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Have a question or ready to start your project? Reach out to our team today.
            </p>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="py-20 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                <!-- Contact Info -->
                <div class="space-y-6">
                    <div>
                        <h3 class="font-serif text-2xl font-bold text-gray-900 mb-6">Contact Information</h3>
                    </div>

                    <div class="glass p-6 rounded-xl border border-gray-200">
                        <div class="flex gap-4">
                            <i data-lucide="phone" class="text-blue-500 w-6 h-6 flex-shrink-0 mt-1"></i>
                            <div>
                                <h4 class="font-semibold text-gray-900 mb-1">Phone</h4>
                                <p class="text-gray-600 text-sm">+60 12-345 6789</p>
                                <p class="text-gray-600 text-sm">+60 12-345 6790</p>
                            </div>
                        </div>
                    </div>

                    <div class="glass p-6 rounded-xl border border-gray-200">
                        <div class="flex gap-4">
                            <i data-lucide="mail" class="text-blue-500 w-6 h-6 flex-shrink-0 mt-1"></i>
                            <div>
                                <h4 class="font-semibold text-gray-900 mb-1">Email</h4>
                                <p class="text-gray-600 text-sm">hello@puchongglass.com</p>
                                <p class="text-gray-600 text-sm">sales@puchongglass.com</p>
                            </div>
                        </div>
                    </div>

                    <div class="glass p-6 rounded-xl border border-gray-200">
                        <div class="flex gap-4">
                            <i data-lucide="map-pin" class="text-blue-500 w-6 h-6 flex-shrink-0 mt-1"></i>
                            <div>
                                <h4 class="font-semibold text-gray-900 mb-1">Location</h4>
                                <p class="text-gray-600 text-sm">Puchong, Selangor 58000</p>
                                <p class="text-gray-600 text-sm">Malaysia</p>
                            </div>
                        </div>
                    </div>

                    <div class="glass p-6 rounded-xl border border-gray-200">
                        <div class="flex gap-4">
                            <i data-lucide="clock" class="text-blue-500 w-6 h-6 flex-shrink-0 mt-1"></i>
                            <div>
                                <h4 class="font-semibold text-gray-900 mb-1">Business Hours</h4>
                                <p class="text-gray-600 text-sm">Mon - Fri: 8:00 AM - 6:00 PM</p>
                                <p class="text-gray-600 text-sm">Sat: 9:00 AM - 3:00 PM</p>
                                <p class="text-gray-600 text-sm">Sun: Closed</p>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div class="pt-4 space-y-2">
                        <a href="https://wa.me/60123456789" class="block w-full px-6 py-3 rounded-lg bg-green-500 text-white font-semibold text-center smooth-transition hover:bg-green-600">
                            Chat on WhatsApp
                        </a>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="lg:col-span-2">
                    <div class="glass p-8 rounded-xl border border-gray-200">
                        <h3 class="font-serif text-2xl font-bold text-gray-900 mb-6">Send us a Message</h3>

                        <?php if (isset($_GET['success']) && $_GET['success'] == '1') : ?>
                            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                                <div class="flex gap-3">
                                    <i data-lucide="check-circle" class="text-green-600 w-5 h-5 flex-shrink-0 mt-0.5"></i>
                                    <div>
                                        <h4 class="font-semibold text-green-900 mb-1">Message Sent Successfully!</h4>
                                        <p class="text-sm text-green-700">Thank you for contacting us. We'll get back to you shortly.</p>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post" class="space-y-4" id="contact-form">
                            <input type="hidden" name="action" value="contact_form">
                            <?php wp_nonce_field('contact_form_submit', 'contact_form_nonce'); ?>
                            
                            <div>
                                <label class="block text-sm font-semibold text-gray-900 mb-2">Full Name *</label>
                                <input type="text" required name="name" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 smooth-transition" placeholder="Your name" />
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-900 mb-2">Email *</label>
                                    <input type="email" required name="email" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 smooth-transition" placeholder="your@email.com" />
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-900 mb-2">Phone *</label>
                                    <input type="tel" required name="phone" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 smooth-transition" placeholder="+60 12-345 6789" />
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-900 mb-2">Service Interest</label>
                                <select name="service" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 smooth-transition">
                                    <option value="">Select a service</option>
                                    <?php
                                    $services_query = new WP_Query(array('post_type' => 'service', 'posts_per_page' => -1));
                                    if ($services_query->have_posts()) :
                                        while ($services_query->have_posts()) : $services_query->the_post();
                                            echo '<option value="' . esc_attr(get_the_title()) . '">' . esc_html(get_the_title()) . '</option>';
                                        endwhile;
                                        wp_reset_postdata();
                                    else:
                                        echo '<option value="Glass Installation">Glass Installation</option>';
                                        echo '<option value="Aluminium Work">Aluminium Work</option>';
                                        echo '<option value="Grill Installation">Grill Installation</option>';
                                        echo '<option value="Other">Other</option>';
                                    endif;
                                    ?>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-900 mb-2">Message *</label>
                                <textarea required name="message" rows="6" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 resize-none smooth-transition" placeholder="Tell us about your project..."></textarea>
                            </div>

                            <button type="submit" class="w-full px-6 py-3 rounded-lg bg-blue-500 text-white font-semibold smooth-transition hover:bg-blue-600 hover:shadow-lg flex items-center justify-center gap-2">
                                <span>Send Message</span>
                                <i data-lucide="send" class="w-5 h-5"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="py-20 px-4 sm:px-6 lg:px-8 bg-white">
        <div class="max-w-7xl mx-auto">
            <h2 class="font-serif text-4xl font-bold text-gray-900 mb-12 text-center">Find Us on the Map</h2>
            <div class="rounded-2xl overflow-hidden border border-gray-200 shadow-lg h-96">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3984.1487169644444!2d101.5753!3d2.9264!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31cdced8c3bf9999%3A0x1234567890!2sPuchong%2C%20Selangor!5e0!3m2!1sen!2smy!4v1234567890" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </section>

</main>

<?php get_footer(); ?>
