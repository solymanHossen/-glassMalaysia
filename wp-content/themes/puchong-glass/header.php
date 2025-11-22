<!doctype html>
<html <?php language_attributes(); ?> class="scroll-smooth">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
    <meta name="description" content="<?php bloginfo('description'); ?>">
	<?php wp_head(); ?>
</head>

<body <?php body_class( 'font-sans antialiased text-gray-900 bg-gray-50' ); ?>>
<?php wp_body_open(); ?>

<header id="main-header" class="fixed w-full top-0 z-50 glass border-b border-gray-200 transition-all duration-300">
    <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
        <!-- Logo -->
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex items-center gap-2 smooth-transition hover:opacity-75">
            <?php if ( has_custom_logo() ) : ?>
                <?php the_custom_logo(); ?>
            <?php else : ?>
                <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center">
                    <span class="text-white font-bold text-lg">PG</span>
                </div>
                <span class="hidden sm:inline font-serif text-xl font-bold text-gray-900"><?php bloginfo( 'name' ); ?></span>
            <?php endif; ?>
        </a>

        <!-- Desktop Navigation -->
        <div class="hidden md:flex items-center gap-8">
            <?php
            $nav_items = array(
                home_url( '/' ) => __( 'Home', 'puchong-glass' ),
                home_url( '/services/' ) => __( 'Services', 'puchong-glass' ),
                home_url( '/project/' ) => __( 'Portfolio', 'puchong-glass' ),
                home_url( '/about/' ) => __( 'About', 'puchong-glass' ),
                home_url( '/contact/' ) => __( 'Contact', 'puchong-glass' ),
            );
            
            if ( has_nav_menu( 'primary' ) ) {
                wp_nav_menu( array(
                    'theme_location' => 'primary',
                    'container'      => false,
                    'menu_class'     => 'flex items-center gap-8',
                    'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                    'link_before'    => '',
                    'link_after'     => '',
                    'depth'          => 2,
                ) );
            } else {
                foreach ( $nav_items as $url => $label ) {
                    $current_url = esc_url( $_SERVER['REQUEST_URI'] ?? home_url() );
                    $is_active = ( rtrim( $current_url, '/' ) === rtrim( parse_url( $url, PHP_URL_PATH ), '/' ) ) || 
                                 ( is_front_page() && $url === home_url( '/' ) );
                    $active_class = $is_active ? 'text-blue-600 font-semibold' : 'text-gray-700';
                    echo '<a href="' . esc_url( $url ) . '" class="' . esc_attr( $active_class ) . ' text-sm font-medium smooth-transition hover:text-blue-500">' . esc_html( $label ) . '</a>';
                }
            }
            ?>
        </div>

        <!-- CTA Button -->
        <div class="hidden md:flex items-center gap-4">
            <a href="https://wa.me/60123456789" class="px-6 py-2.5 rounded-full bg-blue-500 text-white text-sm font-semibold smooth-transition hover:bg-blue-600 hover:shadow-lg">
                WhatsApp
            </a>
        </div>

        <!-- Mobile Menu Button -->
        <button id="mobile-menu-toggle" class="md:hidden p-2 rounded-lg smooth-transition hover:bg-gray-200" aria-label="Toggle Menu">
            <i data-lucide="menu" class="w-6 h-6"></i>
        </button>
    </nav>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-gray-200 py-4 px-4 absolute w-full shadow-lg">
        <div class="flex flex-col gap-3">
            <?php
            $nav_items = array(
                home_url( '/' ) => __( 'Home', 'puchong-glass' ),
                home_url( '/services/' ) => __( 'Services', 'puchong-glass' ),
                home_url( '/project/' ) => __( 'Portfolio', 'puchong-glass' ),
                home_url( '/about/' ) => __( 'About', 'puchong-glass' ),
                home_url( '/contact/' ) => __( 'Contact', 'puchong-glass' ),
            );
            
            if ( has_nav_menu( 'primary' ) ) {
                wp_nav_menu( array(
                    'theme_location' => 'primary',
                    'container'      => false,
                    'items_wrap'     => '%3$s',
                    'depth'          => 2,
                ) );
            } else {
                foreach ( $nav_items as $url => $label ) {
                    $current_url = esc_url( $_SERVER['REQUEST_URI'] ?? home_url() );
                    $is_active = ( rtrim( $current_url, '/' ) === rtrim( parse_url( $url, PHP_URL_PATH ), '/' ) ) || 
                                 ( is_front_page() && $url === home_url( '/' ) );
                    $active_class = $is_active ? 'text-blue-600 font-semibold bg-blue-50' : 'text-gray-700';
                    echo '<a href="' . esc_url( $url ) . '" class="px-4 py-2 ' . esc_attr( $active_class ) . ' text-sm font-medium smooth-transition hover:text-blue-500 rounded-lg">' . esc_html( $label ) . '</a>';
                }
            }
            ?>
            <a href="https://wa.me/60123456789" class="px-4 py-2 rounded-lg bg-blue-500 text-white text-sm font-semibold text-center smooth-transition hover:bg-blue-600">
                WhatsApp
            </a>
        </div>
    </div>
</header>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mobile Menu Toggle
        const btn = document.getElementById('mobile-menu-toggle');
        const menu = document.getElementById('mobile-menu');
        const icon = btn.querySelector('i');

        btn.addEventListener('click', function() {
            menu.classList.toggle('hidden');
            if (menu.classList.contains('hidden')) {
                icon.setAttribute('data-lucide', 'menu');
            } else {
                icon.setAttribute('data-lucide', 'x');
            }
            lucide.createIcons();
        });

        // Header scroll effect
        const header = document.getElementById('main-header');
        let lastScroll = 0;

        window.addEventListener('scroll', function() {
            const currentScroll = window.pageYOffset;
            
            if (currentScroll > 100) {
                header.classList.add('shadow-lg');
                header.style.backgroundColor = 'rgba(255, 255, 255, 0.95)';
            } else {
                header.classList.remove('shadow-lg');
                header.style.backgroundColor = 'rgba(255, 255, 255, 0.7)';
            }
            
            lastScroll = currentScroll;
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const href = this.getAttribute('href');
                if (href !== '#' && href.length > 1) {
                    e.preventDefault();
                    const target = document.querySelector(href);
                    if (target) {
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
    });
</script>
