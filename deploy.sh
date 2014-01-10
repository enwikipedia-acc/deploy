#!/bin/bash

cd ../waca/

git checkout $1

git submodule init
git submodule update
