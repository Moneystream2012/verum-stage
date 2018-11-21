@extends('unify.layouts.personal-office')
@section('main-content')
    <div class="row gutters">
        <div class="col-12">
            @foreach($data as $item)
                <div class="card">
                    <div class="card-header">{{$item->title}}</div>
                    <div class="card-body">
                        <ul class="nav nav-tabs justify-content-end" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#tab-en-{{$item->id}}" role="tab" aria-controls="tab-en-{{$item->id}}" aria-selected="true" aria-expanded="true">English</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tab-ru-{{$item->id}}" role="tab" aria-controls="tab-ru-{{$item->id}}" aria-selected="false" aria-expanded="false">Russian</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab-en-{{$item->id}}" role="tabpanel" aria-labelledby="#tab-en-{{$item->id}}" aria-expanded="true">{!! $item->body !!}</div>
                            <div class="tab-pane" id="tab-ru-{{$item->id}}" role="tabpanel" aria-labelledby="tab-ru-{{$item->id}}" aria-expanded="true">{!! $item->body_ru !!}</div>
                        </div>
                        <p class="text-right mt-2 mb-0">
                            @format_date($item->updated_at)
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
