@foreach($sponsors as $user)
	<li class="dd-item" data-id="{{$user->id}}">
		<div class="panel panel-sm panel-{{$user->plan > 0 ? 'primary' : 'default'}} panel-referral margin-md-bottom">
			@if($level == 1)
			<div class="panel-heading">
				Side: {{$user->leg ? 'right' : 'left'}}
			</div>
			@endif
			<div class="panel-body clearfix">
				<img class="img-circle pull-left margin-sm-vertical margin-right" width="50" height="50"
				     src="{{$user->avatar_url}}">
				<div class="pull-left">
					<strong>{{$user->full_name}}</strong><br>
					<small class="text-muted">Username: {{$user->username}}</small><br>
					<small class="text-muted">Member id: {{$user->id}}</small><br>
                    <small class="text-muted">Sponsor id: {{$user->sponsor_id}}</small><br>
					<small class="text-muted">Email: {{$user->email}}</small><br>
					<small class="text-muted">Mobile Number: {{$user->mobile_number}}</small>
				</div>

				<div class="pull-right">
					<div class="deposits">
						@foreach($user->deposits as $deposit)
                            <div class="deposit-item">
								<i class="fa fa-briefcase text-muted"></i>
								<strong class="small">
									{{$deposit->product['name']}}
								</strong>
							</div>
						@endforeach
					</div>
				</div>
			</div>
		</div>

		@if ($user->sponsors->count() && $level < 5 )
			<ol class="dd-list" style="display: none;"></ol>
		@endif
	</li>
@endforeach
