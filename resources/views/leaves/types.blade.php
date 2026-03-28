@extends('layouts.app')

@section('title', 'Leave Types Management')

@section('content')
<div class="page-header">
    <h1 class="page-title">Leave Types</h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('leaves.index') }}">Leaves</a></li>
            <li class="breadcrumb-item active" aria-current="page">Types</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">Leave Types List</h3>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTypeModal">
                    <i class="fe fe-plus me-2"></i>Add New Type
                </button>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-modern text-nowrap datatable-basic">
                        <thead>
                            <tr>
                                <th>Sl.No.</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($leaveTypes as $type)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $type->name }}</td>
                                <td>
                                    <div class="form-check form-switch p-0" style="width: fit-content;">
                                        <input class="form-check-input status-toggle" type="checkbox" 
                                            data-id="{{ $type->id }}" 
                                            {{ $type->status ? 'checked' : '' }}
                                            style="margin: 0; cursor: pointer;">
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-list d-flex gap-2">
                                        <button class="btn btn-sm btn-info edit-btn" 
                                            data-id="{{ $type->id }}" 
                                            data-name="{{ $type->name }}" 
                                            title="Edit">
                                            <i class="fe fe-edit"></i>
                                        </button>
                                        <form action="{{ route('leaves.types.delete', $type->id) }}" method="POST" class="delete-form">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger confirm-delete" title="Delete">
                                                <i class="fe fe-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center">No leave types found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add type Modal -->
<div class="modal fade" id="addTypeModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('leaves.types.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add New Leave Type</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Type Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" required placeholder="Enter leave type name (e.g., Sick Leave)">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Type</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit type Modal -->
<div class="modal fade" id="editTypeModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="editForm" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Edit Leave Type</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Type Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" id="editName" required placeholder="Enter leave type name">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Type</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('.edit-btn').on('click', function() {
            let id = $(this).data('id');
            let name = $(this).data('name');
            let url = "{{ route('leaves.types.update', ':id') }}".replace(':id', id);
            $('#editForm').attr('action', url);
            $('#editName').val(name);
            $('#editTypeModal').modal('show');
        });

        $('.status-toggle').on('change', function() {
            let status = $(this).prop('checked') ? 1 : 0;
            let id = $(this).data('id');
            let url = "{{ route('leaves.types.updateStatus', ':id') }}".replace(':id', id);

            axios.post(url, {
                status: status,
                _token: '{{ csrf_token() }}'
            }).catch(error => {
                $(this).prop('checked', !status);
                Swal.fire('Error', 'Could not update status', 'error');
            });
        });

        $('.confirm-delete').on('click', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: "Deleting this leave type may affect existing records.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $(this).closest('form').submit();
                }
            });
        });
    });
</script>
@endsection
