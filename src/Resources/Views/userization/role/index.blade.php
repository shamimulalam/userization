@extends(config('userization'))
@section(config('authorization.content_area'))

    <div class="row placeholders">
        <div class="col-xs-12">
            <!-- /.panel -->
            <div class="panel panel-info">
                <div class="panel-header">

                    <div class="col-md-9" style="padding-top: 5px;padding-bottom: 5px;">
                        @if(canViewButton('role/create'))  <a  href="{!! route('role.create') !!}" class="btn btn-warning pull-left addNew">Add New</a>@endif

                    </div>

                    {!! Form::open(['route'=>'role.index','method'=>'get']) !!}

                    <div class="col-md-2" style="padding-top: 5px;padding-bottom: 5px;">
                        {!! Form::select('search',['Active'=>'Active','Inactive'=>'Inactive','Trashed'=>'Trashed'],\Illuminate\Support\Facades\Input::get('search'),[ 'class'=>'form-control',
                        'placeholder'=>'Please select','required' ]) !!}
                    </div>
                    <div class="col-md-1" style="padding-top: 5px;padding-bottom: 5px;">
                        {!! Form::submit('Search',['class'=>'btn btn-primary']) !!}
                    </div>
                    {!! Form::close() !!}



                </div>

                <!-- /.panel-header -->
                <div class="panel-body table-responsive">
                    <table id="organogramTable" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Role</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th class="text-center" style="width: 25%;">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($roles as $role)
                            <tr>

                                <td>{!! $serial++ !!}</td>
                                <td>{!! $role->title !!}</td>
                                <td>{!! $role->description !!}</td>
                                <td>{!! $role->status !!}</td>
                                <td class="text-center" >
                                    @if(canViewButton('role_permission/{id}'))     <a href="{!! route('role_permission.index',$role->id) !!}" class="btn btn-info" title="Permission"> Permission </a>@endif

                                    @if(canViewButton('role/{id}/edit'))  <a href="{!! route('role.edit',$role->id) !!}" class="btn btn-info" title="Edit"><i class="fa fa-edit" title="Edit"></i></a>@endif

                                    @if(\Illuminate\Support\Facades\Input::get('search')=='Trashed')
                                        @if(canViewButton('role/{id}/restore'))   <a href="{!! route('role.restore',$role->id) !!}" class="btn btn-primary" onclick="return confirm('Are you confirm to restore this Role ?')" title="Restore"><i class="fa fa-recycle"></i></a>@endif
                                        @if(canViewButton('role/{id}/delete'))   <a href="{!! route('role.delete',$role->id) !!}" class="btn btn-danger" onclick="return confirm('Are you confirm to delete this Role ?')" title="Delete">Delete</a>@endif
                                    @else
                                        @if(canViewButton('role/{id}/trash'))<a href="{!! route('role.trash',$role->id) !!}" class="btn btn-danger" onclick="return confirm('Are you confirm to make trash this Role ?')" title="Trash"><i class="fa fa-trash"></i></a>@endif
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
            <!-- /.panel -->
        </div>
    </div>
@endsection
