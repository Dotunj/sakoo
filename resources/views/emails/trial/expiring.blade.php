@component('mail::message')
Hello {{$user->name}},

Your Sakoo Trial is About To Expire. You can visit the link below to upgrade your plan

@component('mail::button', ['url' => ''])
Subscribe
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
