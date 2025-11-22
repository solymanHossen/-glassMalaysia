/**
 * Puchong Glass - Main JavaScript
 * Senior engineer level implementation
 */

(function() {
	'use strict';

	/**
	 * Mobile Menu Handler
	 */
	class MobileMenuHandler {
		constructor() {
			this.toggle = document.getElementById('mobile-menu-toggle');
			this.menu = document.getElementById('mobile-menu');
			this.init();
		}

		init() {
			if (!this.toggle || !this.menu) return;

			this.toggle.addEventListener('click', (e) => {
				e.preventDefault();
				this.toggle();
			});

			// Close on link click
			this.menu.querySelectorAll('a').forEach(link => {
				link.addEventListener('click', () => {
					this.close();
				});
			});

			// Close on escape key
			document.addEventListener('keydown', (e) => {
				if (e.key === 'Escape') {
					this.close();
				}
			});
		}

		toggle() {
			this.menu.classList.toggle('hidden');
			const icon = this.toggle.querySelector('i');
			if (icon) {
				icon.setAttribute('data-lucide', this.menu.classList.contains('hidden') ? 'menu' : 'x');
				if (typeof lucide !== 'undefined') {
					lucide.createIcons();
				}
			}
		}

		close() {
			this.menu.classList.add('hidden');
			const icon = this.toggle.querySelector('i');
			if (icon) {
				icon.setAttribute('data-lucide', 'menu');
				if (typeof lucide !== 'undefined') {
					lucide.createIcons();
				}
			}
		}
	}

	/**
	 * Scroll Reveal Animation
	 */
	class ScrollReveal {
		constructor() {
			this.elements = document.querySelectorAll('[data-reveal]');
			if (this.elements.length === 0) return;

			if ('IntersectionObserver' in window) {
				this.initObserver();
			} else {
				this.revealAll();
			}
		}

		initObserver() {
			const observer = new IntersectionObserver(
				(entries) => {
					entries.forEach(entry => {
						if (entry.isIntersecting) {
							entry.target.classList.add('active');
							observer.unobserve(entry.target);
						}
					});
				},
				{
					threshold: 0.1,
					rootMargin: '0px 0px -100px 0px'
				}
			);

			this.elements.forEach(el => {
				observer.observe(el);
			});
		}

		revealAll() {
			this.elements.forEach(el => {
				el.classList.add('active');
			});
		}
	}

	/**
	 * Testimonial Slider
	 */
	class TestimonialSlider {
		constructor() {
			this.slider = document.querySelector('.testimonial-slider');
			this.slides = document.querySelectorAll('.testimonial-slide');
			this.dots = document.querySelectorAll('.testimonial-dot');
			this.prevBtn = document.getElementById('prev-testimonial');
			this.nextBtn = document.getElementById('next-testimonial');

			if (!this.slider || this.slides.length === 0) return;

			this.currentIndex = 0;
			this.autoPlayInterval = null;
			this.init();
		}

		init() {
			if (this.prevBtn) {
				this.prevBtn.addEventListener('click', () => this.goToSlide(this.currentIndex - 1));
			}

			if (this.nextBtn) {
				this.nextBtn.addEventListener('click', () => this.goToSlide(this.currentIndex + 1));
			}

			this.dots.forEach((dot, index) => {
				dot.addEventListener('click', () => this.goToSlide(index));
			});

			this.startAutoPlay();

			// Pause on hover
			if (this.slider.parentElement) {
				this.slider.parentElement.addEventListener('mouseenter', () => this.stopAutoPlay());
				this.slider.parentElement.addEventListener('mouseleave', () => this.startAutoPlay());
			}
		}

		goToSlide(index) {
			const totalSlides = this.slides.length;
			this.currentIndex = ((index % totalSlides) + totalSlides) % totalSlides;

			this.slides.forEach((slide, i) => {
				slide.style.transform = i === this.currentIndex ? 'translateX(0)' : `translateX(${(i - this.currentIndex) * 100}%)`;
			});

			this.updateDots();

			if (typeof lucide !== 'undefined') {
				lucide.createIcons();
			}
		}

		updateDots() {
			this.dots.forEach((dot, i) => {
				if (i === this.currentIndex) {
					dot.classList.add('active', 'bg-blue-500', 'w-8');
					dot.classList.remove('bg-gray-300');
				} else {
					dot.classList.remove('active', 'bg-blue-500', 'w-8');
					dot.classList.add('bg-gray-300');
				}
			});
		}

		startAutoPlay() {
			this.autoPlayInterval = setInterval(() => {
				this.goToSlide(this.currentIndex + 1);
			}, 5000);
		}

		stopAutoPlay() {
			if (this.autoPlayInterval) {
				clearInterval(this.autoPlayInterval);
			}
		}
	}

	/**
	 * Smooth Scroll for Anchor Links
	 */
	class SmoothScroll {
		constructor() {
			this.init();
		}

		init() {
			document.querySelectorAll('a[href^="#"]').forEach(anchor => {
				anchor.addEventListener('click', (e) => {
					const href = anchor.getAttribute('href');
					if (href !== '#' && href.length > 1) {
						e.preventDefault();
						const target = document.querySelector(href);
						if (target) {
							this.scrollToElement(target);
						}
					}
				});
			});
		}

		scrollToElement(element) {
			const headerHeight = 80;
			const elementPosition = element.getBoundingClientRect().top;
			const offsetPosition = elementPosition + window.pageYOffset - headerHeight;

			window.scrollTo({
				top: offsetPosition,
				behavior: 'smooth'
			});
		}
	}

	/**
	 * Back to Top Button
	 */
	class BackToTop {
		constructor() {
			this.button = this.createButton();
			this.init();
		}

		createButton() {
			const btn = document.createElement('button');
			btn.innerHTML = '<i data-lucide="arrow-up" class="w-5 h-5"></i>';
			btn.className = 'fixed bottom-8 right-8 w-12 h-12 rounded-full bg-blue-500 text-white shadow-lg smooth-transition hover:bg-blue-600 hover:shadow-xl z-40 hidden items-center justify-center focus:outline-none focus:ring-2 focus:ring-blue-600';
			btn.setAttribute('aria-label', 'Back to top');
			document.body.appendChild(btn);
			return btn;
		}

		init() {
			window.addEventListener('scroll', () => this.updateVisibility());
			this.button.addEventListener('click', () => this.scrollToTop());
		}

		updateVisibility() {
			if (window.pageYOffset > 300) {
				this.button.classList.remove('hidden');
				this.button.classList.add('flex');
			} else {
				this.button.classList.add('hidden');
				this.button.classList.remove('flex');
			}
		}

		scrollToTop() {
			window.scrollTo({
				top: 0,
				behavior: 'smooth'
			});
		}
	}

	/**
	 * Form Handler with Validation
	 */
	class FormHandler {
		constructor() {
			this.forms = document.querySelectorAll('[data-form-validate]');
			this.init();
		}

		init() {
			this.forms.forEach(form => {
				form.addEventListener('submit', (e) => this.handleSubmit(e, form));
			});
		}

		handleSubmit(e, form) {
			if (!this.validate(form)) {
				e.preventDefault();
			}
		}

		validate(form) {
			const inputs = form.querySelectorAll('[required]');
			let isValid = true;

			inputs.forEach(input => {
				if (!input.value.trim()) {
					isValid = false;
					this.showError(input, 'This field is required');
				} else {
					this.clearError(input);
				}

				// Email validation
				if (input.type === 'email' && input.value) {
					if (!this.isValidEmail(input.value)) {
						isValid = false;
						this.showError(input, 'Please enter a valid email');
					} else {
						this.clearError(input);
					}
				}
			});

			return isValid;
		}

		isValidEmail(email) {
			const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
			return emailRegex.test(email);
		}

		showError(input, message) {
			input.classList.add('border-red-500');
			let errorEl = input.nextElementSibling;
			if (!errorEl || !errorEl.classList.contains('error-message')) {
				errorEl = document.createElement('p');
				errorEl.className = 'error-message text-red-500 text-sm mt-1';
				input.parentNode.insertBefore(errorEl, input.nextSibling);
			}
			errorEl.textContent = message;
		}

		clearError(input) {
			input.classList.remove('border-red-500');
			const errorEl = input.nextElementSibling;
			if (errorEl && errorEl.classList.contains('error-message')) {
				errorEl.remove();
			}
		}
	}

	/**
	 * Initialize all components when DOM is ready
	 */
	document.addEventListener('DOMContentLoaded', function() {
		// Initialize all components
		new MobileMenuHandler();
		new ScrollReveal();
		new TestimonialSlider();
		new SmoothScroll();
		new BackToTop();
		new FormHandler();

		// Initialize Lucide icons
		if (typeof lucide !== 'undefined') {
			lucide.createIcons();
		}

		// Observe image loading
		observeImages();
	});

	/**
	 * Lazy load images
	 */
	function observeImages() {
		if ('IntersectionObserver' in window) {
			const imageObserver = new IntersectionObserver((entries) => {
				entries.forEach(entry => {
					if (entry.isIntersecting) {
						const img = entry.target;
						if (img.dataset.src) {
							img.src = img.dataset.src;
							img.removeAttribute('data-src');
						}
						imageObserver.unobserve(img);
					}
				});
			});

			document.querySelectorAll('img[data-src]').forEach(img => {
				imageObserver.observe(img);
			});
		}
	}

	// Export for testing
	if (typeof window !== 'undefined') {
		window.PuchongGlass = {
			MobileMenuHandler,
			ScrollReveal,
			TestimonialSlider,
			SmoothScroll,
			BackToTop,
			FormHandler
		};
	}
})();
