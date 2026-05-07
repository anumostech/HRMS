<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class LateSummaryNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $lateEmployees;

    /**
     * $lateEmployees should contain:
     * [ employee, late_count ]
     */
    public function __construct($lateEmployees)
    {
        $this->lateEmployees = $lateEmployees;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $mail = (new MailMessage)
            ->subject('Late Comers Summary')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('The following employees have been late multiple times this month:');

        foreach ($this->lateEmployees as $item) {
            $employee = $item['employee'];
            $count = $item['late_count'];

            $mail->line('• ' . $employee->first_name . ' (' . $employee->employee_id . ') - ' . $count . ' times');
        }

        return $mail
            ->line('Total Late Employees: ' . count($this->lateEmployees))
            ->action('View Employees', route('employees.index'))
            ->line('Please review and take action.');
    }

}