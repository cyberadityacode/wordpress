# Revised Theme


Updated the following:

1. Added primary menu
2. Designed basic navigation bar.
3. Page Content displayed by default on click.
4. Added Link to Title of website
5. Added single.php to display individual blog post.
6. Added Featured Image (Thumbnail).
7. Added Read more in excerpts of post list.
8. Added Page with Featured Image
9. Added front-page.php with multiple sections.
10. Added Blog Section to display recent blog with view more redirection to all Blog Posts.





```php

```
---

# Static Pages Display Wordpress- Page.php

Let's now create the `page.php` template to display **WordPress static pages** like **About**, **Contact**, **Services**, etc.

---

##  Why Do We Need `page.php`?

When a user visits a **static page**, WordPress looks for:

```
page-{slug}.php → page.php → index.php
```

If `page.php` is missing, it falls back to `index.php`, which isn't ideal — it shows blog-like formatting. So we build `page.php` to give **pages their own clean layout**.

---

##  Step-by-Step: Create `page.php`

###  Step 1: Create the File

In your theme folder (`wp-content/themes/myfirsttheme/`):

 Create a file named:

```plaintext
page.php
```

---

###  Step 2: Add Page Template Code

Paste this basic code:

```php
<?php get_header(); ?>

<main>
<?php
if ( have_posts() ) :
    while ( have_posts() ) : the_post();
?>
    <article>
        <h1><?php the_title(); ?></h1>

        <div>
            <?php the_content(); ?>
        </div>
    </article>
<?php
    endwhile;
else :
    echo '<p>No page found.</p>';
endif;
?>
</main>

<?php get_footer(); ?>
```

---

###  Step 3: Test It!

1. Go to your WordPress Dashboard.
2. Go to **Pages > Add New**
3. Create an "About" or "Contact" page.
4. Add some content and publish.
5. View the page on the front-end.

 Now it should use your new `page.php` layout!

---

##  Optional Enhancements

You can add these later:

###  Add Featured Image (if you want to show it on pages too):

<!-- add_theme_support('post-thumbnails'); -->

```php
<?php if ( has_post_thumbnail() ) : ?>
    <div>
        <?php the_post_thumbnail('large'); ?>
    </div>
<?php endif; ?>
```

###  Add Breadcrumbs (for SEO-friendly navigation)

###  Style with CSS for better presentation

---

