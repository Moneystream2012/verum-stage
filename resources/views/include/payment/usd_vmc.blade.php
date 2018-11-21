@push('page-scripts')

@endpush

<a class="btn btn-flat btn-success dropdown-toggle " data-toggle="dropdown">Payment <span class="caret"></span></a>

<ul class="dropdown-menu">
    <li>
        <a
            href="#"
            class="btn-paymant"
            data-method="balance"
            data-price="{{$product->price ?? 0}}"
            data-plan="{{$product->id ?? 0}}"
            data-service="{{$service ?? ''}}">
            Balance USD
        </a>
    </li>
    <li>
        <a
            href="#"
            class="btn-paymant"
            data-method="mining_balance"
            data-price="{{$product->price ?? 0}}"
            data-plan="{{$product->id ?? 0}}"
            data-service="{{$service ?? ''}}">
            Balance VMC
        </a>
    </li>
</ul>
@foreach(['balance','mining_balance'] as $method)
    <form
        class="payment-{{$method}}-{{$service}}-{{$product->id or 0}}"
        action="{{ route('personal-office.payment') }}"
        method="POST"
        style="display: none;">
        {{ csrf_field() }}
        <input type="hidden" name="currency" value="{{$currency}}">
        <input type="hidden" name="method" value="{{$method}}">
        <input type="hidden" name="service" value="{{$service}}">
        <input type="hidden" name="plan" value="{{$product->id or 0}}">
    </form>
@endforeach
