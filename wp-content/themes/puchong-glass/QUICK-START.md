# Quick Start Guide - Puchong Glass Theme v2.0.0

## 🚀 Get Started in 5 Minutes

### Step 1: Activate the Theme
1. Go to **WordPress Dashboard**
2. Navigate to **Appearance → Themes**
3. Find "Puchong Glass & Aluminium"
4. Click **Activate**

### Step 2: Set Up Contact Information
1. Go to **Settings → General** (or create custom options page)
2. Add your business details:
   - Phone: `+60 12-345 6789`
   - Email: `hello@puchongglass.com`
   - Address: `Puchong, Selangor 58000`
   - WhatsApp Link: `https://wa.me/60123456789`

### Step 3: Create Initial Content
```
1. Services (Post Type: Service)
   - Glass Installation
   - Aluminium Work
   - Grill Installation

2. Portfolio (Post Type: Portfolio)
   - Upload sample projects
   - Add descriptions
   - Set featured images

3. Pages
   - Home (uses front-page.php)
   - About
   - Contact
   - Services
   - Portfolio
```

### Step 4: Upload Images
1. Go to **Media → Library**
2. Upload high-quality images for:
   - Hero section
   - Portfolio items
   - Service cards
   - Team photos

**Note:** The theme uses professional placeholders automatically if no images are uploaded.

### Step 5: Configure Menus
1. Go to **Appearance → Menus**
2. Create "Primary Navigation" menu
3. Add pages: Home, Services, Portfolio, About, Contact
4. Set as "Primary Navigation"

---

## 📝 Creating Content

### Add a Service

```
1. Go to Dashboard → Services → Add New
2. Title: "Glass Installation"
3. Content: Describe your service
4. Featured Image: Upload image
5. Excerpt: Short description
6. Publish
```

**Result:** Service automatically displays on homepage with image and description.

### Add a Portfolio Project

```
1. Go to Dashboard → Portfolio → Add New
2. Title: "Downtown Office Building"
3. Content: Project details and images
4. Featured Image: Upload project photo
5. Portfolio Categories: Select category
6. Excerpt: Brief project summary
7. Publish
```

**Result:** Project displays in portfolio grid with professional image handling.

### Add a Testimonial

```
1. Go to Dashboard → Testimonials → Add New
2. Title: "Client Name"
3. Content: Their testimonial quote
4. Featured Image: Client photo (optional)
5. Add Meta Fields:
   - client_name: Full Name
   - client_position: Job Title / Company
   - rating: 1-5 stars
6. Publish
```

**Result:** Testimonial appears in carousel on homepage.

### View Contact Submissions

```
1. Go to Dashboard → Contact Submissions
2. View all form submissions
3. Click a submission to see details
4. Reply directly to client email
```

---

## 🎨 Customization

### Change Colors

Edit `/wp-content/themes/puchong-glass/style.css`:

```css
:root {
    --color-primary: #3b82f6;           /* Change to your brand color */
    --color-gray-50: #f9fafb;           /* Background color */
    --color-gray-900: #111827;          /* Text color */
}
```

### Change Fonts

In `functions.php` (Tailwind config):

```javascript
fontFamily: {
    sans: ['YourFont', 'sans-serif'],
    serif: ['YourSerifFont', 'serif'],
}
```

### Modify Contact Form Fields

Edit `functions.php` - `puchong_glass_validate_contact_data()`:

```php
// Add custom validation
$additional_field = isset($data['field_name']) ? sanitize_text_field($data['field_name']) : '';
```

### Change WhatsApp Link

Edit `header.php` and `footer.php`:

```php
// Change from:
https://wa.me/60123456789

// To your WhatsApp link:
https://wa.me/YOUR_PHONE_NUMBER
```

---

## ⚡ Features Explained

### Professional Image Handling

The theme automatically:
- ✅ Shows real images when uploaded
- ✅ Shows professional placeholders when missing
- ✅ Optimizes image loading
- ✅ Handles different image sizes

**Example:** Hero image defaults to placeholder → displays real image when uploaded.

### Smart Form Processing

Contact form includes:
- ✅ Email validation
- ✅ Required field checking
- ✅ Security tokens (CSRF protection)
- ✅ Admin email notifications
- ✅ User confirmation emails
- ✅ IP address logging

### Responsive Design

Works perfectly on:
- ✅ Desktop (1920px+)
- ✅ Tablet (768px - 1024px)
- ✅ Mobile (320px - 767px)

### Modern Interactions

- ✅ Smooth scrolling
- ✅ Animated reveals
- ✅ Mobile menu
- ✅ Back-to-top button
- ✅ Testimonial carousel
- ✅ Hover effects

---

## 🔍 Testing Your Site

