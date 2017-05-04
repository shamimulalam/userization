# About Authorization Package

## Configuration

----------------------------------------------------------------------
'authorization'=>\App\Http\Middleware\AuthorizationMiddleware::class,
----------------------------------------------------------------------
register this line in app/Http/kernel.php "routeMiddleware" section
### In Composer.json
 
    "require": {
        ****************
        "adamilleriam/authorization" : "0.1.*"
    },
    "repositories":[
        {
            "type": "git",
            "url": "git@github.com:adamilleriam/authorization.git"
        }
    ],
    
    and add this line in config/app.php providers array
    ----------------------------------------------------------------
    adamilleriam\authorization\authorizationServiceProvider::class,
    ----------------------------------------------------------------
#### Config
 Package has a config file in config folder. The name of this file is  authorization.php
  First have to add master_template and content_area with master template location and content are name.
  Then add per_page field for pagination.
  
  
#### Rules
    add role button on user list page 
    - Route = role_user.index (send with user id)
    - URL   = role_user/{user_id} 

#### Routes
    - role
    - permission
    
    
#### Extra
    ##### canViewButton() 
    Add this file to composer autoload
    "autoload": {
        "files": ["app/Http/AuthorizationHelper.php"]
    },
    It's a global function. it take to parameter. first one is required and second one is optional.
     - First Parameter => send uri or route 
        Ex. canViewButton('permission/create');
     - Second Parameter => type is it URI or Route. default is URI. if you send route then you have to mention it. 
        EX. canViewButtton('permission.create','route')
    
