# Wordpress Theme Development - Fundamentals 

Let's build a **simple WordPress theme** together, step by step.
---

##  Step 0: **What is a WordPress Theme?**

A **WordPress theme** is a collection of templates, styles, and functions that control how your website looks and behaves on the front end. Think of it as the "clothing" for your site.

---

##  Step 1: **Set Up Your Environment**

###  Tools You Need

1. **Local Server** like:

   * [XAMPP](https://www.apachefriends.org)
   * [LocalWP](https://localwp.com)
2. **Code Editor**: VS Code recommended.
3. **WordPress Core** installed locally.
4. A browser (Chrome/Firefox).

Once you have a working local WordPress site (e.g. `http://localhost/wpaditya/`), let’s move on.

---

##  Step 2: **Create Your Theme Folder**

### Go to:

`wp-content/themes/`

Create a new folder, name it:

```plaintext
myfirsttheme
```

Inside it, add the following **minimum required files**:

### 1. `style.css` – Required!

```css
/*
Theme Name: My First Theme
Author: Aditya Dubey
Version: 1.0
Description: A simple theme for learning.
*/
```

### 2. `index.php` – Required!

```php
<!DOCTYPE html>
<html>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <title><?php bloginfo('name'); ?></title>
    <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">
</head>
<body>
    <h1><?php bloginfo('name'); ?></h1>
    <p><?php bloginfo('description'); ?></p>

    <?php
    if ( have_posts() ) :
        while ( have_posts() ) : the_post();
            the_title('<h2>', '</h2>');
            the_content();
        endwhile;
    else :
        echo '<p>No content found</p>';
    endif;
    ?>
</body>
</html>
```

---

##  Step 3: **Activate the Theme**

* Go to `wp-admin`
* Appearance > Themes
* You’ll see **"My First Theme"** – click **Activate**

Now open your local site — you’ll see your new theme working!

---

##  Step 4: **Break It Into Template Parts**

For better structure, split files like this:

### Add:

* `header.php`
* `footer.php`

### Move HTML from `index.php` to:

#### `header.php`

```php
<!DOCTYPE html>
<html>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <title><?php bloginfo('name'); ?></title>
    <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">
</head>
<body>
    <header>
        <h1><?php bloginfo('name'); ?></h1>
        <p><?php bloginfo('description'); ?></p>
    </header>
```

#### `footer.php`

```php
    <footer>
        <p>&copy; <?php echo date('Y'); ?> - My First Theme</p>
    </footer>
</body>
</html>
```

#### Update `index.php`

```php
<?php get_header(); ?>

<main>
<?php
if ( have_posts() ) :
    while ( have_posts() ) : the_post();
        the_title('<h2>', '</h2>');
        the_content();
    endwhile;
else :
    echo '<p>No content found</p>';
endif;
?>
</main>

<?php get_footer(); ?>
```

---

##  Step 5: **Understand the Template Hierarchy**

Here’s what WordPress looks for when loading pages:

* `front-page.php` – for homepage
* `single.php` – for single blog post
* `page.php` – for static pages
* `index.php` – fallback if others don’t exist

---

##  Step 6: **Add Functions with `functions.php`**

Create a file: `functions.php`

```php
<?php

function myfirsttheme_enqueue_styles() {
    wp_enqueue_style('style', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'myfirsttheme_enqueue_styles');
```

This is the **proper WordPress way** to include CSS.

---

##  Your First Theme is Ready!

You now have:

* A working theme
* Proper structure
* Header/Footer split
* Posts displayed dynamically
* Styles enqueued properly

---

## What is bloginfo('') function?

### Syntax:

```php
bloginfo( string $show )
```

### Parameters:

* `$show` (string) — This specifies what kind of information you want to retrieve. It can be values like `'name'`, `'description'`, `'url'`, `'wpurl'`, etc.

### Common Examples:

```php
<!-- Get the site title -->
<title><?php bloginfo('name'); ?></title>

<!-- Get the site tagline/description -->
<p><?php bloginfo('description'); ?></p>

<!-- Get the site's main URL -->
<a href="<?php bloginfo('url'); ?>">Home</a>

<!-- Get the WordPress installation URL -->
<?php bloginfo('wpurl'); ?>

<!-- Get the character set -->
<meta charset="<?php bloginfo('charset'); ?>" />

<!-- Get the HTML type -->
<?php bloginfo('html_type'); ?>
```

### Common `bloginfo()` Options:

| Option             | Description                                     |
| ------------------ | ----------------------------------------------- |
| `'name'`           | Site title (set in General Settings)            |
| `'description'`    | Site tagline                                    |
| `'wpurl'`          | URL of the WordPress installation               |
| `'url'`            | Site URL (may differ from `wpurl`)              |
| `'admin_email'`    | Admin email address                             |
| `'charset'`        | Character encoding for the site (usually UTF-8) |
| `'version'`        | WordPress version number                        |
| `'language'`       | Language of the site                            |
| `'stylesheet_url'` | URL to the active theme’s style.css file        |
| `'template_url'`   | URL to the active theme’s directory             |

### Echo vs Return:

* `bloginfo()` **echoes** the result directly.
* Use `get_bloginfo()` if you want to **return** the result instead of echoing it:

  ```php
  $site_name = get_bloginfo('name');
  ```

### Use Case:

It is commonly used in theme development for dynamically populating templates with site information.

---

## What is get_header() function ?

Using `get_header()` with arguments is a feature added in **WordPress 5.5**, allowing you to **pass data** to your header template when calling custom versions of it. This is helpful when you want to load a custom header and pass context-specific data (e.g. page type, user info, etc.).

---

###  Syntax:

```php
get_header( string $name = null, array $args = array() );
```

* `$name` (optional): Loads `header-{name}.php` instead of `header.php`.
* `$args` (optional): Passes an associative array of arguments to the header file.

---

###  Example: Using `get_header()` with arguments

#### 1. **Call it in a template:**

```php
<?php 
get_header('custom', array(
    'title' => 'Welcome to My Custom Page',
    'show_banner' => true
));
?>
```

This looks for `header-custom.php`.

---

#### 2. **Inside `header-custom.php`:**

```php
<?php
// Access the arguments
$args = isset($args) ? $args : array();

// Use them
if (!empty($args['title'])) {
    echo '<h1>' . esc_html($args['title']) . '</h1>';
}

if (!empty($args['show_banner'])) {
    echo '<div class="banner">This is a banner</div>';
}
?>
```

>  **Note:** `$args` is automatically available in the template part file, thanks to WordPress's internal use of `get_template_part()` when calling `get_header()`.

---

###  When to Use Arguments in `get_header()`:

* Different layouts for different sections (e.g., blog vs. shop)
* Dynamic content in header (like banners, titles, styles)
* Controlling logic or CSS classes in the header

---

###  Fallback Behavior:

If `header-custom.php` doesn’t exist, WordPress will **fall back to `header.php`**, but **arguments will not be passed** unless the file supports them.

---

---

## What is have_posts and the_post() function?

The `have_posts()` function is a core part of **The Loop** in WordPress. It’s used to check whether there are any posts to display, typically in queries for blog posts, custom post types, or search results.

---

###  Syntax:

```php
have_posts();
```

---

###  What It Does:

* Returns `true` **if there are more posts to loop through**, and `false` when there are none.
* Works in conjunction with `the_post()` to iterate over each post.

---

###  Typical Usage (The Loop):

```php
<?php if ( have_posts() ) : ?>
    <?php while ( have_posts() ) : the_post(); ?>
        <h2><?php the_title(); ?></h2>
        <div><?php the_content(); ?></div>
    <?php endwhile; ?>
<?php else : ?>
    <p>No posts found.</p>
<?php endif; ?>
```

---

###  How It Works:

* `have_posts()` checks the global `$wp_query` object to see if there are posts left.
* Each time it's called, it prepares for the next post.
* `the_post()` advances the internal post pointer and sets up post data.

---

###  Important Notes:

| Function         | Purpose                                      |
| ---------------- | -------------------------------------------- |
| `have_posts()`   | Checks if there are posts in the query       |
| `the_post()`     | Moves to the next post and sets up post data |
| `rewind_posts()` | Resets the post loop so it can run again     |

---

###  Example with Rewinding:

```php
<?php
if ( have_posts() ) {
    while ( have_posts() ) {
        the_post();
        echo the_title('<h2>', '</h2>');
    }

    // Rewind and run a second loop (e.g., for summaries)
    rewind_posts();

    while ( have_posts() ) {
        the_post();
        the_excerpt();
    }
}
?>
```

---

###  Use Cases:

* In `index.php`, `archive.php`, `home.php`, `search.php`, etc.
* For custom loops using `WP_Query` or `query_posts()`.

---

## What is add_action() function?

The `add_action()` function in WordPress is used to **register a custom function (a callback)** to a specific **action hook**. It's a fundamental part of how you **extend or modify WordPress functionality** without editing core files.

---

###  Syntax:

```php
add_action( $hook_name, $callback_function, $priority, $accepted_args );
```

---

###  Parameters:

| Parameter            | Description                                                                 |
| -------------------- | --------------------------------------------------------------------------- |
| `$hook_name`         | (string) The name of the action hook you want to attach your function to.   |
| `$callback_function` | (callable) The name of your custom function.                                |
| `$priority`          | (int, optional) Order in which functions are executed (default is `10`).    |
| `$accepted_args`     | (int, optional) Number of arguments your function accepts (default is `1`). |

---

###  Basic Example:

```php
function my_custom_function() {
    echo 'Hello, world!';
}

add_action('wp_footer', 'my_custom_function');
```

This example hooks your function to the `wp_footer` action, so “Hello, world!” is printed in the footer of the site.

---

###  Common WordPress Action Hooks:

| Hook Name            | Trigger Point                                      |
| -------------------- | -------------------------------------------------- |
| `init`               | After WordPress has loaded but before any headers  |
| `wp_enqueue_scripts` | For enqueueing scripts and styles                  |
| `admin_menu`         | When the admin menu is being constructed           |
| `wp_footer`          | Just before the closing `</body>` tag in the theme |
| `save_post`          | When a post is saved                               |

---

###  Example with Priority and Arguments:

```php
function notify_on_save( $post_id ) {
    // Custom logic, like sending an email
}
add_action( 'save_post', 'notify_on_save', 10, 1 );
```

---

###  Key Concept:

* WordPress triggers many **"action hooks"** at specific points during page load or processing.
* You can **hook into** these points using `add_action()` to run your code at just the right time.

---

###  Difference from `add_filter()`:

* `add_action()` is used when **you want to do something** (side effects).
* `add_filter()` is used when **you want to change something** (return modified data).

---
