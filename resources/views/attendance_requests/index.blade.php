@extends('layouts.app')

@section('title', 'Attendance Requests')

@section('content')
<div class="page-header" style="display:inline;">
    <h1 class="page-title mb-2">Attendance Requests</h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Attendance Requests</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-bottom pt-4">
                <h3 class="card-title fw-bold">Pending & Recent Requests</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive mt-2">
                    <table class="table table-modern text-nowrap" id="basic-datatable">
                        <thead>
                            <tr>
                                <th class="border-bottom-0">#</th>
                                <th class="border-bottom-0">Employee</th>
                                <th class="border-bottom-0">Type</th>
                                <th class="border-bottom-0">Date</th>
                                <th class="border-bottom-0">Time</th>
                                <th class="border-bottom-0 text-center">Status</th>
                                <th class="border-bottom-0 text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($requests as $request)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        @if($request->employee->avatar)
                                            <img src="{{ asset('storage/' . $request->employee->avatar) }}"
                                                 alt="{{ $request->employee->first_name }}"
                                                 style="width:40px;height:40px;object-fit:cover;border-radius:25px;border:1px solid #dee2e6;">
                                        @else
                                            <div style="width:40px;height:40px;border-radius:25px;background:#f3f4f6;display:flex;align-items:center;justify-content:center;font-weight:600;color:#6b7280;font-size:15px;border:1px solid #e5e7eb;">
                                                {{ strtoupper(substr($request->employee->first_name,0,1)) }}{{ strtoupper(substr($request->employee->last_name ?? '',0,1)) }}
                                            </div>
                                        @endif
                                        <span class="fw-semibold text-dark">{{ $request->employee->first_name }} {{ $request->employee->last_name }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-primary-transparent text-primary rounded-pill px-3">
                                        {{ ucwords(str_replace('_', ' ', $request->type)) }}
                                    </span>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($request->request_date)->format('d M, Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($request->request_time)->format('h:i A') }}</td>
                                <td class="text-center">
                                    @if($request->status == 'pending')
                                        <span class="badge bg-warning text-dark rounded-pill px-3">Pending</span>
                                    @elseif($request->status == 'approved')
                                        <span class="badge bg-success rounded-pill px-3">Approved</span>
                                    @else
                                        <span class="badge bg-danger rounded-pill px-3">Rejected</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-list d-flex justify-content-end gap-2">
                                        @if($request->status == 'pending')
                                            <form action="{{ route('attendance_requests.status', $request) }}" method="POST" class="d-inline approve-form">
                                                @csrf
                                                <input type="hidden" name="status" value="approved">
                                                <button type="button" class="btn btn-sm btn-outline-success approve-btn" title="Approve">
                                                    <i class="fe fe-check"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('attendance_requests.status', $request) }}" method="POST" class="d-inline reject-form">
                                                @csrf
                                                <input type="hidden" name="status" value="rejected">
                                                <button type="button" class="btn btn-sm btn-outline-warning reject-btn" title="Reject">
                                                    <i class="fe fe-x"></i>
                                                </button>
                                            </form>
                                        @endif
                                        <a href="{{ route('attendance_requests.edit', $request) }}" class="btn btn-sm btn-outline-primary m-0" title="Edit">
                                            <i class="fe fe-edit"></i>
                                        </a>
                                        <form action="{{ route('attendance_requests.destroy', $request) }}" method="POST" class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-outline-danger delete-btn" title="Delete">
                                                <i class="fe fe-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
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

@section('scripts')
<script>
    $(document).ready(function() {
        // Approve Confirmation
        $('.approve-btn').on('click', function(e) {
            e.preventDefault();
            let form = $(this).closest('.approve-form');
            Swal.fire({
                title: 'Approve Request?',
                text: "Are you sure you want to approve this attendance request?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#059669',
                cancelButtonColor: '#d1d5db',
                confirmButtonText: 'Yes, Approve it!',
                cancelButtonText: 'Cancel',
                borderRadius: '15px'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });

        // Reject Confirmation
        $('.reject-btn').on('click', function(e) {
            e.preventDefault();
            let form = $(this).closest('.reject-form');
            Swal.fire({
                title: 'Reject Request?',
                text: "Are you sure you want to reject this attendance request?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d97706',
                cancelButtonColor: '#d1d5db',
                confirmButtonText: 'Yes, Reject it!',
                cancelButtonText: 'Cancel',
                borderRadius: '15px'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });

        // Delete Confirmation
        $('.delete-btn').on('click', function(e) {
            e.preventDefault();
            let form = $(this).closest('.delete-form');
            Swal.fire({
                title: 'Delete Request?',
                text: "This action cannot be undone. Are you sure?",
                icon: 'error',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#d1d5db',
                confirmButtonText: 'Yes, Delete it!',
                cancelButtonText: 'Cancel',
                borderRadius: '15px'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endsection
