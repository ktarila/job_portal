#!/bin/sh
sleep 10;
php /app/bin/console messenger:consume async -vvv;