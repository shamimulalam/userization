<div class="col-md-offset-3 col-md-6">
    <div class="form-group">
        {!! Form::label('Role Name') !!}
        {!! Form::text('title',null,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('Description') !!}
        {!! Form::textarea('description',null,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('Status') !!}
        :
        {!! Form::radio('status','Active',null,['class'=>'minimal','checked']) !!} Active
        {!! Form::radio('status','Inactive',null,['class'=>'minimal']) !!} Inactive
    </div>

</div>
