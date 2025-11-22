<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#0A2342',
                        'primary-light': '#1E5A8E',
                        accent: '#D4AF37',
                        'accent-light': '#F4E5C2',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        display: ['Sora', 'sans-serif'],
                        mono: ['Space Grotesk', 'monospace'],
                    }
                }
            }
        }
    </script>
</head>
<body <?php body_class( 'bg-white text-gray-800 font-sans' ); ?>>

<nav class="fixed w-full z-50 bg-[#0A2342]/95 backdrop-blur shadow-lg py-4 transition-all">
    <div class="container mx-auto px-4 flex justify-between items-center">
        <a href="<?php echo home_url(); ?>" class="flex items-center space-x-2 text-white cursor-pointer">
            <div class="w-10 h-10 bg-[#D4AF37] rounded flex items-center justify-center font-bold text-[#0A2342] text-xl">P</div>
            <div class="leading-tight">
                <h1 class="font-bold text-lg uppercase tracking-wide">Puchong Glass</h1>
                <p class="text-[10px] text-gray-300 tracking-wider">ALUMINIUM & GRILL</p>
            </div>
        </a>
        
        <div class="hidden md:flex space-x-8 text-sm font-medium text-white/90">
            <?php
            wp_nav_menu( array(
                'theme_location' => 'primary',
                'container' => false,
                'menu_class' => 'flex space-x-8',
                'items_wrap' => '%3$s',
                'link_before' => '',
                'link_after' => '',
                'walker' => new Walker_Nav_Menu(), // Default walker is fine, we just need classes
                // We might need a custom walker to add specific classes or just use JS to add classes
            ) );
            ?>
            <!-- Hardcoded links if menu not set, matching React structure -->
            <?php if ( ! has_nav_menu( 'primary' ) ) : ?>
                <a href="<?php echo home_url(); ?>" class="hover:text-[#D4AF37] transition-colors uppercase tracking-wider">Home</a>
                <a href="<?php echo home_url('/services'); ?>" class="hover:text-[#D4AF37] transition-colors uppercase tracking-wider">Services</a>
                <a href="<?php echo home_url('/portfolio'); ?>" class="hover:text-[#D4AF37] transition-colors uppercase tracking-wider">Portfolio</a>
                <a href="<?php echo home_url('/visualizer'); ?>" class="hover:text-[#D4AF37] transition-colors uppercase tracking-wider">3D Preview</a>
                <a href="<?php echo home_url('/contact'); ?>" class="hover:text-[#D4AF37] transition-colors uppercase tracking-wider">Contact</a>
            <?php endif; ?>
        </div>

        <div class="flex items-center gap-4">
            <button onclick="openQuote()" class="hidden md:flex px-5 py-2 bg-[#D4AF37] hover:bg-[#b8962e] text-[#0A2342] font-bold rounded transition-transform hover:scale-105 items-center">Get Quote</button>
            <button class="md:hidden text-white" id="mobile-menu-btn">
                <i data-lucide="menu"></i>
            </button>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden absolute top-full left-0 w-full bg-[#0A2342] border-t border-white/10 p-6 flex flex-col space-y-4 md:hidden shadow-xl animate-in">
        <a href="<?php echo home_url(); ?>" class="text-white text-lg py-3 border-b border-white/5 text-left">Home</a>
        <a href="<?php echo home_url('/services'); ?>" class="text-white text-lg py-3 border-b border-white/5 text-left">Services</a>
        <a href="<?php echo home_url('/portfolio'); ?>" class="text-white text-lg py-3 border-b border-white/5 text-left">Portfolio</a>
        <a href="<?php echo home_url('/visualizer'); ?>" class="text-white text-lg py-3 border-b border-white/5 text-left">3D Preview</a>
        <a href="<?php echo home_url('/contact'); ?>" class="text-white text-lg py-3 border-b border-white/5 text-left">Contact</a>
        <button onclick="openQuote()" class="w-full py-4 bg-[#D4AF37] text-[#0A2342] font-bold rounded mt-2">Get Instant Quote</button>
    </div>
</nav>
<main class="flex-grow min-h-screen bg-white pt-20">
