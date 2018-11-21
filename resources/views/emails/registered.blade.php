@component('mail::message')
# Registered

@component('mail::panel')
**Member id:** {{$data->id}} <br/>
**Username:** {{$data->username}} <br/>
**Mobile number:** {{$data->mobile_number}} <br/>
**Password:** {{$data->password}} <br/>
**Transaction password:** {{$data->transaction_password}}<br/>
@endcomponent

@component('mail::button', ['url' => $data->url_verify])
Click here to verify your account
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
