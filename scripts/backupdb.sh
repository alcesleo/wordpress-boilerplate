#!/bin/bash -e

# This script makes a textfile containing the database structure and data,
# and stages it in git. This way the database can be kept under version control
# alongside the rest of your code.
#
# It can be used either manually, or as a pre-commit hook (see README.md)

# Configuration
# Change these to what works for you
user=root
password=root
database=database

# Create the database backup
mysqldump --skip-extended-insert --user=$user --password=$password $database > www/database/database.sql
git add www/database/database.sql

echo "Database saved!"
