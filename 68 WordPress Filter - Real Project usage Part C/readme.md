# WordPress Filters

#  Day 1: **Filters – The Core of WordPress Customization**

---

##  Objectives for Day 1

By the end of this lesson, you will:

* Understand what a filter is.
* Know how filters work in WordPress.
* Use `add_filter()` in a theme or plugin.
* Write your own basic filter function.
* Practice with real examples.
* Pass a mini-quiz and homework challenge.

---

##  What Is a Filter in WordPress?

A **filter** in WordPress allows you to **change data before it is shown or saved**—without editing the original source.

> Think of it as a **custom lens** that modifies what you see or store.

---

##  WordPress Filter Anatomy

###  Two Main Functions:

#### 1. `add_filter()`: **Hook your function to a filter**

```php
add_filter('filter_name', 'your_callback_function');
```

#### 2. `apply_filters()`: **WordPress triggers this internally**

```php
$value = apply_filters('filter_name', $value);
```

- You don’t usually use `apply_filters()` unless you're creating custom filters. For Day 1, focus on `add_filter()`.

---

##  Basic Example: Modify Post Title

```php
function modify_post_title($title) {
    return '🔥 ' . $title;
}
add_filter('the_title', 'modify_post_title');
```

**What It Does:** Adds a 🔥 emoji to every post title.

---

##  Where to Write This Code?

For testing:

* Paste it into your theme’s `functions.php` file **(recommended for now)**
* Or create a simple plugin (we’ll cover plugin creation soon)

---

##  Common Parameters of `add_filter`

```php
add_filter('hook_name', 'callback_function', $priority, $accepted_args);
```

| Parameter           | Description                               |
| ------------------- | ----------------------------------------- |
| `hook_name`         | The filter hook name (e.g. `the_title`)   |
| `callback_function` | Your function to process the data         |
| `priority`          | Optional: Order of execution (default 10) |
| `accepted_args`     | Optional: Number of arguments to accept   |

---

##  Practical Exercises

### 1. Add Emoji to Titles

```php
function add_emoji_to_title($title) {
    return '📘 ' . $title;
}
add_filter('the_title', 'add_emoji_to_title');
```

### 2. Change "Read More" Link in Excerpt

```php
function custom_excerpt_more($more) {
    return '... 👉 Read more';
}
add_filter('excerpt_more', 'custom_excerpt_more');
```

### 3. Set Excerpt Length to 15 Words

```php
function custom_excerpt_length($length) {
    return 15;
}
add_filter('excerpt_length', 'custom_excerpt_length');
```

### 4. Append Signature to Post Content

```php
function add_signature_to_content($content) {
    if (is_single()) {
        $content .= '<p><em>— Written by Aditya Dubey</em></p>';
    }
    return $content;
}
add_filter('the_content', 'add_signature_to_content');
```

---

##  Mini Project Task (Live Practice)

💡 Add a short message like "Thanks for visiting!" at the bottom of every blog post using a filter.

**Hint:** Use `the_content` filter. Make sure to use `is_single()`.

---

##  Quiz – Test Your Day 1 Knowledge

1. Which function is used to hook a function into a WordPress filter?
2. What does `apply_filters()` do?
3. Can you use multiple filters on the same hook?
4. What does the `priority` parameter in `add_filter()` control?

<details>
<summary>📝 Answers</summary>

1. `add_filter()`
2. Triggers the filter and passes data through all attached functions
3. ✅ Yes, each will run in priority order
4. It determines the order of execution (lower runs earlier)

</details>

---

##  Homework Challenge (Submission Optional)

- Create three filters in your theme:

1. Add a 🔔 emoji at the start of each post title
2. Append “\~ From Aditya’s Blog” at the end of each post content
3. Change excerpt “...” to say “ → Continue”

You can paste your code here, and I’ll **review and give you feedback**!

---

##  Summary of What You Learned Today

* What filters are and why they’re important
* How `add_filter()` works
* Real examples using `the_title`, `the_content`, `excerpt_more`, and more
* How to practice safely in `functions.php`

---

##  What's Next in Day 2?

* Discover the most powerful built-in WordPress filters
* Use `body_class`, `widget_title`, `comment_text`, and more
* Real-world scenarios for customizing themes and plugins

---

Would you like me to:

* Set up a GitHub repo template for your bootcamp?
* Send a starter plugin scaffold?
* Continue with **Day 2** right away?

Let me know how you want to proceed!


#  Day 2: **Mastering Built-In Filters in WordPress**

---

##  Objectives for Day 2

By the end of this session, you’ll be able to:

* Identify common built-in filters in WordPress.
* Modify theme and plugin output using those filters.
* Apply filters to various WordPress parts like body class, widgets, comments, and more.
* Write 5+ practical filter implementations.

---

## 🔍 Why Built-in Filters Are Powerful

WordPress core, themes, and plugins often call `apply_filters()` internally to allow **developers like you** to modify things without touching core code.

