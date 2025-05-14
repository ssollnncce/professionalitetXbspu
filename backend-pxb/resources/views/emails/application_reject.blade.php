@component('mail::message')
# Здравствуйте, {{ $user->full_name }}

К сожалению ваша заявка на курс "{{ $course->name }}" была отклонена.


@component('mail::button', ['url' => url('/')])
Перейти на сайт
@endcomponent

С уважением,  
Команда {{ config('app.name') }}
@endcomponent