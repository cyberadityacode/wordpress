# Security, Sanitization, and Escaping

## security is not a feature; it's a prerequisite.

A "Legend" level developer assumes all data is malicious until proven otherwise. We follow the golden rule:

1. Sanitize on Input: Clean data before it goes into the database.

2. Escape on Output: Clean data right before it is rendered in the browser.

If we were to allow users to save settings (which we will soon), we would use functions like sanitize_text_field(). When we display data, we use functions like esc_html() or esc_attr()

```php

add_filter('the_content', [$this, 'add_signature_content']);

public function add_signature_content($content){
        return wp_kses_post($content) . '<p>This post was verified by Champion Logic.</p>';
    }
//wp_kses_post: Sanitizes content for allowed HTML tags for post content.
```

## Why did I add if ( ! defined( 'ABSPATH' ) ) { exit; } at the top of the file? (This is a common interview question for WP Developers).

"It prevents Path Disclosure and Direct Script Execution. If a server is misconfigured, an attacker could access the PHP file directly via a URL. Since the file isn't running inside the WordPress environment, global variables like $wpdb or functions like add_action() wouldn't exist, leading to fatal errors that reveal the server's internal file paths. This line ensures the file only executes when the ABSPATH constant is defined by the WordPress core."

If I don't type and access the plugin PATH

http://learndevelopment.local:10013/wp-content/plugins/champion-logic/champion-logic.php

Fatal error: Uncaught Error: Call to undefined function add_action() in /home/aditya/Local Sites/learndevelopment/app/public/wp-content/plugins/champion-logic/champion-logic.php:22 Stack trace: #0 /home/aditya/Local Sites/learndevelopment/app/public/wp-content/plugins/champion-logic/champion-logic.php(51): Champion_Logic->\_\_construct() #1 {main} thrown in /home/aditya/Local Sites/learndevelopment/app/public/wp-content/plugins/champion-logic/champion-logic.php on line 22
