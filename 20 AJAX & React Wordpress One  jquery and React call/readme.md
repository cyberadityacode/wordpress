# How WordPress handles AJAX ?

### The Basic Idea

WordPress uses a central "gatekeeper" file (`admin-ajax.php`) to handle all AJAX requests. Whether you're in the admin dashboard or on the front-end of your site, all AJAX calls go through this file.

### How It Works (Simple Steps)

1. **Your JavaScript Sends a Request**

   - You make a request to `admin-ajax.php`
   - Include an `action` parameter (e.g., `get_toffees`)
   - Example:
     ```javascript
     fetch("/wp-admin/admin-ajax.php?action=get_toffees");
     ```

2. **WordPress Routes the Request**

   - WordPress looks for functions registered to handle your specific action:
     - `wp_ajax_get_toffees` (for logged-in users)
     - `wp_ajax_nopriv_get_toffees` (for guests)

3. **Your PHP Function Runs**

   - You create a function that handles the request:
     ```php
     function get_toffees_handler() {
         $toffees = get_categories(); // Get data
         wp_send_json($toffees); // Send JSON response
     }
     add_action('wp_ajax_get_toffees', 'get_toffees_handler');
     add_action('wp_ajax_nopriv_get_toffees', 'get_toffees_handler');
     ```

4. **Response Sent Back**
   - WordPress sends the output from your function back to the browser as JSON (or any format you choose)

### Security Note

Always include a **nonce** (security token) in your requests to verify they're legitimate:

```javascript
// In JavaScript
fetch("/wp-admin/admin-ajax.php?action=get_toffees&nonce=YOUR_NONCE");
```

```php
// In PHP
add_action('wp_ajax_get_toffees', function() {
    check_ajax_referer('YOUR_NONCE_ACTION'); // Verifies nonce
    // ... rest of code ...
});
```

###  Key Takeaways

- **One Entry Point:** All requests go through `admin-ajax.php`
- **Action Hooks:** Use `wp_ajax_*` and `wp_ajax_nopriv_*` to handle requests
- **Response Helpers:** Use `wp_send_json()`, `wp_send_json_success()`, or `wp_send_json_error()`
- **Security:** Always use nonces and permission checks
- **Front-end Handling:** Works the same for admin area and public site pages

This system keeps AJAX handling consistent while letting you focus on your custom functionality! 


---

Here's a simple, complete example of WordPress AJAX implementation - both frontend and backend:

### Step 1: Add PHP Handlers (in theme's `functions.php`)
```php
// Register AJAX handlers for both logged-in and guest users
add_action('wp_ajax_get_time', 'get_server_time_handler');
add_action('wp_ajax_nopriv_get_time', 'get_server_time_handler');

function get_server_time_handler() {
    // Verify security nonce
    check_ajax_referer('time_nonce', 'security');
    
    // Get server time
    $response = [
        'time' => current_time('mysql'),
        'message' => 'Success!'
    ];
    
    // Send JSON response
    wp_send_json_success($response);
    
    // Always die() at the end
    die();
}

// Enqueue scripts
add_action('wp_enqueue_scripts', 'ajax_demo_scripts');
function ajax_demo_scripts() {
    // Register JavaScript file
    wp_enqueue_script('ajax-demo', get_template_directory_uri() . '/ajax-demo.js', ['jquery'], '1.0', true);
    
    // Localize script data
    wp_localize_script('ajax-demo', 'ajax_object', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('time_nonce')
    ]);
}
```

### Step 2: Create JavaScript File (`/ajax-demo.js`)
```javascript
jQuery(document).ready(function($) {
    $('#get-time-btn').click(function() {
        $.ajax({
            url: ajax_object.ajax_url,
            type: 'POST',
            data: {
                action: 'get_time',
                security: ajax_object.nonce
            },
            beforeSend: function() {
                $('#time-result').html('Loading...');
            },
            success: function(response) {
                if (response.success) {
                    $('#time-result').html('Server time: ' + response.data.time);
                } else {
                    $('#time-result').html('Error: ' + response.data);
                }
            },
            error: function() {
                $('#time-result').html('AJAX request failed!');
            }
        });
    });
});
```

### Step 3: Add HTML to Your Theme
```html
<button id="get-time-btn">Get Server Time</button>
<div id="time-result"></div>
```

### How It Works:
1. **User clicks button**: Triggers AJAX call
2. **JavaScript sends**: 
   - Action name (`get_time`)
   - Security nonce
   - To `admin-ajax.php`
3. **WordPress routes**:
   - Finds `wp_ajax_get_time` action
   - Finds `wp_ajax_nopriv_get_time` for guests
4. **PHP handler**:
   - Verifies nonce
   - Gets server time
   - Sends JSON response
5. **JavaScript**:
   - Updates page with result

### Key Components:
1. **Nonce Security**: Prevents unauthorized requests
2. **wp_localize_script**: Safely passes PHP values to JS
3. **wp_send_json_success**: Properly formatted JSON response
4. **Separate Hooks**: `wp_ajax_` (logged-in) and `wp_ajax_nopriv_` (guests)

### Test It:
1. Add button to your theme template
2. Click the button
3. Should see: "Server time: 2025-06-30 14:30:45"

> **Note**: For admin-only AJAX, remove the `nopriv` hook. Always include nonce verification for security!

---


##  What is `wp_localize_script()`?

