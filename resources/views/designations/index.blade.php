@extends('layouts.app')

@section('title', 'Designations')

@section('content')
    <div class="row w-100">
        <div class="col-lg-12 mx-auto">
            <div class="page-header mt-4 d-flex justify-content-between align-items-center">
                <div class="" style="display: inline;">
                    <h1 class="page-title mb-2">Designations</h1>
                    <div>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Designations</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Listing</li>
                        </ol>
                    </div>
                </div>
                <a href="{{ route('designations.create') }}" class="btn btn-primary"><i class="fe fe-plus"></i> Add
                    Designation</a>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 datatable-basic">
                            <thead class="bg-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Default Punch Access</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($designations as $designation)
                                    <tr>
                                        <td class="fw-bold">{{ $designation->name }}</td>
                                        <td>
                                            @if($designation->default_punch_access)
                                                <span class="badge bg-success">Yes</span>
                                            @else
                                                <span class="badge bg-secondary">No</span>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('designations.edit', $designation->id) }}"
                                                class="btn btn-sm btn-outline-info me-1"><i class="fe fe-edit"></i></a>
                                            <form action="{{ route('designations.destroy', $designation->id) }}" method="POST"
                                                class="d-inline delete-form">
                                                @csrf
                                                @method('DELETE')

                                                <button type="button" class="btn btn-sm btn-outline-danger delete-btn">
                                                    <i class="fe fe-trash-2"></i>
                                                </button>
                                            </form>
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
        $(document).on('click', '.delete-btn', function () {
            let form = $(this).closest('.delete-form');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    </script>
@endsection