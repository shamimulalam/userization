<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Permission extends Model
{
    use SoftDeletes;
    protected $table='permissions';
    protected $fillable=[
        'route_uri',
        'route_name',
        'title',
    ];
    protected $dates = ['deleted_at'];

    /**
     * boot function for created and updated by user
     *
     * */
    /**
     *  Relation Permission user Table
     */
    public function relRolePermission()
    {
        return $this->hasMany('App\RolePermission','permission_id','id');
    }

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
