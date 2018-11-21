@extends('unify.layouts.auth')
@section('page')
    <div class="panel-heading clearfix">
        <div class="pull-left">
            <i class="fa fa-key"></i> Forgot your password?
        </div>
        <div class="pull-right">
            <a href="{{ route('personal-office.login') }}">
                <i class="fa fa-lock"></i> Sign in
            </a>
        </div>
    </div>
    <div class="panel-body">
        @include('flash::message')
        <form novalidate="novalidate" role="form" method="POST" accept-charset="UTF-8"
              action="{{ route('personal-office.password-reset.post') }}">
            {{ csrf_field() }}

            <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email">E-mail <span class="text-danger"> *</span></label>
                <input type="email" autofocus="autofocus" class="form-control" autocomplete="off" name="email"
                       id="email" placeholder="E-mail Address" value="{{ old('email') }}">
                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group" style="margin-top: 25px">
                <button type="submit" class="btn btn-block btn-primary">
                    <i class="fa fa-send"></i> Send Password Reset Link
                </button>
            </div>
        </form>
    </div>
@endsection
