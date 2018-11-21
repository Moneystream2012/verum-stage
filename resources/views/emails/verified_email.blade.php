@component('mail::message')
# Introduction

Thanks for using {{ config('app.name') }}! Please confirm your email address by clicking on the link below.

@component('mail::button', ['url' => $url])
Click here to verify your email
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
