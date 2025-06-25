# Get Template Part in WordPress

Let’s now create a **working example folder structure** and **demo layout** using `get_template_part()` in your custom WordPress theme.

---

##  Goal

We'll build a simple blog theme layout that:

- Displays posts using `get_template_part()`
- Is clean and reusable
- Follows modern theme practices

---

##  Folder Structure

```
your-theme/
├── style.css
├── index.php
├── functions.php
├── header.php
├── footer.php
└── template-parts/
    ├── content.php
    ├── content-none.php
    └── content-single.php
```

---

##  Step-by-Step File Setup

### 1. `style.css`

Just a theme header to make WP recognize your theme:

```css
/*
Theme Name: get template part
Author: Aditya Dubey
Version: 1.0
*/
```

---

### 2. `functions.php`

No need for much, just a basic setup:

```php
<?php
// Enable featured images
add_theme_support( 'post-thumbnails' );

// Load CSS
function mytheme_enqueue_styles() {
    wp_enqueue_style( 'main-style', get_stylesheet_uri() );
}
add_action( 'wp_enqueue_scripts', 'mytheme_enqueue_styles' );
```

---

### 3. `header.php`

```php
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <title><?php bloginfo('name'); ?></title>
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<header>
  <h1><?php bloginfo('name'); ?></h1>
  <p><?php bloginfo('description'); ?></p>
</header>
```

---

### 4. `footer.php`

```php
<footer>
  <p>&copy; <?php echo date('Y'); ?> - My Sample Theme</p>
</footer>

<?php wp_footer(); ?>
</body>
</html>
```

---

### 5. `index.php`

This is the main file that loads blog posts using `get_template_part()`:

```php
<?php get_header(); ?>

<main>
  <?php if ( have_posts() ) : ?>
    <?php while ( have_posts() ) : the_post(); ?>

      <?php get_template_part( 'template-parts/content' ); ?>

    <?php endwhile; ?>
  <?php else : ?>
      <?php get_template_part( 'template-parts/content', 'none' ); ?>
  <?php endif; ?>
</main>

<?php get_footer(); ?>
```

---

### 6. `template-parts/content.php`

```php
<article>
  <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
  <div><?php the_excerpt(); ?></div>
</article>
```

---

### 7. `template-parts/content-none.php`

```php
<section>
  <p>No posts found. Please check back later.</p>
</section>
```

---

### 8. `template-parts/content-single.php`

This will be used if you add it in `single.php` using:

```php
get_template_part( 'template-parts/content', 'single' );
```

```php
<article>
  <h1><?php the_title(); ?></h1>
  <div><?php the_content(); ?></div>
</article>
```

---

##  Test the Setup

1. Upload this theme into your WordPress `/wp-content/themes/` directory.
2. Activate it from WordPress Dashboard → Appearance → Themes.
3. Add a few blog posts.
4. Visit the homepage — your `index.php` will load and use `get_template_part()`.

---

Let’s simplify and **clearly explain point 8** (`template-parts/content-single.php`), step by step.

---

##  First, understand the use-case:

WordPress shows different templates depending on **where you are** on the site:

* Home page → uses `index.php`
* A single blog post (clicked on) → uses `single.php`

Now, sometimes, you want the **post preview** (like on the homepage) to look **different** from the **full post view** (on its own page). That's when we use:

```php
get_template_part( 'template-parts/content', 'single' );
```

---

##  How it works

This line:

```php
get_template_part( 'template-parts/content', 'single' );
```

**Loads this file**:

```
template-parts/content-single.php
```

So, now you can show a **more detailed version** of the post inside it (compared to the shorter version in `content.php`).

---

##  Comparison:

###  content.php (for blog listing)

Used in `index.php` (blog list)

```php
<article>
  <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
  <div><?php the_excerpt(); ?></div> <!-- Short preview -->
</article>
```

---

###  content-single.php (for single post view)

Used in `single.php` (when a single post is opened)

```php
<article>
  <h1><?php the_title(); ?></h1>
  <div><?php the_content(); ?></div> <!-- Full post content -->
</article>
```

---

##  Full Example for `single.php`