Even though it sounds like it's for "translating" or "localizing" text, in WordPress **we mainly use it to send data from PHP to JavaScript**.

###  Simple definition:

> `wp_localize_script()` lets you **pass PHP variables** (like URLs, text, or security tokens) to your JavaScript files.

---

##  Why do we need it?

JavaScript runs in the **browser**
PHP runs on the **server**

So when your JavaScript file needs something from PHP (like the **AJAX URL**), you can't just use a PHP variable directly.

### Example Use:

In AJAX, your JS needs this URL:

```php
admin_url('admin-ajax.php')
```

But that’s PHP — and JavaScript can’t read PHP directly.
So we use `wp_localize_script()` to pass it from PHP → JS.

---

##  Example Code

```php
wp_localize_script('my-ajax-js', 'ajax_object', array(
    'ajax_url' => admin_url('admin-ajax.php')
));
```

###  What this does:

It creates a JavaScript object like this:

```javascript
var ajax_object = {
    ajax_url: 'https://yourdomain.com/wp-admin/admin-ajax.php'
};
```

Now in JavaScript, you can use:

```javascript
ajax_object.ajax_url
```

---

##  Breaking Down the Parameters

```php
wp_localize_script( $handle, $object_name, $data_array );
```

| Parameter      | Meaning                                                                |
| -------------- | ---------------------------------------------------------------------- |
| `$handle`      | The handle of the script you're passing data to (`wp_enqueue_script`)  |
| `$object_name` | The name of the JS object you'll access in your script (`ajax_object`) |
| `$data_array`  | The actual data you want to pass (as key-value pairs)                  |

---

##  Summary

*  `wp_localize_script()` is used to pass data from PHP to JavaScript.
*  Most commonly used to send the AJAX URL.
*  It makes a JavaScript object you can use in your JS code.

---


# REACT with WordPress


---

##  Two Ways to Use React with WordPress

There are two main setups, and I’ll focus on both briefly:

---

###  **Option 1: Use React in a WordPress Plugin or Theme**

You write React code as part of your theme or plugin, build it with tools like **Webpack or Vite**, and then **enqueue** the final JavaScript bundle in WordPress.

This is good for adding **interactive components** to your existing site.

---

###  **Option 2: Build a Headless React Frontend**

Use **WordPress as a backend only** (like an API) and use React to create a **separate frontend** via the REST API or GraphQL.

That’s a full headless setup (like Next.js + WordPress).

---

##  Let’s Do Option 1 — React inside a WordPress theme (Simple Demo)

We’ll make:

* A WordPress theme or plugin with a React component.
* The component sends an AJAX request to `admin-ajax.php`.
* WordPress responds with data.

---

##  Step-by-Step Setup

###  1. **Create Your React App** inside your theme

Go to your theme folder and run:

```bash
npx create-react-app react-ajax
```

This will create a folder like `your-theme/react-ajax`.

---

###  2. **Write React AJAX Code**

In `App.js`:

```jsx
import React, { useState } from 'react';

function App() {
  const [response, setResponse] = useState('');

  const handleClick = () => {
    const formData = new FormData();
    formData.append('action', 'my_ajax_action');
    formData.append('message', 'Hello from React!');

    fetch(window.ajax_object.ajax_url, {
      method: 'POST',
      body: formData
    })
      .then(res => res.text())
      .then(data => setResponse(data))
      .catch(err => setResponse('Error: ' + err.message));
  };

  return (
    <div>
      <h2>React AJAX Example</h2>
      <button onClick={handleClick}>Send AJAX Request</button>
      <div>{response}</div>
    </div>
  );
}

export default App;
```

---

###  3. **Build the React App**

In the `react-ajax` folder:

```bash
npm run build
```

This will generate a `build/` folder with static files.

---

###  4. **Enqueue React JS in WordPress**

In `functions.php`:

```php
function enqueue_react_script() {
    wp_enqueue_script(
        'my-react-app',
        get_template_directory_uri() . '/react-ajax/build/static/js/main.js',
        array(), null, true
    );

    wp_localize_script('my-react-app', 'ajax_object', array(
        'ajax_url' => admin_url('admin-ajax.php')
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_react_script');
```

---

###  5. **Add AJAX Handler in PHP**

Still in `functions.php`:

```php
function my_react_ajax_handler() {
    $msg = isset($_POST['message']) ? sanitize_text_field($_POST['message']) : 'No message';
    echo 'Server says: ' . $msg;
    wp_die();
}
add_action('wp_ajax_my_ajax_action', 'my_react_ajax_handler');
add_action('wp_ajax_nopriv_my_ajax_action', 'my_react_ajax_handler');
```

---

###  6. **Use It in Theme**

In your `index.php` or any template:

```php
<div id="root"></div>
```

The React app will attach to this div automatically after it's loaded.

---

##  Summary

| Step | What You Did                                 |
| ---- | -------------------------------------------- |
| 1    | Created React app inside theme               |
| 2    | Wrote React component to send AJAX           |
| 3    | Built React app to create static JS          |
| 4    | Loaded JS in WordPress and passed AJAX URL   |
| 5    | Created PHP function to handle AJAX          |
| 6    | Inserted `<div id="root">` in theme to mount |

---

##  Result:

When you click the React button, it sends a request to WordPress → PHP responds → the result is shown in React.

---
