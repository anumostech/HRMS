<?php
namespace App\Services;

use App\Models\User;
use App\Models\Employee;
use App\Models\AttendanceLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Notifications\LateWarningNotification;
use App\Notifications\AbsentNotification;

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
            $employee = Employee::find($record->userid);

            if ($employee) {
                foreach ($hrUsers as $user) {
                    $user->notify(new LateWarningNotification($employee, $record->late_count));
                }
            }
        }
    }

    public function notifyAbsentees()
    {
        $hrUsers = User::all();

        $today = Carbon::today();

        $absentees = Employee::whereDoesntHave('attendanceLogs', function ($q) use ($today) {
            $q->whereDate('punch_in', $today);
        })->get();

        foreach ($absentees as $employee) {
            foreach ($hrUsers as $user) {
                $user->notify(new AbsentNotification($employee));
            }
        }
    }
}