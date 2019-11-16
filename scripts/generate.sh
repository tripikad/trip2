#!/bin/bash

  printf "\n\e[0;32mGenerating the airport data\e[0;37m\n\n"

  node scripts/generate_airports.js >./config/airports.php

  printf "\n\e[0;32mGenerating the destination data\e[0;37m\n\n"

  node scripts/generate_destinations.js --json >./scripts/data/destinations2.php

  node scripts/generate_destinations.js >./config/destinations2.php

  printf "\n\e[0;32mGenerating the dots for the Dotmap component\e[0;37m"

  node scripts/generate_dots.js >./config/dots.php

  printf "\n\e[0;32mDone\e[0;37m\n\n"

fi
