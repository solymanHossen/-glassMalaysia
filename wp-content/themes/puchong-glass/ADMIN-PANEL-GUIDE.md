# Puchong Glass Admin Panel - Installation & Setup Guide

## 📋 Table of Contents
1. [Installation](#installation)
2. [Features](#features)
3. [Configuration](#configuration)
4. [Usage](#usage)
5. [Troubleshooting](#troubleshooting)

---

## ✅ Installation

### Step 1: Activate the Theme
The admin panel is automatically included with the Puchong Glass theme. Simply ensure the theme is activated in WordPress.

### Step 2: Access the Admin Panel
You have multiple ways to access the modern admin panel:

**Method A: Via WordPress Admin Menu**
1. Log in to WordPress Dashboard
2. Look for "Puchong Glass" menu item (left sidebar)
3. Click to open the modern admin panel

**Method B: Direct URL**
```
https://yourdomain.com/wp-admin/admin.php?page=puchong-admin-panel
```

**Method C: Admin Bar**
1. In WordPress Dashboard top bar, find "Admin Panel" link
2. Click to navigate to the modern interface

---

## 🎯 Features

### Dashboard
- **Quick Stats**: View total contacts, projects, services, testimonials, and pages
- **Recent Submissions**: See the latest 8 contact submissions in real-time
- **Quick Actions**: Add new projects, services, testimonials quickly
- **System Information**: Monitor WordPress, PHP, MySQL versions

### Contact Management
- **Full Contact List**: View all contact submissions in a beautiful table format
- **Search Functionality**: Filter contacts by name, email, or phone
- **Export to CSV**: Export all contacts for external analysis
- **Detailed View**: Click any contact to see full details
- **Delete Contacts**: Remove outdated submissions (with confirmation)
- **Pagination**: Browse contacts 20 per page

### Settings
- **Phone Number**: Set business phone number
- **Email Address**: Configure contact email
- **Business Address**: Add your physical location
- **WhatsApp URL**: Set WhatsApp direct message link
- **System Info**: View current server configuration
- **Quick Links**: Fast access to WordPress settings, plugins, and themes

---

## ⚙️ Configuration

### Contact Information Settings

1. Navigate to **Settings** in the admin panel
2. Fill in your business information:
   - **Phone**: +60 12-345 6789 (format as needed)
   - **Email**: hello@puchongglass.com
   - **Address**: Puchong, Selangor 58000
   - **WhatsApp**: https://wa.me/60123456789

3. Click **Save Settings**

### WhatsApp Configuration
The WhatsApp URL format must be:
```
https://wa.me/[COUNTRY_CODE][PHONE_NUMBER]
```

Examples:
- Malaysia: `https://wa.me/60123456789`
- USA: `https://wa.me/1234567890`
- UK: `https://wa.me/441234567890`

---

## 🚀 Usage

### Viewing Contacts
1. Click **Contact List** in the sidebar
2. All contacts are displayed in a sortable table
3. Use search bar to filter by name, email, or phone
4. Click **View** to see full details in WordPress editor

### Exporting Contacts
1. Go to **Contact List**
2. Click **Export CSV** button
3. File downloads automatically with format: `contacts-YYYY-MM-DD-HH-ii-ss.csv`
4. Open in Excel, Google Sheets, or any spreadsheet application

### Deleting Contacts
1. Find contact in the list
2. Click **Delete** button in the Actions column
3. Confirm deletion
4. Contact is permanently removed

### Adding Content
From the Dashboard, quickly add:
- **New Project**: Click "Add Project" button
- **New Service**: Click "Add Service" button
- **New Testimonial**: Click "Add Testimonial" button
- **New Page**: Click "Edit Pages" button

### Managing Settings
1. Click **Settings** in sidebar
2. Update contact information as needed
3. View system information and server details
4. Access WordPress settings, plugins, and theme customization

---

## 🔒 Security Features

✅ **WordPress Nonce Verification**: All forms protected
✅ **User Role Checking**: Only administrators can access
✅ **Input Sanitization**: All data sanitized and validated
✅ **SQL Injection Protection**: Uses WordPress prepared statements
✅ **XSS Protection**: All output escaped properly
✅ **CSRF Protection**: Nonce tokens on all forms

---

## 🎨 Design & UX

### Modern Features
- **Glassmorphism**: Beautiful glass effect in sidebar
- **Responsive Design**: Works perfectly on mobile, tablet, desktop
- **Dark Mode Support**: Automatically adapts to system preferences
- **Smooth Animations**: Fade-in effects and transitions
- **Accessible**: WCAG compliant with keyboard navigation
- **Performance**: Optimized and lightweight

### Color Scheme
- **Primary**: Blue (#3b82f6)
- **Success**: Green (#10b981)
- **Warning**: Yellow (#f59e0b)
- **Danger**: Red (#ef4444)
- **Info**: Indigo (#6366f1)

---

## 📊 Contact Data Structure

Each contact submission contains:
- **Name**: Full name of person
- **Email**: Contact email address
- **Phone**: Contact phone number
- **Service**: Service interested in
- **Message**: Full inquiry message
- **Date**: Submission timestamp
- **IP Address**: Submitter's IP address

---

## 🔧 Troubleshooting

### Admin Panel Not Appearing
**Problem**: "Admin Panel" menu item missing from WordPress sidebar
**Solution**:
1. Ensure you're logged in as Administrator
2. Deactivate and reactivate the theme
3. Clear WordPress cache (if using cache plugin)

### Contact List Empty
**Problem**: No contacts showing in contact list
**Solution**:
1. Check that contact form is functional on website
2. Verify "contact" post type is registered (check functions.php)
3. Visit site's contact page and submit a test message

### Export Not Working
**Problem**: Export button not triggering download
**Solution**:
1. Ensure you have manage_options capability
2. Check browser console for errors (F12)
3. Verify PHP output buffering isn't interfering

### Settings Not Saving
**Problem**: Changes not persisting after clicking Save
**Solution**:
1. Verify WordPress database connection
2. Check that wp_options table exists
3. Ensure file permissions are correct (644 for files, 755 for directories)

### Permissions Error
**Problem**: "Access Denied" message when accessing admin panel
**Solution**:
1. Only administrators can access
2. Ask site owner to promote your user role
3. Use administrator account to verify it works

---

## 📱 Mobile Access

The admin panel is fully responsive:
- **Sidebar collapses** on tablets
- **Touch-friendly** buttons and links
- **Optimized tables** for small screens
- **Full functionality** on all devices

---

## 🔄 Automated Functions

The following run automatically:

1. **Contact Email Notifications**
   - Admin receives email on new submission
   - User receives confirmation email

2. **Contact Data Storage**
   - All submissions saved as "contact" post type
   - Metadata stored for easy retrieval

3. **IP Logging**
   - Submission source IP logged
   - Helps identify and prevent spam

4. **Date Tracking**
   - All submissions timestamped
   - Sorted by most recent first

---

## 🌐 Frontend Integration

The contact form on your website automatically:
1. Validates input (client and server-side)
2. Sends emails to admin and user
3. Stores submission in database
4. Appears in admin panel contact list

---

## 🚀 Performance Tips

1. **Regular Cleanup**: Delete old contacts occasionally
2. **Backup**: Export contacts regularly to CSV
3. **Monitor**: Check dashboard daily for new inquiries
4. **Update**: Keep WordPress and plugins updated

---

## 📞 Support

For additional help:
1. Check WordPress documentation: https://wordpress.org/support/
2. Review theme files in `/wp-content/themes/puchong-glass/`
3. Contact theme developer for customization

---

## 📝 Version History

**v2.0.0** (Current)
- Modern admin panel with dashboard
- Contact list management
- Export to CSV
- Settings management
- Beautiful glassmorphism design
- Full responsive support
- Enhanced security features

---

**Last Updated**: November 22, 2025
**Theme Version**: 2.0.0
**Author**: Senior Engineer Team
