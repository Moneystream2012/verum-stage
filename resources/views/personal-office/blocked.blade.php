@extends('layouts.personal-office')
@section('page')
	<div class="container-fluid-md">
		<div class="panel">
			<div class="panel-body text-center">
				<i class="fa fa-warning fa-5x text-muted"></i>
				<h3 class="thin margin-sm-bottom">Your account on the website is blocked: Administration</h3>
				<p class="margin-lg-bottom">Please contact the support.</p>
				<a href="{{route('personal-office.issues.index')}}" class="btn btn-success">Support</a>
			</div>
		</div>
	</div>
@endsection
