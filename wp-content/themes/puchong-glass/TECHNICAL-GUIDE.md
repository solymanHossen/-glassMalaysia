# Technical Implementation Guide - Puchong Glass Theme v2.0.0

## Architecture Overview

### 1. Theme Structure

```
INITIALIZATION
    ↓
functions.php
├── Constants Definition
│   ├── PUCHONG_GLASS_VERSION
│   ├── PUCHONG_GLASS_DIR
│   └── PUCHONG_GLASS_URI
│
├── Asset Management
│   └── Puchong_Assets class
│       ├── enqueue_scripts()
│       ├── enqueue_styles()
│       └── get_tailwind_config()
│
├── Image Handling
│   └── Puchong_Image_Helper class
│       ├── get_image_url()
│       ├── get_placeholder_image()
│       └── display_image()
│
├── Form Processing
│   ├── puchong_glass_validate_contact_data()
│   ├── puchong_glass_handle_contact_form()
│   └── puchong_glass_get_contact_info()
│
├── Custom Post Types
│   └── puchong_glass_register_cpts()
│       ├── Portfolio
│       ├── Service
│       ├── FAQ
│       ├── Contact (read-only)
│       └── Testimonial
│
└── Admin Interface
    ├── Contact columns display
    ├── Meta box rendering
    └── Admin styles
```

### 2. Class-Based Architecture

#### Puchong_Assets
**Purpose:** Centralized asset management

```php
class Puchong_Assets {
    public static function init()          // Initialize hooks
    public static function enqueue_scripts() // Frontend scripts
    public static function enqueue_styles()  // Frontend styles
    public static function enqueue_admin_assets() // Admin styles
    private static function get_tailwind_config() // Tailwind setup
}
```

**Flow:**
1. Theme loads → `functions.php` includes theme setup
2. `add_action('after_setup_theme', 'puchong_glass_setup')`
3. `Puchong_Assets::init()` called
4. WordPress enqueue hooks triggered
5. Scripts/styles loaded with proper dependencies

#### Puchong_Image_Helper
**Purpose:** Professional image handling with fallbacks

```php
class Puchong_Image_Helper {
    public static function get_image_url($post_id, $size)
    public static function get_placeholder_image($size)
    public static function display_image($post_id, $size, $class)
    private static function get_size_dimensions($size)
}
```

**Image Size Definitions:**
- `puchong-hero`: 1920x1080 (full width hero)
- `puchong-portfolio`: 800x600 (portfolio grid)
- `puchong-card`: 400x300 (service cards)
- `puchong-testimonial`: 100x100 (avatar circles)

**Placeholder Generation:**
```
Source: imgplaceholder.com
Format: {width}x{height}?text={text}&bg={color}&textcolor={color}
Example: 1920x1080?text=Premium+Glass&bg=3b82f6&textcolor=ffffff
```

### 3. Form Processing Pipeline

```
User Submits Form
    ↓
wp_verify_nonce() - Check security token
    ↓
puchong_glass_validate_contact_data()
├── Sanitize inputs
├── Validate emails
├── Check message length
└── Return errors if invalid
    ↓
wp_insert_post() - Create Contact CPT
├── Title: "Contact from {Name}"
├── Type: contact
├── Meta: name, email, phone, service, message, date, IP
    ↓
wp_mail() - Send notifications
├── Admin notification
└── User confirmation
    ↓
wp_redirect() - Redirect with success/error
```

### 4. Custom Post Types (CPT)

#### Portfolio
```php
- Public: true
- Archive: /projects/
- Supports: title, editor, thumbnail, excerpt
- Taxonomy: portfolio_category
- Gutenberg: Enabled
```

#### Service
```php
- Public: true
- Archive: /services/
- Supports: title, editor, thumbnail, excerpt
- Gutenberg: Enabled
```

#### FAQ
```php
- Public: false (not in frontend queries)
- Admin UI: true
- Supports: title, editor
- Gutenberg: Enabled
```

