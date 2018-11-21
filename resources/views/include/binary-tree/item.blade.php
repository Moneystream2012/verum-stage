<div class="tree-node">
	<div class="tree-node-sponsor">
		<div class="sponsor {{isset($user['user_id']) ? '' : 'empty' }}">
			<h5>{{$user['user_id'] or 'Member'}}<span>{{$user['username'] or ''}}</span></h5>

			<img class="img-circle" width="50" height="50"
			     src="{{ isset($user['user_id']) ? $avatars[$user['user_id']] : asset('img/avatars/member.png') }}"
			     data-toggle="tooltip" data-placement="bottom"
			     data-original-title="{{ isset($user['user_id']) ? $user['point_left_week'] .' | '. $user['point_right_week'] : '' }}">

			@if (isset($user['user_id']) && empty($user['is_root']))
				<div class="link-up">
					<a href="{{route('personal-office.sponsored.binary', ['user_id' => $user['user_id']])}}">
						<i class="fa fa-sitemap"></i>
					</a>
				</div>
			@endif

		</div>
	</div>

	@if (isset($user) && count($user['children']) == 2)
		<div class="tree-node-children">
			<span class="tree-node-conector"></span>
			<div class="tree-node-left">
				@if(isset($user['user_id']) && $user['user_id'] == $auth->id && !$auth->leg)
					<span class="sponsor_leg left">sponsor branch</span>
				@endif
				@include('include.binary-tree.item', ['user' => $user['children'][0]])
			</div>
			<div class="tree-node-right">
				@if(isset($user['user_id']) && $user['user_id'] == $auth->id && $auth->leg)
					<span class="sponsor_leg right">sponsor branch</span>
				@endif
				@include('include.binary-tree.item', ['user' => $user['children'][1]])
			</div>
		</div>
	@endif
</div>
