# WordPress Theme Template Hierarchy

Learning and mapping the **WordPress Theme Template Hierarchy** is a crucial step in mastering WordPress theme development. Below, I will provide you with a **clear explanation, visual hierarchy**, and **real-world examples** to make this as simple and practical as possible.

---

##  What is WordPress Template Hierarchy?

WordPress uses a **hierarchy system** to decide **which template file to use** when displaying a particular page. It starts from the most specific file and falls back to more general ones if the specific ones don't exist.

---

##  Visual Template Hierarchy Map (Simplified)

Here’s a structured overview from **most specific** to **least specific**:

```plaintext
├── front-page.php
├── home.php
├── page-{slug}.php
├── page-{id}.php
├── page.php
├── singular.php
├── single-{post-type}.php
├── single.php
├── archive-{post-type}.php
├── archive-{taxonomy}.php
├── archive-{taxonomy-term}.php
├── archive.php
├── category-{slug}.php
├── category-{id}.php
├── category.php
├── tag-{slug}.php
├── tag-{id}.php
├── tag.php
├── author-{nicename}.php
├── author-{id}.php
├── author.php
├── date.php
├── search.php
├── 404.php
└── index.php
```

---

##  Common Scenarios with Examples

---

### 1.  Homepage

####  Scenario A: Static Front Page (Set in Settings > Reading)

* **Used template file**: `front-page.php`
* ❌ If not found → `home.php`
* ❌ If not found → `index.php`

####  Scenario B: Latest Posts as Homepage

* **Used template file**: `home.php`
* ❌ If not found → `index.php`

---

### 2.  Single Post (Blog post)

* **Used template file**: `single-post.php`
* ❌ If not found → `single.php`
* ❌ If not found → `singular.php`
* ❌ If not found → `index.php`

**Example**: For a blog post at `example.com/2025/hello-world`, WordPress checks for:

```plaintext
single-post.php → single.php → singular.php → index.php
```

---

### 3.  Custom Post Type (e.g. Portfolio)

* **Used template file**: `single-portfolio.php`
* ❌ If not found → `single.php` → `singular.php` → `index.php`

**Example**: For a post at `example.com/portfolio/project-1`

---

### 4.  Page

####  Scenario A: Specific Page Slug (e.g. "about")

* `page-about.php`

####  Scenario B: Specific Page ID (e.g. ID 42)

* `page-42.php`

* ❌ If not found → `page.php`

* ❌ If not found → `singular.php`

* ❌ If not found → `index.php`

---

### 5.  Category Archive

####  Category: "News" (slug = `news`, ID = 5)

* `category-news.php`
* ❌ → `category-5.php`
* ❌ → `category.php`
* ❌ → `archive.php`
* ❌ → `index.php`

**URL**: `example.com/category/news`

---

### 6.  Tag Archive

####  Tag: "WordPress" (slug = `wordpress`)

* `tag-wordpress.php`
* ❌ → `tag.php`
* ❌ → `archive.php`
* ❌ → `index.php`

---

### 7.  Author Archive

* `author-adityadubey.php`
* ❌ → `author-7.php`
* ❌ → `author.php`
* ❌ → `archive.php`
* ❌ → `index.php`

---

### 8.  Date Archive (year, month, day)

* `date.php` → `archive.php` → `index.php`

---

### 9.  Search Results

* `search.php` → `index.php`

---

### 10.  404 Not Found

* `404.php` → `index.php`

---

##  Practical Tip to Learn Hierarchy

###  Create These Files and Add Comments

In your theme folder, create multiple files and inside each write:

```php
<?php
// This is [file-name].php
get_header();
get_footer();
```

Then visit different URLs like:

* Home: `/`
* Blog page: `/blog`
* Category: `/category/news`
* Page: `/about`
* Single Post: `/2023/hello-world`
* Search: `/?s=WordPress`

 This helps you **see which file is triggered** for each route.

---

##  Bonus: Template Tags You Should Learn Alongside

| Tag               | Usage                               |
| ----------------- | ----------------------------------- |
| `is_home()`       | Checks if blog posts index is shown |
| `is_front_page()` | Checks if it's the front page       |
| `is_single()`     | Checks for single post              |
| `is_page()`       | Checks for any page                 |
| `is_category()`   | Checks for category archive         |
| `is_tag()`        | Checks for tag archive              |
| `is_archive()`    | Any archive                         |
| `is_search()`     | Search result page                  |
| `is_404()`        | 404 page                            |

