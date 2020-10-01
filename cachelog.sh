#!/bin/bash
sudo rm -r var/cache/*
sudo rm -r var/log/*
sudo rm -r var/sessions/*
sudo rm -r public/media/photo/*

HTTPDUSER=`ps axo user,comm | grep -E '[a]pache|[h]ttpd|[_]www|[w]ww-data|[n]ginx' | grep -v root | head -1 | sed 's/ .*$//'`
sudo setfacl -R -m u:"$HTTPDUSER":rwX -m u:`whoami`:rwX var/cache var/log var/sessions public/photo/avatar
sudo setfacl -dR -m u:"$HTTPDUSER":rwX -m u:`whoami`:rwX var/cache var/log var/sessions public/photo/avatar
touch public/media/photo/.gitkeep
# symfony linux directory permissions