📌 Think of it like this:

> "Hey developer, want to tweak what I'm about to output? Just hook into this filter!"

---

## 🧰 Most Useful Built-in Filters (with Use Cases)

| Filter Name      | What it Filters               | Use Case                                |
| ---------------- | ----------------------------- | --------------------------------------- |
| `the_title`      | Post/page title               | Add emojis or prefixes                  |
| `the_content`    | Full post content             | Add signature, ads, promo blocks        |
| `excerpt_length` | Number of words in excerpt    | Control snippet size                    |
| `excerpt_more`   | "..." after excerpt           | Customize read more link                |
| `body_class`     | Classes added to `<body>` tag | Add dynamic classes based on context    |
| `widget_title`   | Title of widgets              | Add icons or styling to widget headings |
| `comment_text`   | The actual comment text       | Censor or format comments               |

---

## ✅ Built-in Filter Examples

### 🔹 1. `body_class`: Add Dynamic Class

```php
function add_custom_body_class($classes) {
    if (is_single()) {
        $classes[] = 'single-post-layout';
    }
    return $classes;
}
add_filter('body_class', 'add_custom_body_class');
```

👀 Output:

```html
<body class="home blog single-post-layout">
```

---

### 🔹 2. `excerpt_more`: Customize the "..."

```php
function custom_excerpt_more($more) {
    return '… 👉 Continue';
}
add_filter('excerpt_more', 'custom_excerpt_more');
```

---

### 🔹 3. `widget_title`: Add Emoji

```php
function add_icon_to_widget_title($title) {
    return '🧰 ' . $title;
}
add_filter('widget_title', 'add_icon_to_widget_title');
```

---

### 🔹 4. `comment_text`: Filter Comments

```php
function censor_bad_words($comment_text) {
    return str_ireplace('badword', '****', $comment_text);
}
add_filter('comment_text', 'censor_bad_words');
```

---

### 🔹 5. `the_content`: Insert Custom Message

```php
function promo_banner_after_content($content) {
    if (is_single()) {
        $content .= '<div class="promo-box">🔥 Don’t miss our new article!</div>';
    }
    return $content;
}
add_filter('the_content', 'promo_banner_after_content');
```

---

## 🧘 Practice Tasks (Try These in Theme)

### Task 1:

Add a custom CSS class `from-aditya` to all pages using `body_class`.

### Task 2:

Change all widget titles to uppercase using `widget_title`.

### Task 3:

Replace the word “WordPress” in comments with “WP 🚀” using `comment_text`.

### Task 4:

Add a note like “Last updated on \[Date]” to the bottom of post content using `the_content`.

---

## ⚙️ Developer Tip: How to Find More Filters

You can find filters in:

* WordPress Core: Search for `apply_filters(` in `/wp-includes/` or `/wp-admin/`
* Plugin code: Use VS Code search to find `apply_filters`
* Official docs: [https://developer.wordpress.org/reference/hooks/](https://developer.wordpress.org/reference/hooks/)

---

## ✅ Real-World Example Use Case

### Situation:

You want your blog to look like a premium site where:

* All post titles have an article number (e.g., “#42 My Journey”).
* Widget titles show the section emoji (e.g., 📚 Resources).
* Each blog post ends with a note saying: “Follow me on Instagram!”

### Implementation Plan:

```php
// Post Title
function number_title($title) {
    static $count = 1;
    return '#' . $count++ . ' ' . $title;
}
add_filter('the_title', 'number_title');

// Widget Title
add_filter('widget_title', function($title) {
    return '📚 ' . $title;
});

// Content Footer
function ig_follow_footer($content) {
    if (is_single()) {
        $content .= '<p>📷 Follow me: @adityadubey.dev</p>';
    }
    return $content;
}
add_filter('the_content', 'ig_follow_footer');
```

---

## 🧠 Day 2 Quiz

1. Which filter would you use to change the number of words in the excerpt?
2. What does the `body_class` filter return?
3. Can you use anonymous functions in `add_filter()`?
4. What’s the difference between `the_content` and `the_excerpt` filters?

<details>
<summary>📝 Answers</summary>

1. `excerpt_length`
2. An array of classes
3. ✅ Yes
4. `the_content` is for full content; `the_excerpt` is for summary

</details>

---

## 🧪 Homework Challenge

🎯 Add the following to your `functions.php` file or a custom plugin:

1. Filter all post titles to start with “📝”.
2. Make all widget titles uppercase + add emoji prefix “🔧”.
3. Add a promo block after each post like:
   *“🎁 Free eBook: 5 Steps to Become a Dev”*
4. Replace all instances of “plugin” in comment text with “plugin 🔌”.

📩 You can paste your code here for feedback!

---

## ✅ Summary of What You Learned

* How to **use core WordPress filters** like `body_class`, `widget_title`, `the_content`, and more.
* Real-world customization without modifying templates.
* Using `add_filter()` with arrays, strings, and anonymous functions.

---

#  Day 3: **Using Filters in Real Projects**

---

##  Objectives for Day 3

By the end of this session, you'll be able to:

* Use filters dynamically with WordPress conditionals like `is_single()`, `is_page()`, `is_home()`, etc.
* Insert styled blocks of HTML using filters.
* Customize both theme and plugin outputs using filters.
* Build a mini real-world filter-based system.

---

##  Key Concepts to Learn

| Topic           | What it does                                  |
| --------------- | --------------------------------------------- |
| `is_single()`   | Checks if a single post is being viewed       |
| `is_page()`     | Checks for a specific page                    |
| `is_home()`     | Checks if it’s the blog home                  |
| `is_category()` | Checks if a category archive is viewed        |
| `is_admin()`    | Checks if you're on the backend (admin panel) |

You’ll use these in **filter callback functions** to make your filters **context-aware**.

---

## Real-Life Filter Examples with Conditionals

---

###  1. Add a “Thank you for reading!” message **only on blog posts**

```php
function add_reading_note($content) {
    if (is_single() && is_main_query()) {
        $content .= '<p style="font-style: italic;">🙏 Thank you for reading!</p>';
    }
    return $content;
}
add_filter('the_content', 'add_reading_note');
```

---

###  2. Add a class to the body **only on About page**

```php
function add_about_page_class($classes) {
    if (is_page('about')) {
        $classes[] = 'about-highlight';
    }
    return $classes;
}
add_filter('body_class', 'add_about_page_class');
```

---

###  3. Add a custom promotion **on blog home page**

```php
function home_page_banner($content) {
    if (is_home() && is_main_query()) {
        $content = '<div class="promo">🎉 Welcome to our blog! Don’t miss our latest updates.</div>' . $content;
    }
    return $content;
}
add_filter('the_content', 'home_page_banner');
```

---

## Pro Developer Tip

✅ Always use `is_main_query()` to avoid affecting widgets, sliders, or sidebar loops.

---

##  Practice Tasks

1. Add a note like “📅 This was posted on: \[date]” after post content (only for posts).
2. Add custom CSS class to body only if the page slug is **contact**.
3. Add a badge like “🌟 Popular Post” before titles of posts in the **category 'featured'**.

<details>
<summary>💡 Hint for Task 3</summary>

Use `has_category('featured')` inside the `the_title` filter.

</details>

---

##  Mini Project: “Blog Booster Filters”

Let’s now build a practical **filter-based module** that enhances your blog without touching templates.

---

###  File: `functions.php` or plugin file

```php
// ✅ Add a welcome box to homepage
function blog_home_welcome($content) {
    if (is_home() && is_main_query()) {
        $box = '<div class="welcome-box" style="background:#f7f7f7;padding:10px;border:1px solid #ddd;margin-bottom:20px;">
                    👋 Welcome to Aditya’s Blog! Explore insightful articles below.
                </div>';
        return $box . $content;
    }
    return $content;
}
add_filter('the_content', 'blog_home_welcome');


//  Add post-date info to the bottom of each post
function post_date_info($content) {
    if (is_single() && is_main_query()) {
        $date = get_the_date();
        $content .= "<p style='font-size: 0.9em;'>📅 Published on: {$date}</p>";
    }
    return $content;
}
add_filter('the_content', 'post_date_info');


//  Add class to body on category archive
function category_archive_class($classes) {
    if (is_category()) {
        $classes[] = 'category-archive-page';
    }
    return $classes;
}
add_filter('body_class', 'category_archive_class');
```

Congratulations — you just built a mini content enhancement plugin with filters!

---

##  Day 3 Quiz

1. What does `is_single()` return?
2. Why should you use `is_main_query()`?
3. Which filter would you use to add a block after post content?
4. How would you detect if the page being viewed is “About”?

<details>
<summary>✅ Answers</summary>

1. It returns true if a single post is being viewed
2. To avoid affecting secondary queries like widgets or custom loops
3. `the_content`
4. Use `is_page('about')`

</details>

---

##  Homework Challenge

 -Implement the following enhancements using filters:

1. For posts in category “updates”, prepend title with “🆕”.
2. On the contact page, add a notice: “📞 We usually respond within 24 hours.”
3. Add a unique class `user-{user_id}` to `<body>` tag (use `get_current_user_id()`).
4. In comments, replace the word “support” with “assistance 💡”.

Submit here for review if you'd like!

---

## Summary of What You Learned

* Using **conditional tags** with filters for dynamic behavior
* Applying filters to **real-world blog layouts**
* Writing context-aware and user-specific filters

---

##  What’s Next in Day 4?

Next, you'll learn to:

* Create **custom filter hooks** using `apply_filters()`
* Make your code extensible so others can hook into it
* Build a mini framework-like plugin that supports 3rd-party modifications

---