```php
<?php get_header(); ?>

<main>
  <?php
  if ( have_posts() ) :
    while ( have_posts() ) : the_post();

      get_template_part( 'template-parts/content', 'single' );

    endwhile;
  endif;
  ?>
</main>

<?php get_footer(); ?>
```

---

##  Summary:

| File                 | Where It’s Used       | Shows What?                   |
| -------------------- | --------------------- | ----------------------------- |
| `content.php`        | On blog homepage      | Post **title + excerpt**      |
| `content-single.php` | On single post page   | Post **title + full content** |
| Called by            | `get_template_part()` | Modular and reusable          |

---
# Creating custom about-us.php Page Template.

Let’s walk through how to **create a custom `about-us.php` page template** for your WordPress theme — step-by-step and in the simplest possible way.

---

##  Goal

We want to:

* Create a custom page template named **"About Us"**
* Use it on a page in WordPress
* Style and structure it however we like

---

##  Step-by-Step Guide

###  Step 1: Create the template file

In your theme folder, create a new file named:

```
about-us.php
```

---

###  Step 2: Add template header comment

At the very top of `about-us.php`, add this:

```php
<?php
/**
 * Template Name: About Us Page
 */
?>

<?php get_header(); ?>

<main class="about-page">
  <h1>About Us</h1>
  <p>Welcome to our About Us page. This is a custom template!</p>

  <!-- You can add more custom HTML or PHP here -->
  <section>
    <h2>Our Mission</h2>
    <p>To create awesome websites using WordPress.</p>
  </section>
</main>

<?php get_footer(); ?>
```

 The special comment `Template Name: About Us Page` is **required**. It tells WordPress this file is a selectable page template.

---

###  Step 3: Create or Edit a Page in WordPress Admin

1. Go to **Pages → Add New** (or edit an existing page).
2. In the right sidebar under **Page Attributes**, you’ll see a dropdown labeled **Template**.
3. Select **“About Us Page”**.
4. Publish or update the page.

---

###  Step 4: Visit the Page

Go to the URL of that page (e.g. `http://yoursite.com/about-us`) and you’ll see your custom layout.

---

##  Bonus: Add Content from the Page Editor

If you want to show content added via the WordPress editor, include this line inside your template:

```php
<?php
while ( have_posts() ) : the_post();
    the_content();
endwhile;
?>
```

So your full `about-us.php` would look like:

```php
<?php
/**
 * Template Name: About Us Page
 */
?>

<?php get_header(); ?>

<main class="about-page">
  <h1><?php the_title(); ?></h1>

  <?php
  while ( have_posts() ) : the_post();
      the_content();
  endwhile;
  ?>
</main>

<?php get_footer(); ?>
```

This allows you to design the structure **and** still manage the content from the WordPress dashboard.

---

##  That’s it!

Now you have a **fully working, clean About Us custom page template**.

We can customize in furthermore:

* Add a sidebar or image gallery?
* Make it mobile-friendly?
* Add a custom CSS file for it?

---

# Make a `content.php` for Loop content

Perfect! Let me now explain how to **make a `content.php`** file for the **Loop content** — step-by-step and super simple 

---

##  First, what is "the Loop"?

In WordPress, **“the Loop”** is the part of code that goes through and shows each blog post on a page (like your homepage, archive, or category page).

For example:

```php
<?php if ( have_posts() ) : ?>
  <?php while ( have_posts() ) : the_post(); ?>
    <!-- show each post here -->
  <?php endwhile; ?>
<?php endif; ?>
```

Instead of writing HTML/PHP to display each post **inside the loop every time**, we use a **reusable file** called `content.php`.

---

##  Goal

We want to:

* Create a `content.php` file
* Use it to display post title + excerpt
* Use `get_template_part()` to include it inside the loop

---

## Step-by-Step Guide

###  Step 1: Create `content.php` file

Inside your theme folder, create:

```
template-parts/content.php
```

> You can also put it directly in the theme folder, but keeping it inside `template-parts/` is more organized.

---

###  Step 2: Add this code in `content.php`

```php
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  <header class="entry-header">
    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
  </header>

  <div class="entry-summary">
    <?php the_excerpt(); ?>
  </div>
</article>
```

- This shows:

