<div class="media">
    <div class="pull-left text-center">
        <a href="{{$url = route('administrator.issues.dialog', $issue->id)}}" class="media-object">
            <img class=" img-circle"
                 src="{{$issue->user->avatar_url}}"
                 style="width: 54px; height: 54px;">
        </a>
        @if($lasts)
            <a data-toggle="collapse" data-parent="#collapse"
               href="#collapse_{{$issue->id}}" aria-expanded="false" aria-controls="collapse_{{$issue->id}}">
                <i class="fa fa-arrow-down"></i>
            </a>
        @endif
    </div>
    <div class="media-body">
        <a href="{{$url}}"><h4 class="media-heading">{{$issue->title}}</h4></a>
        <small>
            <a class="text-muted"
               href="{{route('administrator.users.show', $issue->user->id)}}">
                {{$issue->user->full_name}}</a>
        </small>
        <blockquote>
            {!! $issue->dialogs->first()->body !!}
        </blockquote>
        <p class="text-muted pull-right date-time">
            @format_date($issue->created_at)
        </p>
        <hr class="line">
        <div id="collapse_{{$issue->id}}" class="collapse">
            @foreach($lasts as $item)
                @include('administrator/issues/partials.item_list', ['issue' => $item, 'lasts' => []])
            @endforeach
        </div>
    </div>
</div>
