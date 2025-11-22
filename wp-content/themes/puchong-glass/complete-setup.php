<?php
/**
 * Complete Setup Script - Run this once
 * Access via: yourdomain.com/?run_complete_setup=true
 */

add_action('init', 'run_complete_setup');

function run_complete_setup() {
    // Only run if parameter is set and user is admin
    if (!isset($_GET['run_complete_setup']) || !current_user_can('manage_options')) {
        return;
    }

    $results = array();
    $errors = array();

    // 1. Fix Permalink Structure
    update_option('permalink_structure', '/%postname%/');
    flush_rewrite_rules();
    $results[] = '✅ Permalinks set to Post Name structure';

    // 2. Create Pages
    $pages_to_create = array(
        array(
            'post_title'    => 'Home',
            'post_name'     => 'home',
            'post_content'  => '<!-- Home Page -->',
            'page_template' => 'front-page.php',
            'menu_order'    => 1
        ),
        array(
            'post_title'    => 'About',
            'post_name'     => 'about',
            'post_content'  => '<!-- About Page -->',
            'page_template' => 'page-about.php',
            'menu_order'    => 2
        ),
        array(
            'post_title'    => 'Services',
            'post_name'     => 'services',
            'post_content'  => '<!-- Services Page -->',
            'page_template' => 'page-services.php',
            'menu_order'    => 3
        ),
        array(
            'post_title'    => 'Portfolio',
            'post_name'     => 'portfolio',
            'post_content'  => '<!-- Portfolio Page -->',
            'page_template' => 'page-portfolio.php',
            'menu_order'    => 4
        ),
        array(
            'post_title'    => 'Contact',
            'post_name'     => 'contact',
            'post_content'  => '<!-- Contact Page -->',
            'page_template' => 'page-contact.php',
            'menu_order'    => 5
        ),
        array(
            'post_title'    => 'FAQ',
            'post_name'     => 'faq',
            'post_content'  => '<!-- FAQ Page -->',
            'page_template' => 'page-faq.php',
            'menu_order'    => 6
        )
    );

    $home_page_id = null;

    foreach ($pages_to_create as $page_data) {
        // Check if page already exists
        $existing_page = get_page_by_path($page_data['post_name']);
        
        if ($existing_page) {
            // Update template
            update_post_meta($existing_page->ID, '_wp_page_template', $page_data['page_template']);
            $results[] = '✅ Page "' . $page_data['post_title'] . '" already exists (template updated)';
            
            if ($page_data['post_name'] === 'home') {
                $home_page_id = $existing_page->ID;
            }
            continue;
        }

        // Create new page
        $page_id = wp_insert_post(array(
            'post_title'   => $page_data['post_title'],
            'post_name'    => $page_data['post_name'],
            'post_content' => $page_data['post_content'],
            'post_status'  => 'publish',
            'post_type'    => 'page',
            'post_author'  => 1,
            'menu_order'   => $page_data['menu_order']
        ));

        if ($page_id && !is_wp_error($page_id)) {
            // Set template
            update_post_meta($page_id, '_wp_page_template', $page_data['page_template']);
            $results[] = '✅ Created page: ' . $page_data['post_title'] . ' (ID: ' . $page_id . ')';
            
            if ($page_data['post_name'] === 'home') {
                $home_page_id = $page_id;
            }
        } else {
            $errors[] = '❌ Failed to create page: ' . $page_data['post_title'];
        }
    }

    // 3. Set Homepage
    if ($home_page_id) {
        update_option('page_on_front', $home_page_id);
        update_option('show_on_front', 'page');
        $results[] = '✅ Homepage set to "Home" page';
    } else {
        $errors[] = '❌ Could not find Home page to set as front page';
    }

    // 4. Flush rewrite rules again
    flush_rewrite_rules();
    $results[] = '✅ Rewrite rules flushed';

    // 5. Display results
    display_setup_results($results, $errors);
}

