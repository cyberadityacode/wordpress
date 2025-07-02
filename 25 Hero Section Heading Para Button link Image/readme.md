# Theme Customization in WordPress

> Add Footer Text customization

To add a **customization option in your WordPress theme**—like a **text field to update the footer text**—you should use the **WordPress Customizer API**.

---

### Step 1: Register the Customizer Setting and Control

Add the following code to your theme's `functions.php` file:

```php
function mytheme_customize_register( $wp_customize ) {
    // Add a section for the footer
    $wp_customize->add_section( 'mytheme_footer_section', array(
        'title'    => __( 'Footer Settings', 'mytheme' ),
        'priority' => 160,
    ));

    // Add setting for footer text
    $wp_customize->add_setting( 'mytheme_footer_text', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    // Add control for footer text
    $wp_customize->add_control( 'mytheme_footer_text_control', array(
        'label'    => __( 'Footer Text', 'mytheme' ),
        'section'  => 'mytheme_footer_section',
        'settings' => 'mytheme_footer_text',
        'type'     => 'text',
    ));
}
add_action( 'customize_register', 'mytheme_customize_register' );
```

---

### Step 2: Display the Custom Footer Text in the Theme

Go to your theme's `footer.php` and print the customized value like this:

```php
<?php
$footer_text = get_theme_mod( 'mytheme_footer_text', '' );
if ( !empty( $footer_text ) ) {
    echo '<p>' . esc_html( $footer_text ) . '</p>';
}
?>
```

---

### Step 3: Live Preview (Optional)

To make the footer text preview update live as you type in the customizer, you can enqueue the customizer preview script like this:

**In `functions.php`:**

```php
function mytheme_customize_preview_js() {
    wp_enqueue_script(
        'mytheme-customizer',
        get_template_directory_uri() . '/js/customizer.js',
        array( 'customize-preview' ),
        null,
        true
    );
}
add_action( 'customize_preview_init', 'mytheme_customize_preview_js' );
```

**Create a file `js/customizer.js`:**

```js
(function ($) {
  wp.customize("mytheme_footer_text", function (value) {
    value.bind(function (newval) {
      $("footer p").text(newval);
    });
  });
})(jQuery);
```

---

### Result

Now, go to:

**Appearance → Customize → Footer Settings → Footer Text**

Type your text, and it will show in the theme footer.

---
