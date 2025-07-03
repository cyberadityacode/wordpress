# Custom Post Type (CPT) for Projects with Taxonomy

To add a **Custom Post Type (CPT)** in WordPress for **Projects** with custom fields and taxonomy, follow this **simple step-by-step guide**.

---

###  Step 1: Add CPT Code in `functions.php`

Go to your theme’s `functions.php` file and **add this code**:

```php
function create_projects_post_type() {
    register_post_type('project',
        array(
            'labels' => array(
                'name' => __('Projects'),
                'singular_name' => __('Project')
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'projects'),
            'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'custom-fields', 'tags'),
            'taxonomies' => array('project_category', 'post_tag'), // using custom category + built-in tags
            'show_in_rest' => true, // for Gutenberg and REST API support
        )
    );

    // Register custom taxonomy like Categories (Technology Used)
    register_taxonomy(
        'project_category',
        'project',
        array(
            'label' => __( 'Technology Used' ),
            'rewrite' => array( 'slug' => 'technology' ),
            'hierarchical' => true, // Like categories
            'show_in_rest' => true,
        )
    );
}
add_action('init', 'create_projects_post_type');
```

---

###  What this code does:

*  Creates a new post type: `Projects`
*  Supports: Title, Editor, Excerpt, Featured Image, Custom Fields, Tags
*  Adds a custom taxonomy: `Technology Used` (like Categories)
* 🏷 Enables default tags for additional info

---

### Enable Featured Image:

Make sure your theme supports thumbnails. If not, add this in `functions.php`:

```php
add_theme_support('post-thumbnails');
```

---

###  Step 2: Add "Company Name" Custom Field

You can use the **default custom fields feature**, or install **Advanced Custom Fields (ACF)** plugin for easier UI.

#### If using ACF plugin:

1. Install & activate **Advanced Custom Fields**
2. Create a Field Group called `Project Details`
3. Add Field:

   * Field Label: `Company Name`
   * Field Name: `company_name`
   * Field Type: `Text`
4. Set rules: Show if **Post Type is equal to Project**
5. Publish

ACF will automatically show the field when editing a Project post.

---

###  Optional: Display Data on Frontend

Edit your theme's template (e.g., `single-project.php`) and use this to show fields:

```php
<?php
the_title();
the_post_thumbnail();
the_excerpt();
the_content();

// Company Name (ACF or custom field)
echo '<p><strong>Company:</strong> ' . get_post_meta(get_the_ID(), 'company_name', true) . '</p>';

// Show Technology Used
$terms = get_the_terms( get_the_ID(), 'project_category' );
if ( $terms && ! is_wp_error( $terms ) ) {
    echo '<ul><strong>Technologies:</strong>';
    foreach ( $terms as $term ) {
        echo '<li>' . esc_html( $term->name ) . '</li>';
    }
    echo '</ul>';
}

// Tags
the_tags('<p><strong>Tags:</strong> ', ', ', '</p>');
?>
```

---

###  Bonus Tips

* Visit **Dashboard > Projects** to add your new posts.
*  If you want custom archives or single view, create:

  * `archive-project.php`
  * `single-project.php`
*  Use plugins like **Custom Post Type UI** if you prefer UI instead of code.

