# Custom Post Type (CPT)

Let's register a **Custom Post Type (CPT)** called **"Projects"** using the `register_post_type()` function in the **simplest way possible**.

---

##  Goal:

We want to add a new section in WordPress admin called **"Projects"** where we can add and manage different projects like posts.

---

##  Step-by-Step Code:

###  1. Open your theme’s `functions.php` file

Paste the following code at the end:

```php
function create_projects_cpt() {
    register_post_type('project', array(
        'labels' => array(
            'name' => 'Projects',
            'singular_name' => 'Project',
        ),
        'public' => true, // makes it visible on front-end
        'has_archive' => true, // enables archive page like /project
        'rewrite' => array('slug' => 'projects'), // URL will be like /projects/project-name
        'supports' => array('title', 'editor', 'thumbnail'), // enables these fields
        'menu_icon' => 'dashicons-portfolio', // nice icon in dashboard menu
    ));
}
add_action('init', 'create_projects_cpt');
```

---

###  What This Code Does:

| Part                       | Meaning                                     |
| -------------------------- | ------------------------------------------- |
| `'project'`                | This is the internal name (slug) of the CPT |
| `'Projects'` / `'Project'` | Name shown in admin menu                    |
| `'public' => true`         | Makes it available on frontend              |
| `'has_archive' => true`    | Adds `/projects` archive page               |
| `'rewrite'`                | Makes pretty URLs                           |
| `'supports'`               | Enables title, content, and featured image  |
| `'menu_icon'`              | Adds an icon in admin                       |

---

###  After Adding the Code:

1. Go to your WordPress Dashboard.
2. You will see a new menu item called **Projects**.
3. You can now:

   * Add a new project.
   * View all projects.
   * Manage them just like posts.

---

### Important:

If you don’t see the new CPT showing up right:

* Go to **Settings > Permalinks** and click “Save Changes” to **flush rewrite rules**.

---

# Taxonomy

Absolutely! Let's add a custom taxonomy called **“Project Type”** so you can group your Projects (like Web, App, Branding, etc.) just like categories or tags — but specific to your custom post type `project`.

---

##  What is a Taxonomy?

* **Taxonomy** = a way to group content.
* WordPress has built-in taxonomies: `category` and `post_tag`.
* You can create your **own custom taxonomy**, like `project_type`.

---

##  Step-by-Step: Add "Project Type" Taxonomy

###  1. Add This to Your `functions.php`

Just below your `register_post_type('project', ...)` code, add:

```php
function register_project_type_taxonomy() {
    register_taxonomy('project_type', 'project', array(
        'labels' => array(
            'name' => 'Project Types',
            'singular_name' => 'Project Type',
            'search_items' => 'Search Project Types',
            'all_items' => 'All Project Types',
            'edit_item' => 'Edit Project Type',
            'update_item' => 'Update Project Type',
            'add_new_item' => 'Add New Project Type',
            'new_item_name' => 'New Project Type Name',
            'menu_name' => 'Project Types',
        ),
        'hierarchical' => true, // like categories (true), or tags (false)
        'show_in_rest' => true, // enable for Gutenberg and REST API
        'public' => true,
        'rewrite' => array('slug' => 'project-type'), // URL: /project-type/web-design
    ));
}
add_action('init', 'register_project_type_taxonomy');
```

---

###  2. What This Code Does

| Part                                           | Meaning                                            |
| ---------------------------------------------- | -------------------------------------------------- |
| `'project_type'`                               | This is your taxonomy's machine name               |
| `'project'`                                    | The custom post type it applies to                 |
| `'hierarchical' => true`                       | Acts like categories (with parent-child structure) |
| `'rewrite' => array('slug' => 'project-type')` | Clean URL like `/project-type/web`                 |

---

### 3. Now Go to Admin:

1. Go to **Dashboard > Projects**
2. You’ll see a new menu: **“Project Types”**
3. You can now:

   * Add project types like **Website**, **Mobile App**, **UI Design**
   * Assign them to individual Projects (like categories)

---

###  4. Show "Project Type" in Your Theme (optional)

To display the assigned project types inside the project loop:

```php
<?php
$types = get_the_terms(get_the_ID(), 'project_type');
if ($types && !is_wp_error($types)) {
    echo '<ul class="project-types">';
    foreach ($types as $type) {
        echo '<li>' . esc_html($type->name) . '</li>';
    }
    echo '</ul>';
}
?>
```

 Place this inside your project loop, e.g., in `archive-project.php` or `page-projects.php`.
---

##  Result

* You can now **create**, **assign**, and **display** custom project categories.
* This gives you better content filtering and organization.

---

