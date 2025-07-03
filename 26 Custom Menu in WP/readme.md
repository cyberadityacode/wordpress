# Custom Menu

Adding a **custom menu** to a WordPress theme involves 3 main steps:

---

###  Step 1: **Register the Menu Location** in `functions.php`

Go to your theme's `functions.php` file and add this code:

```php
function mytheme_register_menus() {
    register_nav_menu('main-menu', 'Main Menu');
}
add_action('after_setup_theme', 'mytheme_register_menus');
```

**Explanation:**

* `register_nav_menu()` tells WordPress that your theme supports a menu location called `main-menu`.
* `'Main Menu'` is the name shown in the dashboard.

---

###  Step 2: **Display the Menu in Your Theme (e.g., header.php)**

Now go to `header.php` or wherever you want to show the menu, and add this:

```php
<?php
wp_nav_menu(array(
    'theme_location' => 'main-menu',
    'container' => 'nav',
    'menu_class' => 'my-custom-menu-class'
));
?>
```

**Explanation:**

* `theme_location` should match what you registered in `functions.php`.
* `container` wraps the menu in `<nav>` tag.
* `menu_class` is optional — for styling with CSS.

---

###  Step 3: **Create and Assign the Menu in Dashboard**

1. Go to **Dashboard → Appearance → Menus**
2. Click **"Create a new menu"**
3. Add pages, posts, or custom links to it
4. Under **"Menu Settings"**, check the **"Main Menu"** location
5. Click **Save Menu**

---

###  (Optional) Step 4: **Style It with CSS**

In `style.css` of your theme, you can style the menu like:

```css
.my-custom-menu-class {
    list-style: none;
    display: flex;
    gap: 20px;
}

.my-custom-menu-class li a {
    text-decoration: none;
    color: black;
}
```
Now your custom menu is live and manageable from the WordPress admin area.

