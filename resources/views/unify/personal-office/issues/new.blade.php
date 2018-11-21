@extends('unify.layouts.personal-office')
@section('main-content')
    <div class="row gutters">
        <div class="col-12">
            <div class="card">
                <form method="post">
                    {{csrf_field()}}
                    <div class="card-body">
                        <div class="form-group">
                            <label for="inputTitle" class="control-label">Title</label>
                            <input type="text" name="title"
                                   class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}"
                                   id="inputTitle"
                                   placeholder="Title"
                                   autocomplete="off">
                            @if ($errors->has('title'))
                                <span class="form-text text-danger">{{ $errors->first('title') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="inputBody" class="control-label">Text</label>
                            <textarea name="body"
                                      class="form-control {{ $errors->has('body') ? 'is-invalid' : '' }}"
                                      id="inputBody"
                                      placeholder="Text"
                                      rows="4"
                                      autocomplete="off"></textarea>
                            @if ($errors->has('body'))
                                <span class="form-text text-danger">{{ $errors->first('body') }}</span>
                            @endif
                        </div>
                        <button class="btn btn-primary" type="submit">Submit</button>
                        <a href="{{route('personal-office.issues.index')}}" class="btn btn-outline-light">Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
