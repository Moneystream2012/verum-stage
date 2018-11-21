@extends('layouts.administrator')
@section('title', 'Техподдержка')

@push('page-scripts')
<script src="{{asset('veneto/assets/plugins/jquery-select2/select2.min.js')}}"></script>
<script>
	jQuery ( function ( $ ) {
		'use strict';
		// Select2
		$ ( 'select.form-select2' ).select2 ();
	} );
</script>
@endpush
@push('page-styles')
<link rel="stylesheet" href="{{asset('veneto/css/plugins/jquery-select2.min.css')}}">
@endpush
@section('page')
	<div class="container-fluid-md">
		<div class="row">

			<div class="col-md-3 col-lg-2">
				@include('administrator/issues/partials.navigation')
			</div>
			<div class="col-md-9 col-lg-10">
				<div class="panel">
					<form method="post">
						{{csrf_field()}}
						<div class="panel-body">

							<div class="form-group  {{ $errors->has('user_id') ? ' has-error' : '' }}">
								<label class="control-label" for="title">Кому</label>
								<select class="form-control form-chosen form-select2" data-placeholder="Список пользователей..."
								        name="user_id">
									@foreach ($users as $key => $val)
										<option value="{{ $key }}">{{$val}} [{{$key}}] </option>
									@endforeach
								</select>
								@if ($errors->has('user_id'))
									<span class="help-block">{{ $errors->first('user_id') }}</span>
								@endif
							</div>

							<div class="form-group  {{ $errors->has('title') ? ' has-error' : '' }}">
								<label class="control-label" for="title">Title</label>
								<input class="form-control" id="title" name="title" type="text" value="{{old('title')}}" placeholder="Title" required>
								@if ($errors->has('title'))
									<span class="help-block">{{ $errors->first('title') }}</span>
								@endif
							</div>

							<div class="form-group  {{ $errors->has('body') ? ' has-error' : '' }}">
								<label class="control-label" for="body">Text</label>
								<textarea class="form-control" rows="4" id="body" name="body" placeholder="Text" required>{{old('body')}}</textarea>
								@if ($errors->has('body'))
									<span class="help-block">{{ $errors->first('body') }}</span>
								@endif
							</div>

						</div>
						<div class="panel-footer">
							<button class="btn btn-primary" type="submit">Отправить</button>
						</div>

					</form>
				</div>
			</div>
		</div>
	</div>
@endsection
