#!/usr/bin/env groovy

node('master') {
    stage('build') {
        git url: 'git@github.com:MWoW0/mwow.quazye.me.git'

        // Start services (Let docker-compose build containers for testing)
        sh "./ci.sh up -d"

        // Get composer dependencies
        sh "./ci.sh composer install"

        // Create .env file for testing
        sh 'cp .env.example .env'
        sh './ci.sh php artisan key:generate'
        sh 'sed -i "s/REDIS_HOST=.*/REDIS_HOST=redis/" .env'
        sh 'sed -i "s/CACHE_DRIVER=.*/CACHE_DRIVER=redis/" .env'
        sh 'sed -i "s/SESSION_DRIVER=.*/SESSION_DRIVER=redis/" .env'
    }
    stage('test') {
        sh "APP_ENV=testing ./ci.sh test"
    }
}