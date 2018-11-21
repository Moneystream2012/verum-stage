<a class="dropdown-toggle" href="#" role="button"
   id="dropdownMenuBuy{{$product->plan or 0}}"
   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    {{$l_lang->payment}}
</a>
<div class="dropdown-menu" aria-labelledby="dropdownMenuBuy{{$product->plan or 0}}">
    <a href="#"
       class="dropdown-item btn-paymant"
       data-method="balance"
       data-price="{{$product->price or 0}}"
       data-plan="{{$product->plan or 0}}"
       data-currency="{{$currency}}"
       data-service="{{$service or ''}}">{{$l_lang->balance}} USD</a>
    <a href="#"
       class="dropdown-item btn-paymant"
       data-method="mining_balance"
       data-price="{{$product->price or 0}}"
       data-plan="{{$product->plan or 0}}"
       data-currency="{{$currency}}"
       data-service="{{$service or ''}}">{{$l_lang->balance}} VMC</a>
</div>

@foreach(['balance','mining_balance'] as $method)
    <form
        class="payment-{{$method}}-{{$service}}-{{$product->plan or 0}}"
        action="{{ route('personal-office.products.deposits.payment') }}"
        method="POST"
        style="display: none;">
        {{ csrf_field() }}
        <input type="hidden" name="currency" value="{{$currency}}">
        <input type="hidden" name="method" value="{{$method}}">
        <input type="hidden" name="service" value="{{$service}}">
        <input type="hidden" name="plan" value="{{$product->plan or 0}}">
    </form>
@endforeach
