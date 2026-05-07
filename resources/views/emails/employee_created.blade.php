@component('mail::message')
# Welcome, {{ $employee->first_name }}!

Your account has been successfully created. You can now access the HRMS portal using the following credentials:

@component('mail::panel')
**Username:** {{ $employee->company_email }}
**Password:** {{ $password }}
@endcomponent

@component('mail::button', ['url' => route('employee.login')])
Login to Portal
@endcomponent

For security reasons, we recommend that you change your password after your first login.

If you have any questions or encounter any issues, please contact the HR department.

Best regards,
{{ config('app.name') }} Team
@endcomponent
