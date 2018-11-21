@extends('layouts.administrator')
@section('title', 'Edit News')
@push('page-styles')
    <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.10/summernote.css" rel="stylesheet">
@endpush
@push('page-scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.10/summernote.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.summernote').summernote({
                height: 250,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                ]
            });
        });
    </script>
@endpush
@section('page')
    <div class="container-fluid-md">
        <div class="panel panel-default">
            <div class="panel-heading">
                <p class="panel-title">News</p>
            </div>
            <div class="panel-body">
                <div class="panel-body">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif
                    {!! Form::model($post, ['method' => 'PATCH', 'action' => ['Administrator\PostsController@update', $post->id], 'class' => 'form-horizontal form-bordered']) !!}
                        @include('administrator.posts.form')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
