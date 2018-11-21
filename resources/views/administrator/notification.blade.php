@extends('layouts.administrator')
@section('title', 'Notification')
@section('page')
	<div class="container-fluid-md">
		@forelse($notifications as $notification)
			<div class="panel panel-sm margin-sm-bottom">
				<div class="panel-body ">
					<div class="clearfix">
						<div class="pull-left">
							<div class=margin-sm-vertical">
								<i class="fa {{$notification->data['icon']}} fa-2x fa-lg fa-fw text-primary"></i>
							</div>
						</div>
						<div class="pull-left margin-left">
							<strong>{{trans('administrator/notification.'.snake_case(class_basename($notification->type)), $notification->data) }}</strong><br>
							@if($notification->data['link'] ?? false)
								<a class="margin-sm-bottom" href="{{$notification->data['link']}}">просмотреть</a>
							@endif
						</div>
						<div class="pull-right text-right">
							@if($notification->read_at == null)
								<span class="label label-danger ">new</span> <br>
							@endif
							<small class="text-muted">{{$notification->created_at->format('d/m/Y H:i:s')}}</small>
						</div>
					</div>
					@if($notification->data['text'] ?? false)
						<p class="margin-sm-left margin-sm-vertical">{{$notification->data['text']}}</p>
					@endif
				</div>
			</div>
		@empty
			<p class="text-center">Empty notifications</p>
		@endforelse
	</div>
@endsection