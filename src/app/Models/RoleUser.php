<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;
class RoleUser extends Model
{
    use SoftDeletes;
    protected $table='role_user';
    protected $fillable=[
        'role_id',
        'user_id',
        'status',
    ];
    protected $dates = ['deleted_at'];
    /**
     *  Relation User Table
     */
    public function relUser()
    {
        return $this->belongsTo('App\User','user_id','id');
    }
    /**
     *  Relation Role Table
     */
    public function relRole()
    {
        return $this->belongsTo('App\Role','role_id','id');
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
