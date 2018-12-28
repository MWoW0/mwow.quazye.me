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
    }
    stage('test') {
        sh "APP_ENV=testing ./ci.sh test"
    }
}