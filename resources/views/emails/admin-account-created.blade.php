@component('mail::message')
# Hello {{ $notifiable->name }},

You have been added as an **Admin**.

Your temporary password is:

**{{ $password }}**

@component('mail::button', ['url' => route('login')])
Login Now
@endcomponent

> You are required to change your password on first login.

Thanks,  
{{ config('app.name') }}
@endcomponent
