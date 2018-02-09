# Laravel Repository Generator

*This package permission generate repository class for your controller and model in Laravel*

### Installation

#####1. Install  package wit composer

    composer require oghouz/repogenerate

#####2. Register the service provider

Add the provider to config/app.php

    Oghouz\RepoGenerate\RepoGenerateServiceProvider::class,
    
#####3. Publish 

    php artisan vendor:publish --provider="Oghouz\RepoGenerate\RepoGenerateServiceProvider"



### Configuration

    config/repository.php

### Usage

    php artisan make:repository YourModelName

