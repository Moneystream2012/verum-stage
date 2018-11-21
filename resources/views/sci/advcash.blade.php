<body onload="document.getElementById('form').submit();">
<p>Loading...</p>
<form method="post" action="https://wallet.advcash.com/sci/" id="form">
	<input type="hidden" name="ac_account_email" value="{{config('advcash.account_email')}}"/>
	<input type="hidden" name="ac_sci_name" value="{{config('advcash.sci_name')}}"/>
	<input type="hidden" name="ac_amount" value="{{$amount}}"/>
	<input type="hidden" name="ac_currency" value="{{$currency}}"/>
	<input type="hidden" name="ac_order_id" value="{{$order_id}}"/>
	<input type="hidden" name="ac_sign" value="{{$sign}}"/>
	<!-- Optional Fields -->
	<input type="hidden" name="ac_success_url" value="{{$success_url}}"/>
	<input type="hidden" name="ac_success_url_method" value="GET"/>
	<input type="hidden" name="ac_fail_url" value="{{$fail_url}}"/>
	<input type="hidden" name="ac_fail_url_method" value="POST"/>
	<input type="hidden" name="ac_status_url" value="{{$status_url}}"/>
	<input type="hidden" name="ac_status_url_method" value="POST"/>
	<input type="hidden" name="ac_comments" value="{{$comments}}"/>
	<input type="submit" style="display:none;" value="Replenishment"/>
	<noscript><input type="submit" value="Replenishment"></noscript>
</form>
</body>
