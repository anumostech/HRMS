@extends('layouts.app')

@section('title', 'Leave Management')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Leave Management</h1>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Leaves</a></li>
                <li class="breadcrumb-item active" aria-current="page">Management</li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Leave Requests</h3>
                    <a href="{{ route('leaves.types.index') }}" class="btn btn-primary btn-sm">
                        <i class="fe fe-settings me-1"></i>Manage Leave Types
                    </a>
                </div>

                <div class="card-body">
                    <div class="d-flex align-items-center gap-2 mb-4">
                        <a href="{{ route('leaves.index') }}"
                            class="btn btn-sm btn-{{ !$status ? 'primary' : 'outline-primary' }}">All</a>
                        <a href="{{ route('leaves.index', ['status' => 'pending']) }}"
                            class="btn btn-sm btn-{{ $status == 'pending' ? 'warning' : 'outline-warning' }}">Pending</a>
                        <a href="{{ route('leaves.index', ['status' => 'approved']) }}"
                            class="btn btn-sm btn-{{ $status == 'approved' ? 'success' : 'outline-success' }}">Approved</a>
                        <a href="{{ route('leaves.index', ['status' => 'rejected']) }}"
                            class="btn btn-sm btn-{{ $status == 'rejected' ? 'danger' : 'outline-danger' }}">Rejected</a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-modern text-nowrap" id="basic-datatable">
                            <thead>
                                <tr>
                                    <th>Sl.No.</th>
                                    <th>Employee</th>
                                    <th>Type</th>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>Days</th>
                                    <th>Claim Salary</th>
                                    <th>Doc</th>
                                    <th>Reason</th>
                                    <th>Status</th>
                                    <th>Processed By</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($leaveRequests as $leave)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $leave->employee->name }}</td>
                                        <td>{{ $leave->leaveType->name }}</td>
                                        <td>{{ $leave->start_date->format('d M, Y') }}</td>
                                        <td>{{ $leave->end_date->format('d M, Y') }}</td>
                                        <td><span class="badge bg-light text-dark border">{{ $leave->duration_days }}</span>
                                        </td>
                                        <td>
                                            @if(isset($leave->claim_salary))
                                                {{ $leave->claim_salary ? 'Yes' : 'No' }}
                                            @else
                                                <span>No</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($leave->document)
                                                <a href="{{ asset('storage/' . $leave->document) }}" target="_blank"
                                                    class="text-primary" title="View Document">
                                                    <i class="fe fe-file"></i> <span>View</span>
                                                </a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td title="{{ $leave->reason }}">{{ Str::limit($leave->reason, 20) }}</td>
                                        <td>
                                            @if($leave->status == 'pending')
                                                <span class="badge bg-warning">Pending</span>
                                            @elseif($leave->status == 'approved')
                                                <span class="badge bg-success">Approved</span>
                                            @else
                                                <span class="badge bg-danger">Rejected</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $leave->approver->name ?? 'N/A' }}
                                        </td>
                                        <td>
                                            @if($leave->status == 'pending')
                                                <div class="btn-list d-flex gap-2">
                                                    <button class="btn btn-sm btn-success approve-btn" data-id="{{ $leave->id }}"
                                                        title="Approve">
                                                        <i class="fe fe-check"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger reject-btn" data-id="{{ $leave->id }}"
                                                        title="Reject">
                                                        <i class="fe fe-x"></i>
                                                    </button>
                                                </div>
                                            @else
                                                <span class="text-muted">Processed</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="11" class="text-center">No leave requests found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $leaveRequests->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Approval/Rejection Modal -->
    <div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="statusForm" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitle">Update Leave Status</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="status" id="statusInput">
                        <div class="form-group">
                            <label class="form-label">Remark (Optional)</label>
                            <textarea class="form-control" name="admin_remark" rows="3"
                                placeholder="Enter remark..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Confirm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $('.approve-btn').on('click', function () {
                let id = $(this).data('id');
                let url = "{{ route('leaves.updateStatus', ':id') }}".replace(':id', id);
                $('#statusForm').attr('action', url);
                $('#statusInput').val('approved');
                $('#modalTitle').text('Approve Leave Request');
                $('#statusModal').modal('show');
            });

            $('.reject-btn').on('click', function () {
                let id = $(this).data('id');
                let url = "{{ route('leaves.updateStatus', ':id') }}".replace(':id', id);
                $('#statusForm').attr('action', url);
                $('#statusInput').val('rejected');
                $('#modalTitle').text('Reject Leave Request');
                $('#statusModal').modal('show');
            });
        });
    </script>
@endsection