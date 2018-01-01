# About Userization Package
## Beta Version 0.3 runing

### In Composer.json
 
    "require": {
        ****************
        "adamilleriam/userization" : "0.3.*"
    },
    "repositories":[
        {
            "type": "git",
            "url": "https://github.com/adamilleriam/userization.git"
        }
    ],
    
    and add this line in config/app.php providers array
    ----------------------------------------------------------------
    adamilleriam\userization\userizationServiceProvider::class,
    ----------------------------------------------------------------
    Now Run composer update
#### Vendor Publish
    After complete composer update please Run :::: php artisan vendor:publish --provider="adamilleriam\userization\userizationServiceProvider"
    and 
    Run "composer dump-autoload"
#### Config
 Package has a config file in config folder. The name of this file is  userization.php
  First have to add master_template and content_area with master template location and content area name.
  Then add per_page field for pagination.


#####'userization'=>\App\Http\Middleware\UserizationMiddleware::class,

register this line in app/Http/kernel.php "routeMiddleware" section

Add this file to composer autoload
    "autoload": {
        "files": ["app/Http/UserizationHelper.php"]
    },
### Migration
Before run "php artisan migrate" please add a user id in userization config file.
Provided user will get all privilege in authorization.
 Then run 
 
 #####"php artisan migrate --path=database/migrations/userization"

### Add middleware in your route group
Please add middleware called 'userization' in your route group

### To connect user with role
    add role button on user list page 
    - Route = role_user.index (send with user id)
    - URL   = role_user/{user_id} 

#### Routes
    - role
    - permission
    
    
#### Extra
    Extra fretures are here
##### canViewButton() 
    It's a global function. it take to parameter. first one is required and second one is optional.
     - First Parameter => send uri or route 
        Ex. canViewButton('permission/create');
     - Second Parameter => type is it URI or Route. default is URI. if you send route then you have to mention it. 
#### Ignoring a route
     - if you want to ignore a route just add ::: 'ignore'=>'ignore' in your route. Then this route always ignored by userization package
    
#### Route title
     - If you want you can add title for every route that how a general user can understand what actually he permitted.
    
#Dependencies
1. Bootstrap
2. Jquery
3. Laravel Collective (https://laravelcollective.com/docs/5.0/html)
4. Font Awesome (https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css)

#NB:
- Please don't use few route in your route file. Those routes are booked by Userization package.
    * role
    * permission
    * role_user