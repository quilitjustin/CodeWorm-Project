@component('mail::message')
Hi Mr/Mrs {{ $l_name }},

We would like to inform you that your account registration has been {{ $status }}, on {{ $date }}. 

Thank you for using our services.

Sincerely,
Codeworm 
@endcomponent
