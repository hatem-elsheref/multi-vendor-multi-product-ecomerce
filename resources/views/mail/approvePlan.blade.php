@component('mail::message')


Congratulation {{ $userName }} You Request Approved Now
<br>
You Now In {{$planName}} Plan With Period {{$period}} Months
<br>
Starting Date : {{$startingDate}}
<br>
Expired Date : {{$expiredDate}}
@component('mail::button', ['url' => $dashboardUrl]) Manage Your Stock Now @endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
