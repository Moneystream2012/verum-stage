@extends('unify.layouts.personal-office')
@section('main-content')
    <div class="row gutters">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <img src="{{$qr_code}}" alt="VMC Address" class="img-fluid">
                        </div>
                        <div class="col-md-offset-1 col-md-7">
                            <p class="h4 mt-4">{{$l_lang->total}}: @format_vmc($amount_vmc)</p>
                            <p class="mb-2">@lang('unify/personal-office/ecommerces/verumcoin.send', ['amount' => formatVMC($amount_vmc)])</p>
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <button data-clipboard-target="#address" data-toggle="tooltip"
                                            data-placement="bottom" data-original-title="{{$l_lang->copy_link}}"
                                            class="btn btn-primary" type="button">
                                        <i class="icon-clipboard2"></i>
                                    </button>
                                </span>
                                <input type="text" id="address" value="{{$address}}" class="form-control" readonly>
                            </div>
                            <p class="alert mt-3 alert-info">{{$v_lang->msg_info}}</p>
                            <a href="{{route('personal-office.replenishment.index')}}"
                               class="btn btn-light">{{$l_lang->back}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


