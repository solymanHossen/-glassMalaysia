# 🚀 Quick Setup Guide - Custom Dashboard

## Immediate Setup Steps

### Step 1: Activate Database Table
The database table is created automatically when you switch to this theme. But if you need to manually create it:

1. Go to WordPress Admin
2. Navigate to **Tools → Site Health → Info**
3. Or run this code in **Appearance → Theme Editor** (temporarily):
```php
<?php
pg_create_contact_table();
echo "Database table created successfully!";
?>
```

### Step 2: Test Contact Form
1. Visit your website's Contact page
2. Fill out and submit the form
3. Check your email for notification
4. Go to **Dashboard** to see the submission

### Step 3: Configure Dashboard
1. Go to WordPress **Dashboard**
2. You should see these new widgets:
   - 📬 Contact Form Submissions
   - 📊 Website Statistics
   - 🛡️ Recent Services
   - 🖼️ Recent Portfolio Projects
   - ⚡ Quick Actions

3. Arrange them by dragging (if needed)

### Step 4: Access All Contacts
1. Look for **Contact Forms** in the left sidebar menu
2. Click it to see all submissions
3. Try bulk actions and export features

---

## 🎯 What You Get

### On Dashboard Homepage:
```
┌─────────────────────────────────────┐
│  👋 Welcome back, [Your Name]!      │
│  Manage your Puchong Glass website  │
│  [Quick Action Buttons]             │
└─────────────────────────────────────┘

┌──────────────┐  ┌──────────────┐
│ 📬 Contacts  │  │ 📊 Stats     │
│ - Total: 15  │  │ Services: 8  │
│ - Unread: 3  │  │ Portfolio: 6 │
│ - Today: 2   │  │ Pages: 5     │
│              │  │ Users: 2     │
│ [Recent list]│  │              │
└──────────────┘  └──────────────┘

┌──────────────┐  ┌──────────────┐
│ 🛡️ Services  │  │ 🖼️ Portfolio  │
│ Latest 5     │  │ Latest 5     │
└──────────────┘  └──────────────┘

┌──────────────┐
│ ⚡ Quick      │
│   Actions    │
│ [4 Buttons]  │
└──────────────┘
```

### In Contact Forms Page:
```
📬 Contact Form Submissions
[📥 Export to CSV] [← Back to Dashboard]

[Bulk Actions Dropdown] [Apply]

┌─────────────────────────────────────┐
│ ☑️ Name | Email | Phone | Message  │
│ ☑️ John | john@ | +60.. | Need... │
│ ☑️ Mary | mary@ | +60.. | Quote.. │
└─────────────────────────────────────┘

Pagination: ‹ 1 of 5 ›
```

---

## 🎨 Features Checklist

After setup, verify these features work:

- [ ] Contact form submits successfully
- [ ] Email notification received
- [ ] Submission appears on dashboard
- [ ] Can mark contacts as read/archived
- [ ] Can delete contacts
- [ ] Bulk actions work
- [ ] CSV export downloads
- [ ] Statistics show correct counts
- [ ] Quick actions navigate correctly
- [ ] Mobile responsive (check on phone)

---

## ⚙️ Customization Options

### Change Colors
Edit `/assets/css/admin.css`:
```css
/* Primary color */
#0A2342 → Your color

/* Secondary color */
#1E5A8E → Your color

/* Accent color */
#D4AF37 → Your color
```

### Change Email Template
Edit `functions.php` in `pg_handle_contact_form()`:
```php
$body = "Custom email template here";
```

### Add Custom Fields
Edit contact form in `page-contact.php` and update:
1. Database table structure
2. AJAX handler
3. Widget display
4. CSV export

### Hide Default Widgets
Uncomment lines in `pg_remove_default_dashboard_widgets()`:
```php
remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
// etc.
```

---

## 🔧 Common Issues & Solutions

