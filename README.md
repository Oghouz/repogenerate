# Laravel Repository Generator
[![Build Status](https://travis-ci.org/Oghouz/repogenerate.svg?branch=master)](https://travis-ci.org/Oghouz/repogenerate) [![StyleCI](https://styleci.io/repos/120919876/shield?branch=master)](https://styleci.io/repos/120919876) [![Latest Stable Version](https://poser.pugx.org/oghouz/repogenerate/v/stable)](https://packagist.org/packages/oghouz/repogenerate) [![Total Downloads](https://poser.pugx.org/oghouz/repogenerate/downloads)](https://packagist.org/packages/oghouz/repogenerate) [![Latest Unstable Version](https://poser.pugx.org/oghouz/repogenerate/v/unstable)](https://packagist.org/packages/oghouz/repogenerate)

*This package offer the possibility to generate repository for Laravel 5*

### Compatibility

 Laravel      |
:-------------|
 5.3.x        |
 5.4.x        |
 5.5.x and up |


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

