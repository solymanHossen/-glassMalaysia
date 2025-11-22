<?php
/**
 * Sample Data Installer
 * Run this once to populate dummy content
 * Access: yourdomain.com/?install_sample_data=true
 */

if (!defined('ABSPATH')) exit;

function install_puchong_glass_sample_data() {
    if (!isset($_GET['install_sample_data']) || !current_user_can('manage_options')) {
        return;
    }

    // Prevent duplicate installation
    if (get_option('puchong_glass_sample_data_installed')) {
        wp_die('Sample data already installed!');
    }

    // Install Services
    $services = [
        [
            'title' => 'Glass Installation & Replacement',
            'content' => '<h2>Professional Glass Installation Services</h2>
            <p>Our expert team specializes in custom glass installation for residential and commercial properties. We work with tempered glass, laminated glass, frosted glass, and energy-efficient options.</p>
            
            <h3>What We Offer:</h3>
            <ul>
                <li>Custom glass cutting and installation</li>
                <li>Frameless glass doors and partitions</li>
                <li>Double glazed windows for energy efficiency</li>
                <li>Safety glass for high-traffic areas</li>
                <li>Decorative glass with etching and tinting</li>
                <li>Emergency glass repair and replacement</li>
            </ul>
            
            <h3>Quality Assurance</h3>
            <p>All our glass installations come with comprehensive warranties and are performed by certified installers. We use only premium-grade materials that meet international safety standards.</p>',
            'excerpt' => 'Custom glass installations for windows, doors, and architectural elements with precision and durability.',
            'image' => 'https://images.unsplash.com/photo-1631889993959-41b4e9c6e3c5?w=800&h=600&fit=crop'
        ],
        [
            'title' => 'Aluminium Fabrication & Installation',
            'content' => '<h2>Expert Aluminium Work</h2>
            <p>Transform your space with our professional aluminium fabrication services. We design and install custom aluminium structures for both aesthetic and functional purposes.</p>
            
            <h3>Our Capabilities:</h3>
            <ul>
                <li>Custom aluminium frame design and fabrication</li>
                <li>Powder coating in various colors</li>
                <li>Structural aluminium for commercial buildings</li>
                <li>Aluminium cladding and facades</li>
                <li>Window and door frames</li>
                <li>Weather-resistant finishes</li>
            </ul>
            
            <h3>Modern Solutions</h3>
            <p>We stay updated with the latest aluminium technologies and design trends to provide you with modern, durable solutions that enhance your property value.</p>',
            'excerpt' => 'Professional aluminium fabrication, framing, and installation for modern and contemporary designs.',
            'image' => 'https://images.unsplash.com/photo-1541888946425-d81bb19240f5?w=800&h=600&fit=crop'
        ],
        [
            'title' => 'Security Grill Installation',
            'content' => '<h2>Premium Security Solutions</h2>
            <p>Protect your property with our high-quality security grill installations. We offer both traditional and modern designs that combine security with aesthetics.</p>
            
            <h3>Grill Options:</h3>
            <ul>
                <li>Stainless steel security grills</li>
                <li>Decorative wrought iron designs</li>
                <li>Invisible grills for modern homes</li>
                <li>Sliding and fixed grill systems</li>
                <li>Custom patterns and finishes</li>
                <li>Commercial-grade security options</li>
            </ul>
            
            <h3>Safety First</h3>
            <p>All our grills are engineered to provide maximum security while maintaining aesthetic appeal. Fire-rated options available for commercial properties.</p>',
            'excerpt' => 'Premium grill designs and installations for security and aesthetics. Residential and commercial grade.',
            'image' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=800&h=600&fit=crop'
        ],
        [
            'title' => 'Door & Window Systems',
            'content' => '<h2>Complete Door & Window Solutions</h2>
            <p>Upgrade your property with our comprehensive door and window systems. We offer energy-efficient, secure, and stylish options for every need.</p>
            
            <h3>Systems We Install:</h3>
            <ul>
                <li>Sliding glass doors</li>
                <li>Bi-fold doors</li>
                <li>Casement windows</li>
                <li>Awning windows</li>
                <li>Fixed glass windows</li>
                <li>French doors</li>
            </ul>
            
            <h3>Energy Efficiency</h3>
            <p>Our modern window systems reduce heat transfer, lower energy costs, and improve indoor comfort. All systems come with sound insulation properties.</p>',
            'excerpt' => 'Complete door and window solutions with high performance and energy efficiency ratings.',
            'image' => 'https://images.unsplash.com/photo-1585412727339-54e4bae3bbf9?w=800&h=600&fit=crop'
        ],
        [
            'title' => 'Custom Glass Fabrication',
            'content' => '<h2>Bespoke Glass Design</h2>
            <p>Turn your vision into reality with our custom glass fabrication services. We create unique glass pieces tailored to your exact specifications.</p>
            
            <h3>Custom Services:</h3>
            <ul>
                <li>Architectural glass features</li>
                <li>Glass staircases and balustrades</li>
                <li>Decorative glass panels</li>
                <li>Shower enclosures</li>
                <li>Glass canopies and awnings</li>
                <li>Artistic glass installations</li>
            </ul>
            
            <h3>Design Consultation</h3>
            <p>Our design team works closely with you from concept to completion, ensuring every detail meets your expectations.</p>',
            'excerpt' => 'Bespoke glass and aluminium designs tailored to your exact specifications and vision.',
            'image' => 'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?w=800&h=600&fit=crop'
        ],
        [
            'title' => 'Repair & Maintenance Services',
            'content' => '<h2>Expert Repair & Maintenance</h2>
            <p>Keep your glass and aluminium installations in perfect condition with our professional maintenance and repair services.</p>
            
            <h3>Services Include:</h3>
            <ul>
                <li>Emergency glass repair</li>
                <li>Seal replacement</li>
                <li>Hardware replacement</li>
                <li>Re-glazing services</li>
                <li>Aluminium frame restoration</li>
                <li>Preventive maintenance programs</li>
            </ul>
            
            <h3>24/7 Emergency Service</h3>
            <p>We understand emergencies happen. Our team is available for urgent repairs to secure your property quickly.</p>',
            'excerpt' => 'Expert maintenance and repair services to keep your installations in perfect condition.',
            'image' => 'https://images.unsplash.com/photo-1581578731548-c64695cc6952?w=800&h=600&fit=crop'
        ],
    ];

    foreach ($services as $service) {
        $post_id = wp_insert_post([
            'post_title' => $service['title'],
            'post_content' => $service['content'],
            'post_excerpt' => $service['excerpt'],
            'post_type' => 'service',
            'post_status' => 'publish',
        ]);
        
        if ($post_id) {
            update_post_meta($post_id, 'service_image_url', $service['image']);
        }
    }

    // Install Portfolio Categories
    $categories = ['Residential', 'Commercial', 'Doors & Windows', 'Grills', 'Custom Work'];
    foreach ($categories as $cat) {
        if (!term_exists($cat, 'portfolio_category')) {
            wp_insert_term($cat, 'portfolio_category');
        }
    }

    // Install Portfolio Projects
    $projects = [
        [
            'title' => 'Modern Office Glass Facade',
            'content' => '<p>Complete glass facade installation for a 5-story commercial building in Puchong CBD. The project features energy-efficient double-glazed panels with UV protection, creating a stunning modern aesthetic while reducing cooling costs by 30%.</p>
            <p><strong>Project Details:</strong></p>
            <ul>
                <li>Duration: 3 months</li>
                <li>Glass Type: Low-E Double Glazed</li>
                <li>Area: 2,500 sqm</li>
                <li>Year: 2024</li>
            </ul>',
            'excerpt' => 'Complete glass facade installation for a modern office tower with energy-efficient double glazing.',
            'category' => 'Commercial',
            'image' => 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=800&h=600&fit=crop'
        ],
        [
            'title' => 'Luxury Residence Glass Partition',
            'content' => '<p>Frameless glass partition system for a luxury penthouse apartment. The design creates an open-plan living space while maintaining privacy and sophistication.</p>
            <p><strong>Features:</strong></p>
            <ul>
                <li>12mm tempered glass</li>
                <li>Frameless design</li>
                <li>Smart glass technology</li>
                <li>Acoustic insulation</li>
            </ul>',
            'excerpt' => 'Frameless glass partition system for a luxury residential apartment.',
            'category' => 'Residential',
            'image' => 'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?w=800&h=600&fit=crop'
        ],
        [
            'title' => 'Automated Sliding Door System',
            'content' => '<p>State-of-the-art automatic sliding door installation for a shopping mall entrance. Features touchless sensor operation and heavy-duty commercial-grade hardware.</p>',
            'excerpt' => 'Bespoke aluminium door system with automatic sliding mechanism.',
            'category' => 'Doors & Windows',
            'image' => 'https://images.unsplash.com/photo-1585412727339-54e4bae3bbf9?w=800&h=600&fit=crop'
        ],
        [
            'title' => 'Premium Security Grill Installation',
            'content' => '<p>High-security stainless steel grill installation for a commercial bank. Combines maximum security with elegant design that complements the building architecture.</p>',
            'excerpt' => 'Premium stainless steel grill installation for commercial building.',
            'category' => 'Grills',
            'image' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=800&h=600&fit=crop'
        ],
        [
            'title' => 'Retail Storefront Renovation',
            'content' => '<p>Complete storefront transformation with high-impact glass and branded elements. The design increases visibility while providing security and weather protection.</p>',
            'excerpt' => 'High-impact glass storefront with custom branding integration.',
            'category' => 'Commercial',
            'image' => 'https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=800&h=600&fit=crop'
        ],
        [
            'title' => 'Residential Window Replacement',
            'content' => '<p>Complete window replacement project for a 3-story residential building. Features noise-reduction technology and energy-efficient glass for improved comfort.</p>',
            'excerpt' => 'Complete window replacement project with noise reduction features.',
            'category' => 'Residential',
            'image' => 'https://images.unsplash.com/photo-1513694203232-719a280e022f?w=800&h=600&fit=crop'
        ],
        [
            'title' => 'Industrial Glass Partition',
            'content' => '<p>Durable glass partition system for an industrial facility. Designed to withstand harsh environments while maintaining visibility and safety standards.</p>',
            'excerpt' => 'Durable glass partition system for industrial facility.',
            'category' => 'Commercial',
            'image' => 'https://images.unsplash.com/photo-1565043666747-69f6646db940?w=800&h=600&fit=crop'
        ],
        [
            'title' => 'Luxury Villa Complete Renovation',
            'content' => '<p>Full glass and aluminium renovation for a luxury residential villa. Includes floor-to-ceiling windows, glass staircases, and custom aluminium frames throughout.</p>',
            'excerpt' => 'Complete glass and aluminium renovation for luxury residential project.',
            'category' => 'Custom Work',
            'image' => 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=800&h=600&fit=crop'
        ],
    ];

    foreach ($projects as $project) {
        $post_id = wp_insert_post([
            'post_title' => $project['title'],
            'post_content' => $project['content'],
            'post_excerpt' => $project['excerpt'],
            'post_type' => 'portfolio',
            'post_status' => 'publish',
        ]);
        
        if ($post_id) {
            wp_set_object_terms($post_id, $project['category'], 'portfolio_category');
            update_post_meta($post_id, 'project_image_url', $project['image']);
        }
    }

    // Install FAQs
    $faqs = [
        [
            'question' => 'What types of glass do you offer?',
            'answer' => 'We offer a comprehensive range of glass types including tempered glass, laminated glass, frosted glass, tinted glass, low-emissivity (Low-E) glass, and decorative glass. Each type serves specific purposes - tempered glass for safety, laminated for security, Low-E for energy efficiency, and frosted for privacy. Our experts can recommend the best option based on your specific needs, location, and budget.'
        ],
        [
            'question' => 'How long does a typical installation take?',
            'answer' => 'Installation timelines vary based on project complexity. Simple glass panel installations typically take 2-4 hours. Window replacements for a standard home can be completed in 1-2 days. Larger commercial projects like curtain walls may take several weeks to months. We provide detailed timelines during the initial consultation and keep you informed throughout the process.'
        ],
        [
            'question' => 'Do you provide free quotations?',
            'answer' => 'Yes! We offer completely free, no-obligation quotations for all our services. Our team will visit your location, take measurements, understand your requirements, and provide a detailed written quote. The consultation includes expert advice on materials, design options, and cost-effective solutions.'
        ],
        [
            'question' => 'What warranty do you provide?',
            'answer' => 'We provide comprehensive warranties covering both materials and workmanship. Glass installations typically come with a 5-year warranty on materials and 2 years on installation. Aluminium work includes a 3-year warranty. Specific warranty terms depend on the products and services selected, and all details are clearly outlined in your contract.'
        ],
        [
            'question' => 'Can you handle commercial projects?',
            'answer' => 'Absolutely! We have extensive experience with commercial projects of all sizes, from small retail shops to large office buildings and industrial facilities. Our team can manage projects requiring specialized permits, safety compliance, and coordination with other contractors. We provide professional project management to ensure timely completion within budget.'
        ],
        [
            'question' => 'Are your installations energy efficient?',
            'answer' => 'Yes, we prioritize energy efficiency in all our installations. We offer Low-E glass that reduces heat transfer, double-glazed windows that provide excellent insulation, and aluminium frames with thermal breaks. These solutions can reduce your heating and cooling costs by up to 30% while improving indoor comfort. We can provide energy efficiency ratings for all our products.'
        ],
        [
            'question' => 'Do you offer emergency repair services?',
            'answer' => 'Yes, we provide 24/7 emergency repair services for urgent situations like broken glass, damaged doors, or security concerns. Our emergency team can secure your property quickly and schedule permanent repairs at your convenience. Emergency response times are typically within 2-4 hours in the Puchong area.'
        ],
        [
            'question' => 'What payment methods do you accept?',
            'answer' => 'We accept various payment methods including bank transfer, cash, credit cards, and installment plans for larger projects. Typically, we require a 30% deposit to begin work, with the balance due upon completion. For commercial projects, we can work with purchase orders and offer flexible payment schedules.'
        ],
        [
            'question' => 'Do you help with design and planning?',
            'answer' => 'Yes! Our experienced design team provides free design consultations. We help you visualize your project with sketches and 3D renderings where applicable. We also advise on material selection, color schemes, and design trends to ensure your project meets both functional and aesthetic goals.'
        ],
        [
            'question' => 'What areas do you serve?',
            'answer' => 'We primarily serve Puchong and surrounding areas in Selangor including Subang Jaya, Petaling Jaya, Seri Kembangan, Cyberjaya, and Putrajaya. For larger commercial projects, we can accommodate work throughout Klang Valley and other parts of Malaysia. Contact us to confirm service availability for your location.'
        ],
    ];

    foreach ($faqs as $faq) {
        wp_insert_post([
            'post_title' => $faq['question'],
            'post_content' => $faq['answer'],
            'post_type' => 'faq',
            'post_status' => 'publish',
        ]);
    }

    // Install Testimonials
    $testimonials = [
        [
            'content' => 'Puchong Glass transformed our office with a stunning glass facade. The team was incredibly professional, completed the work on time, and the quality is outstanding. Our energy bills have dropped significantly thanks to their energy-efficient glass. Highly recommend!',
            'client' => 'Michael Chen',
            'position' => 'CEO, Tech Innovations Sdn Bhd',
            'rating' => 5
        ],
        [
            'content' => 'We needed emergency glass repair after a break-in. The team arrived within 2 hours and secured our shop immediately. The next day they installed permanent replacement glass. Excellent service when we needed it most!',
            'client' => 'Sarah Ahmad',
            'position' => 'Owner, Ahmad Trading',
            'rating' => 5
        ],
        [
            'content' => 'The frameless glass partition they installed in our home is absolutely beautiful. It created an open feel while maintaining privacy. The installation was clean, quick, and they cleaned up perfectly. Worth every ringgit!',
            'client' => 'David & Lisa Wong',
            'position' => 'Homeowners, Puchong Jaya',
            'rating' => 5
        ],
        [
            'content' => 'Professional from start to finish. The consultation was detailed, the quote was competitive, and the installation exceeded our expectations. Our new windows have made our home so much quieter and cooler. Thank you!',
            'client' => 'Raj Kumar',
            'position' => 'Property Manager, Vista Residences',
            'rating' => 5
        ],
        [
            'content' => 'Best glass and aluminium contractor we have worked with. They completed our commercial building facade ahead of schedule without compromising quality. The project management was exemplary. Will definitely use them again!',
            'client' => 'Jennifer Lim',
            'position' => 'Project Director, Summit Properties',
            'rating' => 5
        ],
    ];

    foreach ($testimonials as $test) {
        $post_id = wp_insert_post([
            'post_title' => 'Testimonial from ' . $test['client'],
            'post_content' => $test['content'],
            'post_type' => 'testimonial',
            'post_status' => 'publish',
        ]);
        
        if ($post_id) {
            update_post_meta($post_id, 'client_name', $test['client']);
            update_post_meta($post_id, 'client_position', $test['position']);
            update_post_meta($post_id, 'rating', $test['rating']);
        }
    }

    // Mark as installed
    update_option('puchong_glass_sample_data_installed', true);

    wp_die('✅ Sample data installed successfully! <a href="' . home_url() . '">View Site</a>');
}
add_action('init', 'install_puchong_glass_sample_data');
