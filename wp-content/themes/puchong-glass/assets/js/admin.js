/**
 * Puchong Glass Admin Panel JavaScript
 * Modern, functional admin panel system
 * 
 * @package Puchong_Glass
 * @version 2.0.0
 */

document.addEventListener( 'DOMContentLoaded', function() {
	// Initialize Lucide icons
	if ( typeof lucide !== 'undefined' ) {
		lucide.createIcons();
	}

	/**
	 * Mobile Menu Toggle
	 */
	const btn = document.getElementById( 'mobile-menu-toggle' );
	const menu = document.getElementById( 'mobile-menu' );
	
	if ( btn && menu ) {
		const icon = btn.querySelector( 'i' );

		btn.addEventListener( 'click', function() {
			menu.classList.toggle( 'hidden' );
			if ( menu.classList.contains( 'hidden' ) ) {
				icon.setAttribute( 'data-lucide', 'menu' );
			} else {
				icon.setAttribute( 'data-lucide', 'x' );
			}
			if ( typeof lucide !== 'undefined' ) {
				lucide.createIcons();
			}
		});
	}

	/**
	 * Header scroll effect
	 */
	const header = document.getElementById( 'main-header' );
	if ( header ) {
		let lastScroll = 0;

		window.addEventListener( 'scroll', function() {
			const currentScroll = window.pageYOffset;
			
			if ( currentScroll > 100 ) {
				header.classList.add( 'shadow-lg' );
				header.style.backgroundColor = 'rgba(255, 255, 255, 0.95)';
			} else {
				header.classList.remove( 'shadow-lg' );
				header.style.backgroundColor = 'rgba(255, 255, 255, 0.7)';
			}
			
			lastScroll = currentScroll;
		});
	}

	/**
	 * Smooth scroll for anchor links
	 */
	document.querySelectorAll( 'a[href^="#"]' ).forEach( function( anchor ) {
		anchor.addEventListener( 'click', function( e ) {
			const href = this.getAttribute( 'href' );
			if ( href !== '#' && href.length > 1 ) {
				e.preventDefault();
				const target = document.querySelector( href );
				if ( target ) {
					const headerOffset = 80;
					const elementPosition = target.getBoundingClientRect().top;
					const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

					window.scrollTo({
						top: offsetPosition,
						behavior: 'smooth'
					});
				}
			}
		});
	});

	/**
	 * Contact Form Handling
	 */
	const contactForm = document.getElementById( 'contact-form' );
	if ( contactForm ) {
		contactForm.addEventListener( 'submit', function( e ) {
			// Form validation happens server-side for security
			// Show loading state
			const submitBtn = this.querySelector( 'button[type="submit"]' );
			if ( submitBtn ) {
				const originalText = submitBtn.textContent;
				submitBtn.disabled = true;
				submitBtn.textContent = 'Sending...';

				// Reset after submission
				setTimeout( function() {
					submitBtn.disabled = false;
					submitBtn.textContent = originalText;
				}, 3000 );
			}
		});
	}

	/**
	 * Table Row Filtering
	 */
	const searchInputs = document.querySelectorAll( 'input[type="search"]' );
	searchInputs.forEach( function( input ) {
		input.addEventListener( 'input', function() {
			const query = this.value.toLowerCase();
			const table = this.closest( 'form' )?.querySelector( 'table' );
			
			if ( table ) {
				const rows = table.querySelectorAll( 'tbody tr' );
				rows.forEach( function( row ) {
					const text = row.textContent.toLowerCase();
					row.style.display = text.includes( query ) ? '' : 'none';
				});
			}
		});
	});

	/**
	 * Delete Confirmation
	 */
	const deleteButtons = document.querySelectorAll( 'button[name="action"][value="delete"]' );
	deleteButtons.forEach( function( btn ) {
		btn.addEventListener( 'click', function( e ) {
			if ( ! confirm( 'Are you sure you want to delete this contact?' ) ) {
				e.preventDefault();
			}
		});
	});

	/**
	 * Export Functionality
	 */
	const exportBtn = document.querySelector( 'a[href*="action=export"]' );
	if ( exportBtn ) {
		exportBtn.addEventListener( 'click', function( e ) {
			// Show loading state
			this.disabled = true;
			const originalText = this.textContent;
			this.textContent = 'Exporting...';

			// Reset after a moment
			setTimeout( function() {
				exportBtn.disabled = false;
				exportBtn.textContent = originalText;
			}, 2000 );
		});
	}

	/**
	 * Reveal Animation on Scroll
	 */
	const reveals = document.querySelectorAll( '.reveal' );
	if ( reveals.length > 0 && typeof IntersectionObserver !== 'undefined' ) {
		const observer = new IntersectionObserver( function( entries ) {
			entries.forEach( function( entry ) {
				if ( entry.isIntersecting ) {
					entry.target.classList.add( 'active' );
					observer.unobserve( entry.target );
				}
			});
		}, {
			threshold: 0.1,
			rootMargin: '0px 0px -100px 0px'
		});

		reveals.forEach( function( reveal ) {
			observer.observe( reveal );
		});
	}

	/**
	 * Form Validation
	 */
	const forms = document.querySelectorAll( 'form' );
	forms.forEach( function( form ) {
		form.addEventListener( 'submit', function( e ) {
			const inputs = form.querySelectorAll( '[required]' );
			let isValid = true;

			inputs.forEach( function( input ) {
				if ( ! input.value.trim() ) {
					input.classList.add( 'border-red-500' );
					isValid = false;
				} else {
					input.classList.remove( 'border-red-500' );
				}
			});

			if ( ! isValid ) {
				e.preventDefault();
				// Show error message
				const errorDiv = document.createElement( 'div' );
				errorDiv.className = 'mb-4 p-4 bg-red-50 border border-red-200 rounded-lg text-red-800';
				errorDiv.textContent = 'Please fill in all required fields.';
				form.insertBefore( errorDiv, form.firstChild );

				// Remove error after 5 seconds
				setTimeout( function() {
					errorDiv.remove();
				}, 5000 );
			}
		});
	});

	/**
	 * Tooltip Functionality
	 */
	const tooltips = document.querySelectorAll( '[data-tooltip]' );
	tooltips.forEach( function( element ) {
		element.addEventListener( 'mouseenter', function() {
			const tooltip = document.createElement( 'div' );
			tooltip.className = 'absolute bg-gray-900 text-white px-2 py-1 rounded text-xs whitespace-nowrap z-50';
			tooltip.textContent = this.getAttribute( 'data-tooltip' );
			
			// Position tooltip
			const rect = this.getBoundingClientRect();
			tooltip.style.top = ( rect.top - 30 ) + 'px';
			tooltip.style.left = ( rect.left + rect.width / 2 ) + 'px';
			tooltip.style.transform = 'translateX(-50%)';

			document.body.appendChild( tooltip );

			element.addEventListener( 'mouseleave', function() {
				tooltip.remove();
			}, { once: true });
		});
	});

	/**
	 * Copy to Clipboard Functionality
	 */
	const copyButtons = document.querySelectorAll( '[data-copy]' );
	copyButtons.forEach( function( btn ) {
		btn.addEventListener( 'click', function( e ) {
			e.preventDefault();
			const text = this.getAttribute( 'data-copy' );
			
			navigator.clipboard.writeText( text ).then( function() {
				// Show success feedback
				const originalText = btn.textContent;
				btn.textContent = 'Copied!';
				setTimeout( function() {
					btn.textContent = originalText;
				}, 2000 );
			});
		});
	});

	/**
	 * AJAX Contact Form Submission (if needed)
	 */
	if ( typeof puchongGlass !== 'undefined' ) {
		window.submitContactFormAjax = function( form ) {
			const formData = new FormData( form );
			
			fetch( puchongGlass.ajaxUrl, {
				method: 'POST',
				body: formData
			})
			.then( function( response ) {
				return response.json();
			})
			.then( function( data ) {
				if ( data.success ) {
					// Show success message
					const successDiv = document.createElement( 'div' );
					successDiv.className = 'mb-4 p-4 bg-green-50 border border-green-200 rounded-lg text-green-800';
					successDiv.textContent = 'Thank you! Your message has been sent successfully.';
					form.insertBefore( successDiv, form.firstChild );

					// Reset form
					form.reset();

					// Remove message after 5 seconds
					setTimeout( function() {
						successDiv.remove();
					}, 5000 );
				} else {
					// Show error message
					const errorDiv = document.createElement( 'div' );
					errorDiv.className = 'mb-4 p-4 bg-red-50 border border-red-200 rounded-lg text-red-800';
					errorDiv.textContent = data.message || 'An error occurred. Please try again.';
					form.insertBefore( errorDiv, form.firstChild );

					// Remove message after 5 seconds
					setTimeout( function() {
						errorDiv.remove();
					}, 5000 );
				}
			})
			.catch( function( error ) {
				console.error( 'Error:', error );
				const errorDiv = document.createElement( 'div' );
				errorDiv.className = 'mb-4 p-4 bg-red-50 border border-red-200 rounded-lg text-red-800';
				errorDiv.textContent = 'An error occurred. Please try again.';
				form.insertBefore( errorDiv, form.firstChild );

				setTimeout( function() {
					errorDiv.remove();
				}, 5000 );
			});

			return false;
		};
	}

	/**
	 * Print Page Functionality
	 */
	const printButtons = document.querySelectorAll( '[data-print]' );
	printButtons.forEach( function( btn ) {
		btn.addEventListener( 'click', function( e ) {
			e.preventDefault();
			window.print();
		});
	});

	/**
	 * Back to Top Button
	 */
	const backToTopBtn = document.getElementById( 'back-to-top' );
	if ( backToTopBtn ) {
		window.addEventListener( 'scroll', function() {
			if ( window.pageYOffset > 300 ) {
				backToTopBtn.classList.remove( 'hidden' );
			} else {
				backToTopBtn.classList.add( 'hidden' );
			}
		});

		backToTopBtn.addEventListener( 'click', function( e ) {
			e.preventDefault();
			window.scrollTo({
				top: 0,
				behavior: 'smooth'
			});
		});
	}

	/**
	 * Loading States
	 */
	const loadingElements = document.querySelectorAll( '.loading' );
	if ( loadingElements.length > 0 ) {
		// Simulate loading completion after 3 seconds
		setTimeout( function() {
			loadingElements.forEach( function( element ) {
				element.classList.remove( 'loading' );
			});
		}, 3000 );
	}
});
