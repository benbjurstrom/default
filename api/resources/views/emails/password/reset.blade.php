@component('mail::message')
# Hello!

You are receiving this email because we received a password reset request for
your account.

@component('mail::button', ['url' => $url])
Reset Password
@endcomponent

Thanks,<br>
{{ config('app.name') }}

@component('mail::subcopy')
    @lang(
        "If you’re having trouble clicking the Reset Password button, copy and paste the URL below\n".
        'into your web browser: [:url](:url)',
        [
            'url' => $url,
        ]
    )
@endcomponent
@endcomponent
