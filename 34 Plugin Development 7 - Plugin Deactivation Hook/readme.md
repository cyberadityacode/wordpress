# Custom Plugin Development 7

Plugin De-Activation Hook
How to DROP Database Table Dynamically

we are now covering both **activation** and **deactivation** hooks, which is exactly how a well-structured plugin should behave.

---

### Let’s break it down in **very simple terms**:

## What this Plugin Does Now

| Feature                 | What Happens                                                                 |
| ----------------------- | ---------------------------------------------------------------------------- |
| **On Activation**       | A new database table is created (once) called `wp_project_system_form_data`. |
| **On Deactivation**     | That database table is deleted from the database.                            |
| **Menu in Admin Panel** | Adds a main menu and two submenus: “Add Project” and “List Projects”.        |
| **Includes PHP Files**  | Loads specific files for each menu using `include_once`.                     |

---

## Understanding Plugin Hooks Used

### 1. `register_activation_hook`

```php
register_activation_hook(__FILE__, "project_system_create_table");
```

This tells WordPress:

> “When the plugin is **activated**, run the `project_system_create_table()` function.”

Which does:

```php
function project_system_create_table() {
    global $wpdb;
    ...
    dbDelta($sql); // safely creates the table
}
```

This **safely creates the table** if it doesn’t exist, or updates it smartly if it does.

---

### 2. `register_deactivation_hook`

```php
register_deactivation_hook(__FILE__, "project_system_drop_table");
```

This tells WordPress:

> “When the plugin is **deactivated**, run the `project_system_drop_table()` function.”

Which does:

```php
function project_system_drop_table() {
    global $wpdb;
    $sql = "DROP TABLE IF EXISTS {$wpdb->prefix}project_system_form_data";
    $wpdb->query($sql);
}
```

This **removes the table from the database** when the plugin is deactivated.

---

## Best Practice Note (Very Important)

Deleting a table on **deactivation** can be risky. Many plugins only drop the table on **uninstall**, not on deactivation — to avoid data loss.

### Better approach (Safe Option):

Instead of deleting data on **deactivation**, move the drop code to an uninstall hook:

```php
register_uninstall_hook(__FILE__, 'project_system_delete_plugin_data');

function project_system_delete_plugin_data() {
    global $wpdb;
    $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}project_system_form_data");
}
```

This way, data is removed **only** when the plugin is completely **deleted**, not just turned off.

---

## Summary (Easy to Remember):

| Hook                         | Purpose                                         | When It Runs               |
| ---------------------------- | ----------------------------------------------- | -------------------------- |
| `register_activation_hook`   | Setup like creating DB tables, defaults         | On plugin **activation**   |
| `register_deactivation_hook` | Cleanup tasks, like turning off scheduled tasks | On plugin **deactivation** |
| `register_uninstall_hook`    | Delete everything (DB, options)                 | On plugin **deletion**     |

---
