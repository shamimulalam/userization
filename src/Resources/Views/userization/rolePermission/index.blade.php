@extends(config('userization.master_template'))
@section(config('userization.content_area'))
    <div class="breadcrumb">
        <a href="{!! route('role.index') !!}"> Roles </a>
        ||
        <a href="{!! route('permission.index') !!}"> Permissions </a>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <!-- /.panel -->
            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-3" >
                            <h4>Permissions of <b>{!! ucfirst($role->title) !!}</b> Role</h4>
                        </div>
                        {!! Form::open(['route'=>['role_permission.index',$role_id],'method'=>'get']) !!}
                        <div class="col-md-2" style="padding-top: 5px;padding-bottom: 5px;">
                            {!! Form::text('key',\Illuminate\Support\Facades\Input::get('key'),[ 'class'=>'form-control',
                            'placeholder'=>' Enter a keyword' ]) !!}
                        </div>
                        <div class="col-md-2" style="padding-top: 5px;padding-bottom: 5px;">
                            {!! Form::select('fields',['title'=>'Title','route_name'=>'Name','route_uri'=>'URI'],\Illuminate\Support\Facades\Input::get('info'),[ 'class'=>'form-control',
                            'placeholder'=>'Select search column' ]) !!}
                        </div>
                        <div class="col-md-2" style="padding-top: 5px;padding-bottom: 5px;">
                            {!! Form::select('search',['Active'=>'Active','Trashed'=>'Trashed'],\Illuminate\Support\Facades\Input::get('search'),[ 'class'=>'form-control',
                            'placeholder'=>'Select status']) !!}
                        </div>
                        <div class="col-md-1" style="padding-top: 5px;padding-bottom: 5px;">
                            {!! Form::submit('Search',['class'=>'btn btn-primary']) !!}
                        </div>
                        {!! Form::close() !!}
                        <div class="col-md-2" style="padding-top: 5px;padding-bottom: 5px;">
                            @if(canViewButton('role_permission/{id}/create'))<a  href="{!! route('role_permission.create',$role_id) !!}" class="btn btn-warning pull-left addNew">Add New Role Permission</a>@endif
                        </div>
                    </div>
                </div>
        <!-- /.panel-header -->
                <div class="panel-body">
                    <table id="organogramTable" class="table table-bordered table-striped table-responsive">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Title</th>
                            <th>Name</th>
                            <th>URI</th>
                            <th class="text-center" style="width: 25%;">Actions</th>
                        </tr>

                        </thead>
                        <tbody>

                              @foreach($roles as $role)
                            <tr>

                                <td>{!! $serial++ !!}</td>
                                <td>{!! $role->relPermission->title !!}</td>
                                <td>{!! $role->relPermission->route_name !!}</td>
                                <td>{!! $role->relPermission->route_uri !!}</td>
                                <td class="text-center" >
                                    @if(\Illuminate\Support\Facades\Input::get('search')=='Trashed')
                                        @if(canViewButton('role_permission/{id}/restore'))   <a href="{!! route('role_permission.restore',$role->id) !!}" class="btn btn-primary" onclick="return confirm('Are you confirm to restore this Role Permission ?')" title="Restore"><i class="fa fa-recycle"></i></a>@endif
                                            @if(canViewButton('role_permission/{id}/delete'))    <a href="{!! route('role_permission.delete',$role->id) !!}" class="btn btn-danger" onclick="return confirm('Are you confirm to delete this Role Permission ?')" title="Delete"><i class="fa fa-eraser"></i></a>@endif
                                    @else
                                        @if(canViewButton('role_permission/{id}/trash')) <a href="{!! route('role_permission.trash',$role->id) !!}" class="btn btn-danger" onclick="return confirm('Are you confirm to make trash this Role Permission ?')" title="Trash"><i class="fa fa-trash"></i></a>@endif
                                    @endif
                                </td>

                            </tr>
                              @endforeach

                        </tbody>
                    </table>
                    {{$roles->render()}}
                </div>
                <!-- /.panel-body -->
            </div>
        </div>
    </div>

    <!-- /.panel -->

@endsection
