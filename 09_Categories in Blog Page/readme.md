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
---

11. Added Blog Thumbnail, Title, Excerpt with Read more on front-page.php
12. Added fallback thumbnail image on blog post.
13. Updated home.php for Blog Page.

---

14. Added Categories to the blog page


```php

```
---

## Filter Blog by Categories

Let’s now learn how to **filter blog posts by category** on your blog page — in a clean, beginner-friendly way.

---

##  Goal:

Add simple **category filter links** at the top of your blog page (`home.php`) so the user can click and see posts only from that category.

---

##  Step-by-Step: Filter Posts by Category

---

###  Step 1: Add Category Links at Top of `home.php`

Just before your loop, add this code to display category filters:

```php
<div class="category-filters">
    <strong>Filter by category:</strong>
    <?php
    $categories = get_categories();
    foreach ($categories as $category) {
        echo '<a href="' . get_category_link($category->term_id) . '">' . esc_html($category->name) . '</a> ';
    }
    ?>
</div>
```

 This will show:

```
Filter by category: Web Design Tutorials WordPress Coding ...
```

Clicking each link shows posts from that category.

---

###  How it Works:

* WordPress auto-generates archive pages for each category.
* When a user clicks a category like `/category/wordpress/`, WordPress loads `category.php` (or falls back to `archive.php` or `home.php`).
* You don’t need to write custom query — WordPress handles it behind the scenes. 

---

###  Step 2: Style the Filter Links (Optional)

Add to `style.css`:

```css
.category-filters {
    margin: 20px 0;
    text-align: center;
}

.category-filters a {
    margin: 0 8px;
    padding: 6px 12px;
    background: #eee;
    color: #333;
    text-decoration: none;
    border-radius: 5px;
    font-size: 14px;
}

.category-filters a:hover {
    background: #0073aa;
    color: #fff;
}
```

---

###  Step 3: Test It

* Visit your blog page
* You’ll see category buttons/links
* Click one → URL becomes `/category/your-category-slug/`
* You see filtered posts 

---

###  Bonus (Optional): Highlight Active Category


---

##  Summary

| What You Did               | How It Helps                       |
| -------------------------- | ---------------------------------- |
| Showed category links      | Gives users filter control         |
| Used `get_category_link()` | Lets WP auto-handle archive pages  |
| No custom queries          | Clean, fast, easy-to-maintain code |

---

