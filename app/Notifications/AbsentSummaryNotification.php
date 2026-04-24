<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class AbsentSummaryNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $employees;

    /**
     * Create a new notification instance.
     */
    public function __construct($employees)
    {
        $this->employees = $employees;
    }

    /**
     * Delivery channels
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Mail (Email Summary)
     */
    public function toMail(object $notifiable): MailMessage
    {
        $mail = (new MailMessage)
            ->subject('Daily Absent Employees Summary')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('Here is the list of employees who are absent today:');

        foreach ($this->employees as $employee) {
            $mail->line('• ' . $employee->first_name . ' (' . $employee->employee_id . ')');
        }

        return $mail
            ->line('Total Absentees: ' . $this->employees->count())
            ->action('View Employees', route('employees.index'))
            ->line('Please take necessary action.');
    }

}