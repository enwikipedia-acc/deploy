#!/bin/bash

cd ../waca/

git checkout $1

git pull

git submodule init
git submodule update
