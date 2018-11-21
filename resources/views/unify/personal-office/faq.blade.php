@extends('unify.layouts.personal-office')
@push('page-styles')
    <style>
        .accordion-toggle {
            display: block;
        }

        .accordion-toggle:after {
            font-family: FontAwesome;
            content: "\f105";
            float: right;
            color: grey;
            transition: all .3s ease 0s;
            transform: rotate(90deg);
        }

        .accordion-toggle.collapsed:after {
            transform: rotate(0deg);
        }
    </style>
@endpush
@section('main-content')
    <div class="row gutters">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div id="accordion" role="tablist">
                        @foreach($v_lang->items as $item)
                            <div class="card mb-0">
                                <div class="card-header" role="tab" id="heading_{{$loop->index}}">
                                    <h5 class="mb-0">
                                        <a data-toggle="collapse" href="#collapse_{{$loop->index}}"
                                           aria-expanded="false"
                                           aria-controls="collapseOne" class="collapsed accordion-toggle">
                                            {{$item['title']}}
                                        </a>
                                    </h5>
                                </div>
                                <div id="collapse_{{$loop->index}}" class="collapse" role="tabpanel"
                                     aria-labelledby="heading_{{$loop->index}}"
                                     data-parent="#accordion">
                                    <div class="card-body">{!! $item['body'] !!}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
