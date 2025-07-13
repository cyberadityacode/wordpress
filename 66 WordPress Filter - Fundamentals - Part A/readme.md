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
