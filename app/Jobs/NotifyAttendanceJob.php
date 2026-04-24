<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Services\AttendanceNotificationService;
use App\Models\AttendanceUpload;

class NotifyAttendanceJob implements ShouldQueue
{
    use Queueable;

    public $timeout = 300;

    protected $uploadId;

    public function __construct($uploadId)
    {
        $this->uploadId = $uploadId;
    }

    public function handle(AttendanceNotificationService $service)
    {
        $service->notifyLatecomers();
        $service->notifyAbsentees();

    }
}