<body onload="document.getElementById('form').submit();">
<p>Loading...</p>
<form method="get" action="http://www.free-kassa.ru/merchant/cash.php" id="form">
	<input type="hidden" name="m" value="{{$merchant_id}}"/>
	<input type="hidden" name="o" value="{{$order_id}}"/>
	<input type="hidden" name="oa" value="{{$amount}}"/>
	<input type="hidden" name="s" value="{{$sign}}"/>
	<!-- Optional Fields -->
	<input type="hidden" name="i" value="{{$currency}}"/>
	<input type="hidden" name="lang" value="en"/><!-- en\ru -->

	<input type="submit" style="display:none;" value="Replenishment"/>
	<noscript><input type="submit" value="Replenishment"></noscript>
</form>
</body>
