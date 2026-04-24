<?php
namespace App\Services;

use App\Models\User;
use App\Models\Employee;
use App\Models\AttendanceLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Notifications\LateWarningNotification;
use App\Notifications\AbsentNotification;
use App\Notifications\AbsentSummaryNotification;
use App\Notifications\LateSummaryNotification;

class AttendanceNotificationService
{
    public function notifyLatecomers()
    {
        $hrUsers = User::all(); // adjust if you have roles

        $now = Carbon::now();
        $monthStart = $now->copy()->startOfMonth();

        $lateEmployees = AttendanceLog::whereBetween('punch_in', [$monthStart, $now])
            ->whereTime('punch_in', '>=', '08:11:00')
            ->whereTime('punch_in', '<=', '12:00:00')
            ->select('userid', DB::raw('count(*) as late_count'))
            ->groupBy('userid')
            ->having('late_count', '>=', 3)
            ->get();

        foreach ($lateEmployees as $record) {
            $employee = Employee::where('employee_id', $record->userid)->first();

            if ($employee) {
                foreach ($hrUsers as $user) {
                    $user->notify(new LateWarningNotification($employee, $record->late_count));
                }
            }
        }

        foreach ($hrUsers as $user) {
            $user->notify(new LateSummaryNotification($lateEmployees));
        }
    }

    public function notifyAbsentees()
    {
        $hrUsers = User::all();

        $today = Carbon::today();

        $absentees = Employee::whereDoesntHave('attendanceLogs', function ($q) use ($today) {
            $q->whereDate('log_date', $today);
        })->get();

        foreach ($absentees as $employee) {
            foreach ($hrUsers as $user) {
                $user->notify(new AbsentNotification($employee));
            }
        }

        foreach ($hrUsers as $user) {
            $user->notify(new AbsentSummaryNotification($absentees));
        }
    }
}