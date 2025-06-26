# Theme Customizer Integration

## Goal: Add real-time editing options for users

## Task- Enable Custom Logo, Site Title, Tagline



##  Step-by-Step: How to Show Logo Upload Option in Customizer

You need to **enable custom logo support** in your theme first.

---

###  1. Enable Logo in `functions.php`

Open your theme’s `functions.php` file and **add this code**:

```php
function mytheme_setup() {
    // Enable custom logo support
    add_theme_support('custom-logo', array(
        'height'      => 100,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
    ));

    // Optional: Support site title and tagline
    add_theme_support('title-tag');
}
add_action('after_setup_theme', 'mytheme_setup');
```

 Save the file and refresh your WordPress Dashboard.

---

###  2. Upload Logo via Customizer

Now go to:

> **Appearance → Customize → Site Identity**

You will now see a new option:

>  **Logo: \[Select Logo]**

There you can upload your site logo (the one shown in your header area).

---

###  3. Show the Logo in `header.php`

Next, open your theme’s `header.php` file and place this code where you want the logo to appear:

```php
<div class="site-branding">

    <?php
    // Show uploaded logo
    if (has_custom_logo()) {
        the_custom_logo();
    } else {
        // If no logo, show site title
        echo '<h1 class="site-title">' . get_bloginfo('name') . '</h1>';
    }

    // Show tagline
    echo '<p class="site-description">' . get_bloginfo('description') . '</p>';
    ?>
</div>
```

---

###  Final Result:

You can now:

* Upload a **Logo** (will show in header)
* Set a **Site Title**
* Set a **Tagline**
* Upload a **Favicon (Site Icon)**

---

###  Summary Table:

| Feature           | Where You Upload It                    | How to Enable                      |
| ----------------- | -------------------------------------- | ---------------------------------- |
| **Logo**          | Appearance → Customize → Site Identity | `add_theme_support('custom-logo')` |
| **Site Icon**     | Appearance → Customize → Site Identity | Enabled by default                 |
| **Title/Tagline** | Appearance → Customize → Site Identity | `add_theme_support('title-tag')`   |

---

# Working with Customizer

**add custom footer text and a color picker** in the WordPress Customizer.

---

When you go to **Appearance → Customize**, you want:

1.  A place to **change footer text** (like: "© 2025 My Blog")
2.  A **color picker** to choose a **primary color** for your website

---

## Step 1: What is `customize_register`?

WordPress gives us a function hook called `customize_register`.
We use it to **add our own settings and controls** to the Customizer screen.

Example:

```php
add_action('customize_register', 'my_custom_function');
```

Inside `my_custom_function`, we can create our **footer text box** and **color picker**.

---

##  Step 2: Add Code in `functions.php`

Go to your theme → open `functions.php` → and **add this code**:

```php
function mytheme_customize_register($wp_customize) {

    // 1. Create a new section called "Footer Settings"
    $wp_customize->add_section('footer_section', array(
        'title'    => 'Footer Settings',
        'priority' => 30,
    ));

    //  2. Add a setting for footer text
    $wp_customize->add_setting('footer_text', array(
        'default'   => '© 2025 My Website',
        'transport' => 'refresh',
    ));

    // 3. Add a text box to enter footer text
    $wp_customize->add_control('footer_text_control', array(
        'label'    => 'Footer Text',
        'section'  => 'footer_section',
        'settings' => 'footer_text',
        'type'     => 'text',
    ));

    // 4. Add a setting for primary color
    $wp_customize->add_setting('primary_color', array(
        'default'   => '#0073aa', // Default blue
        'transport' => 'refresh',
    ));

    // 5. Add a color picker control
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'primary_color_control', array(
        'label'    => 'Primary Color',
        'section'  => 'colors', // Uses existing "Colors" section
        'settings' => 'primary_color',
    )));

}
add_action('customize_register', 'mytheme_customize_register');
```

---

## Step 3: Show the Footer Text on Your Site

Now open your `footer.php` and paste this wherever you want the footer message to show:

```php
<p><?php echo get_theme_mod('footer_text', '© 2025 My Website'); ?></p>
```

This will show the custom text you type in the Customizer.

---

## Step 4: Use the Color Picker Value in CSS

Let’s apply the color picked from the Customizer.

In your `header.php`, inside the `<head>` tag, write:

```php
<style>
:root {
    --primary-color: <?php echo get_theme_mod('primary_color', '#0073aa'); ?>;
}
</style>
```

Now open your `style.css` and use the color like this:

```css
body {
    background-color: var(--primary-color);
}

a {
    color: var(--primary-color);
}
```

This way, when you pick a new color in Customizer, your site updates with it.

---

## Final Result:

In Appearance → Customize:

* You’ll see **Footer Settings** → you can change the footer text.
* In **Colors** → you can pick a **Primary Color** for your site.

---

## Why This is Awesome

| Feature         | What It Does                                     |
| --------------- | ------------------------------------------------ |
| `footer_text`   | Let’s you change text like "© My Site"           |
| `primary_color` | Lets you color your site as you wish — no coding |

---

## Learned:

* How to use `customize_register`
* How to add text + color controls
* How to show them on the frontend
* How to link PHP to CSS using `:root` variables

---


Let's understand this code **line by line** in the **simplest and most beginner-friendly way**. 

###  FULL CODE:

```php
$wp_customize->add_setting('primary_color', array(
    'default' => '#0073aa',
    'transport' => 'refresh',
));

$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'primary_color_control', array(
    'label' => __('Primary Color', 'mytheme'),
    'section' => 'colors', // you can also create your own section
    'settings' => 'primary_color'
)));
```

---

## LINE-BY-LINE EXPLANATION

---

### First Part: `add_setting()`

```php
$wp_customize->add_setting('primary_color', array(
    'default' => '#0073aa',
    'transport' => 'refresh',
));
```

**What you're doing here:**

* You are **creating a setting** named `'primary_color'`.
* The **default color** is `#0073aa` (a bluish shade).
* `'transport' => 'refresh'` means that whenever the user selects a color, the preview will **refresh** to show the changes.

Think of it like:

> "I want to remember the user's selected color, and by default, it’s blue."

---

### Second Part: `add_control()` using a special color control

```php
$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'primary_color_control', array(
    'label' => __('Primary Color', 'mytheme'),
    'section' => 'colors',
    'settings' => 'primary_color'
)));
```

**What you're doing here:**

* You're adding a **color picker input** to the Customizer.
* `WP_Customize_Color_Control` is a **special built-in WordPress control** for picking colors.
* `'label' => 'Primary Color'` is what the user sees next to the input.
* `'section' => 'colors'` means it will appear inside the **"Colors" section** of the Customizer (which already exists in WordPress).
* `'settings' => 'primary_color'` links this color picker to the setting you just created.

In simple words:

> "Put a color picker in the Customizer, and save the selected color as 'primary\_color'."

---

## RESULT:

* The user sees a color picker labeled **“Primary Color”** under the “Colors” section.
* When they change the color, it’s stored in the `primary_color` setting.
* You can now use this value anywhere in your theme!

---

### How to use it in your theme:

Add this in your `<head>` tag or inline CSS (e.g., in `header.php`):

```php
<style>
    body {
        background-color: <?php echo get_theme_mod('primary_color', '#0073aa'); ?>;
    }
</style>
```

---
