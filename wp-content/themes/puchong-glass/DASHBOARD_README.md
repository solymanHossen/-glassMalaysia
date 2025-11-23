# 📊 Custom Dashboard Documentation

## Overview
This custom WordPress dashboard provides a comprehensive management system for the Puchong Glass website with contact form management, statistics, and quick actions.

---

## 🎯 Features

### 1. **Contact Form Management**
- 📬 **Contact Form Submissions Widget**
  - View all contact submissions directly on the dashboard
  - Real-time statistics (Total, Unread, Today)
  - Color-coded status badges
  - Quick actions: Mark as Read, Archive, Delete, Reply via Email
  
- 📋 **All Contacts Page**
  - Full list view with pagination
  - Bulk actions support
  - Search and filter capabilities
  - Export to CSV functionality

### 2. **Website Statistics**
- 📊 Beautiful gradient cards showing:
  - Total Services
  - Portfolio Projects
  - Pages
  - Users
  - Direct links to manage each section

### 3. **Recent Content Widgets**
- 🛡️ **Recent Services** - Last 5 services added
- 🖼️ **Recent Portfolio** - Last 5 portfolio projects
- Quick edit links for each item

### 4. **Quick Actions**
- ⚡ One-click access to:
  - Add New Service
  - Add New Project
  - Add New Page
  - View Live Website

### 5. **Welcome Panel**
- 👋 Personalized greeting
- Quick navigation buttons
- Beautiful gradient design

---

## 🔧 Technical Details

### Database Table
The contact form uses a custom database table: `wp_pg_contacts`

**Table Structure:**
```sql
- id (mediumint) - Auto increment primary key
- name (varchar) - Contact name
- phone (varchar) - Phone number
- email (varchar) - Email address
- message (text) - Contact message
- submitted_at (datetime) - Submission timestamp
- status (varchar) - Status: unread/read/archived
- notes (text) - Admin notes (future use)
```

### AJAX Handlers
1. **pg_contact_form** - Handles form submissions
2. **pg_update_contact_status** - Updates contact status
3. **pg_delete_contact** - Deletes a contact

### WordPress Hooks Used
- `wp_dashboard_setup` - Register dashboard widgets
- `admin_notices` - Display welcome panel
- `admin_menu` - Add admin menu pages
- `wp_ajax_*` - AJAX handlers
- `after_switch_theme` - Create database table

---

## 🎨 Customization

### Color Scheme
The dashboard uses the brand colors:
- **Primary**: #0A2342 (Dark Blue)
- **Secondary**: #1E5A8E (Medium Blue)
- **Accent**: #D4AF37 (Gold)

### Widget Order
Dashboard widgets can be rearranged by drag-and-drop in the WordPress admin.

### Removing Default Widgets
To remove default WordPress widgets, uncomment the lines in the `pg_remove_default_dashboard_widgets()` function in `functions.php`.

---

## 📧 Email Notifications

When a new contact form is submitted:
1. Data is saved to the database
2. Email is sent to the site admin
3. Success message is displayed to the user
4. Dashboard badge shows new unread count

**Email Details:**
- **To**: Site admin email (from Settings → General)
- **Subject**: "New Contact Form Submission - [Site Name]"
- **Body**: Contains all form data and dashboard link

---

## 📤 Export Functionality

### CSV Export
- Access via: **Contact Forms → Export to CSV**
- Or click "Export to CSV" button on All Contacts page
- File format: UTF-8 encoded CSV
- Filename: `contacts-export-YYYY-MM-DD.csv`

**Export includes:**
- Contact ID
- Name
- Phone
- Email
- Message
- Status
- Submission Date/Time

---

## 🔐 Security Features

1. **Nonce Verification** - All AJAX requests verified
2. **Capability Checks** - Admin actions require `manage_options`
3. **Data Sanitization** - All inputs sanitized before saving
4. **SQL Injection Protection** - Using $wpdb prepared statements
5. **XSS Prevention** - Output escaped with esc_html(), esc_attr(), etc.

---

## 🎯 Usage Guide

### For Administrators

#### Viewing Contact Submissions
1. Log in to WordPress admin
2. Dashboard shows recent submissions automatically
3. Or navigate to **Contact Forms** in the sidebar

#### Managing Contacts
- **Mark as Read**: Click "✓ Mark as Read" button
- **Archive**: Click "📦 Archive" to archive old contacts
- **Delete**: Click "🗑️ Delete" to permanently remove
- **Reply**: Click "✉️ Reply via Email" to open email client

#### Bulk Actions
1. Go to **Contact Forms** page
2. Select multiple contacts using checkboxes
3. Choose action from dropdown (Mark as Read, Archive, Delete)
4. Click "Apply"

#### Exporting Data
1. Navigate to **Contact Forms → Export to CSV**
2. Click "📥 Download CSV File"
3. Open file in Excel, Google Sheets, or any spreadsheet app

---

## 🚀 Installation

The custom dashboard is automatically activated when you:
1. Activate the Puchong Glass theme
2. The database table is created automatically
3. Dashboard widgets appear immediately
4. Contact form starts collecting submissions

---

## 🐛 Troubleshooting

### Contact Form Not Working
1. Check AJAX URL in browser console
2. Verify nonce is being generated
3. Check admin-ajax.php is accessible
4. Review PHP error logs

### Database Table Missing
Run this in phpMyAdmin or via plugin:
```php
pg_create_contact_table();
```

### Emails Not Sending
1. Check WordPress email settings
2. Install WP Mail SMTP plugin
3. Verify admin email in Settings → General

### Dashboard Widgets Not Showing
1. Clear browser cache
2. Check Screen Options (top right of dashboard)
3. Verify user has `manage_options` capability

---

## 📱 Mobile Responsive

The dashboard is fully responsive:
- Stats cards stack on mobile
- Contact items expand to full width
- Touch-friendly buttons
- Optimized for tablets and phones

---

## 🎨 Custom Styling

Custom admin styles are located in:
`/assets/css/admin.css`

You can customize:
- Colors
- Typography
- Spacing
- Animations
- Widget layouts

---

## 🔄 Future Enhancements

Potential features to add:
- [ ] Contact form analytics/charts
- [ ] Email templates for auto-replies
- [ ] Integration with CRM systems
- [ ] SMS notifications
- [ ] Advanced filtering and search
- [ ] Custom fields for contacts
- [ ] Multi-language support
- [ ] Activity logs

---

## 📞 Support

For issues or questions:
1. Check this documentation first
2. Review WordPress error logs
3. Check browser console for JavaScript errors
4. Contact theme developer

---

## 📝 Changelog

### Version 1.0.0 (November 23, 2025)
- Initial release
- Contact form system
- Custom dashboard widgets
- Statistics widgets
- Quick actions
- CSV export
- Email notifications
- Mobile responsive design

---

## 📄 License

This custom dashboard is part of the Puchong Glass theme and inherits the same license.

---

**Developed by:** Puchong Glass Development Team  
**Last Updated:** November 23, 2025  
**Version:** 1.0.0
