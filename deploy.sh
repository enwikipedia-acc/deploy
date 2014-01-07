#!/bin/bash

cd ../waca/

git fetch --all
git fetch --tags

git checkout $1

git pull

git submodule init
git submodule update
