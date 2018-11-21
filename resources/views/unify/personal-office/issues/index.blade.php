@extends('unify.layouts.personal-office')
@section('main-content')
    <div class="row gutters">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{route('personal-office.issues.new')}}" class="btn btn-primary">Create</a>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        @forelse($issues as $issue)
                            <a href="{{route('personal-office.issues.show', $issue->id)}}"
                               class="d-flex justify-content-between align-items-center list-group-item list-group-item-action
                               {{ !$issue->read ? 'list-group-item-dark' : '' }}">
                                {{$issue->title}}
                                <span
                                    class="badge badge-{{$issue->status != 2 ? 'secondary' : 'light' }} badge-pill">{{$issue->status_text}}</span>
                            </a>
                        @empty
                            <p class="text-center text-muted mb-0">{{$l_lang->empty}}</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

