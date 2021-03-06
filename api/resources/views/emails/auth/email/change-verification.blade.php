@component('mail::message')
# Hello!

Please click the button below to complete your email address change.

@component('mail::button', ['url' => $url])
    Verify Email Address
@endcomponent

If you did not request an email address change, no further action is required.

Thanks,<br>
{{ config('app.name') }}

@component('mail::subcopy')
    @lang(
        'If you’re having trouble clicking the Verify Email Address button, copy and paste the URL below\n' .
        'into your web browser: [:url](:url)',
        [
            'url' => $url,
        ]
    )
@endcomponent

@endcomponent
