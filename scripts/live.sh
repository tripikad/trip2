#!/bin/bash

FULL_BASE_URL=$(grep FULL_BASE_URL .env | cut -d '=' -f2)
npx browser-sync start --proxy "$FULL_BASE_URL" --files="(app|config|database|resources|routes|storage|tests)/**/*.(php|js|css|vue|svg|md)" --no-ui --no-notify --reload-delay="1000"
