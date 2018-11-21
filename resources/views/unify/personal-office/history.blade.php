@extends('unify.layouts.personal-office')
@push('page-scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jscroll/2.3.5/jquery.jscroll.min.js"></script>
    <script>
        $(function () {
            $('.infinite-scroll').jscroll({
                autoTrigger: true,
                loadingHtml: '<div class="loading"><span></span><span></span><span></span><span></span><span></span></div>',
                padding: 0,
                nextSelector: '.pagination li.active + li a',
                contentSelector: 'div.infinite-scroll',
                callback: function () {
                    $('ul.pagination').remove();
                }
            });
        });
    </script>
@endpush
@section('main-content')
    <div class="row gutters">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if(count($data) > 0)
                    <div class="infinite-scroll">
                        <!-- Timeline start -->
                        <div class="timeline">
                            @foreach($data as $item)
                                <div class="timeline-row">
                                    <div class="timeline-time">
                                        {{$item->created_at->format('h:i A')}}
                                        <small>{{$item->created_at->formatLocalized('%d %B %Y')}}</small>
                                    </div>
                                    <div class="timeline-content">
                                        <i class="icon-{{$item->icon}}"></i>
                                        <h4>{{$item->title}}</h4>
                                        <p>{!! $item->body !!}</p>
                                        <div>
                                            <span class="badge badge-light">{{$item->category}}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <!-- Timeline end -->
                        <div class="hidden">{{ $data->links() }}</div>
                    </div>
                    @else
                        <div class="text-muted text-center">{{$l_lang->empty}}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
