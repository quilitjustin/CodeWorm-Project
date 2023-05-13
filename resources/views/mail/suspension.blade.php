@component('mail::message')
Hi Mr/Mrs {{ $l_name }},

We would like to inform you that your account has been banned on {{ $date }} due to the following Reason.

{{ $reason }}

Thank you for using our services.

Sincerely,
Codeworm 
@endcomponent
