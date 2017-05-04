<?php
/**
 * Created by PhpStorm.
 * User: sha1
 * Date: 4/25/17
 * Time: 2:13 PM
 */
function canViewButton($uri,$type=false)
{
    if(isset($type) && $type != null)
    {
        if($type='route')
        {
            if(\App\Permission::where('route_name',$uri)->exists()) {
                $permission = \App\Permission::where('route_name', $uri)->first();
                $uri = $permission->route_uri;
            }
        }
    }
    $mdl=new \App\Http\Middleware\AuthorizationMiddleware();
    if($mdl->checkAccessibility($uri))
    {
        return true;
    }
    return false;
}