<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;
class Role extends Model
{
    use SoftDeletes;
    protected $table='roles';
    protected $fillable=[
        'slug',
        'title',
        'description',
        'status',
    ];
    protected $dates = ['deleted_at'];


    /**
     *  Relation Role user Table
     */
    public function relRoleUser()
    {
        return $this->hasMany('App\RoleUser','role_id','id');
    }


    /**
     *  Relation Role permisison Table
     */
    public function relRolePermission()
    {
        return $this->hasMany('App\RolePermission','role_id','id');
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
