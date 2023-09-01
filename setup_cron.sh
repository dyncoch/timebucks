#!/bin/bash

# Define the path to your CakePHP project
PROJECT_PATH="/path-to-your-project"

# Check if the CakePHP command is executable
if [ ! -x "$PROJECT_PATH/bin/cake" ]; then
    echo "The CakePHP command is not executable. Making it executable now."
    chmod +x "$PROJECT_PATH/bin/cake"
fi

# Add the cron job
(crontab -l 2>/dev/null; echo "0 2 * * * $PROJECT_PATH/bin/cake fetch_offers fetchData") | crontab -

echo "Cron job set up successfully."
