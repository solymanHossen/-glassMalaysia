# 🔧 Troubleshooting Guide

## Common Issues and Solutions

---

## Issue: "Failed to submit form. Please try again."

### Problem
The contact form shows this error when submitting.

### Cause
The database table `wp_pg_contacts` doesn't exist.

### Solution 1: Automatic Fix (Recommended)
1. Go to WordPress Admin (`/wp-admin`)
2. Visit any admin page
3. The table will be created automatically
4. Try submitting the form again

### Solution 2: Manual Database Creation
Run this in your MySQL/phpMyAdmin:

```sql
CREATE TABLE IF NOT EXISTS wp_pg_contacts (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    name varchar(255) NOT NULL,
    phone varchar(50) NOT NULL,
    email varchar(255) NOT NULL,
    message text NOT NULL,
    submitted_at datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
    status varchar(20) DEFAULT 'unread' NOT NULL,
    notes text,
    PRIMARY KEY (id)
) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### Solution 3: Using WP-CLI
```bash
wp db query "CREATE TABLE IF NOT EXISTS wp_pg_contacts (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    name varchar(255) NOT NULL,
    phone varchar(50) NOT NULL,
    email varchar(255) NOT NULL,
    message text NOT NULL,
    submitted_at datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
    status varchar(20) DEFAULT 'unread' NOT NULL,
    notes text,
    PRIMARY KEY (id)
) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

### Verification
Check if table exists:
```sql
SHOW TABLES LIKE 'wp_pg_contacts';
```

---

## Issue: Dashboard Widgets Not Showing

### Problem
Custom dashboard widgets are missing.

### Solutions

#### Check Screen Options
1. Go to Dashboard
2. Click "Screen Options" (top right corner)
3. Check all widget boxes
4. Scroll down to see widgets

#### Clear Browser Cache
1. Press `Ctrl + Shift + Delete` (or `Cmd + Shift + Delete` on Mac)
2. Clear cache
3. Refresh page

#### Check User Role
- Only administrators can see custom widgets
- Editor/Subscriber roles won't see Contact Forms menu

---

## Issue: Email Notifications Not Working

### Problem
Admin doesn't receive emails when form is submitted.

### Solutions

#### 1. Check Spam Folder
Look in spam/junk folder of admin email

#### 2. Verify Admin Email
1. Go to **Settings → General**
2. Check "Administration Email Address"
3. Make sure it's correct

#### 3. Install SMTP Plugin
WordPress default mail may not work on all servers.

**Recommended Plugin:** WP Mail SMTP
1. Install "WP Mail SMTP" plugin
2. Configure SMTP settings (Gmail, SendGrid, etc.)
3. Test email sending

#### 4. Test Email Function
Add this to functions.php temporarily:
```php
wp_mail('your-email@example.com', 'Test', 'This is a test email');
```

---

## Issue: AJAX Not Working

### Problem
Form submission doesn't respond or page reloads.

### Check jQuery Loading

Add to page-contact.php before closing `</body>`:
```html
<script>
console.log('jQuery loaded:', typeof jQuery !== 'undefined');
console.log('AJAX URL:', '<?php echo admin_url('admin-ajax.php'); ?>');
</script>
```

### Check Browser Console
1. Press `F12` to open Developer Tools
2. Go to Console tab
3. Look for JavaScript errors
4. Share errors with developer

---

## Issue: CSV Export Empty

### Problem
Downloaded CSV file is empty.

### Solutions

#### Check Contacts Exist
```sql
SELECT COUNT(*) FROM wp_pg_contacts;
```

#### Check User Permissions
- Must be logged in as Administrator
- Must have `manage_options` capability

#### Try Different Browser
- Chrome
- Firefox
- Safari

---

## Issue: Database Error on Form Submission

### Problem
Form shows database error.

### Check Database Permissions
User must have permissions:
- SELECT
- INSERT
- UPDATE
- DELETE

