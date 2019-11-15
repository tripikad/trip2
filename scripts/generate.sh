#!/bin/bash

  printf "\n\e[0;32mGenerating the dots for the Dotmap component\e[0;37m"
  printf "\nThe script will take around a minute to run\n\n"

  node scripts/generate_dots.js >./config/dots.php

  printf "\n\e[0;32mGenerating the airport data\e[0;37m\n\n"

  node scripts/generate_airports.js >./config/airports.php

  printf "\n\e[0;32mGenerating the city data\e[0;37m\n\n"

  node scripts/generate_cities.js >./config/cities.php

  printf "\n\e[0;32mDone\e[0;37m\n\n"

fi
