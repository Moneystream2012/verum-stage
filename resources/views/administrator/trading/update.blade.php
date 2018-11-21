@extends('layouts.administrator')
@section('title', 'Дневной процент')
@section('page')
    <div class="container-fluid-md">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="panel panel-default">
                    <form class="form-horizontal form-bordered" role="form"
                          action="{{route('administrator.trading.update.percent.post')}}"
                          method="post">
                        {{ csrf_field() }}

                            <div class="form-group">
                                <label for="input" class="col-sm-4 control-label">Дневной процент</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control"
                                           name="percent"
                                           value="{{$percent}}"
                                           placeholder="0"
                                           autocomplete="off">
                                </div>
                            </div>
                        <div class="col-sm-push-4 col-sm-8">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="{{route('administrator.trading.index')}}" class="btn btn-default">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

