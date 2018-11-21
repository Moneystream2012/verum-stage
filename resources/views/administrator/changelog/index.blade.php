@extends('layouts.administrator')
@section('title', 'Changelog')
@section('page')
    <div class="container-fluid-md">
        <a href="{{route('administrator.changelog.add')}}" class="btn btn-primary">Add Changelog</a>
        <hr class="margin-bottom">
        @foreach($data as $item)
            <div class="btn-group margin-sm-bottom">
                <a href="{{route('administrator.changelog.active', ['id' => $item->id])}}" class="btn btn-success">Active @if($item->active)
                        | <i class="fa fa-check"></i> @endif</a>
                <a href="{{route('administrator.changelog.remove', ['id' => $item->id])}}"
                   class="btn btn-danger">Delete</a>
            </div>
            <br>
            <div class="changelog-panel margin-lg-bottom">
                <div class="panel panel-{{$item->status}} clearfix">
                    <div class="panel-header clearfix">
                        <img src="{{asset('img/logo-white.png')}}" class="pull-left" alt="{{config('app.name')}}"
                             width="200">
                        <div class="time pull-right">{{$item->created_at}}</div>
                    </div>
                    <br>
                    <div class="panel-body">
                        <i class="fa"></i>
                        @foreach($item->main_text as $i => $text)
                            <p>{!! $text !!}</p>
                        @endforeach
                        @if($item->footer_text)
                            <strong>{!! $item->footer_text !!}</strong>
                        @endif
                    </div>

                </div>
            </div>
        @endforeach
    </div>
@endsection
