<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LateWarningNotification extends Notification
{
    use Queueable;

    public $employee;
    public $lateCount;

    /**
     * Create a new notification instance.
     */
    public function __construct($employee, $lateCount)
    {
        $this->employee = $employee;
        $this->lateCount = $lateCount;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'employee_id' => $this->employee->id,
            'employee_name' => $this->employee->first_name,
            'late_count' => $this->lateCount,
            'title' => 'Late',
            'message' => $this->employee->first_name . ' has been late ' . $this->lateCount . ' times this month.'
        ];
    }
}
