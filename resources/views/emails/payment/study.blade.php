@component('mail::message')
    #PAYMENT STUDY
    @component('mail::panel')
        **First Name:** {{$data->first_name}} <br/>
        **Order ID id:** {{$data->order_id}} <br/>
        **Status:**  {{$data->status or 'not'}}
    @endcomponent

Thanks,<br>
    Study VerumTrade
@endcomponent
