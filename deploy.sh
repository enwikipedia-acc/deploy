#!/bin/bash

cd ../sand/

git fetch --all
git fetch --tags

git checkout $1

git pull

