@extends('layouts.personal-office')
@section('page')
	<div class="container-fluid-md">
		<div class="row">
			<div class="col-md-12">
				<div class="panel">
					<form method="post">
						{{csrf_field()}}
						<div class="panel-body">

							<div class="form-group  {{ $errors->has('title') ? ' has-error' : '' }}">
								<label class="control-label" for="title">Title</label>
								<input class="form-control" id="title" name="title" type="text" placeholder="Title"  autocomplete="off" required>
								@if ($errors->has('title'))
									<span class="help-block">{{ $errors->first('title') }}</span>
								@endif
							</div>

							<div class="form-group  {{ $errors->has('body') ? ' has-error' : '' }}">
								<label class="control-label" for="body">Text</label>
								<textarea class="form-control" rows="4" id="body" name="body" placeholder="Text" required></textarea>
								@if ($errors->has('body'))
									<span class="help-block">{{ $errors->first('body') }}</span>
								@endif
							</div>

						</div>
						<div class="panel-footer">
							<button class="btn btn-primary" type="submit">Submit</button>
							<a href="{{route('personal-office.issues.index')}}" class="btn btn-default">Back</a>
						</div>

					</form>
				</div>
			</div>
		</div>
	</div>
@endsection
