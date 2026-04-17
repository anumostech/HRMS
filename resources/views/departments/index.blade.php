@extends('layouts.app')

@section('title', 'Departments')

@section('content')
<div class="row w-100">
    <div class="col-lg-12 mx-auto">
        <div class="page-header mt-4 mb-4 d-flex justify-content-between align-items-center">
            <h1 class="page-title text-primary"><i class="fe fe-layers"></i> Departments</h1>
            <a href="{{ route('departments.create') }}" class="btn btn-primary"><i class="fe fe-plus"></i> Add Department</a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 datatable-basic">
                        <thead class="bg-light">
                            <tr>
                                <th>Name</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($departments as $department)
                            <tr>
                                <td class="fw-bold">{{ $department->name }}</td>
                                <td class="text-end">
                                    <a href="{{ route('departments.edit', $department->id) }}" class="btn btn-sm btn-outline-info me-1"><i class="fe fe-edit"></i></a>
                                    <form action="{{ route('departments.destroy', $department->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fe fe-trash-2"></i></button>
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
