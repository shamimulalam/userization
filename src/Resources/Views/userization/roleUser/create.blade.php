@extends(config('userization.master_template'))
@section(config('userization.content_area'))

    <!-- SELECT2 EXAMPLE -->
    <div class="panel panel-info">
        <div class="panel-heading">
            <h4>Add new role for user</h4>
        </div>
        <!-- /.panel-header -->
        {!! Form::open(['route'=>'role_user.store','method'=>'post','files'=> true]) !!}
        <div class="panel-body">
            <div class="row">
                @include('userization.roleUser._form')
            </div>
            <div class="row">
                <div class="col-xs-6">
                    {!! Form::submit('Save',['class'=>'btn btn-success pull-right']) !!}

                </div>
                <div class="col-xs-6">
                    <a href="{!! route('role_user.index',$id) !!}" class="btn btn-danger" onclick="return confirm('Are you confirm to cancel !')">Cancel</a>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
        <!-- /.panel-body -->
    </div>
    <!-- /.panel -->
@endsection