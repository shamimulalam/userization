<?php

namespace App\Http\Middleware;

use App\Permission;
use App\RolePermission;
use App\RoleUser;
use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
class AuthorizationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(auth()->id() != null)
        {
            if($this->checkAccessibility())
            {
                return $next($request);
            }
            return response()->view('admin.errorPage.index');
        }else{
            return Redirect::to(config('authorization.redirect_url_while_not_auth'));
        }
    }
    public function getDynamicValues($table,$column)
    {
        return DB::table($table)->select($column)->get();
    }
    public function checkPregMatch($keyword,$value)
    {
        preg_match('/'.$keyword.'/', $value, $matches, PREG_OFFSET_CAPTURE, 1);
        return $matches;
    }
    public function checkAccessibility($uri=false)
    {
        if($this->checkAccessibilityForDynamicUri($uri))
        {
            return true;
        }elseif($this->checkAccessibilityRegular($uri))
        {
            return true;
        }else{
            return false;
        }
    }
    public function checkAccessibilityRegular($uri=false)
    {
        if(isset($uri) && $uri == false)
        {
            $uri=app()->router->getCurrentRoute()->uri;
        }
        $permission=Permission::select('id')->where('route_uri',$uri)->first();
        if(isset($permission) && $permission != null) {
            $permission_id = $permission->id;
            $roles = RoleUser::where('user_id', auth()->id())->where('status', 'active')->pluck('role_id', 'id');
            if (count($roles) > 0) {
                foreach ($roles as $role_id) {
                    if (RolePermission::where('role_id', $role_id)->where('permission_id', $permission_id)->exists()) {
                        return true;
                    }
                }
            }
        }
        return false;
    }
    public function checkAccessibilityForDynamicUri($uri=false)
    {
        if(isset($uri) && $uri==false)
        {
            $uri=app()->router->getCurrentRoute()->uri;
        }
        $matches=$this->checkPregMatch('DYNAMICURI',$uri);
        if (isset($matches) && !empty($matches)) {
            $currentRouteUri=$uri;
            $currentRouteUri=explode('/',$currentRouteUri);
            $segment_id=null;
            foreach ($currentRouteUri as $route_id=>$item) {
                if($item=='{DYNAMICURI}')
                {
                    $segment_id=$route_id+1;
                }
            }
            $values = $this->getDynamicValues(app()->router->getCurrentRoute()->action['table'],app()->router->getCurrentRoute()->action['column']);
            if(count($values)>0) {
                $column = app()->router->getCurrentRoute()->action['column'];
                foreach ($values as $k => $value) {
                    if($value->$column==request()->segment($segment_id)) {
                        $new_uri = str_replace('{DYNAMICURI}', strtolower($value->$column), $uri);
                        if ($this->checkAccessibilityRegular($new_uri)) {
                            return true;
                        }
                    }
                }
            }
        }
        return false;
    }
}
