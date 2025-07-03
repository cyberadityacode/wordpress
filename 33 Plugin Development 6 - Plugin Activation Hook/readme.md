# Custom Plugin Development 6

Plugin Activation Hook
How to create Dynamic Database Table

Great! You've written a neat and functional custom plugin that does **the following**:

---

###  **Summary **

1. **Registers a plugin with meta info** like name, version, author, etc.
2. **Defines constants** for file paths and URLs.
3. **Adds a menu and two submenus** in the WordPress admin panel.
4. **Includes custom PHP pages** when those menus are clicked.
5. **Creates a custom database table** when the plugin is activated using an **activation hook**.

---

###  Now let's understand the **Activation Hook part** clearly:

####  This is the key line:

```php
register_activation_hook(__FILE__, "project_system_create_table");
```

* This tells WordPress:

  > “Hey WordPress! When someone activates this plugin, please run the `project_system_create_table()` function **once**.”

---

###  What does `project_system_create_table()` do?

```php
function project_system_create_table() {
    global $wpdb;
    $table_prefix = $wpdb->prefix; // usually 'wp_'

    $sql = "CREATE TABLE {$table_prefix}project_system_form_data (
      ...
    );";

    include_once ABSPATH . "wp-admin/includes/upgrade.php";

    dbDelta($sql);
}
```

* It connects to the **WordPress database** using `$wpdb`
* It defines a **SQL query** to create a new table called `wp_project_system_form_data`
* It runs the query using `dbDelta()` (which is smart and safe for table creation/updating)

---

###  When will this table be created?

* Only **once**, when the plugin is activated from **Plugins > Activate** in WordPress Admin.

---

###  So what exactly is a Plugin Activation Hook (in context of your code)?

> In your code, it is a **special mechanism** that tells WordPress to **automatically create a custom table** (`project_system_form_data`) in the database **when the plugin is activated**.

---

###  Tip: Want to test if it's working?

1. Deactivate and delete the plugin (only deletes code, not DB table).
2. Delete the table manually from phpMyAdmin.
3. Re-upload the plugin.
4. Activate it again — it should re-create the table.

---

If you want to also create **default rows**, or **add options/settings** on activation, you can do that in the same `project_system_create_table()` function.