### Check Table Structure
```sql
DESCRIBE wp_pg_contacts;
```

Should have these columns:
- id
- name
- phone
- email
- message
- submitted_at
- status
- notes

---

## Issue: Styling Issues

### Problem
Dashboard looks broken or unstyled.

### Solutions

#### Clear Cache
1. Clear browser cache
2. Clear WordPress cache (if using cache plugin)

#### Check File Exists
Verify `/wp-content/themes/puchong-glass/assets/css/admin.css` exists

#### Check File Permissions
```bash
chmod 644 wp-content/themes/puchong-glass/assets/css/admin.css
```

---

## Issue: Status Not Updating

### Problem
Can't mark contacts as read/archived.

### Solutions

#### Check AJAX Handler
Look in browser console for errors

#### Check User Permissions
Only administrators can update status

#### Check Nonce
Make sure nonces are being generated

---

## Issue: Bulk Actions Not Working

### Problem
Bulk actions don't apply to selected contacts.

### Solutions

#### Select Contacts
- Make sure checkboxes are checked
- Try clicking "Select All" checkbox

#### Choose Action
- Select action from dropdown
- Click "Apply" button

#### Check Console
Look for JavaScript errors in console

---

## Debug Mode

Enable WordPress debug mode to see errors:

Edit `wp-config.php`:
```php
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);
```

Check errors in: `/wp-content/debug.log`

---

## Still Having Issues?

### Gather This Information:
1. WordPress version
2. PHP version
3. Theme version
4. Error messages (from console/debug.log)
5. What you were doing when error occurred

### Check Logs:
- Browser Console (F12 → Console)
- WordPress Debug Log (`/wp-content/debug.log`)
- Server Error Log

### Get Help:
1. Check all documentation files
2. Review code comments
3. Contact theme developer

---

## Quick Diagnostic Commands

### Check if table exists:
```bash
wp db query "SHOW TABLES LIKE 'wp_pg_contacts';"
```

### Count contacts:
```bash
wp db query "SELECT COUNT(*) FROM wp_pg_contacts;"
```

### View recent contacts:
```bash
wp db query "SELECT * FROM wp_pg_contacts ORDER BY submitted_at DESC LIMIT 5;"
```

### Delete all contacts (CAREFUL!):
```bash
wp db query "DELETE FROM wp_pg_contacts;"
```

### Reset table (CAREFUL! Deletes all data):
```bash
wp db query "DROP TABLE IF EXISTS wp_pg_contacts;"
# Then visit admin dashboard to recreate
```

---

## Prevention Tips

### Regular Maintenance
- Export contacts monthly (backup)
- Clean up old/archived contacts
- Check debug logs periodically
- Test form submission monthly

### Monitoring
- Check email notifications work
- Verify dashboard loads fast
- Test on mobile devices
- Monitor database size

### Security
- Keep WordPress updated
- Use strong passwords
- Install security plugin
- Regular backups

---

## Emergency Recovery

### If Everything Breaks:

1. **Deactivate Theme**
   - Switch to Twenty Twenty-Four
   - Contact developer

2. **Backup Database**
   ```bash
   wp db export backup.sql
   ```

3. **Export Contacts (if possible)**
   - Via phpMyAdmin
   - Via WP-CLI

4. **Restore Previous Version**
   - Via Git: `git checkout [previous-commit]`
   - Via backups

---

## Success Checklist

After fixing any issue, verify:
- [ ] Contact form submits successfully
- [ ] Email notification received
- [ ] Submission appears on dashboard
- [ ] Can view all contacts page
- [ ] CSV export works
- [ ] Status updates work
- [ ] No console errors
- [ ] No PHP errors

---

**Need More Help?**
Check other documentation:
- SETUP_GUIDE.md
- DASHBOARD_README.md
- TESTING_CHECKLIST.md

**Last Updated:** November 23, 2025
