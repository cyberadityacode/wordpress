# Image Upload using React in WP Plugin

## Phase 1 Goal:

Build a custom plugin that:
✅ Shows a React UI in admin
✅ Allows uploading/selecting an image
✅ Saves the image (URL or ID) via AJAX
✅ Displays the selected image below the form

---

## Project Structure:

```
wp-content/
└── plugins/
    └── react-image-uploader/
        ├── react-image-uploader.php
        ├── includes/
        │   └── Plugin.php
        ├── build/
        │   └── index.js         ← Compiled React code
        └── src/
            └── App.jsx         ← React code (source)
```

---

## Step-by-Step Breakdown

### Step 1: Create Plugin Bootstrap File

**File:** `react-image-uploader.php`

```php
<?php
/*
Plugin Name: React Image Uploader
Description: React-based image upload plugin with media uploader.
Version: 1.0
Author: Aditya Dubey
*/

defined('ABSPATH') || exit;

require_once __DIR__ . '/includes/Plugin.php';

function riu_init_plugin() {
    $plugin = new \RIU\Plugin();
    $plugin->run();
}

add_action('plugins_loaded', 'riu_init_plugin');
```

---

### Step 2: Main Plugin Class

**File:** `includes/Plugin.php`

```php
<?php
namespace RIU;

defined('ABSPATH') || exit;

class Plugin
{
    private $page_hook = '';

    public function run()
    {
        add_action('admin_menu', [$this, 'add_admin_page']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_assets']);

        // Ajax for image save
        add_action('wp_ajax_riu_save_image', [$this, 'save_image']);
    }

    public function add_admin_page()
    {
        $this->page_hook = add_menu_page(
            'React Image Upload',
            'React Image Upload',
            'manage_options',
            'react-image-uploader',
            [$this, 'render_page'],
            'dashicons-format-image',
            26
        );
    }

    public function render_page()
    {
        echo '<div class="wrap"><h1>React Image Upload</h1>';
        echo '<div id="riu-root"></div></div>';
    }

    public function enqueue_assets($hook)
    {
        if ($hook !== $this->page_hook) return;

        // JS (from React build)
        wp_enqueue_script(
            'riu-script',
            plugin_dir_url(__DIR__) . 'build/index.js',
            ['wp-element', 'wp-media-utils'],
            '1.0',
            true
        );

        // WordPress Media
        wp_enqueue_media();

        // Localize
        wp_localize_script('riu-script', 'riu_data', [
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce'   => wp_create_nonce('riu_image_upload'),
        ]);
    }

    public function save_image()
    {
        check_ajax_referer('riu_image_upload', 'nonce');

        $image_url = esc_url_raw($_POST['image_url'] ?? '');

        if (!$image_url) {
            wp_send_json_error(['message' => 'No image provided']);
        }

        // Save to DB if needed (not implemented yet)
        wp_send_json_success(['message' => 'Image URL received', 'url' => $image_url]);
    }
}
```

---

### Step 3: React Setup (Source File)

**File:** `src/App.jsx` (this will be compiled to `build/index.js`)

We’ll handle that in the **next step**, where I’ll guide you through the React code and how to compile it.

---

### Before Proceeding:

You’ve now completed the **WordPress + PHP foundation** for the plugin:

- ✅ Plugin activation
- ✅ Admin page setup
- ✅ Media uploader enqueued
- ✅ AJAX endpoint ready

---

> **Step 4: Writing and compiling the React frontend (App.jsx + bundler setup)?**

---

##  Step 4: React Frontend to Upload Image via Media Library

We'll now create a simple React component with:

- A button to open the WordPress Media Library
- Preview of the selected image
- Save button to send the image URL to the server via AJAX

---

### 1. Setup `src/App.jsx`

**File:** `src/App.jsx`

```jsx
import React, { useState } from "react";

export default function App() {
  const [imageURL, setImageURL] = useState("");
  const [message, setMessage] = useState("");

  const openMediaLibrary = () => {
    const frame = window.wp.media({
      title: "Select Image",
      multiple: false,
      library: { type: "image" },
      button: { text: "Use This Image" },
    });

    frame.on("select", () => {
      const attachment = frame.state().get("selection").first().toJSON();
      setImageURL(attachment.url);
    });

    frame.open();
  };

  const handleSave = async () => {
    try {
      const response = await fetch(riu_data.ajaxurl, {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: new URLSearchParams({
          action: "riu_save_image",
          nonce: riu_data.nonce,
          image_url: imageURL,
        }),
      });

      const data = await response.json();
      if (data.success) {
        setMessage("✅ " + data.data.message);
      } else {
        setMessage("❌ " + data.data.message);
      }
    } catch (err) {
      console.error(err);
      setMessage("❌ Something went wrong.");
    }
  };

  return (
    <div>
      <h2>Upload and Save Image</h2>

      <button onClick={openMediaLibrary}>Select Image</button>

      {imageURL && (
        <div style={{ marginTop: "1rem" }}>
          <img src={imageURL} alt="Selected" style={{ maxWidth: "300px" }} />
          <br />
          <button onClick={handleSave} style={{ marginTop: "1rem" }}>
            Save Image
          </button>
        </div>
      )}

      {message && <p style={{ marginTop: "1rem" }}>{message}</p>}
    </div>
  );
}
```

