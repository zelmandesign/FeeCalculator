#!/bin/sh
cd /var/www/html/public

# Make sure phpunit is executable
chmod +x /var/www/html/public/vendor/bin/phpunit

# Run the tests
/var/www/html/public/vendor/bin/phpunit 
