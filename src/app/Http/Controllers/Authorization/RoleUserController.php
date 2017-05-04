<?php
namespace App\Http\Controllers\Authorization;
use App\User;
use App\Role;
use App\RoleUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use Auth;
class RoleUserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,$id )
    {

        $role=New RoleUser();
        $data['title']='Manage Role User';
        if($request->search=='Trashed'){
            $role=$role->onlyTrashed();
        }elseif($request->search == 'Inactive')
        {
            $role=$role->where('status','Inactive');
        }else{
            $role=$role->where('status','Active');
        }

        $role=$role->where('user_id',$id)->orderBy('id','DESC')->get();
        $data['roles']=$role;
        $serial=1;
        $data['serial']=$serial;
        $data['id']=$id;
        return view('admin.user.role_user.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {

        $data['title']='Add Role User';
        $data['roles']=Role::where('status','Active')->pluck('title','id');
        $data['id']=$id;
        return view('admin.user.role_user.create',$data);

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
            'id' => 'required',
            'role_id' =>'required|unique:role_user|max:255',
            'status' => 'required',
        ]);
        $user=New RoleUser();
        $user->role_id=$request->role_id;
        $user->user_id=$request->id;
        $user->status=$request->status;
        $user->save();
        Session::flash('message','Role User  Successfully Add');
        return redirect()->route('role_user.index',$request->id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function trash($id)
    {
        RoleUser::findorfail($id)->delete();
        Session::flash('message','Role User Successfully Trashed.');
        return redirect()->back();
    }
    public function restore($id){
        $roleuser=RoleUser::withTrashed()->where('id',$id)->first();
        $userid=$roleuser->user_id;
        $roleuser->restore();
        Session::flash('message','Role User Successfully Restored.');
        return redirect()->route('role_user.index',$userid);
    }
    public function destroy($id){
        $roleuser=RoleUser::withTrashed()->where('id',$id)->first();
        $userid=$roleuser->user_id;
        $roleuser->forceDelete();
        Session::flash('message','Role User Successfully Deleted.');
        return redirect()->route('role_user.index',$userid);
    }

    /**
     * active inactive
     */
    public function status($id)
    {
        $roleuser=RoleUser::withTrashed()->where('id',$id)->first();

        if($roleuser->status=='Active') {
            $roleuser->status = 'Inactive';
        }
        else {
            $roleuser->status = 'Active';
            }
        $roleuser->save();
        Session::flash('message','Role User Successfully '.$roleuser->status);
        return redirect()->route('role_user.index',$roleuser->user_id);
    }

}
