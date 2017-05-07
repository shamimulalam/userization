<div class="col-md-offset-3 col-md-6">
    <div class="form-group">
        {!! Form::label('Select Role') !!}
        {{ Form::select('role_id',$roles, null, ['class'=>'form-control','placeholder'=>'--Select Role--','required']) }}

        {!! Form::hidden('id',$id,['class'=>'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('Status') !!}
        :
        {!! Form::radio('status','Active',null,['class'=>'minimal','checked']) !!} Active
        {!! Form::radio('status','Inactive',null,['class'=>'minimal']) !!} Inactive
    </div>

</div>
