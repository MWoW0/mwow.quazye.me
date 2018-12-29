#!/usr/bin/env bash

# We need the full path here because /sbin is not in user Jenkin's $PATH
#export XDEBUG_HOST=$(/sbin/ifconfig docker0 | grep "inet addr" | cut -d ':' -f 2 | cut -d ' ' -f 1)
export CONTAINER_ENV=${CONTAINER_ENV:-local}

export WWWUSER=${WWWUSER:-$UID}
# Set environment variables for dev
export APP_ENV=${APP_ENV:-local}
export APP_PORT=${APP_PORT:-80}
export DB_PORT=${DB_PORT:-3306}
export DB_ROOT_PASS=${DB_ROOT_PASS:-secret}
export DB_NAME=${DB_NAME:-website}
export DB_USER=${DB_USER:-website}
export DB_PASS=${DB_PASS:-secret}

# Create docker-compose command to run
COMPOSE="docker-compose -f docker-compose.ci.yml"

# If we pass any arguments...
if [ $# -gt 0 ]; then
	# COMMAND="run --rm -T"
	COMMAND="exec -T"

    # If "php" is used, pass-thru to "php"
    # inside a new container
    if [ "$1" == "php" ]; then
        # Shift first argument off the bash argumnts and pass the remaining to php inside the app container.
        shift 1
        $COMPOSE $COMMAND \
            app \
            php "$@"

    # If "composer" is used, pass-thru to "composer"
    # inside a new container
    elif [ "$1" == "composer" ]; then
        shift 1
        $COMPOSE $COMMAND \
            app \
            composer "$@"

    # If "test" is used, run unit tests,
    # pass-thru any extra arguments to php-unit
    elif [ "$1" == "test" ]; then
        shift 1
        $COMPOSE $COMMAND \
            app \
            ./vendor/bin/phpunit "$@"
    # Else, pass-thru args to docker-compose
    else
        $COMPOSE "$@"
    fi
else
    # Use the docker-compose ps command if nothing else passed through
    $COMPOSE ps
fi
