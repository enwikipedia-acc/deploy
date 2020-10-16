#!/bin/bash

cd ../rc/

git checkout $1

rm -r templates_c/
mkdir templates_c/

php maintenance/RegenerateStylesheets.php