---

### 2. Create an Entry Point `src/main.jsx`

```jsx
import React from "react";
import { createRoot } from "react-dom/client";
import App from "./App";

const container = document.getElementById("riu-root");
const root = createRoot(container);
root.render(<App />);
```

---

### 3. Setup Vite (or WP Scripts)

If you're using Vite for bundling, your `vite.config.js` should look like:

```js
import { defineConfig } from "vite";
import react from "@vitejs/plugin-react";
import path from "path";

export default defineConfig({
  plugins: [react()],
  build: {
    outDir: "build",
    emptyOutDir: true,
    rollupOptions: {
      input: path.resolve(__dirname, "src/main.jsx"),
      output: {
        entryFileNames: `index.js`,
      },
    },
  },
});
```

---

### 4. Build the React App

Run this from terminal (inside plugin folder):

```bash
npm run build
# or if you're using bun:
bun run build
```

This will generate `build/index.js`, which WordPress loads in admin.

---

### 5. Test in WordPress

- Go to **Admin → React Image Upload**
- Click **Select Image**
- Pick any media image
- Click **Save Image**
-  You'll see the preview + confirmation message

---

### Done with Phase 1!

You’ve now learned how to:

- Build a plugin using OOP
- Create a React frontend
- Use WordPress Media Library in React
- Send/save image via AJAX

---

### Next **Phase 2: Save to Database and Display Images on Frontend with Shortcode**

Awesome! Let's move into **🚀 Phase 2: Save image to the database and display it on the frontend using a shortcode**. This will make your plugin even more dynamic and production-ready.

---

##  Phase 2 Overview

###  Goal:

1. Store selected image URL in the WordPress database (in a custom table or `wp_options`).
2. Display the uploaded image on the **frontend** using a **shortcode** like `[display_uploaded_image]`.

---

## Step-by-Step Breakdown

###  Step 1: Save Image URL to `wp_options` (or custom table)

We'll continue with `wp_options` for simplicity.

#### Modify AJAX Handler in Your Plugin Class

Update the `riu_save_image` AJAX function to store the image URL in options:

```php
public function handle_save_image() {
    check_ajax_referer('riu_nonce', 'nonce');

    $image_url = esc_url_raw($_POST['image_url'] ?? '');

    if (!$image_url) {
        wp_send_json_error(['message' => 'No image provided']);
    }

    update_option('riu_saved_image_url', $image_url);

    wp_send_json_success(['message' => 'Image saved successfully!']);
}
```

 This saves the image URL to WordPress options using `update_option`.

---

###  Step 2: Register Shortcode

Add this to your plugin class:

```php
public function register_shortcodes() {
    add_shortcode('display_uploaded_image', [$this, 'display_uploaded_image_shortcode']);
}

public function display_uploaded_image_shortcode() {
    $image_url = get_option('riu_saved_image_url');

    if (!$image_url) {
        return "<p>No image uploaded yet.</p>";
    }

    return "<img src='" . esc_url($image_url) . "' style='max-width:100%; height:auto;' alt='Uploaded Image' />";
}
```

 This shortcode will display the saved image on any post/page.

 Don’t forget to add this line in your `run()` method:

```php
add_action('init', [$this, 'register_shortcodes']);
```

---

###  Step 3: Test the Shortcode

1. Go to **Posts → Add New** (or Pages)
2. Paste this shortcode:

   ```
   [display_uploaded_image]
   ```
3. View the page. You should see the image that was uploaded from the plugin’s admin panel!

---

##  Done with Phase 2!

You now know how to:

* Save image to the database
* Display image using a frontend shortcode
* Use `wp_options` to persist plugin data

---

## Phase 3

### Phase 3: Allow **multiple image uploads**, store them in a **custom table**, and display them as a **gallery** on the frontend.

**Phase 3: Image Gallery with Custom Table**

