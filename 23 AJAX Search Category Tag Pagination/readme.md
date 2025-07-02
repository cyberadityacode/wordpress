# Securely Return WP Posts in JSON format

Let’s **securely return WordPress posts in JSON format** using `wp_send_json()` and a **nonce check for AJAX requests**.

You’ll get:

1.  Secure `admin-ajax.php` endpoint
2.  JSON data with post id, title, excerpt, content, date, and author
3.  Nonce protection
4.  Clear step-by-step instructions

---

## Step-by-Step: Secure JSON AJAX in WordPress

---

### Step 1: Enqueue Your Script + Localize Nonce

In your theme’s `functions.php`, enqueue your JavaScript and pass AJAX data:

```php
function enqueue_custom_ajax_script() {
    wp_enqueue_script('custom-ajax', get_template_directory_uri() . '/js/custom-ajax.js', ['jquery'], null, true);

    wp_localize_script('custom-ajax', 'ajax_object', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('fetch_posts_nonce')
    ]);
}
add_action('wp_enqueue_scripts', 'enqueue_custom_ajax_script');
```

This:

- Loads your `custom-ajax.js`
- Passes `ajax_url` and `nonce` to JS for safe request

---

### Step 2: Add the AJAX Callback in `functions.php`

```php
function fetch_posts_ajax_callback() {
    check_ajax_referer('fetch_posts_nonce', 'security'); // Nonce check

    $args = array(
        'post_type'      => 'post',
        'posts_per_page' => 10,
        'post_status'    => 'publish'
    );

    $query = new WP_Query($args);
    $posts_data = [];

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $posts_data[] = array(
                'title'   => get_the_title(),
                'excerpt' => get_the_excerpt(),
                'content' => apply_filters('the_content', get_the_content()),
                'date'    => get_the_date('Y-m-d H:i:s'),
                'author'  => get_the_author()
            );
        }
        wp_reset_postdata();
    }

    wp_send_json($posts_data); // Secure JSON response
}

// AJAX action hooks (for both logged-in and guest users)
add_action('wp_ajax_fetch_posts_ajax', 'fetch_posts_ajax_callback');
add_action('wp_ajax_nopriv_fetch_posts_ajax', 'fetch_posts_ajax_callback');
```

This:

- Checks nonce from JS (`security`)
- Runs query
- Sends JSON using `wp_send_json()`

---

### Step 3: JavaScript to Call AJAX (File: `/js/custom-ajax.js`)

```javascript
jQuery(document).ready(function ($) {
  $.ajax({
    url: ajax_object.ajax_url,
    type: "POST",
    dataType: "json",
    data: {
      action: "fetch_posts_ajax",
      security: ajax_object.nonce,
    },
    beforeSend: function () {
      console.log("Fetching posts...");
    },
    success: function (response) {
      console.log("Posts received:", response);
      // You can now render posts on the page
    },
    error: function (xhr, status, error) {
      console.error("Error fetching posts:", error);
    },
  });
});
```

This:

- Sends `POST` to `admin-ajax.php`
- Adds `action` name and `nonce`
- Handles JSON response

---

## Bonus: Output Data in React?

You can fetch the same using `fetch()` inside a React component:

```js
useEffect(() => {
  fetch(ajax_object.ajax_url, {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: new URLSearchParams({
      action: "fetch_posts_ajax",
      security: ajax_object.nonce,
    }),
  })
    .then((res) => res.json())
    .then((data) => {
      console.log("Fetched posts:", data);
    })
    .catch((err) => console.error("Fetch error:", err));
}, []);
```

---

## Final Result

You now have a secure and scalable system that:

- Uses WordPress nonce to prevent CSRF
- Fetches posts dynamically via AJAX
- Can be used in jQuery, vanilla JS, or React
