@extends('layouts.app')

@section('title', 'Task Reports')

@section('content')
    <div class="row w-100">
        <div class="col-lg-12 mx-auto">
            <div class="page-header mt-4 mb-4" style="display:inline">
                <h1 class="page-title mb-2">Task Reports</h1>
                <div>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Task Reports</li>
                    </ol>
                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 datatable-basic">
                            <thead class="bg-light">
                                <tr>
                                    <th>Date</th>
                                    <th>Employee</th>
                                    <!-- <th>Employee ID</th> -->
                                    <th>Tasks Completed</th>
                                    <th>Plan for Tomorrow</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reports as $report)
                                    <tr>
                                        <td class="whitespace-nowrap">
                                            {{ \Carbon\Carbon::parse($report->date)->format('d-m-Y') }}</td>
                                        <td>
                                            <div>{{ $report->employee?->first_name }}
                                                {{ $report->employee?->last_name }}</div>
                                        </td>
                                        <!-- <td>
                                            <div class="small text-muted">{{ $report->employee?->employee_id }}</div>
                                        </td> -->
                                        <td>{{ $report->tasks_completed }}</td>
                                        <td>{{ $report->plan_tomorrow }}</td>
                                        <td>{{ $report->remarks ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection