<?php

function pg_seed_content() {
    // Only run if triggered by admin to avoid accidental runs
    if ( ! isset( $_GET['pg_seed'] ) || $_GET['pg_seed'] !== 'true' || ! current_user_can( 'manage_options' ) ) {
        return;
    }

    // 1. Seed Services
    $services = array(
        array(
            'title' => 'Tempered Glass Shower Screens',
            'content' => 'Upgrade your bathroom with our premium tempered glass shower screens. Custom-made to fit any space, our screens offer both safety and elegance. We use high-quality 10mm or 12mm tempered glass that is 5 times stronger than regular glass.',
            'icon' => 'Droplets',
            'benefits' => array( 'Easy to clean coating', 'Safety tempered glass', 'Custom sizes available', 'Modern frameless design' ),
            'specs' => array( 'Thickness: 10mm / 12mm', 'Material: Grade A Tempered Glass', 'Hardware: Stainless Steel 304', 'Warranty: 5 Years against leakage' )
        ),
        array(
            'title' => 'Aluminium Bi-Fold Doors',
            'content' => 'Transform your living space with our heavy-duty aluminium bi-fold doors. Perfect for connecting indoor and outdoor areas, these doors fold away neatly to create a seamless transition. Available in various powder-coated colors to match your home.',
            'icon' => 'DoorOpen',
            'benefits' => array( 'Space saving design', 'Smooth gliding mechanism', 'Weather and sound proof', 'High security multi-point locking' ),
            'specs' => array( 'Frame: 2.0mm Aluminium Profile', 'Glass: 6.38mm Laminated / Double Glazed', 'Rollers: Heavy Duty Nylon', 'Finish: Powder Coated' )
        ),
        array(
            'title' => 'Glass Railings & Balustrades',
            'content' => 'Secure your balcony or staircase without blocking the view. Our glass railings provide a modern, minimalist look while meeting all safety building codes. We offer frameless, semi-frameless, and stainless steel post options.',
            'icon' => 'Shield',
            'benefits' => array( 'Unobstructed panoramic views', 'Child-safe design', 'Durable and weather resistant', 'Adds value to property' ),
            'specs' => array( 'Glass: 12mm / 15mm Toughened', 'Height: 1000mm (Standard)', 'Fixing: Stainless Steel 316 Spigots', 'Handrail: Optional' )
        ),
        array(
            'title' => 'Commercial Shopfronts',
            'content' => 'Make a great first impression with a modern glass shopfront. We specialize in frameless glass entrances, automatic doors, and aluminium composite panel cladding for businesses in Puchong and Selangor.',
            'icon' => 'Store',
            'benefits' => array( 'Maximum visibility for products', 'Professional corporate image', 'Durable high-traffic doors', 'Energy efficient options' ),
            'specs' => array( 'Glass: 12mm Tempered', 'Door: Floor Spring / Automatic', 'Frame: 100mm x 44mm Aluminium', 'Security: Deadlocks included' )
        ),
        array(
            'title' => 'Skylights & Glass Roofs',
            'content' => 'Bring natural light into your home with our custom glass skylights. Perfect for patios, kitchens, and courtyards. We use laminated safety glass to ensure protection from UV rays and falling objects.',
            'icon' => 'Sun',
            'benefits' => array( 'Natural lighting reduces energy bills', 'UV protection layer', 'Leak-proof guarantee', 'Reduces heat transmission' ),
            'specs' => array( 'Glass: 10.38mm Laminated Safety Glass', 'Structure: Galvanized Steel / Aluminium', 'Waterproofing: Industrial Grade Sealant', 'Tint: Clear / Green / Grey' )
        ),
        array(
            'title' => 'Mirrors & Wall Cladding',
            'content' => 'Create the illusion of space with our custom cut mirrors. Ideal for gyms, dance studios, and feature walls. We also offer colored glass wall cladding (glass whiteboards) for offices and kitchens.',
            'icon' => 'Maximize',
            'benefits' => array( 'Custom shapes and sizes', 'Polished edges for safety', 'Moisture resistant backing', 'Available in bronze/grey tint' ),
            'specs' => array( 'Thickness: 6mm', 'Type: Copper-free Mirror', 'Installation: Glue / Clips', 'Edge: Flat Polish / Beveled' )
        )
    );

    foreach ( $services as $service ) {
        if ( ! get_page_by_title( $service['title'], OBJECT, 'service' ) ) {
            $post_id = wp_insert_post( array(
                'post_title'   => $service['title'],
                'post_content' => $service['content'],
                'post_status'  => 'publish',
                'post_type'    => 'service',
            ) );

            if ( $post_id ) {
                update_post_meta( $post_id, '_pg_icon', $service['icon'] );
                update_post_meta( $post_id, '_pg_benefits', $service['benefits'] );
                update_post_meta( $post_id, '_pg_specs', $service['specs'] );
                // Set a random featured image from Unsplash
                // In a real scenario, we would upload images. Here we can't easily.
            }
        }
    }

    // 2. Seed Portfolio
    $projects = array(
        array(
            'title' => 'Modern Bungalow Renovation',
            'category' => 'Residential',
            'location' => 'Puchong Utama',
            'year' => '2023',
            'challenge' => 'The client wanted to replace old wooden window frames that were rotting and leaking water, while maximizing natural light.',
            'solution' => 'We installed high-performance powder-coated aluminium windows with double glazing. We also replaced the main entrance with a grand pivot glass door.',
            'content' => 'Full renovation of window and door systems for a double-storey bungalow.'
        ),
        array(
            'title' => 'Tech Office Partitions',
            'category' => 'Commercial',
            'location' => 'Cyberjaya',
            'year' => '2024',
            'challenge' => 'An open-plan office needed quiet meeting rooms and executive offices without blocking the flow of light or making the space feel small.',
            'solution' => 'We designed and installed floor-to-ceiling frameless glass partitions with frosted privacy bands. We used heavy-duty hydraulic patch fittings for the doors.',
            'content' => 'Installation of 150ft of glass partitioning.'
        ),
        array(
            'title' => 'Luxury Condo Balcony',
            'category' => 'Residential',
            'location' => 'Mont Kiara',
            'year' => '2023',
            'challenge' => 'The existing iron railings were rusting and blocking the spectacular city view.',
            'solution' => 'We removed the old railings and installed 12mm tempered glass balustrades using stainless steel spigots. The result is a safe, invisible barrier that preserves the view.',
            'content' => 'Balcony upgrade for a penthouse unit.'
        ),
        array(
            'title' => 'Retail Showroom Front',
            'category' => 'Commercial',
            'location' => 'Sunway Pyramid',
            'year' => '2022',
            'challenge' => 'A fashion retailer needed a wide, inviting entrance that could handle high foot traffic.',
            'solution' => 'We installed a 12ft high frameless glass shopfront with automatic sliding doors. The glass is 12mm thick for safety and security.',
            'content' => 'Shopfront installation for a boutique.'
        )
    );

    foreach ( $projects as $project ) {
        if ( ! get_page_by_title( $project['title'], OBJECT, 'portfolio' ) ) {
            $post_id = wp_insert_post( array(
                'post_title'   => $project['title'],
                'post_content' => $project['content'],
                'post_status'  => 'publish',
                'post_type'    => 'portfolio',
            ) );

            if ( $post_id ) {
                update_post_meta( $post_id, '_pg_location', $project['location'] );
                update_post_meta( $post_id, '_pg_year', $project['year'] );
                update_post_meta( $post_id, '_pg_challenge', $project['challenge'] );
                update_post_meta( $post_id, '_pg_solution', $project['solution'] );
                
                wp_set_object_terms( $post_id, $project['category'], 'portfolio_category' );
            }
        }
    }

    // 3. Seed Pages
    $pages = array(
        'Contact' => 'page-contact.php',
        'Visualizer' => 'page-visualizer.php', // Assuming this template exists or will exist
        'Services' => '', // Archive page usually, but can be a page
        'Portfolio' => ''
    );

    foreach ( $pages as $title => $template ) {
        if ( ! get_page_by_title( $title ) ) {
            $post_id = wp_insert_post( array(
                'post_title'   => $title,
                'post_content' => '',
                'post_status'  => 'publish',
                'post_type'    => 'page',
            ) );

            if ( $post_id && ! empty( $template ) ) {
                update_post_meta( $post_id, '_wp_page_template', $template );
            }
        }
    }

    echo '<div class="notice notice-success is-dismissible"><p>Content seeded successfully!</p></div>';
}
add_action( 'admin_init', 'pg_seed_content' );

