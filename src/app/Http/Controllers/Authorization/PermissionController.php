<?php

namespace App\Http\Controllers\Authorization;

use App\Http\Middleware\AuthorizationMiddleware;
use App\Permission;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $permission=new Permission();
        if($request->search=='Trashed'){
            $permission=$permission->onlyTrashed();
        }elseif(isset($request->fields)){
            $permission=$permission->where($request->fields,'like','%'.$request->key.'%');
        }
        $permission=$permission->paginate(10);
        $data['permissions']=$permission;
        $serial=1;
        if($permission->currentPage()>1)
        {
            $serial=(($permission->currentPage()-1)*$permission->perPage())+1;
        }
        $data['serial']=$serial;
        return view('permission.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $routesFromFile=Route::getRoutes();
//        dd($routesFromFile);
        $route_list=[];
        foreach ($routesFromFile as $id=>$route) {
            if(empty($route->action['ignore'])) {
                $authorizationMiddleware=new AuthorizationMiddleware();
                $matches=$authorizationMiddleware->checkPregMatch('DYNAMICURI',$route->uri);
                if (isset($matches) && !empty($matches)) {
                    if (isset($route->action['table']) && isset($route->action['column'])) {
//                    $table_name = explode('+', $matches[1][0]);
                        $values = $authorizationMiddleware->getDynamicValues($route->action['table'],$route->action['column']);
                        if(count($values)>0) {
                            foreach ($values as $k => $value) {
                                $new_route = clone $route;
                                $title = $route->action['column'];
                                $new_uri = str_replace('{DYNAMICURI}', strtolower($value->$title), $new_route->uri);
                                $new_route->uri = $new_uri;

                                /**
                                 * for title
                                 * */
                                if (isset($route->action['title'])) {
                                    $matchesName = $authorizationMiddleware->checkPregMatch('DYNAMICNAME', $route->action['title']);
                                    if (isset($matchesName)) {
                                        $new_route->action['title'] = str_replace('{DYNAMICNAME}', ucfirst($value->$title), $route->action['title']);
                                    }
                                }
                                /**
                                 * for title
                                 * */
                                if ($this->_checkUriExist($new_uri)) {
                                    $route_list[] = $new_route;
                                }
                            }
                        }
                    }
                } elseif ($this->_checkUriExist($route->uri)) {
                    $route_list[] = $route;
                }
            }
        }
        $data['routes']=$route_list;
        return view('permission.create',$data);
    }
    public function _checkUriExist($uri)
    {
        if(!Permission::where('route_uri',$uri)->withTrashed()->exists()){
            return true;
        }
        return false;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $routes = $request->all();
//        dd($routes);
            foreach ($routes['routes'] as $route => $value) {
                if (!Permission::where('route_uri', $route)->exists()) {
                    $permission = new Permission();
                    $permission->route_uri = $route;
                    if (isset($routes['route_titles'][$route])) {
                        $permission->title = $routes['route_titles'][$route];
                    }
                    if (isset($routes['route_names'][$route])) {
                        $permission->route_name = $routes['route_names'][$route];
                    }
                    $permission->save();
                }
            }
            DB::commit();
            Session::flash('message', 'Permission Successfully Insert');
            return redirect()->route('permission.index');
        }catch (\Exception $e)
        {
            DB::rollback();
            Session::flash('message', $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function trash($id)
    {
        Permission::where('id',$id)->delete();
        Session::flash('message', 'Permission Successfully Trashed');
        return redirect()->back();
    }
    public function restore($id){
        Permission::withTrashed()->where('id',$id)->first()->restore();
        Session::flash('message','Permission Successfully restored.');
        return redirect()->route('permission.index');
    }
    public function destroy($id)
    {
        //
    }
}
