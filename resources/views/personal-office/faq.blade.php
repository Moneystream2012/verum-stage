@extends('layouts.personal-office')
@push('page-styles')
<style>
	.panel-heading .accordion-toggle:after {
		font-family: FontAwesome;
		content:     "\f105";
		float:       right;
		color:       grey;
		transition:  all .3s ease 0s;
		transform:   rotate(90deg);
		}

	.panel-heading .accordion-toggle.collapsed:after { transform: rotate(0deg); }
</style>
@endpush
@section('page')
	<div class="container-fluid-md">

		<div class="panel-group" id="accordion" role="tablist">

			@foreach($v_lang->items as $item)
				<div class="panel panel-default">
					<div class="panel-heading" role="tab" id="heading_{{$loop->index}}">
						<h4 class="panel-title">
							<a class="collapsed accordion-toggle" role="button" data-toggle="collapse" data-parent="#accordion"
							   href="#collapse_{{$loop->index}}" aria-expanded="false" aria-controls="collapse_{{$loop->index}}">
								{{$item['title']}}
							</a>
						</h4>
					</div>
					<div id="collapse_{{$loop->index}}" class="panel-collapse collapse" role="tabpanel"
					     aria-labelledby="heading_{{$loop->index}}">
						<div class="panel-body">
							{!! $item['body'] !!}
						</div>
					</div>
				</div>
			@endforeach
		</div>

	</div>
@endsection
