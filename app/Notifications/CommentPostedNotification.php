<?php

namespace App\Notifications;

use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class CommentPostedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected  $comment;

    public function __construct( $comment)
    {
        $this->comment = $comment;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
        
            ->subject('New Comment on Your Post')
            // ->greeting('Hello ' . $notifiable->name . ',')
            ->line('A new comment was added to your post: "' . $this->comment->post->title . '".')
            ->line('Comment: "' . $this->comment->body . '"')
            ->line('Thank you for using our blog!');
        // Log::info($post->user_id);

    }
}
