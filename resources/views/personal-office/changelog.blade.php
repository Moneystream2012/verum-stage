@extends('layouts.personal-office')
@section('page')
    <div class="container-fluid-md">
        @foreach($data as $item)
            @include('include.banner', [ 'item' => $item ])
            <div class="margin-lg-bottom"></div>
        @endforeach
    </div>
@endsection
