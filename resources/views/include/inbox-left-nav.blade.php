<p class="text-muted small">Users status</p>
<ul class="list-group">

	<li class="list-group-item">
		<span class="badge">{{$count['plan'][12] or 0}}</span>
		@lang('plan.12')
	</li>
	<li class="list-group-item">
		<span class="badge">{{$count['plan'][11] or 0}}</span>
		@lang('plan.11')
	</li>
	<li class="list-group-item">
		<span class="badge">{{$count['plan'][10] or 0}}</span>
		@lang('plan.10')
	</li>
	<li class="list-group-item">
		<span class="badge">{{$count['plan'][9] or 0}}</span>
		@lang('plan.9')
	</li>
	<li class="list-group-item">
		<span class="badge">{{$count['plan'][8] or 0}}</span>
		@lang('plan.8')
	</li>
	<li class="list-group-item">
		<span class="badge">{{$count['plan'][7] or 0}}</span>
		@lang('plan.7')
	</li>
	<li class="list-group-item">
		<span class="badge">{{$count['plan'][6] or 0}}</span>
		@lang('plan.6')
	</li>
	<li class="list-group-item">
		<span class="badge">{{$count['plan'][5] or 0}}</span>
		@lang('plan.5')
	</li>
	<li class="list-group-item">
		<span class="badge">{{$count['plan'][4] or 0}}</span>
		@lang('plan.4')
	</li>
	<li class="list-group-item">
		<span class="badge">{{$count['plan'][3] or 0}}</span>
		@lang('plan.3')
	</li>
	<li class="list-group-item">
		<span class="badge">{{$count['plan'][2] or 0}}</span>
		@lang('plan.2')
	</li>
	<li class="list-group-item">
		<span class="badge">{{$count['plan'][1] or 0}}</span>
		@lang('plan.1')
	</li>
	<li class="list-group-item">
		<span class="badge">{{$count['plan'][0] or 0}}</span>
		@lang('plan.0')
	</li>
</ul>

<p class="text-muted small">Products</p>
<ul class="list-group">
	@foreach(array_reverse($products, 1) as $key=>$item)
		<li class="list-group-item">
			<span class="badge">{{$count['products'][$key-1] or 0}}</span>
			{{$item['name']}}
		</li>
	@endforeach
</ul>
