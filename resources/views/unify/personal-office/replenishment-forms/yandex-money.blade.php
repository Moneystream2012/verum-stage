@extends('unify.personal-office.replenishment-forms.form', $data)
@section('form')
    @foreach($data['fields'] as $key => $val)
        <input type='hidden' name="{{$key}}" value="{{$val}}"/>
    @endforeach
@endsection
