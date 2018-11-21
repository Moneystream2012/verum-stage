@extends('layouts.personal-office')
@section('page')
    <div class="container-fluid-md">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Replenishment: Balance VMC</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-4">
                        <img src="{{$qr_code}}" alt="VMC Address" class="img-responsive">
                    </div>
                    <div class="col-sm-offset-1 col-sm-7">
                        <p class="h4 padding-md-top">Total: @format_vmc($amount_vmc)</p>
                        <p class="">Please send <strong>exactly @format_vmc($amount_vmc) to</strong></p>
                        <div class="input-group">
                            <input type="text" id="address" value="{{$address}}" class="form-control" readonly="">
                            <span class="input-group-btn">
                                <button data-clipboard-target="#address" class="btn btn-white" type="button"><i class="fa fa-clipboard"></i></button>
                            </span>
                        </div>
                        <p class="alert alert-info">After sending coins you can close this window. Payment will be processed automatically after 3 confirmation in crypto network.</p>

                        <a href="{{route('personal-office.replenishment.index')}}" class="btn btn-default">Back</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection


