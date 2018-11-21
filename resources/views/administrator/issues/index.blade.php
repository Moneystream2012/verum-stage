@extends('layouts.administrator')
@section('title', 'Техподдержка')

@push('page-styles')
    <style>
        .media-heading {
            margin: 0;
        }
        .line{
            margin-top: 9px;
        }
        blockquote {
            margin: 5px 0 0;
            font-size: 14px;
        }
        .date-time{
            margin-left: 5px;
        }
    </style>
@endpush
@section('page')
    <div class="container-fluid-md">
        <div class="row">
            <div class="col-md-3 col-lg-2">
                @include('administrator/issues/partials.navigation')
            </div>
            <div class="col-md-9 col-lg-10">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong class="panel-title">List</strong>
                    </div>
                    <div class="panel-body">
                        @forelse($issues as $issue)
                            @include('administrator/issues/partials.item_list', ['issue' => $issue['first'], 'lasts' => $issue['lasts']])
                        @empty
                            <p class="text-center text-muted">Empty</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
@endsection
