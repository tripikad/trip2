#!/bin/bash

node scripts/generate_styles.js
./node_modules/.bin/prettier config/styles.php --write
