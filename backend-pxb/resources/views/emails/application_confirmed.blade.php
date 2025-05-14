@component('mail::message')
# Здравствуйте, {{ $user->full_name }}

Ваша заявка на курс "{{ $course->name }}" была подтверждена.

Спасибо, что выбрали нас!

@component('mail::button', ['url' => url('/')])
Перейти на сайт
@endcomponent

С уважением,  
Команда {{ config('app.name') }}
@endcomponent