@component('mail::message')

    <p>{{$message}}</p>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
