# Work with The Loop and display blog posts

> Tasks:

1. Added Loop in `home.php` to display posts (`have_posts()` and `the_post()`)

2. Added `the_title()` and `the_excerpt() or the_content()`
3. Added featured image support. (`add_theme_support('post-thumbnails')`)
4. Added a Read More link, and excerpt with `the_excerpt()`
5. Styled post grid with custom CSS.


---

## Featured Images (post thumbnails) and custom image size of featured images

To display **featured images (post thumbnails)** in your theme, you need to **enable support** using `add_theme_support('post-thumbnails')`. Let’s do this step-by-step:

---

##  Step 1: Enable Featured Image Support

📄 Open (or create) your theme’s `functions.php` file.

Add this code inside:

```php
<?php
// Theme setup
function theme_hierarchy_test_setup() {
    add_theme_support('post-thumbnails'); // ✅ Enable featured image support
}
add_action('after_setup_theme', 'theme_hierarchy_test_setup');
```

---

##  Step 2: Display the Featured Image in `home.php` (or any template with the loop)

Inside your loop in `home.php`, add this:

```php
<?php if ( has_post_thumbnail() ) : ?>
    <div class="post-thumbnail">
        <?php the_post_thumbnail('medium'); // You can use 'thumbnail', 'medium', 'large', or custom sizes ?>
    </div>
<?php endif; ?>
```

 Place this before or after the title inside the loop.

---

##  Step 3: Set Featured Image in Admin

1. Go to **Posts > All Posts**
2. Click **Edit** on a post
3. In the right sidebar, find **Featured Image**
4. Click “Set Featured Image” and upload or select an image

---

##  Optional: Custom Image Size

You can define a custom image size in `functions.php`:

```php
add_image_size('custom-thumb', 400, 300, true); // 400x300 hard crop
```

Then use it like this:

```php
the_post_thumbnail('custom-thumb');
```

---

##  Summary

| Task                      | Status               |
| ------------------------- | -------------------- |
| Enabled `post-thumbnails` | ✅ In `functions.php` |
| Displayed thumbnail       | ✅ In `home.php` loop |
| Set image from admin      | ✅ Using WordPress UI |

---

