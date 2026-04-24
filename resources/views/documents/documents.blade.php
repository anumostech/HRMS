@extends('layouts.app')

@section('title', 'Documents')

@section('content')
<div class="page-header">
    <h1 class="page-title">Documents</h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('employees.index') }}">Employees</a></li>
            <li class="breadcrumb-item active" aria-current="page">Documents</li>
        </ol>
    </div>
</div>
<!-- { Tabs style 1 } start -->
<div class="col-xl-12">
    <div class="card">
        <div class="card-body">
            <div class="panel panel-primary">
                <div class=" tab-menu-heading">
                    <div class="tabs-menu1">
                        <!-- Tabs -->
                        <ul class="nav panel-tabs" role="tablist">
                            <li><a href="#tab5" class="active" data-bs-toggle="tab" aria-selected="true" role="tab">Organization Files</a></li>
                            <li><a href="#tab6" data-bs-toggle="tab" aria-selected="false" tabindex="-1" role="tab">Agreements</a></li>
                            <li><a href="#tab7" data-bs-toggle="tab" aria-selected="false" tabindex="-1" role="tab">HR</a></li>
                            <li><a href="#tab8" data-bs-toggle="tab" aria-selected="false" tabindex="-1" role="tab">Others</a></li>
                            <li><a href="#tab9" data-bs-toggle="tab" aria-selected="false" tabindex="-1" role="tab">Folders</a></li>
                            <li><a href="#tab10" data-bs-toggle="tab" aria-selected="false" tabindex="-1" role="tab">Employees</a></li>
                        </ul>
                    </div>
                </div>
                <div class="panel-body tabs-menu-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab5" role="tabpanel">
                            @if($organization_files->isEmpty())
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <img src="{{ asset('assets/images/no-data.png') }}">
                                </div>
                            </div>
                            <h5 class="text-center mt-2">No organization file added</h5>
                            <p class="text-center">Upload important common files such as policies or company handbooks that can be shared across the entire organization or for selected business entities, locations, departments, etc.</p>
                            <div class="row">
                                <div class="col-md-12 text-center mt-2">
                                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#largemodal" data-type="organization"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="white" viewBox="0 0 16 16">
                                            <path d="M8 1a.5.5 0 0 1 .5.5V7.5H14.5a.5.5 0 0 1 0 1H8.5V14.5a.5.5 0 0 1-1 0V8.5H1.5a.5.5 0 0 1 0-1H7.5V1.5A.5.5 0 0 1 8 1z" />
                                        </svg> Add Organization Files</button>
                                </div>
                            </div>
                            @else
                            <div class="row">
                                <div class="col-md-12 text-end mt-2">
                                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#largemodal" data-type="organization"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="white" viewBox="0 0 16 16">
                                            <path d="M8 1a.5.5 0 0 1 .5.5V7.5H14.5a.5.5 0 0 1 0 1H8.5V14.5a.5.5 0 0 1-1 0V8.5H1.5a.5.5 0 0 1 0-1H7.5V1.5A.5.5 0 0 1 8 1z" />
                                        </svg> Add Organization Files</button>
                                </div>
                            </div>
                            <div class="table-responsive mt-2">
                                <table class="table table-modern text-nowrap datatable-basic">
                                    <thead>
                                        <tr>
                                            <th>Sl.No.</th>
                                            <th>Name</th>
                                            <th>Folder</th>
                                            <th>Share With</th>
                                            <th>Expiry Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($organization_files as $key => $record)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>

                                            <!-- File Name -->
                                            <td>
                                                @php
                                                $ext = strtolower(pathinfo($record->file_path, PATHINFO_EXTENSION));
                                                @endphp

                                                @if($ext == 'pdf')
                                                <i class="fe fe-file-text text-danger"></i>

                                                @elseif($ext == 'docx')
                                                <i class="fe fe-file text-info"></i>

                                                @elseif(in_array($ext,['jpg','jpeg','png']))
                                                <i class="fe fe-image text-success"></i>
                                                @endif
                                                <a href="{{ asset('storage/'.$record->file_path) }}" class="text-black">
                                                    {{ $record->name }}{{ $ext }}
                                                </a>
                                            </td>

                                            <!-- Folder -->
                                            <td>{{ $record->folder }}</td>

                                            <!-- Share With -->
                                            <td>{{ $record->share_with ?? 'All' }}</td>

                                            <!-- Expiry Date -->
                                            <td>
                                                @if($record->expiry_date)
                                                {{ \Carbon\Carbon::parse($record->expiry_date)->format('d-m-Y') }}
                                                @else
                                                <span class="text-muted">No Expiry</span>
                                                @endif
                                            </td>

                                            <!-- Actions -->
                                            <td>

                                                <a href="{{ asset('storage/'.$record->file_path) }}"
                                                    class="btn btn-sm btn-primary"
                                                    target="_blank">

                                                    <i class="fe fe-eye"></i>
                                                </a>

                                                <a href="{{ asset('storage/'.$record->file_path) }}"
                                                    class="btn btn-sm btn-success"
                                                    download>

                                                    <i class="fe fe-download"></i>
                                                </a>

                                                <button class="btn btn-sm btn-danger delete-btn" data-id="{{ $record->id }}">
                                                    <i class="fe fe-trash"></i>
                                                </button>

                                            </td>

                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div>
                            
                            </div>
                            @endif
                        </div>
                        <div class="tab-pane" id="tab6" role="tabpanel">
                            @if($agreements->isEmpty())
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <img src="{{ asset('assets/images/no-data.png') }}">
                                </div>
                            </div>
                            <h5 class="text-center mt-2">No agreements added</h5>
                            <div class="row">
                                <div class="col-md-12 text-center mt-2">
                                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#largemodal" data-type="agreement"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="white" viewBox="0 0 16 16">
                                            <path d="M8 1a.5.5 0 0 1 .5.5V7.5H14.5a.5.5 0 0 1 0 1H8.5V14.5a.5.5 0 0 1-1 0V8.5H1.5a.5.5 0 0 1 0-1H7.5V1.5A.5.5 0 0 1 8 1z" />
                                        </svg> Add Agreement</button>
                                </div>
                            </div>
                            @else
                            <div class="row">
                                <div class="col-md-12 text-end mt-2">
                                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#largemodal" data-type="agreement"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="white" viewBox="0 0 16 16">
                                            <path d="M8 1a.5.5 0 0 1 .5.5V7.5H14.5a.5.5 0 0 1 0 1H8.5V14.5a.5.5 0 0 1-1 0V8.5H1.5a.5.5 0 0 1 0-1H7.5V1.5A.5.5 0 0 1 8 1z" />
                                        </svg> Add Agreement</button>
                                </div>
                            </div>
                            <div class="table-responsive mt-2">
                                <table class="table table-modern text-nowrap datatable-basic">
                                    <thead>
                                        <tr>
                                            <th>Sl.No.</th>
                                            <th>Name</th>
                                            <th>Folder</th>
                                            <th>Share With</th>
                                            <th>Expiry Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($agreements as $key => $record)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>

                                            <!-- File Name -->
                                            <td>
                                                @php
                                                $ext = strtolower(pathinfo($record->file_path, PATHINFO_EXTENSION));
                                                @endphp

                                                @if($ext == 'pdf')
                                                <i class="fe fe-file-text text-danger"></i>

                                                @elseif($ext == 'docx')
                                                <i class="fe fe-file text-info"></i>

                                                @elseif(in_array($ext,['jpg','jpeg','png']))
                                                <i class="fe fe-image text-success"></i>
                                                @endif
                                                <a href="{{ asset('storage/'.$record->file_path) }}" class="text-black">
                                                    {{ $record->name }}
                                                </a>
                                            </td>

                                            <!-- Folder -->
                                            <td>{{ $record->folder }}</td>

                                            <!-- Share With -->
                                            <td>{{ $record->share_with ?? 'All' }}</td>

                                            <!-- Expiry Date -->
                                            <td>
                                                @if($record->expiry_date)
                                                {{ \Carbon\Carbon::parse($record->expiry_date)->format('d-m-Y') }}
                                                @else
                                                <span class="text-muted">No Expiry</span>
                                                @endif
                                            </td>

                                            <!-- Actions -->
                                            <td>

                                                <a href="{{ asset('storage/'.$record->file_path) }}"
                                                    class="btn btn-sm btn-primary"
                                                    target="_blank">

                                                    <i class="fe fe-eye"></i>
                                                </a>

                                                <a href="{{ asset('storage/'.$record->file_path) }}"
                                                    class="btn btn-sm btn-success"
                                                    download>

                                                    <i class="fe fe-download"></i>
                                                </a>

                                                 <button class="btn btn-sm btn-danger delete-btn" data-id="{{ $record->id }}">
                                                    <i class="fe fe-trash"></i>
                                                </button>

                                            </td>

                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div>
                            
                            </div>
                            @endif
                        </div>
                        <div class="tab-pane" id="tab7" role="tabpanel">
                            @if($hr->isEmpty())
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <img src="{{ asset('assets/images/no-data.png') }}">
                                </div>
                            </div>
                            <h5 class="text-center mt-2">No HR Files added</h5>
                            <div class="row">
                                <div class="col-md-12 text-center mt-2">
                                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#largemodal" data-type="HR"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="white" viewBox="0 0 16 16">
                                            <path d="M8 1a.5.5 0 0 1 .5.5V7.5H14.5a.5.5 0 0 1 0 1H8.5V14.5a.5.5 0 0 1-1 0V8.5H1.5a.5.5 0 0 1 0-1H7.5V1.5A.5.5 0 0 1 8 1z" />
                                        </svg> Add HR File</button>
                                </div>
                            </div>
                            @else
                            <div class="row">
                                <div class="col-md-12 text-end mt-2">
                                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#largemodal" data-type="HR"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="white" viewBox="0 0 16 16">
                                            <path d="M8 1a.5.5 0 0 1 .5.5V7.5H14.5a.5.5 0 0 1 0 1H8.5V14.5a.5.5 0 0 1-1 0V8.5H1.5a.5.5 0 0 1 0-1H7.5V1.5A.5.5 0 0 1 8 1z" />
                                        </svg> Add HR File</button>
                                </div>
                            </div>
                            <div class="table-responsive mt-2">
                                <table class="table table-modern text-nowrap datatable-basic">
                                    <thead>
                                        <tr>
                                            <th>Sl.No.</th>
                                            <th>Name</th>
                                            <th>Folder</th>
                                            <th>Share With</th>
                                            <th>Expiry Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($hr as $key => $record)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>

                                            <!-- File Name -->
                                            <td>
                                                @php
                                                $ext = strtolower(pathinfo($record->file_path, PATHINFO_EXTENSION));
                                                @endphp

                                                @if($ext == 'pdf')
                                                <i class="fe fe-file-text text-danger"></i>

                                                @elseif($ext == 'docx')
                                                <i class="fe fe-file text-info"></i>

                                                @elseif(in_array($ext,['jpg','jpeg','png']))
                                                <i class="fe fe-image text-success"></i>
                                                @endif
                                                <a href="{{ asset('storage/'.$record->file_path) }}" class="text-black">
                                                    {{ $record->name }}
                                                </a>
                                            </td>

                                            <!-- Folder -->
                                            <td>{{ $record->folder }}</td>

                                            <!-- Share With -->
                                            <td>{{ $record->share_with ?? 'All' }}</td>

                                            <!-- Expiry Date -->
                                            <td>
                                                @if($record->expiry_date)
                                                {{ \Carbon\Carbon::parse($record->expiry_date)->format('d-m-Y') }}
                                                @else
                                                <span class="text-muted">No Expiry</span>
                                                @endif
                                            </td>

                                            <!-- Actions -->
                                            <td>

                                                <a href="{{ asset('storage/'.$record->file_path) }}"
                                                    class="btn btn-sm btn-primary"
                                                    target="_blank">

                                                    <i class="fe fe-eye"></i>
                                                </a>

                                                <a href="{{ asset('storage/'.$record->file_path) }}"
                                                    class="btn btn-sm btn-success"
                                                    download>

                                                    <i class="fe fe-download"></i>
                                                </a>

                                                 <button class="btn btn-sm btn-danger delete-btn" data-id="{{ $record->id }}">
                                                    <i class="fe fe-trash"></i>
                                                </button>

                                            </td>

                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div>
                            
                            </div>
                            @endif
                        </div>
                        <div class="tab-pane" id="tab8" role="tabpanel">
                            @if($others->isEmpty())
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <img src="{{ asset('assets/images/no-data.png') }}">
                                </div>
                            </div>
                            <h5 class="text-center mt-2">No Files added</h5>
                            <div class="row">
                                <div class="col-md-12 text-center mt-2">
                                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#largemodal" data-type="others"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="white" viewBox="0 0 16 16">
                                            <path d="M8 1a.5.5 0 0 1 .5.5V7.5H14.5a.5.5 0 0 1 0 1H8.5V14.5a.5.5 0 0 1-1 0V8.5H1.5a.5.5 0 0 1 0-1H7.5V1.5A.5.5 0 0 1 8 1z" />
                                        </svg> Add File</button>
                                </div>
                            </div>
                            @else
                            <div class="row">
                                <div class="col-md-12 text-end mt-2">
                                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#largemodal" data-type="others"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="white" viewBox="0 0 16 16">
                                            <path d="M8 1a.5.5 0 0 1 .5.5V7.5H14.5a.5.5 0 0 1 0 1H8.5V14.5a.5.5 0 0 1-1 0V8.5H1.5a.5.5 0 0 1 0-1H7.5V1.5A.5.5 0 0 1 8 1z" />
                                        </svg> Add File</button>
                                </div>
                            </div>
                            <div class="table-responsive mt-2">
                                <table class="table table-modern text-nowrap datatable-basic">
                                    <thead>
                                        <tr>
                                            <th>Sl.No.</th>
                                            <th>Name</th>
                                            <th>Folder</th>
                                            <th>Share With</th>
                                            <th>Expiry Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($others as $key => $record)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>

                                            <!-- File Name -->
                                            <td>
                                                @php
                                                $ext = strtolower(pathinfo($record->file_path, PATHINFO_EXTENSION));
                                                @endphp

                                                @if($ext == 'pdf')
                                                <i class="fe fe-file-text text-danger"></i>

                                                @elseif($ext == 'docx')
                                                <i class="fe fe-file text-info"></i>

                                                @elseif(in_array($ext,['jpg','jpeg','png']))
                                                <i class="fe fe-image text-success"></i>
                                                @endif
                                                <a href="{{ asset('storage/'.$record->file_path) }}" class="text-black">
                                                    {{ $record->name }}
                                                </a>
                                            </td>

                                            <!-- Folder -->
                                            <td>{{ $record->folder }}</td>

                                            <!-- Share With -->
                                            <td>{{ $record->share_with ?? 'All' }}</td>

                                            <!-- Expiry Date -->
                                            <td>
                                                @if($record->expiry_date)
                                                {{ \Carbon\Carbon::parse($record->expiry_date)->format('d-m-Y') }}
                                                @else
                                                <span class="text-muted">No Expiry</span>
                                                @endif
                                            </td>

                                            <!-- Actions -->
                                            <td>

                                                <a href="{{ asset('storage/'.$record->file_path) }}"
                                                    class="btn btn-sm btn-primary"
                                                    target="_blank">

                                                    <i class="fe fe-eye"></i>
                                                </a>

                                                <a href="{{ asset('storage/'.$record->file_path) }}"
                                                    class="btn btn-sm btn-success"
                                                    download>

                                                    <i class="fe fe-download"></i>
                                                </a>

                                                 <button class="btn btn-sm btn-danger delete-btn" data-id="{{ $record->id }}">
                                                    <i class="fe fe-trash"></i>
                                                </button>

                                            </td>

                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div>
                            
                            </div>
                            @endif
                        </div>
                        <div class="tab-pane" id="tab9" role="tabpanel">
                            @if($folders->isEmpty())
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <img src="{{ asset('assets/images/no-data.png') }}">
                                </div>
                            </div>
                            <h5 class="text-center mt-2">No Folders Found</h5>
                            @else
                            <div class="row mt-2">
                                @foreach($folders as $folder)
                                <div class="col-md-2 col-4 text-center mb-4">
                                    <div class="folder-card gap-2" onclick="openFolder('{{ $folder }}')">
                                        <i class="fa fa-folder folder-icon fs-14"></i>
                                        <div class="folder-name">{{ ucfirst($folder) }}</div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @endif
                        </div>
                        <div class="tab-pane" id="tab10" role="tabpanel">
                            @if($employees->isEmpty())
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <img src="{{ asset('assets/images/no-data.png') }}">
                                </div>
                            </div>
                            <h5 class="text-center mt-2">No records found</h5>
                            <div class="row">
                                <div class="col-md-12 text-center mt-2">
                                    <a href="{{ route('employees.create') }}" class="btn btn-primary ms-2"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="white" viewBox="0 0 16 16">
                                            <path d="M8 1a.5.5 0 0 1 .5.5V7.5H14.5a.5.5 0 0 1 0 1H8.5V14.5a.5.5 0 0 1-1 0V8.5H1.5a.5.5 0 0 1 0-1H7.5V1.5A.5.5 0 0 1 8 1z" />
                                        </svg> Add Employee</a>
                                </div>
                            </div>
                            @else
                            <div class="row">
                                <div class="col-md-12 text-end mt-2">
                                    <a href="{{ route('employees.create') }}" class="btn btn-primary ms-2"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="white" viewBox="0 0 16 16">
                                            <path d="M8 1a.5.5 0 0 1 .5.5V7.5H14.5a.5.5 0 0 1 0 1H8.5V14.5a.5.5 0 0 1-1 0V8.5H1.5a.5.5 0 0 1 0-1H7.5V1.5A.5.5 0 0 1 8 1z" />
                                        </svg> Add Employee</a>
                                </div>
                            </div>
                            <div class="table-responsive mt-2">
                                <table class="table table-modern text-nowrap datatable-basic">
                                    <thead>
                                        <tr>
                                            <th class="wd-15p border-bottom-0">Name</th>
                                            <th class="wd-15p border-bottom-0">Designation</th>
                                            <th class="wd-20p border-bottom-0">Department</th>
                                            <th class="wd-15p border-bottom-0">Company</th>
                                            <th class="wd-10p border-bottom-0">Status</th>
                                            <th class="wd-25p border-bottom-0">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($employees as $employee)
                                        <tr>
                                            <td>{{ $employee->name }}</td>
                                            <td>{{ $employee->designation }}</td>
                                            <td>{{ $employee->department->name ?? '' }}</td>
                                            <td>{{ $employee->company->name ?? '' }}</td>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="form-check form-switch d-flex align-items-center">
                                                        <input
                                                            class="form-check-input status-toggle"
                                                            type="checkbox"
                                                            role="switch"
                                                            id="status"
                                                            data-id="{{ $employee->id }}"
                                                            {{ $employee->status == 'active' ? 'checked' : '' }}
                                                            style="height: 25px;
                                                            width: 45px;
                                                            margin-left: -2.2em;
                                                            margin-top: 0;
                                                            position:relative;">
                                                        <span class="status-text{{ $employee->id }}">{{ ucfirst($employee->status) }}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="btn-list d-flex">
                                                    <!-- <a href="#" class="btn btn-sm btn-info" title="View Details">
                                            <i class="fe fe-eye"></i>
                                        </a> -->
                                                    <a href="{{ route('employees.show', $employee->id) }}" class="btn btn-sm btn-info" title="View Details">
                                                        <i class="fe fe-eye"></i>
                                                    </a>
                                                    <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-sm btn-primary" title="Edit">
                                                        <i class="fe fe-edit"></i>
                                                    </a>
                                                    @if($employee->status == 'active')
                                                    <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" onsubmit="confirmDelete(event)">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" title="Deactivate">
                                                            <i class="fe fe-trash"></i>
                                                        </button>
                                                    </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div>
                            
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- { Modal } -->
<div class="modal fade" id="largemodal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Files</h5>
                <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- <form> -->
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Upload file</label>
                        <p>Upload important organization-wide files such as policies or company handbooks.</p>
                        <div class="ff_fileupload_dropzone_wrap">
                            <form action="/upload-temp-document"
                                class="dropzone"
                                id="documentDropzone"
                                method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="dz-message">
                                    <i class="fe fe-upload-cloud" style="font-size:40px;"></i>
                                    <p>Drag & Drop files here or click to upload</p>
                                </div>
                                <input type="hidden" name="file_path" id="file_path">
                            </form>
                        </div>
                        <span>All standard document file types such as .pdf .docx .xls can be uploaded with a maximum file size of 10 MB</span>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label">File Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" value="" placeholder="File name">
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" rows="2"></textarea>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Share with <span class="text-danger">*</span></label>
                        <div class="select-wrapper">
                            <select class="form-control @error('share_with') is-invalid @enderror" name="share_with" id="folderSelect">
                                <option value="">Share with</option>
                                @foreach($share_with as $share)
                                <option value="{{ $share->id }}">{{ $share->name }}</option>
                                @endforeach
                            </select>
                            @error('share_with') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <input type="text" class="form-control" name="share_with" value="" placeholder="Share with">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Folders <span class="text-danger">*</span></label>
                        <div class="select-wrapper">
                            <select class="form-control @error('company_id') is-invalid @enderror" name="folder" id="folderSelect">
                                <option value="">Select Folder</option>
                                @foreach($folders as $folder)
                                <option value="{{ $folder }}">{{ $folder }}</option>
                                @endforeach
                                <option value="__new__" id="addFolderOption" class="text-center" style="background:#0D9C1E;color:#fff;">+ Add Folder</option>
                            </select>
                            @error('folder') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label">File Expiry Date</label>
                        <input type="text" class="form-control datepicker" name="expiry_date" value="" placeholder="Select date">
                        <input type="hidden" name="type" id="type">
                    </div>
                </div>
                <!-- </form> -->
            </div>
            <div class="modal-footer">
                <button class="btn btn-default" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="submitForm()">Save</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="createFolderModal">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Create Folder</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <input type="text" id="newFolderName" class="form-control" placeholder="Enter folder name">
            </div>

            <div class="modal-footer">
                <button class="btn btn-default" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary" id="saveFolderBtn">Create</button>
            </div>

        </div>
    </div>
