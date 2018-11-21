
<a href="{{route('administrator.issues.new')}}" class="btn btn-block btn-primary">New issue</a>

<div class="mail-navigation panel">
	<ul class="nav nav-pills nav-stacked">
		<li>
			<a href="{{route('administrator.issues.index')}}">

			<i class="fa fa-fw fa-circle text-{{Request::segment(4) == null ? 'primary' : 'muted'}}"></i> Новые</a>
		</li>
		<li>
			<a href="{{route('administrator.issues.index', ['status' => 1])}}">

			<i class="fa fa-fw fa-circle text-{{Request::segment(4) == '1' ? 'primary' : 'muted'}}"></i> Открытые</a>
		</li>
		<li>
			<a href="{{route('administrator.issues.index', ['status' => 2])}}">

			<i class="fa fa-fw fa-circle text-{{Request::segment(4) == '2' ? 'primary' : 'muted'}}"></i> Закрытые</a>
		</li>

	</ul>

</div>
