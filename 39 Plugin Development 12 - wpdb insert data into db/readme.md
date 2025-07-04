# Custom Plugin Development 12

Submit form to insert values to database

---

Global Database Object
CRUD methods of Database objects

global $wpdb;

<!-- insert command -->
<!-- keys are column name -->

$wpdb->insert("<table name>", array(
"key"=>"value",
));
% get id of the inserted data
$wpdb->insert_id() // return auto incremented primary key

<!-- update command -->

$wpdb->update("<table name>", array(SET OF DATA), array(SET OF CONDITIONS));

% <!-- Delete command -->

$wpdb->delete("<table name>", array(SET OF CONDITIONS));

<!-- % Select statements -->

$wpdb->get_result() //list all data

$wpdb->get_row() //single row data

$wpdb->get_var() //single row data's property eg. email

$wpdb->prepare();

<!--  -->

# What is GLOBAL DATABASE OBJECT?

In WordPress, the **Global Database Object** is a built-in PHP object that lets you interact with your **WordPress database** easily. It's named **`$wpdb`**, and it’s available globally — meaning you can use it anywhere in your WordPress plugin or theme files.

---

### What is `$wpdb`?

`$wpdb` is an instance of the `wpdb` class provided by WordPress. It allows you to:

- Run custom SQL queries
- Read/write/delete data from any WordPress table (like posts, users, options, etc.)

---

### Why use `$wpdb` instead of raw SQL?

Because:

- It handles **WordPress table prefixes** automatically (`wp_` or custom)
- It protects from **SQL injection** if used properly
- It’s safer, faster, and follows WordPress best practices

---

### Example Use Cases

#### 1. **Select Data**

```php
global $wpdb;

$results = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}posts WHERE post_status = 'publish'");
foreach ($results as $post) {
    echo $post->post_title . '<br>';
}
```

#### 2. **Insert Data**

```php
global $wpdb;

$wpdb->insert(
    $wpdb->prefix . 'my_custom_table',
    array(
        'name' => 'Aditya',
        'email' => 'aditya@example.com'
    ),
    array('%s', '%s') // data formats
);
```

#### 3. **Update Data**

```php
global $wpdb;

$wpdb->update(
    $wpdb->prefix . 'my_custom_table',
    array('name' => 'Updated Name'),
    array('id' => 1),
    array('%s'),
    array('%d')
);
```

#### 4. **Delete Data**

```php
global $wpdb;

$wpdb->delete(
    $wpdb->prefix . 'my_custom_table',
    array('id' => 1),
    array('%d')
);
```

---

### Always use `prepare()` for safety

```php
$sql = $wpdb->prepare(
    "SELECT * FROM {$wpdb->prefix}posts WHERE post_title = %s",
    'Hello World'
);
$results = $wpdb->get_results($sql);
```

---

### Access Common WordPress Tables

```php
$wpdb->posts      // 'wp_posts'
$wpdb->users      // 'wp_users'
$wpdb->options    // 'wp_options'
$wpdb->comments   // 'wp_comments'
// and so on...
```

---

### In Simple Words:

Think of `$wpdb` like a **remote control** for your WordPress database — it lets you **fetch**, **insert**, **update**, or **delete** data in a safe, WordPress-friendly way without writing full raw SQL.

---

# Use of prepare in wpdb?

---

### What is `prepare()` in `$wpdb`?

`$wpdb->prepare()` is a **security function** that helps prevent **SQL injection attacks**.

It prepares your raw SQL query by safely **escaping** and **inserting variables** into it.

---

### When should you use `prepare()`?

You should use it **whenever you're inserting variables into SQL queries**, **especially with SELECT queries** or **custom SQL** that you write manually.

---

### Syntax:

```php
$wpdb->prepare( "SQL_QUERY_WITH_PLACEHOLDERS", value1, value2, ... );
```

- `%s` = string
- `%d` = integer
- `%f` = float

---

### Example with `prepare()` — SELECT:

```php
global $wpdb;
$name = 'Aditya';

$sql = $wpdb->prepare(
    "SELECT * FROM {$wpdb->prefix}my_custom_table WHERE name = %s",
    $name
);
$results = $wpdb->get_results($sql);
```

---

### Can you use `prepare()` with **INSERT**, **UPDATE**, **DELETE**?

🔸 **Yes, but only when writing raw SQL manually.**

🔸 If you use `$wpdb->insert()`, `$wpdb->update()`, or `$wpdb->delete()` methods, **you don't need `prepare()`** — those methods already sanitize the inputs internally using safe escaping.

---

### DO NOT do this:

```php
// Wrong: This is double-escaping (not needed)
$wpdb->insert(
    $wpdb->prefix . 'table_name',
    array('name' => $wpdb->prepare('%s', $name)), // ❌ wrong
    array('%s')
);
```

---

### Summary:

| Method          | Use `prepare()`? | Reason            |
| --------------- | ---------------- | ----------------- |
| `get_results()` | Yes              | You write raw SQL |
| `get_var()`     | Yes              | You write raw SQL |
| `insert()`      | No               | Internally safe   |
| `update()`      | No               | Internally safe   |
| `delete()`      | No               | Internally safe   |

---

### Best Practice:

- Use `$wpdb->prepare()` when writing any **custom SQL query**.
- Don’t use it inside `$wpdb->insert/update/delete()`, because those functions **already sanitize the input for you**.
