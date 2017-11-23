@component('mail::message')
Beste {{ $user->name}},

Bijgevoegd aan deze mail vind u uw factuur: <i>{{ $invoice->name }}</i>.

Met vriendelijke groet,

{{ config('app.name') }}
@endcomponent
