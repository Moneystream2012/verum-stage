@extends('unify.layouts.personal-office')
@push('page-scripts')
    <script>
        $(function() {
            $('.chatScroll').slimScroll({
                height: "300px",
                color: '#e5e8f2',
                alwaysVisible: false,
                size: "7px",
                start: $('.chats li:last'),
                distance: '1px',
                railVisible: false,
                railColor: "#007ae1",
            });
        });
    </script>
@endpush
@section('main-content')
    <div class="row gutters">
        <div class="col-12">
            <div class="card">
                <div class="card-header">{{$issue->title}}</div>
                <div class="card-body chatScroll">
                    <ul class="chats">
                        @foreach($issue->dialogs as $item)
                            <li class="chats-{{$item->is_support ? 'right' : 'left'}}">
                                <div class="chats-avatar">
                                    <img
                                        src="{{$item->is_support ?  asset('/img/avatars/support.png') : $auth->avatar_url }}"
                                        alt="{{$item->full_name}}">
                                    <div class="chats-name">{{ $item->is_support ? 'Support' : 'You'}}</div>
                                </div>
                                <div class="chats-text">{!! $item->body !!}</div>
                                <div class="chats-hour">{{$item->created_at->diffForHumans()}}</div>
                            </li>
                        @endforeach
                    </ul>

                </div>
                <div class="card-footer">
                    <form method="post">
                        {{csrf_field()}}
                        <div class="form-group">
                                <textarea class="form-control {{ $errors->has('body') ? 'is-invalid' : '' }}"
                                          rows="4"
                                          name="body"
                                          placeholder="Click here to reply..."
                                          style="resize:vertical;"
                                    {{ $issue->is_baned_send ? 'disabled' : ''}}
                                ></textarea>
                            @if ($errors->has('body'))
                                <span class="form-text text-danger">{{ $errors->first('body') }}</span>
                            @endif
                        </div>
                        <button class="btn btn-primary"
                                {{ $issue->is_baned_send ? 'disabled' : ''}}
                                type="submit">Submit
                        </button>
                        <a href="{{route('personal-office.issues.index')}}" class="btn btn-outline-light">Back</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
