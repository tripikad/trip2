#!/bin/bash

if [ $# -eq 0 ]; then
    printf "\nUsage: ./generate.sh http://your-local-trip.dev"
    printf "\n\nYou need to have csvkit installed\n\e[4;37mhttp://csvkit.readthedocs.io/en/1.0.2/tutorial/1_getting_started.html#installing-csvkit\e[0;37m\n\n"
else
    
printf "\n\e[0;32mGetting the data...\e[0;37m\n\n"

curl https://raw.githubusercontent.com/johan/world.geo.json/master/countries.geo.json > data/countries.json

curl https://raw.githubusercontent.com/datasets/country-codes/master/data/country-codes.csv | csvjson -i 4 > data/codes.json

curl $1/api/destinations/data > data/destinations_data.json

printf "\n\e[0;32mGenerating the dots for the map (this will take around 10min) ...\e[0;37m\n\n"

node generate_dots.js > ../config/dots.php

printf "\n\e[0;32mDone\e[0;37m\n\n"

fi