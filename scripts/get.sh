#!/bin/bash

if [ $# -eq 0 ]; then
  printf "\nUsage: ./generate.sh http://your-local-trip.dev\n\n"
else

  printf "\n\e[0;32mFetching the source data\e[0;37m\n\n"

  curl https://raw.githubusercontent.com/johan/world.geo.json/master/countries.geo.json >./scripts/data/countries.json

  curl https://raw.githubusercontent.com/datasets/country-codes/master/data/country-codes.csv >./scripts/data/codes.csv

  curl https://raw.githubusercontent.com/euvl/country-phone-number-codes/master/codes.json >./scripts/data/dialcodes.json

  curl https://raw.githubusercontent.com/jpatokal/openflights/master/data/routes.dat >./scripts/data/routes.csv

  curl https://raw.githubusercontent.com/jpatokal/openflights/master/data/airports.dat >./scripts/data/airports.csv

  curl http://api.geonames.org/countryInfoJSON?username=kristjanjansen >./scripts/data/geonames_countries.json

  curl $1/api/destinations >./scripts/data/trip_destinations.json

  # curl $1/api/destinations/data >./scripts/data/trip_destinations_data.json

  node scripts/get_geonames_destinations.js >./scripts/data/geonames_destinations.json

  printf "\n\e[0;32mDone\e[0;37m\n\n"

fi
