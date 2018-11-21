@extends('layouts.personal-office')
@section('page')
    <div class="container-fluid-md">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="binary-responsive">
                            <div class="binary-wrapper">
                                @if(isset($users['parent']))
                                    <div>
                                        <a href="{{route('personal-office.sponsored.binary')}}" class="link-down">
                                            <i class="fa fa-chevron-circle-up"></i> My Network
                                        </a>
                                    </div>
                                    <div>
                                        <a href="{{route('personal-office.sponsored.binary', ['user_id' => $users['parent']['user_id'] ])}}"
                                           class="link-down">
                                            <i class="fa  fa-chevron-circle-up"></i> {{$users['parent']['user_id']}}
                                            <small>{{$users['parent']['username']}}</small>
                                        </a>
                                    </div>
                                @endif
                                @include('include.binary-tree.item', ['user' => $users])
                            </div>
                        </div>
                    </div>
                    <div class="hidden col-sm-4 col-md-3 col-md-pull-9 col-sm-pull-8">
                        {{--@include('include.inbox-left-nav', ['products' => $products])--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