</div>
<!-- { Tabs style 1 } end -->
@endsection
@section('scripts')
<script>
    Dropzone.autoDiscover = false;

    var myDropzone = new Dropzone("#documentDropzone", {

        url: "{{ route('documents.upload') }}",

        maxFilesize: 10,

        acceptedFiles: ".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png",

        success: function(file, response) {

            document.getElementById('file_path').value = response.path;

        }

    });

    var modal = document.getElementById('largemodal');

    modal.addEventListener('show.bs.modal', function(event) {

        var button = event.relatedTarget;

        var type = button.getAttribute('data-type');

        modal.querySelector('#type').value = type;

    });

    function submitForm() {

        axios.post('{{ route("documents.store") }}', {

            name: document.querySelector('[name="name"]').value,

            description: document.querySelector('textarea[name="description"]').value,

            folder: document.querySelector('[name="folder"]').value,

            share_with: document.querySelector('[name="share_with"]').value,

            expiry_date: document.querySelector('[name="expiry_date"]').value,

            file_path: document.getElementById('file_path').value,

            type: document.querySelector('[name="type"]').value,

        }).then(response => {

            let modalElement = document.getElementById('largemodal');
            let modal = bootstrap.Modal.getInstance(modalElement);

            modal.hide();

            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Organization added successfully',
                showConfirmButton: false,
                timer: 1500
            });

            location.reload();

        });

    }
    $('#folderSelect').on('change', function() {

        if ($(this).val() === '__new__') {

            let modal = new bootstrap.Modal(document.getElementById('createFolderModal'));
            modal.show();

        }

    });

    $('#saveFolderBtn').click(function() {

        let folderName = $('#newFolderName').val();

        if (!folderName) {
            alert("Folder name is required");
            return;
        }

        let newOption = `<option value="${folderName}">${folderName}</option>`;

        $('#addFolderOption').before(newOption);

        $('#folderSelect').val(folderName).trigger('change');

        $('#newFolderName').val('');

        bootstrap.Modal.getInstance(document.getElementById('createFolderModal')).hide();

    });

    $('#createFolderModal').on('hidden.bs.modal', function() {

        if ($('#folderSelect').val() === '__new__') {
            $('#folderSelect').val('');
        }

    });
