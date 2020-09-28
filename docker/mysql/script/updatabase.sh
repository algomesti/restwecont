#!/bin/sh

mysql -u root -h mysql --password=root < /var/www/html/db/database.sql

RESULT=$?
exit $RESULT
