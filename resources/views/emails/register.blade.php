<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Активация регистрации нового ползователя</title>
</head>
<body>
<h1>Спасибо за регистрацию!</h1>

<p>Member id: {{$data->id}}</p>
<p>Username: {{$data->username}}</p>
<p>Mobile number: {{$data->mobile_number}}</p>
<p>Password: {{$data->password}}</p>
<p>Transaction password: {{$data->transaction_password}}</p>

<p>
	Перейдите <a href='{{$data->url_verify}}'>по ссылке </a>чтобы завершить регистрацию!
</p>
</body>
</html>
