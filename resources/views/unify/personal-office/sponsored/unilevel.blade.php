@extends('unify.layouts.personal-office')
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
@push('page-styles')
    <style>
        #unilevel {
            overflow-y: scroll;
        }
        #unilevel ul li {
            list-style: none;
            margin-left: 40px;
            position: relative;
            min-width: 380px;
            padding-right: 10px;
        }
        #unilevel .dd-item > button {
            background-color: #f5f6fa;
            border: 1px solid #e4e7f2;
            margin-top: 0;
            position: absolute;
            left: -40px;
            top: 20px;
            display: inline-block;
            font: normal normal normal 14px/1 FontAwesome;
            font-size: 12px;
            color: #4d4c4c;
            text-rendering: auto;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            transform: translate(0, 0);
            overflow: hidden;
            width: 25px;
            height: 25px;
            border-radius: 50%;
            padding: 0;
            cursor: pointer;
        }
        #unilevel .dd-item > button:hover {
            color: #4265b2;
        }
        #unilevel .dd-item > button[data-action=expand]:before {
            content: "";
            display: block;
            z-index: 1;
            padding: 6px 0 4px;
        }
        #unilevel .dd-item > button[data-action=collapse]:before {
            content: "";
            display: block;
            z-index: 1;
            padding: 6px 0 4px;
        }
        #unilevel .dd-handle {
            margin: 5px 0;
        }
    </style>
    @endpush
@section('main-content')
    <div class="row gutters">
        <div class="col-12">
            <div class="card">
                <div class="card-body dd" id="unilevel">
                @if(isset($search))
                    <h4><a href="{{route('personal-office.sponsored.unilevel')}}"
                           class="btn btn-primary btn-xs margin-right"><i class="fa fa-reply"></i></a>Search
                    </h4>
                    <hr class="margin-sm-top">
                @endif
                    <ul class="message-wrapper dd-list">
                        @if(count($sponsors) > 0)
                            @include('unify.personal-office.partials.unilevel.items')
                        @else
                            <p class="text-center text-muted m-auto">You don't have any
                                sponsors</p>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
