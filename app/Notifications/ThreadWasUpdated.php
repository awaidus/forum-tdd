<?php

namespace App\Notifications;


use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ThreadWasUpdated extends Notification
{
    /**
     * The thread that was updated.
     *
     * @var \App\Thread
     */
    protected $thread;

    /**
     * The new reply.
     *
     * @var \App\Reply
     */
    protected $reply;

    /**
     * Create a new notification instance.
     *
     * @param \App\Thread $thread
     * @param \App\Reply $reply
     */
    public function __construct($thread, $reply)
    {
        $this->thread = $thread;
        $this->reply = $reply;
    }

    /**
     * Get the notification's delivery channels.
     * @return array
     * @internal param mixed $notifiable
     */
    public function via()
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     * @return array
     * @internal param mixed $notifiable
     */
    public function toArray()
    {
        return [
            'message' => $this->reply->user->name . ' replied to ' . $this->thread->title,
            'link' => $this->reply->path()
        ];
    }
}