### Test Contact Form
1. Go to Contact page
2. Fill in the form
3. Click Submit
4. Check email for confirmation
5. Check WordPress admin for submission

### Test Images
1. Create a portfolio post without an image → Shows placeholder
2. Add an image → Image displays automatically
3. Verify it works across all pages

### Test Mobile
1. Open site on mobile phone
2. Click hamburger menu → Opens/closes
3. Check layout responsiveness
4. Test touch interactions

### Test Accessibility
1. Use keyboard to navigate
2. Press Tab to move through links
3. Press Enter to activate buttons
4. Check focus indicators are visible

---

## 🔧 Common Tasks

### Add a New Page

```
1. Dashboard → Pages → Add New
2. Title: "Your Page"
3. Content: Add your content
4. Publish
5. Add to menu: Appearance → Menus
```

### Update Site Title

```
1. Dashboard → Settings → General
2. Update "Site Title"
3. Update "Tagline"
4. Save
```

### Change Logo

```
1. Dashboard → Appearance → Customize
2. Site Identity → Logo
3. Upload your logo (120x120px recommended)
4. Publish
```

### Update Footer Links

Edit `/footer.php`:

```php
<a href="<?php echo home_url('/privacy'); ?>">Privacy Policy</a>
<a href="<?php echo home_url('/terms'); ?>">Terms of Service</a>
```

---

## 📱 Mobile Optimization

### Test Mobile Performance

1. Open DevTools (F12)
2. Toggle Device Toolbar (Ctrl+Shift+M)
3. Select Mobile device
4. Check:
   - Layout looks good
   - Text is readable
   - Buttons are tappable
   - Images load properly

### Mobile-Friendly Checklist

- [x] Menu is accessible
- [x] Buttons are large enough to tap
- [x] Images are responsive
- [x] Text is readable without zooming
- [x] Forms are easy to fill

---

## 🚀 Performance Tips

### Optimize Images
```
1. Compress images before uploading
2. Use modern formats (WebP)
3. Upload correct size (not too large)
4. Add descriptive alt text
```

### Enable Caching
```
1. Install caching plugin (e.g., WP Super Cache)
2. Enable Gzip compression
3. Set browser cache expiry
```

### Use CDN
```
1. Set up CDN (e.g., CloudFlare)
2. Point domain to CDN
3. Serve static assets from CDN
```

---

## 🆘 Troubleshooting

### Form not sending emails
```
1. Check WordPress mail settings
2. Verify SMTP configuration
3. Test with Contact page
4. Check spam folder
5. Enable debug mode to see errors
```

### Images not showing
```
1. Check image upload settings
2. Verify file permissions
3. Check media library
4. Ensure filename is valid
5. Try PNG/JPG format
```

### Menu not displaying
```
1. Go to Appearance → Menus
2. Create Primary menu
3. Add pages to menu
4. Assign to "Primary Navigation"
5. Save and refresh
```

### Styling looks broken
```
1. Clear browser cache (Ctrl+Shift+Del)
2. Clear WordPress cache plugin
3. Deactivate plugins temporarily
4. Check CSS in inspect element
5. Verify stylesheet loaded
```

---

## 📚 Documentation

For detailed information, see:

1. **IMPLEMENTATION-SUMMARY.md** - Feature overview
2. **MODERNIZATION-GUIDE.md** - Complete guide
3. **TECHNICAL-GUIDE.md** - Architecture details

---

## 🎯 Best Practices

### Content
- ✅ Use descriptive titles
- ✅ Add relevant images
- ✅ Include meta descriptions
- ✅ Use clear, readable text

### SEO
- ✅ Add meta titles
- ✅ Add meta descriptions
- ✅ Use proper headings
- ✅ Add alt text to images

### Security
- ✅ Keep WordPress updated
- ✅ Use strong passwords
- ✅ Enable two-factor auth
- ✅ Regular backups

### Performance
- ✅ Optimize images
- ✅ Enable caching
- ✅ Use CDN
- ✅ Monitor Core Web Vitals

---

## 📞 Next Steps

1. ✅ Activate theme
2. ✅ Add your contact info
3. ✅ Create initial content
4. ✅ Upload images
5. ✅ Configure menus
6. ✅ Test all features
7. ✅ Customize colors
8. ✅ Launch! 🎉

---

## 💡 Pro Tips

### Tip 1: Use Categories
Organize portfolio projects with categories for easy filtering.

### Tip 2: Schedule Posts
Create posts in advance and schedule them to publish later.

### Tip 3: Draft Mode
Save drafts before publishing to get feedback from team.

### Tip 4: Revisions
All changes are saved as revisions. You can restore older versions.

### Tip 5: Backup Regularly
Export your content regularly as backup.

---

**Happy building with Puchong Glass Theme! 🚀**

For more details, check the other documentation files in the theme folder.
