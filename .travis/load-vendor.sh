#!/bin/sh

checksum=$(sha1sum composer.json | cut -d' ' -f1)
url=http://bacon.dasprids.de/travis/BaconUser/vendor-$checksum.tgz

curl -s --head $url | head -n 1 | grep "HTTP/1.[01] [23].." > /dev/null

if [ $? -eq 0 ]
then
    echo "Downloading cached composer installation"
    curl -s -o vendor.tgz $url
    tar -xf vendor.tgz
    rm -f vendor.tgz
else
    echo "Installing from composer"
    composer install --dev --prefer-source
fi
