# The Settings API (Fields & Sections)

Most developers just create a `<form>` and handle `$_POST` data manually. Legends don't do that.

- WordPress provides the Settings API. It's more complex to set up initially, but it handles security (nonces), error messaging, and data saving automatically. It consists of three main parts:

1. Setting: The name of the option in the database (stored in wp_options).

2. Section: A group of related settings (used for visual layout).

3. Field: The actual input (text, checkbox, etc.).
