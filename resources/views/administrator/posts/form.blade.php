{{ csrf_field() }}
<div class="form-group">
    {!! Form::label('title', 'Title', ['class' => 'control-label col-sm-2']) !!}
    <div class="col-sm-10">
    {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Title', 'required', 'autocomplete' => 'off']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('body', 'Content EN', ['class' => 'control-label col-sm-2']) !!}
    <div class="col-sm-10">
        {!! Form::textarea('body', null, ['class' => 'form-control summernote', 'placeholder' => 'Content EN', 'required', 'autocomplete' => 'off', 'rows' => '10']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('body_ru', 'Content RU', ['class' => 'control-label col-sm-2']) !!}
    <div class="col-sm-10">
        {!! Form::textarea('body_ru', null, ['class' => 'form-control summernote', 'placeholder' => 'Content RU', 'required', 'autocomplete' => 'off', 'rows' => '10']) !!}
    </div>
</div>
<div class="form-group no-margin-bottom">
    <div class="col-sm-push-2 col-sm-10">
        <a href="{{route('administrator.posts.index')}}" class="btn btn-default">Back</a>
        <span class="text-muted">|</span>
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>
