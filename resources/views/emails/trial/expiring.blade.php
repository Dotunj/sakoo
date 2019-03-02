@component('mail::message')
Hello {{$user->name}},

Your Sakoo trial is about To expire. You can visit the link below to upgrade your plan

@component('mail::button', ['url' => ''])
Subscribe
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
