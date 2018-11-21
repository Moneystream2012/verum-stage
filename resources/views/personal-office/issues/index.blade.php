@extends('layouts.personal-office')

@push('page-styles')
<style>
	.table-mail tr { cursor: pointer !important; }
</style>
@endpush
@section('page')
	<div class="container-fluid-md">
		<div class="row">
			<div class="col-md-12">

				<div class="margin-md-bottom">
					<a href="{{route('personal-office.issues.new')}}" class="btn btn-primary t">New issue</a>
				</div>

				<div class="panel">
					<div class="panel-heading">
						<strong class="panel-title">List</strong>
					</div>
					<div class="table-responsive">
						<table class="table table-hover table-mail">
							<colgroup>
								<col width="80%">
								<col width="20%">
							</colgroup>
							<tbody>
							@forelse($issues as $issue)
								<tr
										onclick="document.location = '{{route('personal-office.issues.show', $issue->id, [], true)}}'">
									<td>
										<span
												class="label margin-right label-{{$issue->status != 2 ? 'success' : 'default' }}  margin-xs-top"
												style="display: inline-block">{{$issue->status_text}}</span>
                                        {!! !$issue->read ? '<i class="fa fa-envelope text-muted"></i>' : '' !!}
                                        {{$issue->title}}

									</td>

									<td class="text-right">
										{{$issue->created_at->format('d/m/Y H:i:s')}}
									</td>
								</tr>
							@empty
								<td>
									<p class="text-center text-muted margin-vertical">Empty issues</p>
								</td>
							@endforelse
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
