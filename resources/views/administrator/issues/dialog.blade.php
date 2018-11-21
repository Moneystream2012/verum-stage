@extends('layouts.administrator')

@section('title', 'Техподдержка')

@section('page')
    <div class="container-fluid-md">
        <div class="row">
            <div class="col-md-3 col-lg-2">
                @include('administrator/issues/partials.navigation')
            </div>
            <div class="col-md-9 col-lg-10">

                <div class="panel panel-lg panel-light mail-thread">
                    <div class="panel-body padding-md-vertical mail-subject thin">
                        {{$issue->title}}
                        @if($issue->status == 1 || $issue->status == 0 )
                            <a href="{{route('administrator.issues.closed', ['id' => $issue->id])}}"
                               class="btn btn-success btn-sm pull-right">Закрыть</a>
                        @endif
                    </div>
                    @forelse($issue->dialogs as $item)
                        @if($loop->first && $item->is_support)
                            <div class="panel-body panel-body-default padding-md-vertical">
                                <div class="mail-message">
                                    <a href="{{$url = route('administrator.users.show', $issue->user->id)}}"
                                       class="pull-left">
                                        <img class="img-circle mail-sender-image" src="{{$issue->user->avatar_url }}">
                                    </a>
                                    <div class="mail-meta">
                                        <h4>{{$issue->user->full_name}}</h4>
                                        <small class="text-muted">
                                            <a href="{{$url}}">{{$issue->user->username}}</a></small>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="panel-body padding-md-vertical">
                            <div class="mail-message">
                                @if(!$item->is_support)
                                    <a href="{{$url = route('administrator.users.show', $issue->user->id)}}"
                                       class=" pull-left">
                                        <img class="img-circle mail-sender-image" src="{{$issue->user->avatar_url }}">
                                    </a>
                                @else
                                    <img class="mail-sender-image img-circle pull-left"
                                         src="{{asset('/img/avatars/support.png')}}">
                                @endif
                                <div class="mail-meta">
                                    <span class="mail-date pull-right  text-muted">
                                        <i class="fa fa-clock-o"></i>
                                        {{$item->created_at->format('d/m/Y H:i:s')}}
                                    </span>
                                    <h4 class="">{{ $item->is_support ? 'Technical Support' : $issue->user->full_name}}</h4>
                                    <small class="text-muted">
                                        {{$item->is_support ? 'support@verumtrade.com' : $issue->user->username}}
                                    </small>
                                </div>
                                <div class="mail-body">{!! $item->body !!}</div>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-muted">Empty</p>
                    @endforelse
                    @if($issue->status != 2)
                        <div class="panel-body padding-md-vertical">
                            <div class="mail-message">
                                <img class="mail-sender-image img-circle pull-left hidden-xs"
                                     src="{{asset('/img/avatars/support.png')}}">
                                <form method="post">
                                    {{csrf_field()}}
                                    <div class="mail-body">
                                        <div class="form-group  {{ $errors->has('body') ? ' has-error' : '' }}">
									<textarea class="form-control" rows="5" name="body"
                                              placeholder="Click here to reply..."
                                              style="resize:vertical;"
                                    ></textarea>
                                            @if ($errors->has('body'))
                                                <p class="margin-xs-vertical text-danger">{{ $errors->first('body') }}</p>
                                            @endif
                                        </div>
                                        <button class="btn btn-primary margin-sm-right" type="submit">Отправить</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
