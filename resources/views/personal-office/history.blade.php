@extends('layouts.personal-office')
@push('page-scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jscroll/2.3.5/jquery.jscroll.min.js"></script>
<script>
	$ ( 'ul.pagination' ).hide ();
	$ ( function () {

		$ ( '.infinite-scroll' ).jscroll ( {
			autoTrigger:     true,
			loadingHtml:     '<p class="text-center"><i class="fa fa-spinner fa-spin fa-2x fa-fw text-muted"></i></p>', // MAKE SURE THAT YOU PUT THE CORRECT IMG PATH
			padding:         0,
			nextSelector:    '.pagination li.active + li a',
			contentSelector: 'div.infinite-scroll',
			callback:        function () {
				$ ( 'ul.pagination' ).remove ();
			}
		} );
	} );
</script>
@endpush
@section('page')
	<div class="container-fluid-md">
		<div class="panel">
			<div class="panel-body">
				<div class="row hidden">
					<div class="col-md-12">
						<div class="btn-group btn-group-sm pull-left">
							<p class="small text-muted margin-xs-vertical">Date filter</p>
							<a href="{{route('personal-office.history', [
									'category' => $category
							])}}" class="btn btn-default btn">All</a>

							<a href="{{route('personal-office.history', [
									'category' => $category,
									'date' => 'yesterday'
							])}}" class="btn btn-default @if($date == 'yesterday') active @endif">Yesterday</a>

							<a href="{{route('personal-office.history', [
									'category' => $category,
									'date' => 'today'
							])}}" class="btn btn-default @if($date == 'today') active @endif">Today</a>

							<a href="{{route('personal-office.history', [
									'category' => $category,
									'date' => 'week'
							])}}" class="btn btn-default @if($date == 'week') active @endif">This week</a>

							<a href="{{route('personal-office.history', [
									'category' => $category,
									'date' => 'month'
							])}}" class="btn btn-default @if($date == 'month') active @endif">This month</a>
						</div>

						<div class="btn-group btn-group-sm pull-right">
							<p class="small text-muted margin-xs-vertical">Type filter</p>
							<a href="{{route('personal-office.history', [
									'category' => 0,
									'date'     => $date,
							])}}" class="btn btn-default">All</a>

							<a href="{{route('personal-office.history', [
									'category' => 1,
									'date'     => $date,
							])}}" class="btn btn-default @if($category == 1) active @endif">Payments</a>

							<a href="{{route('personal-office.history', [
									'category' => 2,
									'date'     => $date,
							])}}" class="btn btn-default @if($category == 2) active @endif">Transfers</a>

							<a href="{{route('personal-office.history', [
									'category' => 3,
									'date'     => $date,
							])}}" class="btn btn-default @if($category == 3) active @endif">Profits</a>

							<a href="{{route('personal-office.history', [
									'category' => 4,
									'date'     => $date,
							])}}" class="btn btn-default @if($category == 4) active @endif">Requests</a>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						@if (count($data) > 0)
							<ul class="timeline">
								<div class="infinite-scroll">
									@foreach($data as $item)
										<li>
											<div class="timeline-badge primary">
												<i class="fa {{$item->icon}}"></i>
											</div>
											<div class="timeline-panel">
												<div class="timeline-heading">
													<strong class="timeline-title">{{$item->title}}</strong>
													<p>
														<small class="text-muted"><i class="fa fa-clock-o"></i>
															{{$item->created_at->format('d/m/Y H:i:s')}}
														</small>
													</p>
												</div>
												<div class="timeline-body">
													<p>{!! $item->body !!}</p>
												</div>
											</div>
										</li>

									@endforeach
									<div class="hidden">{{ $data->links() }}</div>

								</div>
							</ul>
						@else
							<p class="text-muted margin-vertical text-center">Empty</p>
						@endif

					</div>
				</div>
			</div>
		</div>

	</div>
@endsection
