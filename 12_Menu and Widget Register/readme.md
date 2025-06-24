# Navigation, Widgets, and Sidebar

Learn and integrate common theme features.

> Tasks:

1. Register a menu with `register_nav_menus()` in `functions.php`
2. Added `wp_nav_menu()` in `header.php`
3. Register and display a sidebar with `register_sidebar()` and `dynamic_sidebar()`
4. Used default widgets like recent posts, categories

---

## How to Register a Menu

Let’s walk through **how to register a menu** in WordPress using `register_nav_menus()` in the **simplest way possible**. 

---

##  What is `register_nav_menus()`?

It tells WordPress:

> “Hey, I want to create a named menu area so users can assign custom menus to it from the Dashboard.”

---

##  Step-by-Step Guide

###  Step 1: Add this to `functions.php`

```php
function working_loop_theme_setup() {
    //  Add menu support
    add_theme_support('menus');

    //  Register a menu location
    register_nav_menus(array(
        'main-menu' => 'Main Menu',  // 'main-menu' is the ID used in code, 'Main Menu' is the name shown in admin
    ));
}
add_action('after_setup_theme', 'working_loop_theme_setup');
```

---

###  Step 2: Go to Admin and Add a Menu

1. Go to **Appearance > Menus**
2. Click “Create a new menu”
3. Add pages, links, etc.
4. Under "Menu Settings > Display location", check  “Main Menu”
5. Save menu

---

###  Step 3: Display the Menu in Your Theme (e.g. in `header.php`)

```php
<?php
wp_nav_menu(array(
    'theme_location' => 'main-menu', // Must match the key used in register_nav_menus
    'container' => 'nav',            // Wraps menu inside <nav>
    'menu_class' => 'main-nav',      // CSS class for styling the menu
));
?>
```

---

##  Bonus: Sample CSS for Menu

```css
.main-nav {
  display: flex;
  list-style: none;
  gap: 20px;
  padding: 0;
}

.main-nav li {
  display: inline-block;
}

.main-nav a {
  text-decoration: none;
  color: darkblue;
  font-weight: bold;
}
```

---

##  Summary

| Task            | Code                                      |
| --------------- | ----------------------------------------- |
| Register a menu | `register_nav_menus()` in `functions.php` |
| Display it      | `wp_nav_menu()` in template               |
| Style it        | Use `.main-nav` or your class in CSS      |
| Assign it       | In **Appearance > Menus** in Dashboard    |

---

## Creating 2 Columns on home.php

Let’s build a **2-column layout** for your blog page, where:

*  Left side = Blog Posts
*  Right side = Sidebar (Widgets)

We’ll use **Flexbox** (pure CSS) — simple, responsive, and beginner-friendly.

---

##  Step 1: Update Your `home.php`

Here’s a clean structure:

###  `home.php`

```php
<?php get_header(); ?>

<h1>This is home.php</h1>

<div class="blog-layout">
    <!--  Main Blog Posts -->
    <div class="blog-posts">
        <h2>Blog Posts</h2>
        <?php if (have_posts()): while (have_posts()): the_post(); ?>
            <article class="single-post">
                <?php if (has_post_thumbnail()): ?>
                    <div class="post-thumb">
                        <?php the_post_thumbnail('custom-thumb'); ?>
                    </div>
                <?php endif; ?>
                <h3><?php the_title(); ?></h3>
                <p><?php the_excerpt(); ?></p>
                <a href="<?php the_permalink(); ?>">Read more...</a>
            </article>
        <?php endwhile; else: ?>
            <p>No posts found.</p>
        <?php endif; ?>
    </div>

    <!--  Sidebar Widgets -->
    <aside class="blog-sidebar">
        <?php
        if (is_active_sidebar('main-sidebar')) {
            dynamic_sidebar('main-sidebar');
        }
        ?>
    </aside>
</div>

<?php get_footer(); ?>
```

---

##  Step 2: Add CSS to `style.css`

###  `style.css`

```css
.blog-layout {
  display: flex;
  flex-direction: row;
  gap: 30px;
  max-width: 1200px;
  margin: 0 auto;
  padding: 20px;
}

/* Left column - blog posts */
.blog-posts {
  flex: 2;
}

/* Right column - sidebar */
.blog-sidebar {
  flex: 1;
  background-color: #f9f9f9;
  padding: 15px;
  border-left: 3px solid #ccc;
}

.single-post {
  margin-bottom: 30px;
  padding-bottom: 15px;
  border-bottom: 1px solid #ddd;
}

.post-thumb img {
  width: 100%;
  height: auto;
  object-fit: cover;
  margin-bottom: 10px;
}

.widget {
  margin-bottom: 20px;
}

.widget-title {
  font-weight: bold;
  margin-bottom: 10px;
}
```

---

##  Step 3: Add Widgets

1. Go to **Appearance > Widgets**
2. Drag some widgets (Search, Categories, etc.) into **Main Sidebar**
3. Refresh your site — you’ll see posts on the left, sidebar on the right!

---

##  Bonus: Make it Mobile Responsive

You can add this to the bottom of your CSS:

```css
@media screen and (max-width: 768px) {
  .blog-layout {
    flex-direction: column;
  }

  .blog-sidebar {
    border-left: none;
    border-top: 3px solid #ccc;
    margin-top: 20px;
  }
}
```

---

##  Done! You now have:

| Section         | Purpose               |
| --------------- | --------------------- |
| `.blog-posts`   | Posts column          |
| `.blog-sidebar` | Widgets column        |
| Flexbox         | 2-column layout       |
| Media query     | Mobile responsiveness |

---