</script>
<script>
    function confirmDelete(event) {

        event.preventDefault();

        Swal.fire({
            title: "Are you sure?",
            text: "This employee will be deleted!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#eee",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {

            if (result.isConfirmed) {
                event.target.submit();
            }

        });

    }

    document.addEventListener('change', function(e) {

        if (e.target.classList.contains('status-toggle')) {

            let employeeId = e.target.dataset.id;
            let status = e.target.checked ? 'active' : 'inactive';

            axios.post("{{ route('employees.updateStatus', ':id') }}", {
                    status: status
                }, {
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(function(response) {
                    let formattedStatus = status.charAt(0).toUpperCase() + status.slice(1);
                    $(".status-text" + employeeId).text(formattedStatus);

                    let message = status === 'active' ?
                        'Employee activated successfully.' :
                        'Employee deactivated successfully.';

                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: message,
                        showConfirmButton: false,
                        timer: 1500
                    });

                    setTimeout(function() {
                        window.location.href = "{{ route('employees.index') }}?status=" + status;
                    }, 1510);

                })
                .catch(function(error) {

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Status update failed'
                    });

                });

        }

    });
</script>
<script>
$(document).on('click', '.delete-btn', function() {

    let id = $(this).data('id');

    Swal.fire({
            title: "Are you sure?",
            text: "This document will be deleted!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "Cancel",
            confirmButtonColor: "#d33",
            cancelButtonColor: "#e9e9f1",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {

            if(result.isConfirmed){

                axios.post("{{ route('documents.delete', ':id') }}", {
                    _token: "{{ csrf_token() }}"
                })
                .then(function (response){

                    Swal.fire(
                        "Success",
                        "Record deleted successfully.",
                        "success"
                    ).then(() => {
                        location.reload();
                    });

                })
                .catch(function (error){

                    Swal.fire(
                        "Error!",
                        "Something went wrong.",
                        "error"
                    );

                });

            }

        });

});
</script>
@endsection