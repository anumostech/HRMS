<?php

namespace App\Mail;

use App\Models\Employee;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmployeeCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $employee;
    public $password;

    /**
     * Create a new message instance.
     */
    public function __construct(Employee $employee, $password)
    {
        $this->employee = $employee;
        $this->password = $password;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Welcome to the Team - Your Account Details')
                    ->markdown('emails.employee_created');
    }
}
