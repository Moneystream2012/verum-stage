@extends('layouts.personal-office')
@section('page')
	<div class="container-fluid-md">
		<div class="row">
			<div class="col-md-12">

				<div class="panel panel-lg panel-light mail-thread">
					<div class="panel-body padding-md-vertical mail-subject thin">
						{{$issue->title}}
					</div>
					@forelse($issue->dialogs as $item)
						<div class="panel-body padding-md-vertical">
							<div class="mail-message">
								<img class="mail-sender-image img-circle pull-left"
								     src="{{$item->is_support ?  asset('/img/avatars/support.png') : $auth->avatar_url }}">
								<div class="mail-meta">
                  <span class="mail-date pull-right text-muted">
	                   <i class="fa fa-clock-o"></i>
	                  {{$item->created_at->diffForHumans()}}
                  </span>
									<h4 class="">{{ $item->is_support ? 'Technical Support' : $auth->full_name}}</h4>
									<small class="text-muted">{{$item->is_support ? 'support@verumtrade.com' : $auth->email}}</small>
								</div>
								<div class="mail-body">{!! $item->body !!}</div>
							</div>
						</div>
					@empty
						<p class="text-center text-muted">Empty</p>
					@endforelse

					<div class="panel-body padding-md-vertical">
						<div class="mail-message">
							<img class="mail-sender-image img-circle pull-left hidden-xs" src="{{$auth->avatar_url}}">
							<form method="post">
								{{csrf_field()}}
								<div class="mail-body">
									<div class="form-group  {{ $errors->has('body') ? ' has-error' : '' }}">
									<textarea class="form-control" rows="5" name="body" placeholder="Click here to reply..."
									          style="resize:vertical;"
											{{ $issue->is_baned_send ? 'disabled' : ''}}
									></textarea>
										@if ($errors->has('body'))
											<p class="margin-xs-vertical text-danger">{{ $errors->first('body') }}</p>
										@endif
									</div>
									<button class="btn btn-primary margin-sm-right"
									        {{ $issue->is_baned_send ? 'disabled' : ''}} type="submit">Submit
									</button>
									<a href="{{route('personal-office.issues.index')}}" class="btn btn-default">Back</a>
								</div>
							</form>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
@endsection
