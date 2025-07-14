
#  Day 7: **Final Project + Complete Recap**

---

## 🎯 Day 7 Objectives

By the end of this session, you will:

* Build a production-ready plugin with layered filter architecture.
* Combine built-in + custom filters.
* Recap and reinforce everything from Day 1 to 6.
* Be ready to **ship WordPress plugins** like a pro.

---

## 🛠️ Final Project: **Aditya Dynamic Footer**

### 🔹 Goal:

Create a plugin that:

1. Displays a custom footer message on **every page**.
2. Uses filters to:

   * Modify message (`aditya_footer_message`)
   * Modify style (`aditya_footer_style`)
   * Enable/disable (`aditya_footer_enable`)
   * Allow page-specific override (`aditya_footer_override`)

---

## 📁 Plugin Structure

```
aditya-dynamic-footer/
└── aditya-dynamic-footer.php
```

---

## 📄 `aditya-dynamic-footer.php`

```php
<?php
/*
Plugin Name: Aditya Dynamic Footer
Description: Adds a customizable footer message on every page using WordPress filters.
Version: 1.0
Author: Aditya Dubey
*/

defined('ABSPATH') || exit;

// Step 1: Hook into footer via action
add_action('wp_footer', 'aditya_show_footer');

function aditya_show_footer() {
    // Step 2: Check if footer is enabled
    $enabled = apply_filters('aditya_footer_enable', true);
    if (!$enabled) return;

    // Step 3: Allow override for specific pages
    $override = apply_filters('aditya_footer_override', null);
    if ($override !== null) {
        $message = $override;
    } else {
        $message = apply_filters('aditya_footer_message', '🚀 Thank you for visiting Aditya’s website!');
    }

    // Step 4: Get style
    $style = apply_filters('aditya_footer_style', 'text-align:center;padding:10px;margin-top:30px;color:#555;font-size:0.95em;');

    echo "<div class='aditya-dynamic-footer' style='$style'>$message</div>";
}
```

---

## 🧪 Use Case Examples

### ✅ In your theme `functions.php`, try:

```php
// Custom message
add_filter('aditya_footer_message', function($msg) {
    return "🌟 Made with ❤️ by Aditya Dev Studio";
});

// Style change
add_filter('aditya_footer_style', function($style) {
    return $style . ' background: #f8f9fa;';
});

// Disable on Contact page
add_filter('aditya_footer_enable', function($enabled) {
    return !is_page('contact');
});

// Override message only on Homepage
add_filter('aditya_footer_override', function($override) {
    if (is_front_page()) {
        return "🏡 Welcome to the homepage!";
    }
    return null;
});
```

🔁 You’ve now built a **smart, filter-driven component** that adapts to different pages without hardcoding.

---

## ✅ Recap: Filter Mastery Review

| Day | Focus Area                   | Key Concepts Covered                          |
| --- | ---------------------------- | --------------------------------------------- |
| 1   | Intro to Filters             | `add_filter`, `apply_filters`, simple hooks   |
| 2   | Built-in WordPress Filters   | `the_title`, `the_content`, `body_class` etc. |
| 3   | Filters + Conditionals       | `is_single()`, `is_page()`, `is_home()`       |
| 4   | Creating Custom Filters      | Writing your own `apply_filters()` hooks      |
| 5   | Advanced Usage               | Priority, chaining, closures, multi-arg       |
| 6   | Plugin Building with Filters | Full plugin + extensibility                   |
| 7   | Final Project + Master Recap | Extensible component using filters            |

---

## 🧪 Homework (Certification Challenge – Optional)

Build a plugin named:
**`aditya-content-transformer`**

**Requirements:**

1. Hook into `the_content`
2. Use filters:

   * `act_enable_transform` → true/false
   * `act_prepend_message` → Add message at the top
   * `act_append_message` → Add message at the end
   * `act_transform_content` → Apply transformations (e.g., bold, emoji, etc.)

📩 Submit your `.php` code here and I’ll do a **full plugin review**, like a real open-source project check.

---

## 🏅 Filter Mastery Badge

You’ve now learned **100% of what professional WordPress plugin developers know** about filters.

🎉 **Claim your win:**

* ✅ You understand filters from scratch to pro.
* ✅ You can write AND expose your own hooks.
* ✅ You can build plugins extensibly.

---