---

# Practical implementation of Template Hierarchy

Let's make this super simple and **practical**, like a bootcamp. We’ll walk step-by-step through **creating files**, using **template tags**, and **seeing them in action**.

---

##  Goal: Learn WordPress Template Hierarchy by Doing

We’ll create **test files** in your theme and **visually confirm** which one is being used for different pages.

---

##  Step 1: Setup a Clean Theme

If you don’t already have one, create a custom theme:

 Inside your `wp-content/themes/` folder, make a new folder called `theme-hierarchy-test`.

### Create these two base files:

####  `style.css`

```css
/*
Theme Name: Template Hierarchy Test
Author: Aditya Dubey
Version: 1.0
Description: Template Hierarchy Implementation
*/
```

####  `index.php`

```php
<?php
get_header();
echo '<h1>This is index.php</h1>';
get_footer();
```

Now activate this theme from WP admin → Appearance → Themes.

---

##  Step 2: Create Template Files for Testing

Create these files one by one in your theme directory:

| File Name        | Content                                                                        |
| ---------------- | ------------------------------------------------------------------------------ |
| `front-page.php` | `<?php get_header(); echo '<h1>This is front-page.php</h1>'; get_footer(); ?>` |
| `home.php`       | `<?php get_header(); echo '<h1>This is home.php</h1>'; get_footer(); ?>`       |
| `single.php`     | `<?php get_header(); echo '<h1>This is single.php</h1>'; get_footer(); ?>`     |
| `page.php`       | `<?php get_header(); echo '<h1>This is page.php</h1>'; get_footer(); ?>`       |
| `category.php`   | `<?php get_header(); echo '<h1>This is category.php</h1>'; get_footer(); ?>`   |
| `search.php`     | `<?php get_header(); echo '<h1>This is search.php</h1>'; get_footer(); ?>`     |
| `404.php`        | `<?php get_header(); echo '<h1>This is 404.php</h1>'; get_footer(); ?>`        |

** Tip:** You can copy and paste this and change the text for each file.

---

##  Step 3: Visit Different URLs

Now test your template hierarchy visually by visiting:

| Page Type                | URL                       | Which File Loads |
| ------------------------ | ------------------------- | ---------------- |
| Home (Static Front Page) | `/`                       | `front-page.php` |
| Blog (Posts Page)        | `/blog`                   | `home.php`       |
| A Blog Post              | `/hello-world`            | `single.php`     |
| A Page (e.g. "About")    | `/about`                  | `page.php`       |
| A Category Archive       | `/category/uncategorized` | `category.php`   |
| Search                   | `/?s=test`                | `search.php`     |
| 404 Not Found            | `/random-not-real-page`   | `404.php`        |

---

##  Step 4: Learn Template Tags

Inside any of the above template files, add this:

```php
<?php
if ( is_front_page() ) echo '<p>This is the front page.</p>';
if ( is_home() ) echo '<p>This is the blog page.</p>';
if ( is_single() ) echo '<p>This is a single post.</p>';
if ( is_page() ) echo '<p>This is a static page.</p>';
if ( is_category() ) echo '<p>This is a category archive.</p>';
if ( is_search() ) echo '<p>This is a search results page.</p>';
if ( is_404() ) echo '<p>This is a 404 page.</p>';
?>
```

 This helps you **verify** the type of page being loaded using logic — perfect for beginners.

---

##  Step 5: Bonus - Add Header and Footer

Create:

###  `header.php`

```php
<!DOCTYPE html>
<html>
<head>
    <title>Template Test</title>
    <?php wp_head(); ?>
</head>
<body>
    <header><h2>My Theme Header</h2></header>
```

### `footer.php`

```php
    <footer><p>My Theme Footer</p></footer>
    <?php wp_footer(); ?>
</body>
</html>
```

Now all your template files like `page.php`, `single.php`, etc., will look nice and structured.

---

##  Summary

You now:

✅ Created base theme
✅ Made files to test template hierarchy
✅ Used template tags like `is_single()` and `is_page()`
✅ Visited URLs to **see which file loads**
✅ Built confidence step-by-step

---
