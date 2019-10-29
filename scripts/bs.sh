#!/bin/bash

FULL_BASE_URL=$(grep FULL_BASE_URL .env | cut -d '=' -f2)
npx browser-sync start --proxy "$FULL_BASE_URL" --files="(app|config|database|public|resources|routes|storage|tests)/**/*.(php|js|vue|svg)" --no-ui --no-notify
