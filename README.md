# WebfactionCommands

Some artisan commands for the deployment on WebFaction servers.

## Install && Usage

Add in `composer.json`  
```
"require": {
    "spescina/webfaction-commands": "1.0.*"
}
```

Run `composer update`  

Add the service provider in the `app/config/app.php` file  
```
"Spescina\WebfactionCommands\WebfactionCommandsServiceProvider"
```

Publish the package config running `php artisan config:publish spescina/webfaction-commands`.  

Setup your environments and a Webfaction remote connection.  

`php artisan wf:install` and `php artisan wf:update` will be added to your artisan commands.     
