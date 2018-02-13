# Laravel Repository Generator
[![StyleCI](https://styleci.io/repos/120919876/shield?branch=master)](https://styleci.io/repos/120919876) 

*This package offer the possibility to generate repository for Laravel*



### Installation

1. Install  package wit composer


    composer require oghouz/repogenerate

2. Register the service provider

Add the provider to config/app.php


    Oghouz\RepoGenerate\RepoGenerateServiceProvider::class,
    
3. Publish 

    php artisan vendor:publish --provider="Oghouz\RepoGenerate\RepoGenerateServiceProvider"


### Configuration


    config/repository.php

### Usage


    php artisan make:repository YourModelName   

