@foreach($sponsors as $user)
    <li class="in dd-item" data-id="{{$user->id}}">
        <img class="avatar" alt="{{$user->full_name}}" src="{{$user->avatar_url}}">
        <div class="message">
            <span class="name">{{$user->full_name}}</span>
            <div class="body">
                <small class="text-muted">Level: <strong>{{$level}}</strong> |</small>
                <small class="text-muted">Invest Token: <strong>@format_usd($user->deposits->sum('invest'))</strong> |</small>
                <small class="text-muted">Invest Global: <strong>@format_usd($user->tradings->sum('invest'))</strong> |</small>
                <small class="text-muted">Username: {{$user->username}} |</small>
                <small class="text-muted">Member id: {{$user->id}} |</small>
                <small class="text-muted">Sponsor id: {{$user->sponsor_id}} |</small>
                <small class="text-muted">Email: {{$user->email}} |</small>
                <small class="text-muted">Mobile Number: {{$user->mobile_number}}</small>
            </div>
        </div>
        @if ($user->sponsors->count() && $level < 8 )
            <ol class="dd-list mt-4" style="display: none;"></ol>
        @endif
    </li>
@endforeach