#### Contact (Read-Only)
```php
- Public: false
- Admin UI: true
- Create Posts: false (no manual creation)
- Display: Custom columns, meta box
```

#### Testimonial
```php
- Public: false
- Admin UI: true
- Supports: title, editor, thumbnail
- Meta Fields: client_name, client_position, rating
```

### 5. JavaScript Architecture

#### Module Pattern with Classes

```javascript
(function() {
    'use strict';
    
    // Class definitions
    class MobileMenuHandler { /* ... */ }
    class ScrollReveal { /* ... */ }
    
    // Initialize on DOM ready
    document.addEventListener('DOMContentLoaded', () => {
        new MobileMenuHandler();
        new ScrollReveal();
        // ... more components
    });
    
    // Export for testing
    window.PuchongGlass = { MobileMenuHandler, ScrollReveal, ... };
})();
```

#### Component Responsibilities

| Component | Purpose | Dependencies |
|-----------|---------|--------------|
| MobileMenuHandler | Toggle mobile menu | None |
| ScrollReveal | Animate on scroll | IntersectionObserver |
| TestimonialSlider | Carousel functionality | CSS transitions |
| SmoothScroll | Anchor link scrolling | None |
| BackToTop | Scroll-to-top button | None |
| FormHandler | Client-side validation | None |

### 6. CSS Architecture

#### Cascade Structure

```
1. CSS Custom Properties (--color-*, --spacing-*, etc.)
   ↓
2. Reset & Base (*, html, body)
   ↓
3. Typography (h1-h6, p, a)
   ↓
4. Utilities (smooth-transition, glass, etc.)
   ↓
5. Animations (@keyframes)
   ↓
6. Components (cards, buttons, forms)
   ↓
7. Responsive Media Queries
   ↓
8. Accessibility (prefers-reduced-motion, prefers-color-scheme)
   ↓
9. Print Styles
```

#### CSS Custom Properties (Variables)

```css
:root {
    /* Colors */
    --color-primary: #3b82f6;
    --color-gray-50: #f9fafb;
    
    /* Spacing */
    --spacing-unit: 4px;
    
    /* Transitions */
    --transition-fast: 0.2s ease-in-out;
    --transition-normal: 0.3s ease-in-out;
    --transition-slow: 0.6s ease-in-out;
    
    /* Shadows */
    --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    
    /* Borders */
    --border-radius-lg: 16px;
    
    /* Fonts */
    --font-sans: 'Inter', sans-serif;
    --font-serif: 'Playfair Display', serif;
    
    /* Z-Index Scale */
    --z-sticky: 20;
    --z-fixed: 50;
    --z-modal: 1000;
}
```

### 7. Data Flow - Contact Form Example

```
HTML Form
    ↓ (submit event)
FormHandler (JavaScript)
    ├── Client validation (email, length)
    └── Prevent submit if invalid
    ↓ (if valid)
Backend Processing
    ├── wp_verify_nonce()
    ├── puchong_glass_validate_contact_data()
    ├── wp_insert_post() (create Contact CPT)
    └── wp_mail() (send emails)
    ↓ (success)
wp_redirect()
    ↓
Refresh page with success query var
    ↓
JavaScript reads query param
    ↓
Display success message
```

### 8. Database Schema

#### Contact Post Type Meta
```
post_id (from wp_posts)
├── contact_name (text)
├── contact_email (text)
├── contact_phone (text)
├── contact_service (text)
├── contact_message (text)
├── contact_date (datetime)
└── contact_ip (text)
```

#### Testimonial Post Type Meta
```
post_id
├── client_name (text)
├── client_position (text)
└── rating (number 1-5)
```

### 9. Security Flow