function display_setup_results($results, $errors) {
    $html = '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Setup Complete - Puchong Glass</title>
        <style>
            * { margin: 0; padding: 0; box-sizing: border-box; }
            body {
                font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                min-height: 100vh;
                padding: 20px;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .container {
                max-width: 800px;
                width: 100%;
                background: white;
                border-radius: 20px;
                box-shadow: 0 20px 60px rgba(0,0,0,0.3);
                overflow: hidden;
            }
            .header {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
                padding: 40px;
                text-align: center;
            }
            .header h1 {
                font-size: 2.5em;
                margin-bottom: 10px;
            }
            .header p {
                font-size: 1.2em;
                opacity: 0.9;
            }
            .content {
                padding: 40px;
            }
            .results {
                background: #f0fdf4;
                border: 2px solid #86efac;
                border-radius: 10px;
                padding: 20px;
                margin-bottom: 20px;
            }
            .results h2 {
                color: #166534;
                margin-bottom: 15px;
                font-size: 1.5em;
            }
            .results ul {
                list-style: none;
            }
            .results li {
                padding: 10px 0;
                color: #166534;
                border-bottom: 1px solid #dcfce7;
                font-size: 1.1em;
            }
            .results li:last-child {
                border-bottom: none;
            }
            .errors {
                background: #fef2f2;
                border: 2px solid #fca5a5;
                border-radius: 10px;
                padding: 20px;
                margin-bottom: 20px;
            }
            .errors h2 {
                color: #991b1b;
                margin-bottom: 15px;
            }
            .errors li {
                padding: 8px 0;
                color: #991b1b;
            }
            .next-steps {
                background: #eff6ff;
                border: 2px solid #93c5fd;
                border-radius: 10px;
                padding: 20px;
                margin-bottom: 20px;
            }
            .next-steps h2 {
                color: #1e40af;
                margin-bottom: 15px;
            }
            .next-steps ol {
                margin-left: 20px;
            }
            .next-steps li {
                padding: 8px 0;
                color: #1e40af;
                line-height: 1.6;
            }
            .buttons {
                display: flex;
                gap: 15px;
                flex-wrap: wrap;
                margin-top: 30px;
            }
            .btn {
                flex: 1;
                min-width: 200px;
                padding: 15px 30px;
                border-radius: 10px;
                text-decoration: none;
                text-align: center;
                font-weight: bold;
                font-size: 1.1em;
                transition: all 0.3s;
                display: inline-block;
            }
            .btn-primary {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
            }
            .btn-primary:hover {
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
            }
            .btn-secondary {
                background: #10b981;
                color: white;
            }
            .btn-secondary:hover {
                background: #059669;
                transform: translateY(-2px);
            }
            .btn-tertiary {
                background: #f59e0b;
                color: white;
            }
            .btn-tertiary:hover {
                background: #d97706;
                transform: translateY(-2px);
            }
            .test-urls {
                background: #f8fafc;
                border-radius: 10px;
                padding: 20px;
                margin-top: 20px;
            }
            .test-urls h3 {
                color: #334155;
                margin-bottom: 15px;
            }
            .test-urls a {
                display: block;
                padding: 10px;
                margin: 5px 0;
                background: white;
                border: 1px solid #e2e8f0;
                border-radius: 5px;
                color: #667eea;
                text-decoration: none;
                transition: all 0.2s;
            }
            .test-urls a:hover {
                background: #667eea;
                color: white;
                transform: translateX(5px);
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h1>🎉 Setup Complete!</h1>
                <p>Your WordPress theme is now ready to use</p>
            </div>
            <div class="content">';

    if (!empty($results)) {
        $html .= '<div class="results">
                    <h2>✅ Successfully Completed:</h2>
                    <ul>';
        foreach ($results as $result) {
            $html .= '<li>' . $result . '</li>';
        }
        $html .= '</ul></div>';
    }

    if (!empty($errors)) {
        $html .= '<div class="errors">
                    <h2>⚠️ Errors:</h2>
                    <ul>';
        foreach ($errors as $error) {
            $html .= '<li>' . $error . '</li>';
        }
        $html .= '</ul></div>';
    }

    $html .= '<div class="next-steps">
                    <h2>📋 Next Steps:</h2>
                    <ol>
                        <li><strong>Test your pages:</strong> Click the links below to verify they work</li>
                        <li><strong>Install sample data:</strong> Click the button below to add dummy content</li>
                        <li><strong>Customize:</strong> Go to WordPress admin to edit content</li>
                    </ol>
                </div>

                <div class="test-urls">
                    <h3>🔗 Test Your Pages (Should all work now!):</h3>
                    <a href="' . home_url('/') . '" target="_blank">🏠 Homepage</a>
                    <a href="' . home_url('/services/') . '" target="_blank">🛠️ Services</a>
                    <a href="' . home_url('/portfolio/') . '" target="_blank">🎨 Portfolio</a>
                    <a href="' . home_url('/contact/') . '" target="_blank">📧 Contact</a>
                    <a href="' . home_url('/about/') . '" target="_blank">ℹ️ About</a>
                    <a href="' . home_url('/faq/') . '" target="_blank">❓ FAQ</a>
                </div>

                <div class="buttons">
                    <a href="' . home_url('/') . '" class="btn btn-primary">🏠 View Homepage</a>
                    <a href="' . home_url('/?install_sample_data=true') . '" class="btn btn-secondary">📝 Install Sample Data</a>
                    <a href="' . admin_url('edit.php?post_type=page') . '" class="btn btn-tertiary">⚙️ Manage Pages</a>
                </div>
            </div>
        </div>
    </body>
    </html>';

    wp_die($html);
}
