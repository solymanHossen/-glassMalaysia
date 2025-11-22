# ⚡ QUICK SETUP GUIDE

## 🚨 Fix Your 404 Error in 3 Steps:

### Problem:
Getting "Not Found" errors when clicking Services, Contact, etc.?

### Solution:

#### Step 1: Create All Pages ✅
Visit (as admin):
```
http://localhost/wordpress/?create_theme_pages=true
```

This automatically creates:
- Home
- Services
- Portfolio
- Contact
- About
- FAQ

#### Step 2: Fix Permalinks ⚙️ (MOST IMPORTANT!)
1. Go to: **WordPress Admin > Settings > Permalinks**
2. Click on: **"Post name"** (the option that shows `/%postname%/`)
3. Click: **"Save Changes"**

**This is REQUIRED** - Without this, all pages will show 404 errors!

#### Step 3: Add Content 📝
Visit (as admin):
```
http://localhost/wordpress/?install_sample_data=true
```

This adds dummy content (services, portfolio, FAQs, testimonials)

---

## 🎯 That's It!

Now visit:
- http://localhost/wordpress/ (Homepage)
- http://localhost/wordpress/services/ (Should work!)
- http://localhost/wordpress/contact/ (Should work!)
- http://localhost/wordpress/portfolio/ (Should work!)

---

## ❓ Still Getting 404?

### Check This:
1. **Are pages created?**
   - Go to: WordPress Admin > Pages
   - Should see: Home, Services, Contact, Portfolio, About, FAQ

2. **Did you save permalinks?**
   - Go to: Settings > Permalinks
   - Make sure "Post name" is selected
   - Click "Save Changes" again

3. **Is homepage set?**
   - Go to: Settings > Reading
   - Should show: "A static page" with "Home" selected

---

## 🔗 Correct URL Structure

After fixing permalinks, your URLs should be:

✅ **Correct:**
- http://localhost/wordpress/
- http://localhost/wordpress/services/
- http://localhost/wordpress/contact/
- http://localhost/wordpress/portfolio/

❌ **Wrong (without pages or permalinks):**
- http://localhost/wordpress/services/ → 404 Error
- http://localhost/wordpress/contact/ → 404 Error

---

## 🆘 Emergency Fix

If nothing works, run these in order:

1. **Create pages:** `?create_theme_pages=true`
2. **Go to admin:** Settings > Permalinks
3. **Select:** "Post name"
4. **Click:** "Save Changes"
5. **Visit:** http://localhost/wordpress/services/

Should work now! ✅