```
Input Received
    ↓
1. CSRF Check (nonce verification)
   ├── $_POST['contact_form_nonce'] verified
   ├── Nonce action: 'contact_form_submit'
   └── Fail: wp_die()
    ↓
2. Sanitization
   ├── sanitize_text_field() - text inputs
   ├── sanitize_email() - email
   ├── sanitize_textarea_field() - messages
   └── Removes potentially harmful content
    ↓
3. Validation
   ├── Type checking (email, phone)
   ├── Length validation
   ├── Pattern matching
   └── Return errors if invalid
    ↓
4. Output Escaping
   ├── esc_html() - text output
   ├── esc_attr() - HTML attributes
   ├── esc_url() - URLs
   └── nl2br(esc_html()) - formatted text
    ↓
5. Data Logging
   └── IP address recorded
    ↓
Database Storage (secure)
```

### 10. Performance Optimization Chain

```
Asset Loading
    ├── Script dependencies defined
    ├── Deferred loading where possible
    └── Inline only critical code

Image Handling
    ├── Lazy loading (loading="lazy")
    ├── Async decoding (decoding="async")
    ├── Responsive sizing
    └── Professional placeholders

CSS Strategy
    ├── Tailwind CDN (dev) → build process (prod)
    ├── CSS custom properties for theming
    ├── Minification in production
    └── Critical CSS inlined

JavaScript Optimization
    ├── Class-based architecture
    ├── Event delegation
    ├── Conditional initialization
    └── Modern ES6+ syntax
```

---

## Integration Points

### WordPress Hooks Used

#### Theme Hooks
```php
add_action('after_setup_theme', 'puchong_glass_setup');
add_action('wp_enqueue_scripts', 'Puchong_Assets::enqueue_scripts');
add_action('wp_enqueue_scripts', 'Puchong_Assets::enqueue_styles');
add_action('admin_enqueue_scripts', 'Puchong_Assets::enqueue_admin_assets');
```

#### Form Processing
```php
add_action('admin_post_nopriv_contact_form', 'puchong_glass_handle_contact_form');
add_action('admin_post_contact_form', 'puchong_glass_handle_contact_form');
```

#### Custom Post Types
```php
add_action('init', 'puchong_glass_register_cpts');
```

#### Admin Columns
```php
add_filter('manage_contact_posts_columns', 'puchong_glass_contact_columns');
add_action('manage_contact_posts_custom_column', 'puchong_glass_contact_column_content', 10, 2);
add_action('add_meta_boxes', 'puchong_glass_contact_meta_box');
```

---

## Testing Checklist

### Functionality
- [ ] Contact form submission
- [ ] Email notifications received
- [ ] Images display (with and without uploads)
- [ ] Testimonial slider works
- [ ] Mobile menu toggles
- [ ] Smooth scrolling functions
- [ ] Back-to-top button appears/disappears

### Accessibility
- [ ] Keyboard navigation
- [ ] Screen reader testing
- [ ] Color contrast checks
- [ ] Focus indicators visible
- [ ] ARIA labels present

### Performance
- [ ] Lighthouse score > 90
- [ ] Core Web Vitals pass
- [ ] Images lazy load
- [ ] No render-blocking resources

### Security
- [ ] Form validation works
- [ ] CSRF tokens verified
- [ ] XSS prevention tested
- [ ] SQL injection prevented
- [ ] Sensitive data escaped

### Browser Compatibility
- [ ] Chrome/Edge 90+
- [ ] Firefox 88+
- [ ] Safari 14+
- [ ] Mobile browsers

---

## Deployment Checklist

1. **Build Process**
   - [ ] Compile Tailwind CSS
   - [ ] Minify CSS/JavaScript
   - [ ] Optimize images
   - [ ] Generate source maps

2. **Configuration**
   - [ ] Update constant values
   - [ ] Set production mode
   - [ ] Configure error logging
   - [ ] Set up CDN

3. **Testing**
   - [ ] Run test suite
   - [ ] Manual QA
   - [ ] Performance testing
   - [ ] Security audit

4. **Deployment**
   - [ ] Backup database
   - [ ] Upload files
   - [ ] Clear caches
   - [ ] Test on production

5. **Monitoring**
   - [ ] Monitor error logs
   - [ ] Track performance
   - [ ] Check security alerts
   - [ ] User feedback

---

**Maintained with ❤️ by Senior Engineer Team**
