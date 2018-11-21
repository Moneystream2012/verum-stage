@extends('layouts.administrator')
@section('title', 'Обновления пакетов')

@push('page-styles')
@endpush

@push('page-scripts')
@endpush

@section('page')
    <div class="container-fluid-md">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">Настройки процентных выплат</h4>
            </div>
            <div class="panel-body">
                <div class="panel panel-default ">
                    <form class="form-horizontal form-bordered" role="form"
                          action="{{route('administrator.deposits.update.percent.post')}}"
                          method="post">
                        {{ csrf_field() }}

                        @foreach($products as $product)
                            <div class="form-group">
                                <label for="input_advcash" class="col-sm-4 control-label">Plan {{$product['name']}}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control"
                                           name="plan_{{$product['plan']}}_percent"
                                           value="{{$product['percent']}}"
                                           placeholder="0"
                                           autocomplete="off">
                                </div>
                            </div>
                        @endforeach
                        <div class="col-sm-push-4 col-sm-8">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="{{route('administrator.deposits.index')}}" class="btn btn-default">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

