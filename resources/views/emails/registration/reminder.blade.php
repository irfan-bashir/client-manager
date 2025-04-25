@component('mail::message')
    # Reminder: Registration Due

    Dear {{ $registration->user_name }},

    This is a reminder for the task scheduled on **{{ $registration->date }}**.

    @component('mail::button', ['url' => url('/')])
        View Dashboard
    @endcomponent

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