### Issue: Contact form not submitting
**Solution:**
1. Check browser console for errors
2. Verify AJAX URL is correct
3. Check nonce is generated
4. Review server error logs

### Issue: No email notifications
**Solution:**
1. Install WP Mail SMTP plugin
2. Configure SMTP settings
3. Test with WP Mail SMTP test feature
4. Check spam folder

### Issue: Dashboard widgets not showing
**Solution:**
1. Click "Screen Options" (top right)
2. Check all widget boxes
3. Scroll down to see them
4. Clear browser cache

### Issue: CSV export is empty
**Solution:**
1. Check if contacts exist in database
2. Verify user has admin permissions
3. Check PHP error logs
4. Try different browser

---

## 📊 Database Management

### View Contacts in Database
Using phpMyAdmin or Adminer:
```sql
SELECT * FROM wp_pg_contacts ORDER BY submitted_at DESC;
```

### Count by Status
```sql
SELECT status, COUNT(*) as count 
FROM wp_pg_contacts 
GROUP BY status;
```

### Delete Old Contacts (older than 6 months)
```sql
DELETE FROM wp_pg_contacts 
WHERE submitted_at < DATE_SUB(NOW(), INTERVAL 6 MONTHS);
```

### Backup Contacts Table
```bash
mysqldump -u username -p database_name wp_pg_contacts > contacts_backup.sql
```

---

## 🚀 Performance Tips

1. **Regular Cleanup**: Archive or delete old contacts monthly
2. **Database Optimization**: Run `OPTIMIZE TABLE wp_pg_contacts` quarterly
3. **Pagination**: Default is 20 per page (adjustable in code)
4. **Email Queue**: For high volume, consider using WP Mail Queue plugin
5. **Caching**: Use object caching for statistics

---

## 📱 Mobile App Integration

The AJAX endpoints can be used by mobile apps:

**Submit Contact:**
```
POST /wp-admin/admin-ajax.php
action: pg_contact_form
nonce: [generated nonce]
name: John Doe
phone: +60123456789
email: john@example.com
message: Your message here
```

**Response:**
```json
{
  "success": true,
  "data": {
    "message": "Thank you! Your message has been sent."
  }
}
```

---

## 🔐 Security Best Practices

1. **Regular Updates**: Keep WordPress and theme updated
2. **Strong Passwords**: Use strong admin passwords
3. **Limit Login Attempts**: Install Limit Login Attempts plugin
4. **SSL Certificate**: Ensure site uses HTTPS
5. **Regular Backups**: Backup database including contacts table
6. **Monitor Logs**: Check for suspicious activity
7. **Spam Protection**: Consider adding reCAPTCHA to contact form

---

## 📈 Analytics Integration

Track form submissions with Google Analytics:

Add to contact form success callback:
```javascript
gtag('event', 'form_submit', {
  'event_category': 'Contact',
  'event_label': 'Contact Form'
});
```

Or use GTM to track form submissions.

---

## 🎓 Training Resources

For your team:
1. **Admin Login**: Provide admin credentials
2. **Quick Tour**: Show dashboard widgets
3. **Contact Management**: Demo marking as read/archive
4. **Export**: Show how to download CSV
5. **Email Replies**: Show reply via email button

---

## 📞 Need Help?

If you encounter issues:
1. Check `DASHBOARD_README.md` for detailed docs
2. Review WordPress error logs
3. Check browser console
4. Contact theme developer

---

## ✅ Success Checklist

Before going live:
- [ ] Test contact form submission
- [ ] Verify email notifications work
- [ ] Test all dashboard features
- [ ] Try CSV export
- [ ] Check mobile responsiveness
- [ ] Test bulk actions
- [ ] Verify security (nonces, sanitization)
- [ ] Set up email SMTP
- [ ] Configure backup system
- [ ] Train admin users

---

**Setup Complete!** 🎉

Your custom dashboard is now ready to use. Start receiving and managing contact form submissions efficiently!
