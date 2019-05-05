<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
class RolePermission extends Model
{
    use SoftDeletes;
    protected $table='role_permission';
    protected $fillable=[
        'role_id',
        'permission_id',
        'status',
    ];
    protected $dates = ['deleted_at'];
    /**
     *  Relation Role Table
     */
    public function relRole()
    {
        return $this->belongsTo('App\Role','role_id','id')->withTrashed();
    }
    /**
     *  Relation Permission Table
     */
    public function relPermission()
    {
        return $this->belongsTo('App\Permission','permission_id','id')->withTrashed();
    }
    /**
     * boot function for created and updated by user
     *
     * */
    public static function boot(){
        parent::boot();
        static::creating(function($query){
            if(Auth::check()){
                $query->created_by = Auth::user()->id;
            }
        });
        static::updating(function($query){
            if(Auth::check()){
                $query->updated_by = Auth::user()->id;
            }
        });
    }
}
