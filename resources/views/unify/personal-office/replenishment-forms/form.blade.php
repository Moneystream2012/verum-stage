<body onload="document.getElementById('form').submit();">
<p>Loading...</p>
<form action="{{$action}}" id="form" method="POST">
    @yield('form')
    <input type="submit" name="PAYMENT_METHOD" style="display:none;" value="Replenishment"/>
    <noscript><input type="submit" name="PAYMENT_METHOD" value="Replenishment"></noscript>
</form>
