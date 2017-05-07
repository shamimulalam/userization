@extends(config('authorization.master_template'))
@section(config('authorization.content_area'))
    <div class="row placeholders">
        <div class="col-xs-12">
            <!-- /.box -->

            <div class="box">
                <div class="box-header">

                    <div class="col-md-9" style="padding-top: 5px;padding-bottom: 5px;">
                        @if(canViewButton('role_user/{id}/create')) <a  href="{!! route('role_user.create',$id) !!}" class="btn btn-warning pull-left addNew">Add New</a>@endif

                    </div>


                    {!! Form::open(['route'=>['roleUser',$id],'method'=>'get']) !!}

                    <div class="col-md-2" style="padding-top: 5px;padding-bottom: 5px;">
                        {!! Form::select('search',['Active'=>'Active','Inactive'=>'Inactive','Trashed'=>'Trashed'],\Illuminate\Support\Facades\Input::get('search'),[ 'class'=>'form-control',
                        'placeholder'=>'Please select','required' ]) !!}
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
                        <td>{!! $role->relRole->title !!}</td>
                        <td>{!! $role->relRole->description !!}</td>
                        <td>{!! $role->status !!}</td>
                        <td class="text-center" >
                            <a href="{!! route('role_user.status',$role->id) !!}" class="btn btn-info" title="Edit">  @if($role->status=='Active') Inactive  @else Active @endif</a>
                            @if(\Illuminate\Support\Facades\Input::get('search')=='Trashed')
                                @if(canViewButton('role_user/{id}/restore'))<a href="{!! route('role_user.restore',$role->id) !!}" class="btn btn-primary" onclick="return confirm('Are you confirm to restore this Role ?')" title="Restore"><i class="fa fa-recycle"></i></a>@endif
                                @if(canViewButton('role_user/{id}/delete'))<a href="{!! route('role_user.delete',$role->id) !!}" class="btn btn-danger" onclick="return confirm('Are you confirm to delete this Role ?')" title="Delete"><i class="fa fa-eraser"></i></a>@endif
                            @else
                                @if(canViewButton('role_user/{id}/trash'))<a href="{!! route('role_user.trash',$role->id) !!}" class="btn btn-danger" onclick="return confirm('Are you confirm to make trash this Role ?')" title="Trash"><i class="fa fa-trash"></i></a>@endif
                            @endif
                        </td>

                    </tr>
                @endforeach

                </tbody>
            </table>


        </div>
        <!-- /.box-body -->

    </div>
    <!-- /.box -->

@endsection