if ( defined( 'WP_CLI' ) && WP_CLI ) {
    WP_CLI::add_command( 'pg seed', function() {
        // Mock GET for the function or just extract logic. 
        // For simplicity, let's just bypass the check by setting the flag
        $_GET['pg_seed'] = 'true';
        // Mock capability check or ensure we run as admin user
        // Actually, let's just copy the logic or make the function accept a force param.
        
        // Better: Refactor pg_seed_content to accept a force argument.
        pg_seed_content_logic();
        WP_CLI::success( 'Content seeded successfully!' );
    });
}

function pg_seed_content_logic() {
    // 1. Seed Services
    $services = array(
        array(
            'title' => 'Tempered Glass Shower Screens',
            'content' => 'Upgrade your bathroom with our premium tempered glass shower screens. Custom-made to fit any space, our screens offer both safety and elegance. We use high-quality 10mm or 12mm tempered glass that is 5 times stronger than regular glass.',
            'icon' => 'Droplets',
            'benefits' => array( 'Easy to clean coating', 'Safety tempered glass', 'Custom sizes available', 'Modern frameless design' ),
            'specs' => array( 'Thickness: 10mm / 12mm', 'Material: Grade A Tempered Glass', 'Hardware: Stainless Steel 304', 'Warranty: 5 Years against leakage' )
        ),
        array(
            'title' => 'Aluminium Bi-Fold Doors',
            'content' => 'Transform your living space with our heavy-duty aluminium bi-fold doors. Perfect for connecting indoor and outdoor areas, these doors fold away neatly to create a seamless transition. Available in various powder-coated colors to match your home.',
            'icon' => 'DoorOpen',
            'benefits' => array( 'Space saving design', 'Smooth gliding mechanism', 'Weather and sound proof', 'High security multi-point locking' ),
            'specs' => array( 'Frame: 2.0mm Aluminium Profile', 'Glass: 6.38mm Laminated / Double Glazed', 'Rollers: Heavy Duty Nylon', 'Finish: Powder Coated' )
        ),
        array(
            'title' => 'Glass Railings & Balustrades',
            'content' => 'Secure your balcony or staircase without blocking the view. Our glass railings provide a modern, minimalist look while meeting all safety building codes. We offer frameless, semi-frameless, and stainless steel post options.',
            'icon' => 'Shield',
            'benefits' => array( 'Unobstructed panoramic views', 'Child-safe design', 'Durable and weather resistant', 'Adds value to property' ),
            'specs' => array( 'Glass: 12mm / 15mm Toughened', 'Height: 1000mm (Standard)', 'Fixing: Stainless Steel 316 Spigots', 'Handrail: Optional' )
        ),
        array(
            'title' => 'Commercial Shopfronts',
            'content' => 'Make a great first impression with a modern glass shopfront. We specialize in frameless glass entrances, automatic doors, and aluminium composite panel cladding for businesses in Puchong and Selangor.',
            'icon' => 'Store',
            'benefits' => array( 'Maximum visibility for products', 'Professional corporate image', 'Durable high-traffic doors', 'Energy efficient options' ),
            'specs' => array( 'Glass: 12mm Tempered', 'Door: Floor Spring / Automatic', 'Frame: 100mm x 44mm Aluminium', 'Security: Deadlocks included' )
        ),
        array(
            'title' => 'Skylights & Glass Roofs',
            'content' => 'Bring natural light into your home with our custom glass skylights. Perfect for patios, kitchens, and courtyards. We use laminated safety glass to ensure protection from UV rays and falling objects.',
            'icon' => 'Sun',
            'benefits' => array( 'Natural lighting reduces energy bills', 'UV protection layer', 'Leak-proof guarantee', 'Reduces heat transmission' ),
            'specs' => array( 'Glass: 10.38mm Laminated Safety Glass', 'Structure: Galvanized Steel / Aluminium', 'Waterproofing: Industrial Grade Sealant', 'Tint: Clear / Green / Grey' )
        ),
        array(
            'title' => 'Mirrors & Wall Cladding',
            'content' => 'Create the illusion of space with our custom cut mirrors. Ideal for gyms, dance studios, and feature walls. We also offer colored glass wall cladding (glass whiteboards) for offices and kitchens.',
            'icon' => 'Maximize',
            'benefits' => array( 'Custom shapes and sizes', 'Polished edges for safety', 'Moisture resistant backing', 'Available in bronze/grey tint' ),
            'specs' => array( 'Thickness: 6mm', 'Type: Copper-free Mirror', 'Installation: Glue / Clips', 'Edge: Flat Polish / Beveled' )
        )
    );

    foreach ( $services as $service ) {
        if ( ! get_page_by_title( $service['title'], OBJECT, 'service' ) ) {
            $post_id = wp_insert_post( array(
                'post_title'   => $service['title'],
                'post_content' => $service['content'],
                'post_status'  => 'publish',
                'post_type'    => 'service',
            ) );

            if ( $post_id ) {
                update_post_meta( $post_id, '_pg_icon', $service['icon'] );
                update_post_meta( $post_id, '_pg_benefits', $service['benefits'] );
                update_post_meta( $post_id, '_pg_specs', $service['specs'] );
            }
        }
    }

    // 2. Seed Portfolio
    $projects = array(
        array(
            'title' => 'Modern Bungalow Renovation',
            'category' => 'Residential',
            'location' => 'Puchong Utama',
            'year' => '2023',
            'challenge' => 'The client wanted to replace old wooden window frames that were rotting and leaking water, while maximizing natural light.',
            'solution' => 'We installed high-performance powder-coated aluminium windows with double glazing. We also replaced the main entrance with a grand pivot glass door.',
            'content' => 'Full renovation of window and door systems for a double-storey bungalow.'
        ),
        array(
            'title' => 'Tech Office Partitions',
            'category' => 'Commercial',
            'location' => 'Cyberjaya',
            'year' => '2024',
            'challenge' => 'An open-plan office needed quiet meeting rooms and executive offices without blocking the flow of light or making the space feel small.',
            'solution' => 'We designed and installed floor-to-ceiling frameless glass partitions with frosted privacy bands. We used heavy-duty hydraulic patch fittings for the doors.',
            'content' => 'Installation of 150ft of glass partitioning.'
        ),
        array(
            'title' => 'Luxury Condo Balcony',
            'category' => 'Residential',
            'location' => 'Mont Kiara',
            'year' => '2023',
            'challenge' => 'The existing iron railings were rusting and blocking the spectacular city view.',
            'solution' => 'We removed the old railings and installed 12mm tempered glass balustrades using stainless steel spigots. The result is a safe, invisible barrier that preserves the view.',
            'content' => 'Balcony upgrade for a penthouse unit.'
        ),
        array(
            'title' => 'Retail Showroom Front',
            'category' => 'Commercial',
            'location' => 'Sunway Pyramid',
            'year' => '2022',
            'challenge' => 'A fashion retailer needed a wide, inviting entrance that could handle high foot traffic.',
            'solution' => 'We installed a 12ft high frameless glass shopfront with automatic sliding doors. The glass is 12mm thick for safety and security.',
            'content' => 'Shopfront installation for a boutique.'
        )
    );

    foreach ( $projects as $project ) {
        if ( ! get_page_by_title( $project['title'], OBJECT, 'portfolio' ) ) {
            $post_id = wp_insert_post( array(
                'post_title'   => $project['title'],
                'post_content' => $project['content'],
                'post_status'  => 'publish',
                'post_type'    => 'portfolio',
            ) );

            if ( $post_id ) {
                update_post_meta( $post_id, '_pg_location', $project['location'] );
                update_post_meta( $post_id, '_pg_year', $project['year'] );
                update_post_meta( $post_id, '_pg_challenge', $project['challenge'] );
                update_post_meta( $post_id, '_pg_solution', $project['solution'] );
                
                wp_set_object_terms( $post_id, $project['category'], 'portfolio_category' );
            }
        }
    }

    // 3. Seed Pages
    // We only create pages that are NOT archives. 
    // Services and Portfolio are CPT archives, so we should NOT create pages for them to avoid slug conflicts.
    // If they exist, we delete them to let the archive take over.
    
    $conflicting_pages = array( 'Services', 'Portfolio' );
    foreach ( $conflicting_pages as $title ) {
        $page = get_page_by_title( $title );
        if ( $page ) {
            wp_delete_post( $page->ID, true );
        }
    }

    $pages = array(
        'Contact' => 'page-contact.php',
        'Visualizer' => 'page-visualizer.php',
    );

    foreach ( $pages as $title => $template ) {
        if ( ! get_page_by_title( $title ) ) {
            $post_id = wp_insert_post( array(
                'post_title'   => $title,
                'post_content' => '',
                'post_status'  => 'publish',
                'post_type'    => 'page',
            ) );

            if ( $post_id && ! empty( $template ) ) {
                update_post_meta( $post_id, '_wp_page_template', $template );
            }
        }
    }
    
    // Flush rewrite rules to ensure CPT archives work
    flush_rewrite_rules();

    echo '<div class="notice notice-success is-dismissible"><p>Content seeded successfully!</p></div>';
}
add_action( 'admin_init', 'pg_seed_content' );

if ( defined( 'WP_CLI' ) && WP_CLI ) {
    WP_CLI::add_command( 'pg seed', function() {
        // Mock GET for the function or just extract logic. 
        // For simplicity, let's just bypass the check by setting the flag
        $_GET['pg_seed'] = 'true';
        // Mock capability check or ensure we run as admin user
        // Actually, let's just copy the logic or make the function accept a force param.
        
        // Better: Refactor pg_seed_content to accept a force argument.
        pg_seed_content();
        WP_CLI::success( 'Content seeded successfully!' );
    });
}




