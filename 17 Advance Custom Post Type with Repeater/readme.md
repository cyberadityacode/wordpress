# Advanced Custom Fields (ACF)\*\*

## Use fields to customize post/page content.

---

## Goal:

Allow the user to add multiple **Project Features** using a **single textarea**, and show them as a bullet list on the front end.

---

## Step 1: Create the ACF Textarea Field

1. Go to **Custom Fields > Field Groups**

2. Click on your group (e.g. `Project Details`)

3. Click **+ Add Field**

   - **Field Label**: `Project Features`
   - **Field Name**: `project_features`
   - **Field Type**: `Textarea`
   - (Leave all other options default)

4. Click **Update**

---

## Step 2: Enter Data in Admin

Edit any **Project** post, and in the “Project Features” textarea, enter features like:

```
Responsive Design
E-Commerce Integration
SEO Optimized
Payment Gateway
```

One feature per line.

---

## Step 3: Display It in the Template

In your `archive-project.php` or any template where you show project details, add this code **inside your loop**:

```php
<?php
$features = get_field('project_features'); // Get the textarea content
if ($features):
    $features_array = explode("\n", $features); // Split by new lines
    echo '<h4>Project Features:</h4><ul>';
    foreach ($features_array as $feature) {
        echo '<li>' . esc_html(trim($feature)) . '</li>';
    }
    echo '</ul>';
endif;
?>
```

---

### Result on Frontend:

**Project Features:**

- Responsive Design
- E-Commerce Integration
- SEO Optimized
- Payment Gateway

---

## Optional CSS

Add to `style.css` if you want to style the list:

```css
.single-project ul {
  list-style: disc;
  padding-left: 20px;
  margin-top: 10px;
}
```

---

## Summary

| Repeater (Pro)       | Textarea (Free)                |
| -------------------- | ------------------------------ |
| Add rows visually    | Add one item per line manually |
| Multiple field types | Only simple text               |
| More powerful        | Lightweight workaround         |

---
