## What is `Text-Domain` in WordPress?

**Text-Domain is an identifier used for translations (i18n).**

It tells WordPress:

> “These strings belong to _this plugin/theme_. Use _this_ translation file for them.”

Think of it like a **namespace for language strings**.

---

## Why do we need Text-Domain?

WordPress supports **multiple languages**.
Your plugin might be used in:

- English 🇺🇸
- Hindi 🇮🇳
- French 🇫🇷
- German 🇩🇪
- etc.

The `Text-Domain` allows WordPress to replace text like:

```php
__( 'Revision Menu', 'revision-logic' );
```

with a translated version **based on the site’s language**.

Without a text-domain → **no translations possible**.

---

## How it works (conceptually)

1. You write translatable strings:

```php
__( 'Revision Menu', 'revision-logic' );
```

2. WordPress looks for translation files:

```
revision-logic-en_US.mo
revision-logic-hi_IN.mo
```

3. It matches:

- string: `"Revision Menu"`
- domain: `"revision-logic"`

4. Output becomes (example Hindi):

```
Revision Menu → संशोधन मेनू
```

---

## Where is Text-Domain defined?

### In plugin header (mandatory)

```php
/**
 * Text Domain: revision-logic
 */
```

### In translation functions (mandatory)

```php
__( 'Revision Menu', 'revision-logic' );
esc_html__( 'Revision Logic Page', 'revision-logic' );
```

**Both must match exactly**.

---

## What happens if you don’t use Text-Domain?

- ❌ Your plugin **cannot be translated**
- ❌ WordPress.org plugin repository **may reject it**
- ❌ Fails professional code review
- ❌ Non-English users get poor UX

---

## Difference between `__()` and `_e()`

| Function       | Purpose                   |
| -------------- | ------------------------- |
| `__()`         | Returns translated string |
| `_e()`         | Echoes translated string  |
| `esc_html__()` | Returns + escapes         |
| `esc_html_e()` | Echoes + escapes          |

Example (best practice):

```php
<h1><?php echo esc_html__( 'Revision Logic Page', 'revision-logic' ); ?></h1>
```

---

## Why Text-Domain name matters

### Best practice

- Same as plugin folder
- Same as main plugin file
- Lowercase + hyphen

```text
plugin folder: revision-logic
main file:    revision-logic.php
Text Domain:  revision-logic
```

---

## Professional takeaway

**Text-Domain is not optional fluff.**

It enables:

- 🌍 Internationalization
- 🧩 Plugin interoperability
- 🏆 WordPress.org compliance
- 👨‍💻 Professional-grade plugins
