<?php

namespace App\Http\Controllers\Userization;

use App\Role;
use App\RolePermission;
use App\RoleUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use Auth;
class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $roles=New Role();
        $data['title']='Manage Role';
        if($request->search=='Trashed'){
            $roles=$roles->onlyTrashed();

        }elseif($request->search == 'Inactive')
        {
            $roles=$roles->where('status','Inactive');
        }else{
            $roles=$roles->where('status','Active');
        }

        $roles=$roles->orderBy('id','DESC')->paginate(config('userization.par_page'));
        if(isset($request->search))
        {
            $render['search']=$request->search;
            $roles=$roles->appends($render);
        }
        $data['roles']=$roles;
        $serial=1;
        if($roles->currentPage()>1)
        {
            $serial=(($roles->currentPage()-1)*$roles->perPage())+1;
        }
        $data['serial']=$serial;
        return view('userization.role.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $data['title']='Add Role';
        return view('userization.role.create',$data);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'status' => 'required',
        ]);
        $role=New Role();
        $role->title=$request->title;
        $role->description=$request->description;
        $role->status=$request->status;
        $role->save();
        Session::flash('message','Role Successfully Insert');
        return redirect()->route('role.index');

    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['title']='Edit User';
        $data['role']=Role::withTrashed()->where('id',$id)->first();
        return view('userization.role.edit',$data);
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
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'status' => 'required',

        ]);
        $user=Role::withTrashed()->where('id',$id)->first();
        $user->title=$request->title;
        $user->description=$request->description;
        $user->status=$request->status;
        $user->save();
        Session::flash('message','Role Successfully Update');
        return redirect()->route('role.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function trash($id)
    {
        Role::findorfail($id)->delete();
        Session::flash('message','Role Successfully Trashed.');
        return redirect()->back();
    }

    public function restore($id){
        Role::withTrashed()->where('id',$id)->first()->restore();
        Session::flash('message','Role Successfully Restored.');
        return redirect()->route('role.index');



    }
    public function destroy($id){
        RoleUser::where('role_id',$id)->forceDelete();
        RolePermission::where('role_id',$id)->forceDelete();
        Role::withTrashed()->where('id',$id)->first()->forceDelete();
        Session::flash('message','Role Successfully Deleted.');
        return redirect()->route('role.index');


    }
}
