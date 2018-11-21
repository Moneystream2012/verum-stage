@extends('unify.layouts.personal-office')
@section('main-content')
    <div class="row gutters">
        <div class="col">
            <div class="card">
                <div class="card-body text-center">
                    <i class="icon-assignment_ind text-danger mb-2" style="font-size: 8em"></i>
                    <h4>{{$v_lang->h4}}</h4>
                    <p class="text-muted">{{$v_lang->p}}</p>
                    <a href="{{route('personal-office.issues.index')}}" class="btn btn-primary">{{trans('personal-office/issues/index.title')}}</a>
                </div>
            </div>
        </div>
    </div>
@endsection
