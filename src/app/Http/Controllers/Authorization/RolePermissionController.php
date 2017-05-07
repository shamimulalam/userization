<?php
namespace App\Http\Controllers\Authorization;
use App\RolePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Permission;
use DB;
use App\Http\Controllers\Controller;
class RolePermissionController extends Controller
{
    public function index(Request $request,$id)
    {
        if(isset($request->fields))
        {
            $permissions= Permission::select('id')->where($request->fields,'like','%'.$request->key.'%')->get();
            $pers=[];
            if(count($permissions)>0) {
                foreach ($permissions as $permission) {
                    $pers[]=$permission->id;
                }
            }

        }
        $data['role_id']=$id;
        $role=New RolePermission();
        $data['title']="Manage Role Permission";
        if($request->search=='Trashed'){
            $role=$role->where('role_id',$id)->onlyTrashed();
        }elseif($request->search == 'Active')
        {
            $role=$role->where('role_id',$id)->where('status','Active');
        }elseif(isset($request->fields))
        {
            $role=$role->whereIn('permission_id',$pers)->where('status','Active');
        }
        $role=$role->where('role_id',$id)->paginate(10);
        $data['roles']=$role;
        $serial=1;
        if($role->currentPage()>1)
        {
            $serial=(($role->currentPage()-1)*$role->perPage())+1;
        }
        $data['serial']=$serial;
        return view('rolePermission.index',$data);
    }
    public function create($id)
    {   $data['role_id']=$id;
         $role_permission=Permission::all();
         foreach ($role_permission as $roles)
        if(!RolePermission::where('permission_id',$roles->id)->where('role_id',$id)->withTrashed()->exists()){
            $route_list[]=$roles;
            $data['routes']=$route_list;
        }else{

            $data['alert']="No Route Exist !";

        }
        return view('rolePermission.create',$data);
    }
    public function store(Request $request){
        DB::beginTransaction();
        try {
        $routes=$request->all();
        foreach ($routes['routes'] as $route => $value) {
                $permission = new RolePermission();
                $permission->permission_id=$route;
                $permission->role_id=$request->role_id;
                $permission->save();
            }
            DB::commit();
        Session::flash('message', 'Role Permission Successfully Insert');
        return redirect()->route('role_permission.index',$request->role_id);
        }catch (\Exception $e)
        {
            DB::rollback();
            Session::flash('message', $e->getMessage());
            return redirect()->back();
        }
        }
    public function trash($id)
    {
        RolePermission::where('id',$id)->delete();
        Session::flash('message', 'Role Permission Successfully Trashed');
        return redirect()->back();
    }
    public function restore($id){
        RolePermission::withTrashed()->where('id',$id)->first()->restore();
        Session::flash('message','Role Permission Successfully restored.');
        return redirect()->back();
    }
    public function destroy($id)
    {
        RolePermission::withTrashed()->where('id',$id)->first()->forceDelete();
        Session::flash('message','Role Permission Successfully Delete.');
        return redirect()->back();
    }
}
