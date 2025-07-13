**Phase 3: Image Gallery with Custom Table**

> Upload multiple images via WordPress Media Library (React)
> Save the image URLs in a custom table
> Display the gallery using a shortcode

---

## STEP-BY-STEP IMPLEMENTATION (PLUGIN + REACT)

---

## Step 1: Setup Plugin Scaffolding

### Folder: `wp-react-image-uploader`

Create these files:

```
wp-react-image-uploader/
│
├── wp-react-image-uploader.php
├── ReactImageUploader.php
├── build/         ← Output for React bundle (JS)
└── src/           ← React Source Code
```

---

## 1. `wp-react-image-uploader.php`

```php
<?php
/**
 * Plugin Name: WP React Image Uploader
 * Description: Upload images with React and display as gallery.
 * Version: 1.0
 * Author: Aditya Dubey
 */

defined('ABSPATH') || exit;

require_once __DIR__ . '/ReactImageUploader.php';

register_activation_hook(__FILE__, ['ReactImageUploader', 'activate']);

$plugin = new ReactImageUploader();
$plugin->run();
```

---

## 2. `ReactImageUploader.php`

```php
<?php

defined('ABSPATH') || exit;

class ReactImageUploader {
    private $page_hook = '';

    public function run() {
        add_action('admin_menu', [$this, 'add_menu']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_assets']);

        add_action('wp_ajax_save_gallery_images', [$this, 'handle_save_gallery']);

        add_shortcode('riu_gallery', [$this, 'display_gallery_shortcode']);
    }

    public static function activate() {
        global $wpdb;
        $table = $wpdb->prefix . 'riu_gallery';
        $charset = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table (
            id INT AUTO_INCREMENT PRIMARY KEY,
            image_url TEXT NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        ) $charset;";

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta($sql);
    }

    public function add_menu() {
        $this->page_hook = add_menu_page(
            'React Image Uploader',
            'Image Uploader',
            'manage_options',
            'react-image-uploader',
            [$this, 'render_page'],
            'dashicons-format-gallery',
            25
        );
    }

    public function render_page() {
        echo "<div id='react-image-uploader'></div>";
    }

    public function enqueue_assets($hook) {
        if ($hook !== $this->page_hook) return;

        $asset_url = plugin_dir_url(__FILE__) . 'build/index.js';

        wp_enqueue_media(); // Required for Media Library
        wp_enqueue_script('react-image-uploader', $asset_url, [], '1.0', true);
        wp_localize_script('react-image-uploader', 'riuData', [
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('riu_nonce')
        ]);
    }

    public function handle_save_gallery() {
        check_ajax_referer('riu_nonce', 'nonce');

        global $wpdb;
        $table = $wpdb->prefix . 'riu_gallery';
        $images = json_decode(stripslashes($_POST['images']), true);

        if (!is_array($images)) wp_send_json_error(['message' => 'Invalid data']);

        foreach ($images as $url) {
            $wpdb->insert($table, ['image_url' => esc_url_raw($url)]);
        }

        wp_send_json_success(['message' => 'Images saved!']);
    }

    public function display_gallery_shortcode() {
        global $wpdb;
        $table = $wpdb->prefix . 'riu_gallery';
        $images = $wpdb->get_results("SELECT * FROM $table ORDER BY created_at DESC");

        if (!$images) return "<p>No images found.</p>";

        ob_start();
        echo "<div style='display: flex; flex-wrap: wrap; gap: 10px;'>";
        foreach ($images as $img) {
            echo "<img src='" . esc_url($img->image_url) . "' width='150' />";
        }
        echo "</div>";
        return ob_get_clean();
    }
}
```

---

## 3. React Frontend (Inside `src/App.jsx`)

```jsx
import React, { useState } from "react";
import { createRoot } from "react-dom/client";

export default function App() {
  const [images, setImages] = useState([]);

  const openMediaLibrary = () => {
    const frame = wp.media({
      title: "Select Images",
      multiple: true,
      library: { type: "image" },
      button: { text: "Use Selected Images" },
    });

    frame.on("select", () => {
      const selection = frame.state().get("selection");
      const selectedUrls = selection.map((img) => img.toJSON().url);
      setImages([...images, ...selectedUrls]);
    });

    frame.open();
  };

  const saveGallery = async () => {
    const response = await fetch(riuData.ajaxurl, {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: new URLSearchParams({
        action: "save_gallery_images",
        nonce: riuData.nonce,
        images: JSON.stringify(images),
      }),
    });

    const data = await response.json();
    if (data.success) alert("Gallery Saved!");
    else alert("Error: " + data.data.message);
  };

  return (
    <div style={{ padding: "20px" }}>
      <h2>React Image Uploader</h2>
      <button onClick={openMediaLibrary}>📁 Select Images</button>
      <button onClick={saveGallery} style={{ marginLeft: "10px" }}>
        💾 Save Gallery
      </button>
      <div
        style={{
          display: "flex",
          gap: "10px",
          marginTop: "20px",
          flexWrap: "wrap",
        }}
      >
        {images.map((url, index) => (
          <img key={index} src={url} width="100" alt="preview" />
        ))}
      </div>
    </div>
  );
}

const container = document.getElementById("react-image-uploader");
if (container) {
  createRoot(container).render(<App />);
}
```

