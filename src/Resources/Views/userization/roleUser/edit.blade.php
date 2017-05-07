@extends(config('userization'))
@section(config('authorization.content_area'))

    <!-- SELECT2 EXAMPLE -->
    <div class="box box-default">

        <!-- /.box-header -->

        {!! Form::model($role,['route'=>['roleUser',$role->id],'method'=>'put','files'=> true]) !!}
        <div class="box-body">
            <div class="row">
                @include('userization.role._form')
            </div>
            <div class="row">
                <div class="col-xs-6">
                    {!! Form::submit('Update',['class'=>'btn btn-success pull-right']) !!}

                </div>
                <div class="col-xs-6">
                    <a href="{!! route('role.index') !!}" class="btn btn-danger" onclick="return confirm('Are you confirm to cancel !')">Cancel</a>
                </div>
            </div>
        </div>
        {!! Form::close() !!}

    </div>
    <!-- /.box -->
@endsection