<?php

namespace App\Services;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushMessage;
use NotificationChannels\WebPush\WebPushChannel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class WebNotifyService extends Notification
{

    use Queueable;


    public function via($notifiable)
    {
        return [WebPushChannel::class];
    }

    public function toWebPush($notifiable, $notification)
    {
        return (new WebPushMessage)
            ->title('訂閱成功')
            // ->icon('/notification-icon.png')
            ->body('您已成功啟用訂閱服務!')
            ->action('開啟首頁', 'openHomepage');
    }
}
