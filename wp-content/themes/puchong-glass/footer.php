</main>

<footer class="bg-[#0A2342] text-white pt-16 pb-8 border-t border-white/10">
    <div class="container mx-auto px-4 grid md:grid-cols-4 gap-12 mb-12">
        <div>
            <div class="flex items-center space-x-2 mb-6">
                <div class="w-8 h-8 bg-[#D4AF37] rounded flex items-center justify-center font-bold text-[#0A2342]">P</div>
                <span class="font-bold text-lg uppercase">Puchong Glass</span>
            </div>
            <p class="text-gray-400 text-sm leading-relaxed">Premium glass & aluminium specialists serving Selangor since 2003.</p>
        </div>
        <div>
            <h4 class="font-bold mb-6">Explore</h4>
            <ul class="space-y-3 text-gray-400 text-sm">
                <li><a href="<?php echo home_url(); ?>" class="hover:text-[#D4AF37]">Home</a></li>
                <li><a href="<?php echo home_url('/services'); ?>" class="hover:text-[#D4AF37]">Services</a></li>
                <li><a href="<?php echo home_url('/portfolio'); ?>" class="hover:text-[#D4AF37]">Portfolio</a></li>
                <li><a href="<?php echo home_url('/contact'); ?>" class="hover:text-[#D4AF37]">Contact</a></li>
            </ul>
        </div>
        <div>
            <h4 class="font-bold mb-6">Services</h4>
            <ul class="space-y-3 text-gray-400 text-sm">
                <?php
                $services = new WP_Query( array( 'post_type' => 'service', 'posts_per_page' => 4 ) );
                if ( $services->have_posts() ) :
                    while ( $services->have_posts() ) : $services->the_post();
                        ?>
                        <li><a href="<?php the_permalink(); ?>" class="hover:text-[#D4AF37]"><?php the_title(); ?></a></li>
                        <?php
                    endwhile;
                    wp_reset_postdata();
                endif;
                ?>
            </ul>
        </div>
        <div>
            <h4 class="font-bold mb-6">Contact</h4>
            <ul class="space-y-3 text-gray-400 text-sm">
                <li><i data-lucide="map-pin" class="inline mr-2 text-[#D4AF37] w-4 h-4"></i> Puchong, Selangor</li>
                <li><i data-lucide="phone" class="inline mr-2 text-[#D4AF37] w-4 h-4"></i> +60 12-345 6789</li>
            </ul>
        </div>
    </div>
    <div class="text-center text-xs text-gray-500 border-t border-white/10 pt-8">&copy; <?php echo date('Y'); ?> Puchong Glass Aluminium & Grill. All rights reserved.</div>
</footer>

<!-- Floating Actions -->
<div class="fixed bottom-6 right-6 flex flex-col gap-4 z-40 animate-in">
    <a href="https://wa.me/60123456789" target="_blank" class="w-14 h-14 bg-green-500 rounded-full flex items-center justify-center text-white shadow-lg hover:scale-110 transition-transform hover:shadow-green-500/30 group relative" title="WhatsApp Us">
        <i data-lucide="message-circle" class="w-7 h-7"></i>
        <span class="absolute right-full mr-4 bg-white text-gray-800 px-3 py-1 rounded shadow text-sm font-bold opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap pointer-events-none">Chat Now</span>
    </a>
    <a href="tel:+60123456789" class="w-14 h-14 bg-[#0A2342] rounded-full flex items-center justify-center text-white shadow-lg hover:scale-110 transition-transform hover:shadow-[#0A2342]/40 group relative" title="Call Now">
        <i data-lucide="phone" class="w-6 h-6"></i>
        <span class="absolute right-full mr-4 bg-white text-gray-800 px-3 py-1 rounded shadow text-sm font-bold opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap pointer-events-none">Call Us</span>
    </a>
</div>

<!-- Quote Modal -->
<div id="quote-modal" class="fixed inset-0 z-[60] hidden items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/70 backdrop-blur-sm" onclick="closeQuote()"></div>
    <div class="bg-white rounded-2xl w-full max-w-xl relative z-10 overflow-hidden shadow-2xl flex flex-col max-h-[90vh] animate-in">
        <div class="bg-[#0A2342] p-6 text-white flex justify-between items-center">
            <h3 class="text-xl font-bold">Instant Quote Estimator</h3>
            <button onclick="closeQuote()" class="hover:bg-white/10 p-2 rounded-full"><i data-lucide="x"></i></button>
        </div>
        <div class="p-8 space-y-6 overflow-y-auto" id="quote-step-1">
            <h4 class="font-bold text-[#0A2342]">Select Service</h4>
            <div class="grid grid-cols-2 gap-3" id="quote-services-list">
                <!-- Populated by JS -->
            </div>
            <button onclick="nextQuoteStep()" id="quote-next-btn" disabled class="w-full py-3 bg-[#D4AF37] text-[#0A2342] font-bold rounded disabled:opacity-50 mt-4">Next Step</button>
        </div>
        <div class="p-8 space-y-6 overflow-y-auto hidden" id="quote-step-2">
            <h4 class="font-bold text-[#0A2342]">Dimensions (ft)</h4>
            <div class="flex gap-4">
                <input type="number" id="quote-width" placeholder="Width" class="w-full p-3 border rounded">
                <input type="number" id="quote-height" placeholder="Height" class="w-full p-3 border rounded">
            </div>
            <select id="quote-material" class="w-full p-3 border rounded mt-4">
                <option value="Standard">Standard Grade</option>
                <option value="Premium">Premium Grade</option>
            </select>
            <div class="flex gap-4 mt-6">
                <button onclick="prevQuoteStep()" class="w-1/3 py-3 border font-bold rounded">Back</button>
                <button onclick="calculateQuote()" class="w-2/3 py-3 bg-[#0A2342] text-white font-bold rounded">Calculate</button>
            </div>
        </div>
        <div class="p-8 space-y-6 overflow-y-auto hidden" id="quote-step-3">
            <div class="text-center">
                <div class="text-gray-500 mb-2">Estimated Cost</div>
                <div class="text-5xl font-bold text-[#D4AF37] font-mono-nums mb-6">RM <span id="quote-result">0.00</span></div>
                <button onclick="sendQuoteWhatsapp()" class="w-full py-4 bg-green-500 text-white font-bold rounded flex items-center justify-center gap-2 hover:bg-green-600">
                    <i data-lucide="message-circle"></i> Send to WhatsApp
                </button>
            </div>
        </div>
    </div>
</div>

<?php wp_footer(); ?>
</body>
</html>
