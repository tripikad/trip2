#!/bin/bash

printf "\n\e[0;32mGenerating the airport data\e[0;37m\n\n"

node scripts/generate_airports.js >./config/airports.php

printf "\n\e[0;32mGenerating the destination data\e[0;37m\n\n"

node scripts/generate_facts.js --json >./scripts/data/trip_facts.php

node scripts/generate_facts.js >./config/facts.php

printf "\n\e[0;32mGenerating the dots for the Dotmap component\e[0;37m"

node scripts/generate_dots.js >./config/dots.php

printf "\n\e[0;32mDone\e[0;37m\n\n"
