# Puchong Glass & Aluminium WordPress Theme - Setup Guide

## 🚀 Quick Start

### 1. Activate the Theme
1. Go to **Appearance > Themes**
2. Activate **Puchong Glass & Aluminium**

### 2. Setup Pages
Create these pages and assign templates:

#### **Homepage**
- Create page: "Home"
- Template: **Home Page**
- Go to **Settings > Reading**
- Set "Your homepage displays" to "A static page"
- Select "Home" as Homepage

#### **Other Pages**
Create the following pages with their templates:

| Page Name | Template |
|-----------|----------|
| About | About Page |
| Services | Services Page |
| Portfolio | Portfolio Page |
| Contact | Contact Page |
| FAQ | FAQ Page |

### 3. Add Dynamic Content

#### **Services**
1. Go to **Services > Add New**
2. Add service title, description, and featured image
3. Publish

#### **Portfolio Projects**
1. Go to **Portfolio > Add New**
2. Add project title, description, and featured image
3. Assign **Portfolio Categories** (e.g., Residential, Commercial, Grills)
4. Publish

#### **FAQs**
1. Go to **FAQs > Add New**
2. Title = Question
3. Content = Answer
4. Publish

#### **Testimonials**
1. Go to **Testimonials > Add New**
2. Add client testimonial in content
3. Add custom fields (optional):
   - `client_name`: Client's name
   - `client_position`: Job title/company
   - `rating`: 1-5 stars
4. Add featured image (client photo)

### 4. Setup Navigation Menu
1. Go to **Appearance > Menus**
2. Create a new menu named "Primary Menu"
3. Add pages: Home, Services, Portfolio, About, Contact
4. Assign to **Primary Menu** location
5. Save

### 5. Configure Contact Form
- The contact form automatically saves submissions to **Contact Submissions** in admin
- View submissions: **Contact Submissions** menu
- Email notifications are sent to the admin email (set in Settings > General)

### 6. Customize Logo & Site Identity
1. Go to **Appearance > Customize > Site Identity**
2. Upload your logo (recommended size: 60x60px)
3. Set Site Title and Tagline
4. Save & Publish

## 📋 Features

### ✅ Dynamic Content System
- **Services**: Fully manageable from admin dashboard
- **Portfolio**: Projects with categories and filtering
- **FAQs**: Easy question/answer management
- **Testimonials**: Client reviews with ratings
- **Contact Forms**: Submissions saved in WordPress admin

### ✅ Modern Design Features
- Responsive mobile-first design
- Glassmorphism effects
- Smooth animations and transitions
- Scroll reveal effects
- Interactive hover states
- Back-to-top button

### ✅ SEO Friendly
- Semantic HTML5 structure
- Schema-ready markup
- Fast loading with Tailwind CDN
- Mobile optimized

### ✅ Interactive Elements
- Working contact form with admin integration
- Filterable portfolio
- Collapsible FAQ sections
- Mobile responsive menu
- Smooth scroll navigation

## 🎨 Customization

### Colors
Edit in `functions.php` - Tailwind config section:
```javascript
colors: {
    blue: { ... } // Change primary color
}
```

### Fonts
Current fonts (via Google Fonts):
- **Inter**: Body text
- **Playfair Display**: Headings

### Icons
Uses **Lucide Icons** - change any icon by editing the `data-lucide` attribute.

## 📧 Contact Form Setup

### How It Works:
1. User fills form on Contact page
2. Submission saved to **Contact Submissions** post type
3. Email notification sent to admin
4. View all submissions in WordPress admin

### View Submissions:
- Dashboard menu: **Contact Submissions**
- Columns show: Name, Email, Phone, Service, Date
- Click to view full message

## 🔧 Advanced Configuration

### Add Custom Fields to Portfolio
Use Advanced Custom Fields (ACF) plugin to add:
- Client name
- Project date
- Location
- Budget
- Gallery images

### Add More Portfolio Categories
Go to **Portfolio > Project Categories** and add:
- Residential
- Commercial
- Doors & Windows
- Grills
- Custom Work

### Customize Email Notifications
Edit `functions.php` - function `puchong_glass_handle_contact_form()`:
```php
$to = get_option('admin_email'); // Change recipient
$subject = 'New Contact Form...'; // Change subject
```

## 📱 Mobile Optimization

The theme is fully responsive:
- Mobile menu (hamburger)
- Touch-friendly buttons
- Optimized images
- Fast loading

## 🛠️ Troubleshooting

### Contact form not working?
1. Check **Settings > General** - admin email is correct
2. Test with WP Mail SMTP plugin if emails not sending
3. Check **Contact Submissions** - submissions should appear

### Portfolio/Services not showing?
1. Make sure you've added posts in admin
2. Go to **Settings > Permalinks** and click "Save Changes"
3. Clear browser cache

### Icons not appearing?
- Lucide icons load from CDN
- Check internet connection
- Try clearing cache

## 🎯 Next Steps

1. ✅ Add 3-5 services
2. ✅ Upload 6-10 portfolio projects with images
3. ✅ Add 5-8 FAQs
4. ✅ Add 2-3 testimonials
5. ✅ Upload logo
6. ✅ Setup navigation menu
7. ✅ Test contact form
8. ✅ Configure SEO plugin (Yoast or Rank Math)

## 📞 Support

For theme support, please refer to the documentation or contact the developer.

---

**Theme Version:** 1.0.0  
**WordPress Required:** 6.0+  
**PHP Required:** 7.4+
