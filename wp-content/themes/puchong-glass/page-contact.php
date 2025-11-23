<?php
/* Template Name: Contact Page */
get_header();
?>

<div class="pt-24 pb-20 animate-in bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12 animate-in">
            <h4 class="font-bold tracking-widest text-sm mb-2 text-[#0A2342]">GET IN TOUCH</h4>
            <h2 class="text-3xl md:text-5xl font-bold text-[#0A2342]">Start Your Project</h2>
            <div class="w-20 h-1 mx-auto mt-4 rounded bg-[#0A2342]"></div>
        </div>
        
        <div class="grid lg:grid-cols-5 gap-8 lg:gap-12">
            
            <!-- LEFT COLUMN: CONTACT FORM -->
            <div class="lg:col-span-2 order-2 lg:order-1">
                <div class="bg-white p-8 rounded-3xl shadow-xl border border-gray-100 h-full flex flex-col relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-[#D4AF37]/10 rounded-bl-full -mr-8 -mt-8"></div>
                    
                    <h3 class="text-2xl font-bold text-[#0A2342] mb-2">Send a Message</h3>
                    <p class="text-gray-500 mb-8">Fill out the form below and our team will get back to you within 24 hours.</p>
                    
                    <div id="pg-form-message" style="display: none;" class="mb-4 p-4 rounded-xl"></div>
                    
                    <form id="pg-contact-form" class="space-y-5 flex-grow">
                        <div>
                            <label class="text-xs font-bold text-[#0A2342] uppercase tracking-wider mb-1 block">Full Name</label>
                            <input type="text" name="name" id="pg-name" placeholder="e.g. John Doe" class="w-full p-4 bg-gray-50 rounded-xl border-transparent focus:bg-white focus:border-[#D4AF37] focus:ring-0 transition-all outline-none font-medium" required />
                        </div>
                        
                        <div>
                            <label class="text-xs font-bold text-[#0A2342] uppercase tracking-wider mb-1 block">Phone Number</label>
                            <input type="tel" name="phone" id="pg-phone" placeholder="+60 12-345 6789" class="w-full p-4 bg-gray-50 rounded-xl border-transparent focus:bg-white focus:border-[#D4AF37] focus:ring-0 transition-all outline-none font-medium" required />
                        </div>
                        
                        <div>
                            <label class="text-xs font-bold text-[#0A2342] uppercase tracking-wider mb-1 block">Email Address</label>
                            <input type="email" name="email" id="pg-email" placeholder="name@example.com" class="w-full p-4 bg-gray-50 rounded-xl border-transparent focus:bg-white focus:border-[#D4AF37] focus:ring-0 transition-all outline-none font-medium" required />
                        </div>
                        
                        <div>
                            <label class="text-xs font-bold text-[#0A2342] uppercase tracking-wider mb-1 block">Message</label>
                            <textarea name="message" id="pg-message" rows="4" placeholder="Tell us about your renovation needs..." class="w-full p-4 bg-gray-50 rounded-xl border-transparent focus:bg-white focus:border-[#D4AF37] focus:ring-0 transition-all outline-none font-medium resize-none" required></textarea>
                        </div>
                        
                        <button type="submit" id="pg-submit-btn" class="w-full py-4 bg-[#0A2342] text-white font-bold rounded-xl hover:bg-[#1E5A8E] transition-all shadow-lg hover:shadow-[#0A2342]/30 flex items-center justify-center group">
                            <span id="pg-btn-text">Send Message</span>
                            <i data-lucide="arrow-right" class="ml-2 group-hover:translate-x-1 transition-transform w-4 h-4" id="pg-btn-icon"></i>
                        </button>
                    </form>
                    
                    <script>
                    jQuery(document).ready(function($) {
                        $('#pg-contact-form').on('submit', function(e) {
                            e.preventDefault();
                            
                            var form = $(this);
                            var submitBtn = $('#pg-submit-btn');
                            var btnText = $('#pg-btn-text');
                            var btnIcon = $('#pg-btn-icon');
                            var messageDiv = $('#pg-form-message');
                            
                            // Disable form
                            submitBtn.prop('disabled', true);
                            btnText.text('Sending...');
                            btnIcon.hide();
                            
                            // Prepare data
                            var formData = {
                                action: 'pg_contact_form',
                                nonce: '<?php echo wp_create_nonce( "pg_contact_form" ); ?>',
                                name: $('#pg-name').val(),
                                phone: $('#pg-phone').val(),
                                email: $('#pg-email').val(),
                                message: $('#pg-message').val()
                            };
                            
                            // Send AJAX request
                            $.post('<?php echo admin_url( "admin-ajax.php" ); ?>', formData, function(response) {
                                if (response.success) {
                                    messageDiv.removeClass('bg-red-100 text-red-700')
                                             .addClass('bg-green-100 text-green-700')
                                             .html('✓ ' + response.data.message)
                                             .fadeIn();
                                    form[0].reset();
                                } else {
                                    messageDiv.removeClass('bg-green-100 text-green-700')
                                             .addClass('bg-red-100 text-red-700')
                                             .html('✗ ' + response.data.message)
                                             .fadeIn();
                                }
                                
                                // Re-enable form
                                submitBtn.prop('disabled', false);
                                btnText.text('Send Message');
                                btnIcon.show();
                                
                                // Hide message after 5 seconds
                                setTimeout(function() {
                                    messageDiv.fadeOut();
                                }, 5000);
                            });
                        });
                    });
                    </script>
                </div>
            </div>

            <!-- RIGHT COLUMN: MAP & INFO -->
            <div class="lg:col-span-3 order-1 lg:order-2 flex flex-col gap-6">
                
                <!-- INFO CARDS -->
                <div class="grid md:grid-cols-3 gap-4">
                    <div class="bg-[#0A2342] text-white p-6 rounded-2xl shadow-lg flex flex-col items-center text-center hover:-translate-y-1 transition-transform duration-300 cursor-default">
                        <div class="w-12 h-12 bg-[#D4AF37] rounded-full flex items-center justify-center text-[#0A2342] mb-4 shadow-[0_0_15px_rgba(212,175,55,0.4)]">
                            <i data-lucide="phone" class="w-6 h-6"></i>
                        </div>
                        <h4 class="font-bold text-lg mb-1">Call Us</h4>
                        <p class="text-[#D4AF37] font-mono-nums font-bold text-lg">+60 12-345 6789</p>
                        <p class="text-gray-400 text-xs mt-1">Mon-Sat, 9am-6pm</p>
                    </div>

                    <div onclick="window.open('https://wa.me/60123456789', '_blank')" class="bg-white p-6 rounded-2xl shadow-md border border-gray-100 flex flex-col items-center text-center hover:-translate-y-1 transition-transform duration-300 cursor-pointer group">
                        <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center text-[#0A2342] mb-4 group-hover:bg-[#0A2342] group-hover:text-[#D4AF37] transition-colors">
                            <i data-lucide="message-circle" class="w-6 h-6"></i>
                        </div>
                        <h4 class="font-bold text-[#0A2342] text-lg mb-1">WhatsApp</h4>
                        <p class="text-gray-600">Fast Response</p>
                        <span class="text-[#0A2342] text-xs mt-2 font-bold border-b border-[#D4AF37]">Chat Now</span>
                    </div>

                    <div onclick="window.open('https://maps.google.com?q=Puchong+Glass+Aluminium', '_blank')" class="bg-white p-6 rounded-2xl shadow-md border border-gray-100 flex flex-col items-center text-center hover:-translate-y-1 transition-transform duration-300 cursor-pointer group">
                        <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center text-[#0A2342] mb-4 group-hover:bg-[#0A2342] group-hover:text-[#D4AF37] transition-colors">
                            <i data-lucide="map-pin" class="w-6 h-6"></i>
                        </div>
                        <h4 class="font-bold text-[#0A2342] text-lg mb-1">Showroom</h4>
                        <p class="text-gray-600 text-sm">Taman Perindustrian Puchong</p>
                        <span class="text-[#0A2342] text-xs mt-2 font-bold border-b border-[#D4AF37]">View on Map</span>
                    </div>
                </div>

                <!-- MAP CONTAINER -->
                <div id="map" class="relative flex-grow min-h-[450px] rounded-3xl overflow-hidden shadow-2xl border-4 border-white group">
                    <!-- Google Map Iframe - pointing to Puchong Glass coordinates -->
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3984.086362837956!2d101.5832606!3d2.9913691!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31cdb3b2e9ade33b%3A0x47f0779bbd297c10!2sPuchong%20Glass%20Aluminium%20and%20Grill!5e0!3m2!1sen!2smy!4v1700000000000!5m2!1sen!2smy" 
                        width="100%" 
                        height="100%" 
                        style="border: 0; filter: grayscale(10%) contrast(1.1);" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade"
                        class="group-hover:filter-none transition-all duration-700"
                        title="Google Map Location"
                    ></iframe>

                    <!-- Map Overlay Badge -->
                    <div class="absolute bottom-6 left-6 bg-white/95 backdrop-blur-md p-4 rounded-xl shadow-xl max-w-xs animate-in border border-gray-100">
                        <div class="flex items-start gap-3">
                            <div class="bg-[#0A2342] p-2.5 rounded-lg text-[#D4AF37] shrink-0">
                                <i data-lucide="map-pin" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <p class="font-bold text-[#0A2342] text-sm leading-tight mb-1">Puchong Glass Aluminium & Grill</p>
                                <p class="text-[11px] text-gray-500 leading-relaxed">No. 15, Jalan TPP 1/3, Taman Perindustrian Puchong, 47100 Selangor.</p>
                                <button onclick="window.open('https://maps.google.com?q=Puchong+Glass+Aluminium', '_blank')" class="text-[10px] font-bold text-[#D4AF37] mt-2 uppercase tracking-wide flex items-center hover:underline">
                                    Get Directions <i data-lucide="chevron-right" class="w-3 h-3 ml-1"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