* Post title (as a link)
* Excerpt (short summary)

---

###  Step 3: Use `get_template_part()` in your loop

In `index.php` or `home.php`, update your Loop to this:

```php
<?php if ( have_posts() ) : ?>
  <?php while ( have_posts() ) : the_post(); ?>

    <?php get_template_part( 'template-parts/content' ); ?>

  <?php endwhile; ?>
<?php else : ?>
  <p>No posts found.</p>
<?php endif; ?>
```

 This now loads `content.php` for **every post** in the loop.

---

##  Bonus: Customize with versions

If you want different versions for different contexts:

```php
get_template_part( 'template-parts/content', 'single' ); // loads content-single.php
get_template_part( 'template-parts/content', 'archive' ); // loads content-archive.php
```

This looks for:

```
template-parts/content-single.php
template-parts/content-archive.php
```

---

##  Summary

| File                      | Purpose                                                           |
| ------------------------- | ----------------------------------------------------------------- |
| `content.php`             | Standard layout for each post in a loop (homepage, archive, etc.) |
| `get_template_part()`     | Loads the content file cleanly & modularly                        |
| `index.php` or `home.php` | Where you use the Loop to show posts                              |

---

Following features can be added furthermore

* Add post thumbnail (featured image)
* Show full content instead of excerpt
* Customize for pages or categories

---

# Add Pagination using paginate_links() in WordPress

Let's learn how to **add pagination using `paginate_links()`** in WordPress — step-by-step and very simply. 

---

##  Goal

We want to show a **pagination bar** like:

```
<< Previous 1 2 3 4 Next >>
```

…on a blog page (like `home.php`, `index.php`, or a custom query page).

---

##  Step-by-Step Guide

---

###  Step 1: Tell WordPress how many posts per page

Go to:

**Dashboard → Settings → Reading → Blog pages show at most → `e.g., 5`**

(It is important to have more than 5 posts on your dashboard posts segment)

Or control it inside your custom query using `query_posts()` or `WP_Query`.

---

###  Step 2: Add Pagination in `index.php` or `home.php`

Below your loop, add this code:

```php
<div class="pagination">
  <?php
  echo paginate_links( array(
    'total' => $wp_query->max_num_pages,
  ) );
  ?>
</div>
```

This shows pagination using the **current query**.

---

###  Full Example in `index.php`

```php
<?php get_header(); ?>

<main>
  <h1>Blog</h1>

  <?php if ( have_posts() ) : ?>
    <?php while ( have_posts() ) : the_post(); ?>
      <?php get_template_part( 'template-parts/content' ); ?>
    <?php endwhile; ?>

    <!-- Pagination -->
    <div class="pagination">
      <?php
      echo paginate_links( array(
        'prev_text' => '&laquo; Prev',
        'next_text' => 'Next &raquo;',
        'mid_size'  => 2
      ) );
      ?>
    </div>

  <?php else : ?>
    <p>No posts found.</p>
  <?php endif; ?>
</main>

<?php get_footer(); ?>
```

---

##  Step 3: Style the Pagination (Optional)

Add this to your theme’s `style.css`:

```css
.pagination {
  text-align: center;
  margin: 30px 0;
}

.pagination .page-numbers {
  display: inline-block;
  padding: 8px 12px;
  margin: 0 4px;
  background: #eee;
  color: #333;
  text-decoration: none;
  border-radius: 4px;
}

.pagination .current {
  background: #333;
  color: #fff;
  font-weight: bold;
}
```

---

##  For Custom WP\_Query

If you're using a **custom query**, you must:

### 1. Use `'paged' => get_query_var( 'paged' )`:

```php
$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;

$custom_query = new WP_Query( array(
  'posts_per_page' => 5,
  'paged' => $paged,
) );
```

### 2. Use this after the loop:

```php
echo paginate_links( array(
  'total' => $custom_query->max_num_pages,
) );
```

---

##  Test It

1. Add more than the set number of posts.
2. Visit your blog/home page.
3. Scroll to bottom — you should see page numbers.

---

##  Done!

Now our blog has **clean, numbered pagination** using `paginate_links()` 

We will Include AJAX and React to fetch more post in future.