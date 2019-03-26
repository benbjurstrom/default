#!/bin/sh

set -e

echo "Running the webserver..."
exec php artisan serve --host=0.0.0.0 --port 8000