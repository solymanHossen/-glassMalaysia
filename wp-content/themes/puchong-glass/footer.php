<footer class="bg-gray-900 text-gray-100 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">
            <!-- Brand -->
            <div>
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex items-center gap-2 mb-4">
                    <div class="w-10 h-10 rounded-lg bg-blue-500 flex items-center justify-center">
                        <span class="text-white font-bold">PG</span>
                    </div>
                    <span class="font-serif text-lg font-bold">Puchong Glass</span>
                </a>
                <p class="text-gray-400 text-sm mb-4">
                    Premium glass, aluminium, and grill solutions for residential and commercial projects.
                </p>
                <div class="flex gap-3">
                    <a href="#" class="w-10 h-10 rounded-lg bg-gray-800 flex items-center justify-center smooth-transition hover:bg-blue-500" aria-label="Facebook">
                        <i data-lucide="facebook" class="w-4 h-4"></i>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-lg bg-gray-800 flex items-center justify-center smooth-transition hover:bg-blue-500" aria-label="Instagram">
                        <i data-lucide="instagram" class="w-4 h-4"></i>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-lg bg-gray-800 flex items-center justify-center smooth-transition hover:bg-blue-500" aria-label="LinkedIn">
                        <i data-lucide="linkedin" class="w-4 h-4"></i>
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h4 class="font-semibold text-white mb-4">Quick Links</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="<?php echo home_url('/'); ?>" class="text-gray-400 smooth-transition hover:text-blue-400">Home</a></li>
                    <li><a href="<?php echo home_url('/services'); ?>" class="text-gray-400 smooth-transition hover:text-blue-400">Services</a></li>
                    <li><a href="<?php echo home_url('/portfolio'); ?>" class="text-gray-400 smooth-transition hover:text-blue-400">Portfolio</a></li>
                    <li><a href="<?php echo home_url('/about'); ?>" class="text-gray-400 smooth-transition hover:text-blue-400">About Us</a></li>
                </ul>
            </div>

            <!-- Services -->
            <div>
                <h4 class="font-semibold text-white mb-4">Services</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="<?php echo home_url('/services#glass'); ?>" class="text-gray-400 smooth-transition hover:text-blue-400">Glass Installation</a></li>
                    <li><a href="<?php echo home_url('/services#aluminium'); ?>" class="text-gray-400 smooth-transition hover:text-blue-400">Aluminium Work</a></li>
                    <li><a href="<?php echo home_url('/services#grill'); ?>" class="text-gray-400 smooth-transition hover:text-blue-400">Grill Installation</a></li>
                    <li><a href="<?php echo home_url('/services#fabrication'); ?>" class="text-gray-400 smooth-transition hover:text-blue-400">Custom Fabrication</a></li>
                </ul>
            </div>

            <!-- Contact -->
            <div>
                <h4 class="font-semibold text-white mb-4">Contact</h4>
                <div class="space-y-3 text-sm">
                    <div class="flex gap-3">
                        <i data-lucide="phone" class="text-blue-400 w-4 h-4 flex-shrink-0 mt-0.5"></i>
                        <span class="text-gray-400">+60 12-345 6789</span>
                    </div>
                    <div class="flex gap-3">
                        <i data-lucide="mail" class="text-blue-400 w-4 h-4 flex-shrink-0 mt-0.5"></i>
                        <span class="text-gray-400">hello@puchongglass.com</span>
                    </div>
                    <div class="flex gap-3">
                        <i data-lucide="map-pin" class="text-blue-400 w-4 h-4 flex-shrink-0 mt-0.5"></i>
                        <span class="text-gray-400">Puchong, Selangor 58000</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Divider -->
        <div class="border-t border-gray-800 pt-8">
            <div class="flex flex-col md:flex-row justify-between items-center text-sm text-gray-400">
                <p>&copy; <?php echo date('Y'); ?> Puchong Glass & Aluminium. All rights reserved.</p>
                <div class="flex gap-6 mt-4 md:mt-0">
                    <a href="#" class="smooth-transition hover:text-blue-400">Privacy Policy</a>
                    <a href="#" class="smooth-transition hover:text-blue-400">Terms of Service</a>
                </div>
            </div>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>

<script>
// Scroll reveal animation
function reveal() {
    const reveals = document.querySelectorAll('.reveal');
    
    reveals.forEach(element => {
        const windowHeight = window.innerHeight;
        const elementTop = element.getBoundingClientRect().top;
        const elementVisible = 150;
        
        if (elementTop < windowHeight - elementVisible) {
            element.classList.add('active');
        }
    });
}

window.addEventListener('scroll', reveal);
reveal(); // Check on load

// Form submission handling
const contactForm = document.getElementById('contact-form');
if (contactForm) {
    contactForm.addEventListener('submit', function(e) {
        const button = this.querySelector('button[type="submit"]');
        button.classList.add('loading');
        button.disabled = true;
    });
}

// Add intersection observer for animations
if ('IntersectionObserver' in window) {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, {
        threshold: 0.1,
        rootMargin: '0px 0px -100px 0px'
    });

    document.querySelectorAll('.glass, .interactive-card').forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        el.style.transition = 'opacity 0.6s ease-out, transform 0.6s ease-out';
        observer.observe(el);
    });
}

// Back to top button
const backToTop = document.createElement('button');
backToTop.innerHTML = '<i data-lucide="arrow-up" class="w-5 h-5"></i>';
backToTop.className = 'fixed bottom-8 right-8 w-12 h-12 rounded-full bg-blue-500 text-white shadow-lg smooth-transition hover:bg-blue-600 hover:shadow-xl z-40 hidden items-center justify-center';
backToTop.setAttribute('aria-label', 'Back to top');
document.body.appendChild(backToTop);

window.addEventListener('scroll', function() {
    if (window.pageYOffset > 300) {
        backToTop.classList.remove('hidden');
        backToTop.classList.add('flex');
    } else {
        backToTop.classList.add('hidden');
        backToTop.classList.remove('flex');
    }
});

backToTop.addEventListener('click', function() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
});

// Initialize Lucide icons after dynamic content
if (typeof lucide !== 'undefined') {
    lucide.createIcons();
}
</script>
</body>
</html>
