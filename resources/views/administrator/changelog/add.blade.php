@extends('layouts.administrator')
@section('title', 'Add Changelog')
@section('page')
    <div class="container-fluid-md">
        <a href="{{route('administrator.changelog.index')}}" class="btn btn-default margin-bottom">Back</a>

        <div class="panel panel-default">
            <div class="panel-heading">
                <p class="panel-title">Changelog</p>
            </div>
            <div class="panel-body">
                <div class="panel-body">
                    <form class="form-horizontal form-bordered" role="form"
                          action="{{route('administrator.changelog.add.post')}}" method="post">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="status" class="control-label col-sm-2">Status</label>
                            <div class="col-sm-10">
                                <select name="status" id="status" class="form-control">
                                    <option value="success">Success</option>
                                    <option value="warning">Warning</option>
                                    <option value="danger">Danger</option>
                                </select>
                            </div>
                        </div>
                        @foreach([1,2,3,4,5] as $item)
                        <div class="form-group">
                            <label for="text_{{$item}}" class="control-label col-sm-2">Text #{{$item}}</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" name="text[]" id="text_{{$item}}" placeholder="Text #{{$item}}"
                                          autocomplete="off" rows="1"></textarea>
                            </div>
                        </div>
                        @endforeach
                        <div class="form-group">
                            <label for="footer_text" class="control-label col-sm-2">Footer Text</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="footer_text" id="footer_text" placeholder="Footer Text"
                                       autocomplete="off">
                            </div>
                        </div>

                        <div class="form-group no-margin-bottom">
                            <div class="col-sm-push-2 col-sm-10">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection
