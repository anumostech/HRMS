@extends('layouts.app')

@section('title', 'Reports')

@section('content')
    <div class="row w-100">
        <div class="col-lg-12 mx-auto">
            <div class="page-header mt-4 mb-5">
                <div>
                    <h1 class="page-title"><i class="fe fe-trending-up"></i> Reports</h1>
                    <p class="text-muted mb-0 mt-1">Access all your HR and organizational reports in one place.</p>
                </div>
            </div>

            <div class="row g-4">
                {{-- 1. Employee Details --}}
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <a href="{{ route('reports.employee_details') }}" class="report-card h-100 border-primary-soft">
                        <div class="report-icon bg-soft-primary">
                            <i class="fe fe-users"></i>
                        </div>
                        <div class="report-info">
                            <h5>Employee Details</h5>
                            <p>Full employee data view</p>
                        </div>
                        <div class="report-arrow">
                            <i class="fe fe-chevron-right"></i>
                        </div>
                    </a>
                </div>

                {{-- 6. Attendance Report --}}
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <a href="{{ route('reports.attendance') }}" class="report-card h-100 border-info-soft">
                        <div class="report-icon bg-soft-info">
                            <i class="fe fe-calendar"></i>
                        </div>
                        <div class="report-info">
                            <h5>Attendance Report</h5>
                            <p>Detailed punch logs</p>
                        </div>
                        <div class="report-arrow">
                            <i class="fe fe-chevron-right"></i>
                        </div>
                    </a>
                </div>

                {{-- 7. Leave Requests --}}
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <a href="{{ route('reports.leave_requests') }}" class="report-card h-100 border-success-soft">
                        <div class="report-icon bg-soft-success">
                            <i class="fe fe-file-text"></i>
                        </div>
                        <div class="report-info">
                            <h5>Leave Requests</h5>
                            <p>History of leave requests</p>
                        </div>
                        <div class="report-arrow">
                            <i class="fe fe-chevron-right"></i>
                        </div>
                    </a>
                </div>

                {{-- 8. Pending Leaves --}}
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <a href="{{ route('reports.pending_leaves') }}" class="report-card h-100 border-warning-soft">
                        <div class="report-icon bg-soft-warning border-warning">
                            <i class="fe fe-user-check"></i>
                        </div>
                        <div class="report-info">
                            <h5>Pending Leaves</h5>
                            <p>Awaiting approval</p>
                        </div>
                        <div class="report-arrow">
                            <i class="fe fe-chevron-right"></i>
                        </div>
                    </a>
                </div>

                {{-- 2. Employee Nearest Expiry --}}
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <a href="{{ route('reports.employee_nearest_expiry') }}" class="report-card h-100 border-danger-soft">
                        <div class="report-icon bg-soft-danger">
                            <i class="fe fe-alert-circle"></i>
                        </div>
                        <div class="report-info">
                            <h5>Emp. Nearest Expiry</h5>
                            <p>Critical expiry alerts</p>
                        </div>
                        <div class="report-arrow">
                            <i class="fe fe-chevron-right"></i>
                        </div>
                    </a>
                </div>

                {{-- 3. Employee Upcoming Renewals --}}
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <a href="{{ route('reports.employee_upcoming_renewals') }}" class="report-card h-100 border-indigo-soft">
                        <div class="report-icon bg-soft-indigo">
                            <i class="fe fe-refresh-cw"></i>
                        </div>
                        <div class="report-info">
                            <h5>Emp. Upcoming Renewals</h5>
                            <p>Renewal pipeline</p>
                        </div>
                        <div class="report-arrow">
                            <i class="fe fe-chevron-right"></i>
                        </div>
                    </a>
                </div>

                {{-- 4. Company Nearest Expiry --}}
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <a href="{{ route('reports.company_nearest_expiry') }}" class="report-card h-100 border-danger-soft">
                        <div class="report-icon bg-soft-danger">
                            <i class="fe fe-briefcase"></i>
                        </div>
                        <div class="report-info">
                            <h5>Org. Nearest Expiry</h5>
                            <p>Company document alerts</p>
                        </div>
                        <div class="report-arrow">
                            <i class="fe fe-chevron-right"></i>
                        </div>
                    </a>
                </div>

                {{-- 5. Company Upcoming Renewals --}}
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <a href="{{ route('reports.company_upcoming_renewals') }}" class="report-card h-100 border-teal-soft">
                        <div class="report-icon bg-soft-teal">
                            <i class="fe fe-shield"></i>
                        </div>
                        <div class="report-info">
                            <h5>Org. Upcoming Renewals</h5>
                            <p>Planned compliance</p>
                        </div>
                        <div class="report-arrow">
                            <i class="fe fe-chevron-right"></i>
                        </div>
                    </a>
                </div>

            </div>
        </div>
    </div>

    <style>
        .report-card {
            display: flex;
            align-items: center;
            background: white;
            padding: 20px;
            border-radius: 16px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.02);
            border: 1px solid #f1f5f9;
            text-decoration: none !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .report-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.08);
            border-color: var(--primary);
        }

        .report-card:hover .report-arrow {
            transform: translateX(5px);
            color: var(--primary);
        }

        .report-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            margin-right: 15px;
            flex-shrink: 0;
        }

        .report-info h5 {
            margin: 0;
            font-size: 0.95rem;
            font-weight: 700;
            color: #1e293b;
        }

        .report-info p {
            margin: 2px 0 0;
            font-size: 0.75rem;
            color: #64748b;
        }

        .report-arrow {
            margin-left: auto;
            color: #cbd5e1;
            transition: all 0.2s;
        }

        /* Soft Colors */
        .bg-soft-primary {
            background: #f0f4ff;
            color: #4f46e5!important;
        }

        .bg-soft-info {
            background: #f0f9ff;
            color: #0ea5e9;
        }

        .bg-soft-success {
            background: #f0fdf4;
            color: #16a34a;
        }

        .bg-soft-warning {
            background: #fffbeb;
            color: #d97706;
        }

        .bg-soft-danger {
            background: #fef2f2;
            color: #dc2626;
        }

        .bg-soft-indigo {
            background: #f5f3ff;
            color: #7c3aed;
        }

        .bg-soft-teal {
            background: #f0fdfa;
            color: #0d9488;
        }

        .border-danger-soft {
            border-left: 3px solid #fecaca;
        }

        .border-primary-soft {
            border-left: 3px solid #4f46e5;
        }

        .border-info-soft {
            border-left: 3px solid #0ea5e9;
        }

        .border-success-soft {
            border-left: 3px solid #16a34a;
        }

        .border-warning-soft {
            border-left: 3px solid #d97706;
        }

        .border-indigo-soft {
            border-left: 3px solid #7c3aed;
        }

        .border-teal-soft {
            border-left: 3px solid #0d9488;
        }


        @media (max-width: 576px) {
            .report-card {
                padding: 15px;
            }

            .report-icon {
                width: 40px;
                height: 40px;
                font-size: 18px;
            }
        }
    </style>
@endsection