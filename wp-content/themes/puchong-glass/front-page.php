<?php get_header(); ?>

<div class="animate-in">
    <!-- Hero -->
    <section class="relative min-h-[90vh] flex items-center pt-20 overflow-hidden">
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1613545325278-f24b0cae1224?auto=format&fit=crop&q=80&w=2000" alt="Modern House" class="w-full h-full object-cover" />
            <div class="absolute inset-0 bg-gradient-to-r from-[#0A2342]/95 via-[#0A2342]/70 to-transparent"></div>
        </div>
        <div class="container mx-auto px-4 relative z-10 grid md:grid-cols-2 gap-12 items-center">
            <div class="space-y-8 animate-slide-up">
                <div class="inline-block px-4 py-1 rounded-full bg-[#D4AF37]/20 border border-[#D4AF37]/50 text-[#D4AF37] text-sm font-bold tracking-wider">PREMIUM GLASS SPECIALISTS</div>
                <h1 class="text-5xl md:text-7xl font-bold text-white leading-tight">Clear Vision. <br/><span class="text-transparent bg-clip-text bg-gradient-to-r from-[#D4AF37] to-[#F4E5C2]">Solid Protection.</span></h1>
                <p class="text-lg text-gray-300 max-w-lg leading-relaxed">From elegant shower screens to commercial shopfronts – we deliver excellence in every installation across Puchong & Selangor.</p>
                <div class="flex flex-wrap gap-4 pt-4">
                    <button onclick="openQuote()" class="px-8 py-4 bg-[#D4AF37] hover:bg-[#b8962e] text-[#0A2342] font-bold rounded-lg shadow-[0_0_20px_rgba(212,175,55,0.3)] transition-all hover:scale-105 flex items-center gap-2">
                        Get Free Quote <i data-lucide="arrow-right" class="w-5 h-5"></i>
                    </button>
                    <a href="<?php echo home_url('/portfolio'); ?>" class="px-8 py-4 glass-panel text-white font-bold rounded-lg hover:bg-white/10 transition-all flex items-center">
                        <i data-lucide="play" class="w-5 h-5 mr-2 fill-white"></i> View Projects
                    </a>
                </div>
                <div class="flex items-center gap-6 pt-8 text-sm text-gray-400 font-mono-nums">
                    <div class="flex items-center gap-2"><i data-lucide="star" class="text-[#D4AF37] fill-[#D4AF37] w-4 h-4"></i><span>4.9/5 Rating</span></div>
                    <div class="w-px h-4 bg-gray-600"></div><div>5000+ Projects</div><div class="w-px h-4 bg-gray-600"></div><div>20+ Years Exp.</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Services -->
    <section class="py-20 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12 animate-in">
                <h4 class="font-bold tracking-widest text-sm mb-2 text-[#0A2342]">OUR EXPERTISE</h4>
                <h2 class="text-3xl md:text-5xl font-bold text-[#0A2342]">Premium Services</h2>
                <div class="w-20 h-1 mx-auto mt-4 rounded bg-[#0A2342]"></div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <?php
                $services = new WP_Query( array( 'post_type' => 'service', 'posts_per_page' => 3 ) );
                if ( $services->have_posts() ) :
                    while ( $services->have_posts() ) : $services->the_post();
                        $icon = get_post_meta( get_the_ID(), '_pg_icon', true ) ?: 'Shield';
                        ?>
                        <div onclick="window.location.href='<?php the_permalink(); ?>'" class="bg-white rounded-2xl p-8 shadow-sm hover:shadow-xl transition-all cursor-pointer group border border-gray-100">
                            <div class="w-14 h-14 bg-[#0A2342]/5 rounded-xl flex items-center justify-center text-[#0A2342] mb-6 group-hover:bg-[#0A2342] group-hover:text-[#D4AF37] transition-colors">
                                <i data-lucide="<?php echo strtolower($icon); ?>"></i>
                            </div>
                            <h3 class="text-xl font-bold text-[#0A2342] mb-3"><?php the_title(); ?></h3>
                            <p class="text-gray-600 mb-6 line-clamp-2"><?php echo get_the_excerpt(); ?></p>
                            <span class="text-[#D4AF37] font-bold text-sm flex items-center group-hover:translate-x-2 transition-transform">Learn More <i data-lucide="chevron-right" class="w-4 h-4 ml-1"></i></span>
                        </div>
                        <?php
                    endwhile;
                    wp_reset_postdata();
                else:
                    echo '<p class="text-center col-span-3">No services found. Please add some in the backend.</p>';
                endif;
                ?>
            </div>
            <div class="text-center mt-12">
                <a href="<?php echo home_url('/services'); ?>" class="px-8 py-3 border-2 border-[#0A2342] text-[#0A2342] font-bold rounded-lg hover:bg-[#0A2342] hover:text-white transition-all inline-block">View All Services</a>
            </div>
        </div>
    </section>

    <!-- Safety Standard -->
    <section id="safety" class="py-16 bg-[#0A2342] relative overflow-hidden">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-10"></div>
        <div class="container mx-auto px-6 relative z-10">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <div>
                    <div class="text-left mb-8 animate-in">
                        <h4 class="font-bold tracking-widest text-sm mb-2 text-[#D4AF37]">SAFETY STANDARD</h4>
                        <h2 class="text-3xl md:text-5xl font-bold text-white">Fortress Grade Security</h2>
                        <div class="w-20 h-1 mt-4 rounded bg-[#D4AF37]"></div>
                    </div>
                    <p class="text-gray-400 mb-8 leading-relaxed">
                        Your home shouldn't just look good; it must be impenetrable. Our security grills and doors are engineered using high-tensile aluminium alloys and heavy-duty deadbolts.
                    </p>
               
                    <div class="space-y-6">
                        <?php
                        $features = [
                            [ "title" => "Impact Resistant", "desc" => "Tested against blunt force to prevent forced entry." ],
                            [ "title" => "Anti-Pry Locking", "desc" => "Multi-point locking mechanisms for maximum security." ],
                            [ "title" => "Rust Proof Warranty", "desc" => "Powder-coated finishes that withstand Malaysian humidity." ]
                        ];
                        foreach($features as $item):
                        ?>
                        <div class="flex gap-4 p-4 rounded-xl bg-white/5 border border-white/10 hover:border-[#D4AF37]/50 transition-colors">
                            <div class="bg-[#D4AF37]/10 p-3 rounded-lg h-fit">
                                <i data-lucide="lock" class="w-6 h-6 text-[#D4AF37]"></i>
                            </div>
                            <div>
                                <h4 class="text-white font-bold mb-1"><?php echo esc_html($item['title']); ?></h4>
                                <p class="text-sm text-gray-400"><?php echo esc_html($item['desc']); ?></p>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
             
                <div class="relative">
                    <div class="absolute inset-0 bg-[#D4AF37] rounded-full blur-[150px] opacity-10"></div>
                    <div class="relative rounded-2xl overflow-hidden border-2 border-white/10 shadow-2xl">
                        <img src="https://images.unsplash.com/photo-1618219944342-824e40a13285?q=80&w=2574&auto=format&fit=crop" alt="Security Door Detail" class="w-full h-[500px] object-cover" />
                        <div class="absolute bottom-0 inset-x-0 bg-[#0A2342]/90 backdrop-blur p-6 text-center border-t border-white/10">
                            <p class="text-[#D4AF37] font-mono text-sm font-bold">CERTIFIED SAFETY GRADE A</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
  <!-- Before/After -->
    <section id="projects" class="md:py-24 py-12 bg-slate-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12 animate-in">
                <h4 class="font-bold tracking-widest text-sm mb-2 text-[#D4AF37]">VISUAL PROOF</h4>
                <h2 class="text-3xl md:text-5xl font-bold text-[#0A2342]">The Transformation</h2>
                <div class="w-20 h-1 mx-auto mt-4 rounded bg-[#0A2342]"></div>
            </div>

            <div class="w-full  mx-auto my-12 select-none" id="before-after-container">
                <div class="text-center mb-6">
                    <span class="text-slate-500 text-sm font-mono uppercase tracking-wider flex items-center justify-center gap-2">
                        <i data-lucide="layout-grid" class="w-4 h-4"></i> Drag slider to compare
                    </span>
                </div>
                <div 
                    class="relative w-full h-[300px] md:h-[500px] rounded-2xl overflow-hidden cursor-ew-resize shadow-2xl border-4 border-white ring-1 ring-slate-200"
                    id="before-after-slider"
                >
                    <!-- Finished Image (Background) -->
                    <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1600607686527-6fb886090705?q=80&w=2000&auto=format&fit=crop')">
                        <div class="absolute top-4 right-4 bg-amber-500/90 backdrop-blur text-slate-900 px-4 py-1 rounded font-bold text-xs shadow-lg">FINISHED</div>
                    </div>
                    
                    <!-- Construction Image (Foreground with Clip Path) -->
                    <div 
                        class="absolute inset-0 bg-cover bg-center"
                        id="before-image-wrapper"
                        style="background-image: url('https://images.unsplash.com/photo-1504307651254-35680f356dfd?q=80&w=2000&auto=format&fit=crop'); clip-path: inset(0 50% 0 0);"
                    >
                        <div class="absolute top-4 left-4 bg-slate-900/80 backdrop-blur text-white px-4 py-1 rounded font-bold text-xs border border-slate-700 shadow-lg">CONSTRUCTION</div>
                    </div>
                    
                    <!-- Handle -->
                    <div class="absolute top-0 bottom-0 w-1 bg-amber-500 cursor-ew-resize z-10 shadow-[0_0_20px_rgba(245,158,11,0.8)]" id="slider-handle" style="left: 50%">
                        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-12 h-12 bg-slate-900 border-2 border-amber-500 rounded-full flex items-center justify-center shadow-xl">
                            <i data-lucide="maximize-2" class="w-5 h-5 text-amber-500"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Testimonials -->
    <section class="md:py-24 py-12 bg-[#0A2342] relative overflow-hidden">
        <!-- Decorative Background Elements -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none">
            <div class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-[#D4AF37] rounded-full mix-blend-overlay filter blur-[100px] opacity-5"></div>
            <div class="absolute bottom-[-10%] right-[-10%] w-96 h-96 bg-[#1E5A8E] rounded-full mix-blend-overlay filter blur-[100px] opacity-10"></div>
        </div>

        <div class="container mx-auto px-4 relative z-10">
            <div class="text-center mb-16 animate-in">
                <h4 class="font-bold tracking-widest text-sm mb-3 text-[#D4AF37] uppercase">Client Stories</h4>
                <h2 class="text-4xl md:text-6xl font-bold text-white mb-6">Trusted by Neighbors</h2>
                <div class="w-24 h-1.5 mx-auto rounded-full bg-[#D4AF37]"></div>
            </div>
            
            <div class="relative" id="testimonial-slider-container">
                <!-- Navigation Buttons -->
                <button id="prev-testimonial" class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-2 md:-translate-x-12 z-20 bg-[#1E3A5F] text-white p-3 rounded-full shadow-lg border border-white/10 hover:bg-[#D4AF37] hover:text-[#0A2342] transition-all disabled:opacity-30 disabled:cursor-not-allowed">
                    <i data-lucide="chevron-left" class="w-6 h-6"></i>
                </button>
                <button id="next-testimonial" class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-2 md:translate-x-12 z-20 bg-[#1E3A5F] text-white p-3 rounded-full shadow-lg border border-white/10 hover:bg-[#D4AF37] hover:text-[#0A2342] transition-all disabled:opacity-30 disabled:cursor-not-allowed">
                    <i data-lucide="chevron-right" class="w-6 h-6"></i>
                </button>

                <div class="overflow-hidden px-4 py-8 -mx-4">
                    <div class="flex transition-transform duration-500 ease-in-out" id="testimonial-track">
                        <?php
                        $testimonials = new WP_Query( array( 'post_type' => 'testimonial', 'posts_per_page' => 6 ) );
                        if ( $testimonials->have_posts() ) :
                            while ( $testimonials->have_posts() ) : $testimonials->the_post();
                                $role = get_post_meta( get_the_ID(), '_pg_role', true );
                                $rating = get_post_meta( get_the_ID(), '_pg_rating', true ) ?: 5;
                                $img_url = get_the_post_thumbnail_url( get_the_ID(), 'thumbnail' ) ?: 'https://ui-avatars.com/api/?name=' . urlencode(get_the_title()) . '&background=random';
                                ?>
                                <div class="w-full md:w-1/3 flex-shrink-0 px-4 testimonial-slide">
                                    <div class="bg-[#112B4D]/50 backdrop-blur-sm p-8 rounded-2xl relative group border border-white/10 h-full flex flex-col">
                                        <!-- Quote Icon -->
                                        <div class="absolute top-8 right-8 text-[#D4AF37]/20">
                                            <i data-lucide="quote" class="w-12 h-12 fill-current"></i>
                                        </div>

                                        <!-- Stars -->
                                        <div class="flex gap-1 mb-6">
                                            <?php for($i=0; $i<$rating; $i++): ?>
                                                <i data-lucide="star" class="w-5 h-5 text-[#D4AF37] fill-[#D4AF37]"></i>
                                            <?php endfor; ?>
                                        </div>

                                        <!-- Text -->
                                        <p class="text-gray-300 mb-8 leading-relaxed relative z-10 text-lg">"<?php echo get_the_content(); ?>"</p>

                                        <!-- Author -->
                                        <div class="flex items-center gap-4 border-t border-white/10 pt-6 mt-auto relative">
                                            <img src="<?php echo esc_url($img_url); ?>" alt="<?php the_title(); ?>" class="w-14 h-14 rounded-full object-cover border-2 border-[#D4AF37]/50" />
                                            <div>
                                                <h5 class="text-white font-bold text-lg"><?php the_title(); ?></h5>
                                                <p class="text-xs text-[#D4AF37] uppercase tracking-wider font-bold"><?php echo esc_html($role); ?></p>
                                            </div>
                                            
                                            <!-- Verified Badge -->
                                            <div class="absolute bottom-0 right-0 flex items-center gap-1 text-[10px] text-green-400 bg-green-400/10 px-3 py-1 rounded-full border border-green-400/20">
                                                <i data-lucide="check" class="w-3 h-3"></i> Verified Project
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            endwhile;
                            wp_reset_postdata();
                        else:
                            echo '<p class="text-gray-400 text-center w-full">No testimonials found.</p>';
                        endif;
                        ?>
                    </div>
                </div>
                
                <!-- Dots -->
                <div class="flex justify-center gap-2 mt-8" id="testimonial-dots">
                    <!-- JS will populate dots -->
                </div>
            </div>
            
            <div class="mt-20 text-center">
                <div class="inline-flex items-center gap-8 text-gray-300 text-sm font-mono-nums bg-[#112B4D] border border-white/10 px-10 py-5 rounded-full shadow-2xl">
                    <div class="flex flex-col md:flex-row items-center gap-3">
                        <span class="text-3xl font-bold text-white">4.9</span>
                        <span class="uppercase tracking-wider text-xs font-bold">Average Rating</span>
                    </div>
                    <div class="w-px h-10 bg-white/10"></div>
                    <div class="flex flex-col md:flex-row items-center gap-3">
                        <span class="text-3xl font-bold text-white">500+</span>
                        <span class="uppercase tracking-wider text-xs font-bold">5-Star Reviews</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

  

    <!-- Location -->
    <section id="location" class="py-0 bg-slate-900 relative">
        <div class="h-[500px] w-full relative filter grayscale contrast-125 hover:filter-none transition-all duration-700 group">
            <!-- Google Map Iframe -->
            <iframe 
                title="Master Home Services Location"
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3984.146627842453!2d101.5933243758562!3d3.0554063537251226!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31cc4b4117755555%3A0x78961234567890!2sPuchong%2C%20Selangor!5e0!3m2!1sen!2smy!4v1708500000000!5m2!1sen!2smy" 
                width="100%" 
                height="100%" 
                style="border: 0;" 
                allowfullscreen="" 
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
                class="w-full h-full bg-slate-800 map-filter"
            ></iframe>
          
            <!-- Floating Location Card -->
            <div class="absolute top-1/2 left-6 right-6 md:left-auto md:right-24 md:w-96 -translate-y-1/2 bg-slate-900/90 backdrop-blur-xl p-8 rounded-2xl border border-slate-700 shadow-2xl z-10">
                <h3 class="text-2xl font-bold text-white mb-6">Visit the Factory</h3>
                
                <div class="space-y-6">
                    <div class="flex items-start gap-4">
                        <i data-lucide="map-pin" class="w-6 h-6 text-amber-500 flex-shrink-0 mt-1"></i>
                        <div>
                            <p class="text-slate-300 font-medium">Lot 13, Bt 13, Jalan Jurutera</p>
                            <p class="text-slate-500 text-sm">Kampung Seri Aman, 47100 Puchong</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start gap-4">
                        <i data-lucide="phone" class="w-6 h-6 text-amber-500 flex-shrink-0 mt-1"></i>
                        <div>
                            <p class="text-slate-300 font-medium">+60 11-2447 4500</p>
                            <p class="text-slate-500 text-sm">Mon-Sat, 9am - 6pm</p>
                        </div>
                    </div>
                </div>

                <button class="w-full mt-8 px-6 py-3 bg-[#D4AF37] hover:bg-[#b8962e] text-[#0A2342] font-bold rounded-lg transition-all" onclick="window.open('https://waze.com/ul?q=Puchong', '_blank')">
                    Navigate with Waze
                </button>
            </div>
        </div>
    </section>
</div>

<?php get_footer(); ?>
