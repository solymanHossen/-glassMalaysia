<?php
/**
 * Automatic Page Creator
 * Visit: yourdomain.com/?create_theme_pages=true
 */

add_action('init', 'create_theme_pages_automatically');

function create_theme_pages_automatically() {
    // Check if the parameter is set and user is admin
    if (!isset($_GET['create_theme_pages']) || !current_user_can('manage_options')) {
        return;
    }

    // Check if pages already created
    if (get_option('theme_pages_created')) {
        wp_die('Pages already created! Go to <a href="' . admin_url('edit.php?post_type=page') . '">Pages</a> to view them.');
    }

    $pages_to_create = array(
        array(
            'post_title'    => 'Home',
            'post_name'     => 'home',
            'post_status'   => 'publish',
            'post_type'     => 'page',
            'post_content'  => '<!-- Home Page Content -->',
            'page_template' => 'front-page.php'
        ),
        array(
            'post_title'    => 'About',
            'post_name'     => 'about',
            'post_status'   => 'publish',
            'post_type'     => 'page',
            'post_content'  => '<!-- About Page Content -->',
            'page_template' => 'page-about.php'
        ),
        array(
            'post_title'    => 'Services',
            'post_name'     => 'services',
            'post_status'   => 'publish',
            'post_type'     => 'page',
            'post_content'  => '<!-- Services Page Content -->',
            'page_template' => 'page-services.php'
        ),
        array(
            'post_title'    => 'Portfolio',
            'post_name'     => 'portfolio',
            'post_status'   => 'publish',
            'post_type'     => 'page',
            'post_content'  => '<!-- Portfolio Page Content -->',
            'page_template' => 'page-portfolio.php'
        ),
        array(
            'post_title'    => 'Contact',
            'post_name'     => 'contact',
            'post_status'   => 'publish',
            'post_type'     => 'page',
            'post_content'  => '<!-- Contact Page Content -->',
            'page_template' => 'page-contact.php'
        ),
        array(
            'post_title'    => 'FAQ',
            'post_name'     => 'faq',
            'post_status'   => 'publish',
            'post_type'     => 'page',
            'post_content'  => '<!-- FAQ Page Content -->',
            'page_template' => 'page-faq.php'
        )
    );

    $created_pages = array();

    foreach ($pages_to_create as $page) {
        // Check if page already exists
        $existing_page = get_page_by_path($page['post_name']);
        
        if ($existing_page) {
            $created_pages[] = $page['post_title'] . ' (already exists)';
            // Update template if needed
            update_post_meta($existing_page->ID, '_wp_page_template', $page['page_template']);
            continue;
        }

        // Create the page
        $page_id = wp_insert_post(array(
            'post_title'   => $page['post_title'],
            'post_name'    => $page['post_name'],
            'post_content' => $page['post_content'],
            'post_status'  => 'publish',
            'post_type'    => 'page',
            'post_author'  => 1
        ));

        if ($page_id && !is_wp_error($page_id)) {
            // Set the page template
            update_post_meta($page_id, '_wp_page_template', $page['page_template']);
            $created_pages[] = $page['post_title'] . ' (ID: ' . $page_id . ')';
            
            // Set as front page if it's the home page
            if ($page['post_name'] === 'home') {
                update_option('page_on_front', $page_id);
                update_option('show_on_front', 'page');
            }
        }
    }

    // Flush rewrite rules
    flush_rewrite_rules();

    // Mark as created
    update_option('theme_pages_created', true);

    // Display success message
    $message = '<div style="font-family: Arial, sans-serif; max-width: 800px; margin: 50px auto; padding: 30px; background: #f0f9ff; border-radius: 10px; border: 2px solid #0ea5e9;">';
    $message .= '<h1 style="color: #0c4a6e; margin-bottom: 20px;">✅ Pages Created Successfully!</h1>';
    $message .= '<div style="background: white; padding: 20px; border-radius: 8px; margin: 20px 0;">';
    $message .= '<h3 style="color: #0369a1;">Created Pages:</h3>';
    $message .= '<ul style="line-height: 2;">';
    foreach ($created_pages as $page) {
        $message .= '<li style="color: #0c4a6e;">' . $page . '</li>';
    }
    $message .= '</ul>';
    $message .= '</div>';
    $message .= '<div style="background: #dcfce7; padding: 15px; border-radius: 8px; border-left: 4px solid #16a34a; margin: 20px 0;">';
    $message .= '<h3 style="color: #15803d;">✅ Homepage Set:</h3>';
    $message .= '<p style="color: #166534;">The "Home" page has been set as your front page.</p>';
    $message .= '</div>';
    $message .= '<div style="background: #fef3c7; padding: 15px; border-radius: 8px; border-left: 4px solid #f59e0b; margin: 20px 0;">';
    $message .= '<h3 style="color: #b45309;">⚠️ Important: Fix Permalinks</h3>';
    $message .= '<p style="color: #92400e; margin-bottom: 10px;">Go to: <strong>Settings > Permalinks</strong></p>';
    $message .= '<p style="color: #92400e;">Select <strong>"Post name"</strong> and click <strong>"Save Changes"</strong></p>';
    $message .= '</div>';
    $message .= '<div style="margin-top: 30px; text-align: center;">';
    $message .= '<a href="' . home_url() . '" style="display: inline-block; padding: 15px 30px; background: #0ea5e9; color: white; text-decoration: none; border-radius: 8px; font-weight: bold; margin: 10px;">🏠 View Homepage</a>';
    $message .= '<a href="' . admin_url('edit.php?post_type=page') . '" style="display: inline-block; padding: 15px 30px; background: #8b5cf6; color: white; text-decoration: none; border-radius: 8px; font-weight: bold; margin: 10px;">📝 View All Pages</a>';
    $message .= '<a href="' . admin_url('options-permalink.php') . '" style="display: inline-block; padding: 15px 30px; background: #f59e0b; color: white; text-decoration: none; border-radius: 8px; font-weight: bold; margin: 10px;">⚙️ Fix Permalinks</a>';
    $message .= '</div>';
    $message .= '<div style="margin-top: 30px; padding: 20px; background: white; border-radius: 8px;">';
    $message .= '<h3 style="color: #0369a1;">🎉 Next Steps:</h3>';
    $message .= '<ol style="line-height: 2.5; color: #0c4a6e;">';
    $message .= '<li><strong>Fix Permalinks:</strong> Click the button above to go to Settings > Permalinks</li>';
    $message .= '<li><strong>Install Sample Data:</strong> Visit <code style="background: #f1f5f9; padding: 5px 10px; border-radius: 4px;">?install_sample_data=true</code></li>';
    $message .= '<li><strong>View Your Site:</strong> All pages are now accessible!</li>';
    $message .= '</ol>';
    $message .= '</div>';
    $message .= '</div>';

    wp_die($message);
}
