@extends(config('authorization.master_template'))
@section(config('authorization.content_area'))

    <div class="row placeholders">
        <div class="col-xs-12">
            <!-- /.box -->

            <div class="box">
                <div class="box-header">
                    <div class="col-md-2" style="padding-top: 5px;padding-bottom: 5px;">
                        @if(canViewButton('role_permission/{id}/create'))<a  href="{!! route('role_permission.create',$role_id) !!}" class="btn btn-warning pull-left addNew">Add New Role Permission</a>@endif
                    </div>
                    <div class="col-md-1" style="padding-top: 5px;padding-bottom: 5px;">
                        @if(canViewButton('permission/create'))<a  href="{!! route('permission.create') !!}" class="btn btn-warning pull-left addNew">Permission</a>@endif
                    </div>
                    <div class="col-md-1" style="padding-top: 5px;padding-bottom: 5px; margin-left:5px;">
                        @if(canViewButton('role'))<a  href="{!! route('role.index') !!}" class="btn btn-warning pull-left addNew">Role</a>@endif
                    </div>
                    {!! Form::open(['route'=>['role_permission.index',$role_id],'method'=>'get']) !!}
                    <div class="col-md-2" style="padding-top: 5px;padding-bottom: 5px;">
                        {!! Form::text('key',\Illuminate\Support\Facades\Input::get('key'),[ 'class'=>'form-control',
                        'placeholder'=>' Enter A Keyword' ]) !!}
                    </div>
                    <div class="col-md-2" style="padding-top: 5px;padding-bottom: 5px;">
                        {!! Form::select('fields',['title'=>'Title','route_name'=>'Name','route_uri'=>'URI'],\Illuminate\Support\Facades\Input::get('info'),[ 'class'=>'form-control',
                        'placeholder'=>'Please select' ]) !!}
                    </div>
                    <div class="col-md-2" style="padding-top: 5px;padding-bottom: 5px;">
                        {!! Form::select('search',['Active'=>'Active','Trashed'=>'Trashed'],\Illuminate\Support\Facades\Input::get('search'),[ 'class'=>'form-control',
                        'placeholder'=>'Please select']) !!}
                    </div>
                    <div class="col-md-1" style="padding-top: 5px;padding-bottom: 5px;">
                        {!! Form::submit('Search',['class'=>'btn btn-primary']) !!}
                    </div>
                    {!! Form::close() !!}
                </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive">
            <table id="organogramTable" class="table table-bordered table-striped">
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
        <!-- /.box-body -->
    </div>
    </div>

    <!-- /.box -->

@endsection
