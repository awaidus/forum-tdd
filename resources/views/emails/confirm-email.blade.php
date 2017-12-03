@component('mail::message')
    # One Last Step

    We just need you to confirm your email address to prove that you're a human. You get it, right?

    @component('mail::button', ['url' => url('/register/confirm?token=' . $user->confirmation_token)])
        Confirm Your Email
    @endcomponent

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent