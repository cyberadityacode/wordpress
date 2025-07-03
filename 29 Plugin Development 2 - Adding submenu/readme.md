# Custom Plugin Development 1

1. Create a sub-folder inside plugin directory (your plugin name)
2. Create a file of same name example custom-plugin.php
3. Add Comment for plugin details
4. Then we have to call action hook to add menu

```php
// calling action hook to add menu
add_action('admin_menu', 'cp_add_admin_menu');
```

5. define this callback function to add menu

```php
// add menu
function cp_add_admin_menu()
{
    //title, menu name, manage_options means super admin, slug, callback function to display interface, dashicon, order of plugin menu

    add_menu_page("Custom Plugin Menu", "Custom Plugin", "manage_options", "cp-plugin", "cp_handle_admin_menu", "dashicons-admin-home", 23);
}
```

6. Define callback menu handle

```php
// menu handle callback
function cp_handle_admin_menu()
{
    echo "<h2>Welcome to Custom Plugin Menu</h2>";
}
```
