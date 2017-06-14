#!/bin/bash

cd ../waca/

git checkout $1

git submodule init
git submodule update

rm -r templates_c/
mkdir templates_c/
