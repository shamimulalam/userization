<?php
/**
 * Created by PhpStorm.
 * User: sha1
 * Date: 5/4/17
 * Time: 2:14 PM
 */

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['namespace'=> 'App\Http\Controllers\Authorization','middleware'=>['web','userization']], function() {

    /**
     *Role CRUDE
     */
//Role CRUD

    Route::get('role', [
        'as' => 'role.index',
        'uses' => 'RoleController@index',
        'title'=>'Roles'

    ]);
//Role create
    Route::get('role/create', [
        'as' => 'role.create',
        'uses' => 'RoleController@create',
        'title'=>'Create Roles'
    ]);
//Role insert
    Route::post('role/store', [
        'as' => 'role.store',
        'uses' => 'RoleController@store',
        'title'=>'Store Roles'
    ]);
//Role edit
    Route::get('role/{id}/edit', [
        'as' => 'role.edit',
        'uses' => 'RoleController@edit',
        'title'=>'Edit Roles'
    ]);
//Role update
    Route::put('role/{id}/edit', [
        'as' => 'role.update',
        'uses' => 'RoleController@update',
        'title'=>'Update Roles'

    ]);
//Role trash
    Route::get('role/{id}/trash', [
        'as' => 'role.trash',
        'uses' => 'RoleController@trash',
        'title'=>'Trash Roles'


    ]);
//Role restore
    Route::get('role/{id}/restore', [
        'as' => 'role.restore',
        'uses' => 'RoleController@restore',
        'title'=>'Restore Roles'

    ]);
//Role Delete
    Route::get('role/{id}/delete', [
        'as' => 'role.delete',
        'uses' => 'RoleController@destroy',
        'title'=>'Delete Roles'

    ]);

    /**
     *Role User CRUDE
     */
//Role User CRUD

    Route::get('role_user/{id}', [
        'as' => 'role_user.index',
        'uses' => 'RoleUserController@index',
        'title'=>'Role User'


    ]);
//Role User create
    Route::get('role_user/{id}/create', [
        'as' => 'role_user.create',
        'uses' => 'RoleUserController@create',
        'title'=>'Create Roles User'

    ]);
//Role User insert
    Route::post('role_user/store', [
        'as' => 'role_user.store',
        'uses' => 'RoleUserController@store',
        'title'=>'Store Roles User'


    ]);

//Role User trash
    Route::get('role_user/{id}/trash', [
        'as' => 'role_user.trash',
        'uses' => 'RoleUserController@trash',
        'title'=>'Trash Roles User'

    ]);
//Role User restore
    Route::get('role_user/{id}/restore', [
        'as' => 'role_user.restore',
        'uses' => 'RoleUserController@restore',
        'title'=>'Restore Roles User'

    ]);
//Role User Delete
    Route::get('role_user/{id}/delete', [
        'as' => 'role_user.delete',
        'uses' => 'RoleUserController@destroy',
        'title'=>'Destroy Roles User'

    ]);

    //Role User edit
    Route::get('role_user/{id}/status', [
        'as' => 'role_user.status',
        'uses' => 'RoleUserController@status',
        'title'=>'Edit Roles User'

    ]);
//Role Permission Crude
    Route::get('role_permission/{id}', [
        'as' => 'role_permission.index',
        'uses' => 'RolePermissionController@index',
        'title'=>'Role Permission'

    ]);
//Role Permission Create

    Route::get('role_permission/{id}/create', [
        'as' => 'role_permission.create',
        'uses' => 'RolePermissionController@create',
        'title'=>'Create Roles Permission'

    ]);
//Role Permission store
    Route::post('role_permission/store', [
        'as' => 'role_permission.store',
        'uses' => 'RolePermissionController@store',
        'title'=>'Store Roles Permission'

    ]);
//Role Permission trash
    Route::get('role_permission/{id}/trash', [
        'as' => 'role_permission.trash',
        'uses' => 'RolePermissionController@trash',
        'title'=>'Trash Roles permission'


    ]);
//Role Permission restore
    Route::get('role_permission/{id}/restore', [
        'as' => 'role_permission.restore',
        'uses' => 'RolePermissionController@restore',
        'title'=>'Restore Role Permission'

    ]);
//Role Permission Delete
    Route::get('role_permission/{id}/delete', [
        'as' => 'role_permission.delete',
        'uses' => 'RolePermissionController@destroy',
        'title'=>'Destroy Roles Permission'

    ]);

    Route::get('permissions', [
        'as' => 'permission.index',
        'uses' => 'PermissionController@index',
        'title' => 'Permission List'
    ]);
    Route::get('permission/create', [
        'as' => 'permission.create',
        'uses' => 'PermissionController@create',
        'title' => 'Create new Permission'
    ]);
    Route::post('permission/create', [
        'as' => 'permission.store',
        'uses' => 'PermissionController@store',
        'title' => 'Store Permissions'
    ]);
    Route::get('permission/trash/{id}', [
        'as' => 'permission.trash',
        'uses' => 'PermissionController@trash',
        'title' => 'Trash Permission'
    ]);
    Route::get('permission/restore/{id}', [
        'as' => 'permission.restore',
        'uses' => 'PermissionController@restore',
        'title' => 'Restore trashed Permission'
    ]);
    Route::get('permission/destroy/{id}', [
        'as' => 'permission.destroy',
        'uses' => 'PermissionController@destroy',
        'title' => 'Destroy Permission'
    ]);
    Route::get('role/{id}/permissions', [
        'as' => 'role.permissions',
        'uses' => 'RolePermissionController@index',
        'title' => 'Role wise permissions'
    ]);

});

