<div class="card-changelog card">
    <div class="card-{{$item->status}}">
        <div class="card-header">
            <div class="row justify-content-between align-items-center">
                <div class="col-6 col-sm-4 col-md-3">
                    <img src="{{asset_theme('img/logo.svg')}}" class="img img-fluid" alt="{{config('app.name')}}">
                </div>
                <div class="col-6 col-sm-4 text-right">
                    @format_date($item->created_at)
                    <button type="button" class="close ml-4" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <i class="icon-"></i>
            @foreach($item->main_text as $i => $text)
                <p>{!! $text !!}</p>
            @endforeach
            @if($item->footer_text)
                <strong>{!! $item->footer_text !!}</strong>
            @endif
        </div>
    </div>
</div>
