@component('mail::message')
Verify your new email address

Please click the button below to verify your new email address.

@component('mail::button', ['url' => $verification_url])
Verify Email Address
@endcomponent

If you did not make this change, no further action is required on your part.

Thank you for using our services.

Sincerely,
Codeworm
@endcomponent
