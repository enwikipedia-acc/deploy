#!/bin/bash

cd ../rc/

git checkout $1


export HOME=/var/www
composer install --no-cache -n --no-progress
npm install

rm -r templates_c/
mkdir templates_c/

npm run build-scss
