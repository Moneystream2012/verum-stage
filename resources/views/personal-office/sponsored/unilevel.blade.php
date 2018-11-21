@extends('layouts.personal-office')
@push('page-scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Nestable/2012-10-15/jquery.nestable.min.js"></script>
<script>
    $('#unilevel.dd').nestable();
    $('#unilevel.dd').nestable('collapseAll');

    $(document).on('click', '.dd-item button[data-action=expand]', function (event) {
        event.preventDefault();

        var elm = $(event.target),
            parent = elm.closest('.dd-item'),
            url = '/personal-office/sponsored/unilevel/'+parent.attr('data-id')+'/ajax';

        if (parent.hasClass('loaded')) {
            return false;
        }
        parent.addClass('loaded');

        $.get(url, function (data) {
            parent.children('.dd-list').html(data);
            parent.children('.dd-list').nestable();
            parent.children('.dd-list').nestable('collapseAll');
        });

    });
</script>
@endpush
@section('page')
    <div class="container-fluid-md">
        <div class="panel panel-default">

            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-10 col-sm-push-1">
                        <div class="dd" id="unilevel">
                            @if(isset($search))
                                <h4><a href="{{route('personal-office.sponsored.unilevel')}}"
                                       class="btn btn-primary btn-xs margin-right"><i class="fa fa-reply"></i></a>Search
                                </h4>
                                <hr class="margin-sm-top">
                            @endif
                            <ol class="dd-list">
                                @if(count($users) > 0)
                                    @include('include.unilevel.items')
                                @else
                                    <p class="text-center text-muted margin-lg-vertical">You don't have any
                                        referrals</p>
                                @endif
                            </ol>
                        </div>
                    </div>
                    {{--<div class="hidden col-sm-4 col-sm-pull-8">

                        <ul class="list-group">
                            <li class="list-group-item clearfix text-center">
                                <span class="pull-left text-muted small">Left</span>
                                <span class="text-muted small rank-text-center">Users plan</span>
                                <span class="pull-right text-muted small">Right</span>
                            </li>
                            @foreach(array_reverse(trans('plan'), true) as $id=>$plan_text )
                                <li class="list-group-item clearfix text-center">
                                    <span class="badge pull-left">{{$counts[0][$id]}}</span>
                                    <span class=" rank-text-center">{{$plan_text}}</span>
                                    <span class="badge pull-right">{{$counts[1][$id]}}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>--}}
                </div>
            </div>
        </div>
    </div>
@endsection
