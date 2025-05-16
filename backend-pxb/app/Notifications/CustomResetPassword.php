<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CustomResetPassword extends Notification
{
    use Queueable;

    public $token;
    public $email;

    /**
     * Create a new notification instance.
     */
    public function __construct($token, $email)
    {
        $this->token = $token;
        $this->email = $email;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $url = url('/password-reset/'.$this->token.'?email='.$this->email);

        return (new MailMessage)
            ->subject('Восстановление пароля на портале Профессионалитет X БГПУ')
            ->greeting('Здравствуйте!')
            ->line('Вы получили это письмо, потому что был отправлен запрос на сброс пароля для вашей учетной записи.')
            ->action('Сбросить пароль', $url)
            ->line('Срок действия ссылки для сброса пароля истекает через 60 минут.')
            ->line('Если вы не запрашивали сброс пароля, никаких дальнейших действий не требуется.')
            ->salutation('С уважением, команда Профессионалитет X БГПУ');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