---

## 4. Build Your React App

In your plugin directory, inside `src/`:

```bash
bun create react  # or use Vite/CRA
```

Then build it for production:

```bash
bun run build
```

> Ensure output goes to `build/index.js`

---

## 5. Use Shortcode on a Page

Go to **Pages > Add New**, and add:

```plaintext
[riu_gallery]
```

Now you’ll see all uploaded images 🎉

---

## Done!

** Phase 4: Edit/Delete Images in React Admin Panel**


Let's begin ** Phase 4: Edit/Delete Images in React Admin Panel**, where you'll extend the functionality of the React gallery to:

---

##  Goals of Phase 4

| Task                          | Description                                  |
| ----------------------------- | -------------------------------------------- |
| 🖼 Display saved images       | Fetch from custom DB table and show in React |
| ✏️ Delete image               | Remove a specific image from DB              |
| ♻️ Optional: Reorder/edit URL | Update DB record (bonus)                     |

---

##  Project Structure Continuation

We’ll enhance your existing plugin by:

* Creating a new `wp_ajax_get_gallery_images` hook to fetch images
* Adding `wp_ajax_delete_gallery_image` to delete image
* Updating your React code to display + manage the images

---

### 🪛 Backend Enhancements (`ReactImageUploader.php`)

---

### 1. Add AJAX handlers in `run()` method:

```php
add_action('wp_ajax_get_gallery_images', [$this, 'handle_get_gallery']);
add_action('wp_ajax_delete_gallery_image', [$this, 'handle_delete_image']);
```

---

###  2. Add the image fetch method:

```php
public function handle_get_gallery() {
    global $wpdb;
    $table = $wpdb->prefix . 'riu_gallery';
    $images = $wpdb->get_results("SELECT * FROM $table ORDER BY created_at DESC", ARRAY_A);
    wp_send_json_success($images);
}
```

---

###  3. Add the delete image method:

```php
public function handle_delete_image() {
    check_ajax_referer('riu_nonce', 'nonce');

    $id = intval($_POST['id']);
    if (!$id) {
        wp_send_json_error(['message' => 'Invalid ID']);
    }

    global $wpdb;
    $deleted = $wpdb->delete(
        $wpdb->prefix . 'riu_gallery',
        ['id' => $id],
        ['%d']
    );

    if ($deleted) {
        wp_send_json_success(['message' => 'Image deleted']);
    } else {
        wp_send_json_error(['message' => 'Failed to delete']);
    }
}
```

---

##  React Admin Enhancement (`src/App.jsx`)
---

###  1. Fetch saved images on load:

Add inside `useEffect`:

```js
useEffect(() => {
  fetchImagesFromServer();
}, []);

const fetchImagesFromServer = async () => {
  const response = await fetch(riuData.ajaxurl + "?action=get_gallery_images");
  const data = await response.json();
  if (data.success) {
    setImages(data.data);
  }
};
```

---

###  2. Add Delete Image Function:

```js
const handleDelete = async (id) => {
  if (!window.confirm("Are you sure to delete this image?")) return;

  const response = await fetch(riuData.ajaxurl, {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: new URLSearchParams({
      action: "delete_gallery_image",
      nonce: riuData.nonce,
      id: id,
    }),
  });

  const data = await response.json();
  if (data.success) {
    alert("Image deleted");
    fetchImagesFromServer(); // refresh
  } else {
    alert(data.data.message);
  }
};
```

---

###  3. Update image rendering

Update render section:

```jsx
<div style={{ display: "flex", flexWrap: "wrap", gap: "15px", marginTop: "20px" }}>
  {images.map((img) => (
    <div key={img.id} style={{ position: "relative" }}>
      <img src={img.image_url} width="100" alt="gallery" />
      <button
        onClick={() => handleDelete(img.id)}
        style={{
          position: "absolute",
          top: 0,
          right: 0,
          background: "red",
          color: "white",
          border: "none",
          borderRadius: "50%",
          width: "20px",
          height: "20px",
          cursor: "pointer"
        }}
      >
        ×
      </button>
    </div>
  ))}
</div>
```

---

## 🧪 Final Testing

1. Upload a few images from the plugin React panel
2. Save to DB 
3. Display all images in React 
4. Click ❌ button to delete → Confirm deletion → Refetch 

---

##  What's Next?

Once you're comfortable with Phase 4, here’s what you can do in **Phase 5**:

| Phase 5 Task                  | Description                                         |
| ----------------------------- | --------------------------------------------------- |
|  Pagination or Lazy Loading | Load images in batches using offset/limit           |
|  Download Support           | Allow users to download individual gallery images   |
|  Custom Meta Info           | Store alt-text/caption with each image              |
| Frontend Upload Shortcode  | Let users upload from frontend (securely)           |
|  Use `WP_REST_API`          | Migrate from `admin-ajax.php` to REST API endpoints |

