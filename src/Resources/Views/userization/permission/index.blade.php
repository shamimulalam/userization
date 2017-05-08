@extends(config('userization.master_template'))
@section(config('userization.content_area'))
    <div class="breadcrumb">
        <a href="{!! route('role.index') !!}"> Roles </a>
    </div>
    <div class="row">
        <div class="col-md-12">
            <!-- /.panel -->
            <div class="panel panel-info">
                <div class="panel panel-heading">
                    <div class="row">
                        <div class="col-md-3">
                            <h4>Permissions</h4>
                        </div>
                        {!! Form::open(['route'=>'permission.index','method'=>'get']) !!}
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
                            @if(canViewButton('permission/create'))
                                <a href="{!! route('permission.create') !!}" class="btn btn-warning pull-left addNew">
                                    Add New Permissions
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- /.panel-header -->
                <div class="panel-body">
                    <table id="organogramTable" class="table table-responsive table-bordered table-striped">
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
                        @foreach($permissions as $permission)
                            <tr>

                                <td>{!! $serial++ !!}</td>
                                <td>{!! $permission->title !!}</td>
                                <td>{!! $permission->route_name !!}</td>
                                <td>{!! $permission->route_uri !!}</td>
                                <td class="text-center">
                                    @if(\Illuminate\Support\Facades\Input::get('search')=='Trashed')
                                        @if(canViewButton('permission/restore/{id}'))  <a
                                                href="{!! route('permission.restore',$permission->id) !!}"
                                                class="btn btn-primary"
                                                onclick="return confirm('Are you confirm to restore this Permission ?')"
                                                title="Restore"><i class="fa fa-recycle"></i></a>@endif
                                        @if(canViewButton('permission/destroy/{id}'))  <a
                                                href="{!! route('permission.destroy',$permission->id) !!}"
                                                class="btn btn-danger"
                                                onclick="return confirm('Are you confirm to delete this Permission ?')"
                                                title="Delete">Delete</a>@endif
                                    @else
                                        @if(canViewButton('permission/trash/{id}'))
                                            <a href="{!! route('permission.trash',$permission->id) !!}"
                                               class="btn btn-danger"
                                               onclick="return confirm('Are you confirm to make trash this Permission ?')"
                                               title="Trash"><i class="fa fa-trash"></i></a>
                                        @endif
                                    @endif
                                </td>

                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                    {{$permissions->render()}}
                </div>
                <!-- /.panel-body -->
            </div>
        </div>
    </div>
        <!-- /.panel -->

@endsection
