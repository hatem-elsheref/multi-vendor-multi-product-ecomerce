@component('mail::message')
    Hi , {{$order->user->name }} You Order From Stock {{$order->seller->stock}} shipped now and will delivered through {{$days}} days
    <br>
    - The total cost is {{$order->total}} $
    <br>
    - The address is {{$order->country}} , {{$order->city}} , {{$order->address}} , post code : {{$order->postcode}}
    <br>
    -Connection details is email: {{$order->email}} and phone: {{$order->phone}}
    <br>
    -------------------------------
    <br>
    You Orders is
    <br>---------------<br>
    @foreach($order->items as $item)
      {{$item->product->name}} x {{$item->quantity}} = {{$item->product->price*$item->quantity}}$
    @endforeach
    <br>---------------<br>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
