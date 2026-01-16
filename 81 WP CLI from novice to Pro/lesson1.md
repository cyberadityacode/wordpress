# WP CLI Lessons from novice to Pro

## Day 1

wp --info

wp cli info
wp core version
wp user list

## Day 2

wp core check-update
wp core update
wp core download
wp core verify-checksums

## Day 3

plugins

wp plugin list
wp plugin install woocommerce --activate
wp plugin update --all
wp plugin delete hello

themes

wp theme list
wp theme install astra --activate
wp theme delete twentytwenty

## Day 4

wp user list
wp user create john john@test.com --role=editor
wp user update <user> --user_pass="YourNewPassword" //change user password
wp user reset-password <user> --show-password

wp user update <user> --role=administrator

## Day 5

wp post list
wp post delete 12 --force
wp post list --post_type=page --format=ids // list all post ids

wp post delete $(wp post list --post_type=page --format=ids) --force //it works like sql subqueries => delete all page post

wp post create --post_type=page --post_title="Test Page"

Aditya Dubey
cyberadityacode
