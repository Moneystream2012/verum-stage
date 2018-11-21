@extends('layouts.personal-office')
@section('page')
    <div class="container-fluid-md">
        @foreach($data as $item)
            <div class="panel panel-lg panel-info">
                <div class="panel-heading">
                    <h4 class="panel-title">{{$item->title}}</h4>
                </div>
                <div class="panel-body">
                    <ul class="nav nav-pills navbar-right">
                        <li class="active"><a data-toggle="tab" href="#tab-en-{{$item->id}}">English</a></li>
                        <li><a data-toggle="tab" href="#tab-ru-{{$item->id}}">Russian</a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="tab-en-{{$item->id}}" class="tab-pane active">
                            {!! $item->body !!}
                        </div>
                        <div id="tab-ru-{{$item->id}}" class="tab-pane">
                            {!! $item->body_ru !!}
                        </div>
                    </div>
                    <p class="text-right no-margin-bottom">
                        <i class="fa fa-clock-o text-muted"></i>
                        @format_date($item->updated_at)
                    </p>
                </div>
            </div>
        @endforeach
    </div>
@endsection
