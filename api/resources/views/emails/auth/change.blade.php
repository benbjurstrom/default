@component('mail::message')
# Hello!

Your password has been updated. If you did not request this change please
contact {{ config('app.name') }} immediately.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
