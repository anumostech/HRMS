@extends('layouts.app')

@section('title', 'Agreements')

@section('content')
    <style>
        .tab-content .btn i {
            color: inherit !important;
        }
    </style>
    <div class="page-header" style="display:inline;">
        <h1 class="page-title mb-2">Agreements</h1>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Agreements</li>
            </ol>
        </div>
    </div>
    <!-- { Tabs style 1 } start -->
    <div class="col-xl-12">
        <div class="card">
            @if(!$agreements->isEmpty())
                <div class="card-header d-flex justify-content-between">
                    <h3 class="card-title">Agreement Files</h3>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#largemodal"
                        data-type="agreement"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="white"
                            viewBox="0 0 16 16">
                            <path
                                d="M8 1a.5.5 0 0 1 .5.5V7.5H14.5a.5.5 0 0 1 0 1H8.5V14.5a.5.5 0 0 1-1 0V8.5H1.5a.5.5 0 0 1 0-1H7.5V1.5A.5.5 0 0 1 8 1z" />
                        </svg> Add Agreement Files</button>
                </div>
            @endif
            <div class="card-body">
                <div class="panel panel-primary">
                    <div class="panel-body tabs-menu-body" style="padding:0px;">
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab6" role="tabpanel">
                                @if($agreements->isEmpty())
                                    <div class="row">
                                        <div class="col-md-12 text-center">
                                            <img src="{{ asset('assets/images/no-data.png') }}">
                                        </div>
                                    </div>
                                    <h5 class="text-center mt-2">No agreements added</h5>
                                    <div class="row">
                                        <div class="col-md-12 text-center mt-2">
                                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#largemodal"
                                                data-type="agreement"><svg xmlns="http://www.w3.org/2000/svg" width="18"
                                                    height="18" fill="white" viewBox="0 0 16 16">
                                                    <path
                                                        d="M8 1a.5.5 0 0 1 .5.5V7.5H14.5a.5.5 0 0 1 0 1H8.5V14.5a.5.5 0 0 1-1 0V8.5H1.5a.5.5 0 0 1 0-1H7.5V1.5A.5.5 0 0 1 8 1z" />
                                                </svg> Add Agreement</button>
                                        </div>
                                    </div>
                                @else
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

                                                            @elseif(in_array($ext, ['jpg', 'jpeg', 'png']))
                                                                <i class="fe fe-image text-success"></i>
                                                            @endif
                                                            <a href="{{ asset('storage/' . $record->file_path) }}"
                                                                class="text-black">
                                                                {{ $record->name }}
                                                            </a>
                                                        </td>

                                                        <!-- Folder -->
                                                        <td>{{ $record->folder }}</td>

                                                        <!-- Share With -->
                                                        <td>{{ $record->shareWith->name ?? 'All' }}</td>

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
                                                            <div class="btn-list d-flex">
                                                                <a href="{{ asset('storage/' . $record->file_path) }}"
                                                                    class="btn btn-sm btn-outline-info" target="_blank"
                                                                    title="View">
                                                                    <i class="fe fe-eye"></i>
                                                                </a>

                                                                <a href="{{ asset('storage/' . $record->file_path) }}"
                                                                    class="btn btn-sm btn-outline-success" download
                                                                    title="Download">
                                                                    <i class="fe fe-download"></i>
                                                                </a>

                                                                <button class="btn btn-sm btn-outline-primary edit-agreement"
                                                                    data-id="{{ $record->id }}" title="Edit">
                                                                    <i class="fe fe-edit"></i>
                                                                </button>

                                                                <button class="btn btn-sm btn-outline-danger delete-agreement"
                                                                    data-id="{{ $record->id }}" title="Delete">
                                                                    <i class="fe fe-trash"></i>
                                                                </button>
                                                            </div>
                                                        </td>

                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="largemodal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Add Agreement Files</h5>
                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="agreement_id" id="agreement_id">
                        <div class="col-md-12 mb-3" id="upload_section">
                            <label class="form-label">Upload file</label>
                            <div class="ff_fileupload_dropzone_wrap">
                                <form action="{{ route('documents.upload') }}" class="dropzone" id="documentDropzone"
                                    method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="dz-message">
                                        <i class="fe fe-upload-cloud" style="font-size:40px;"></i>
                                        <p>Drag & Drop files here or click to upload</p>
                                    </div>
                                    <input type="hidden" name="file_path" id="file_path">
                                </form>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">File Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" placeholder="File name">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description" rows="2"></textarea>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Party</label>
                            <select class="form-control" name="party_id" id="agreementSelect">
                                <option value="">Select Party</option>
                                @foreach($parties as $party)
                                    <option value="{{ $party->id }}">{{ $party->name }}</option>
                                @endforeach
                                <option value="__party__" id="addPartyOption" class="text-center"
                                    style="background:#0D9C1E;color:#fff;">+ Add Party</option>
                            </select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Share with <span class="text-danger">*</span></label>
                            <select class="form-control" name="share_with">
                                <option value="">Share with</option>
                                @foreach($share_with as $share)
                                    <option value="{{ $share->id }}">{{ $share->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Folders <span class="text-danger">*</span></label>
                            <select class="form-control" name="folder" id="folderSelect">
                                <option value="">Select Folder</option>
                                @foreach($folders as $folder)
                                    <option value="{{ $folder }}">{{ $folder }}</option>
                                @endforeach
                                <option value="__new__" id="addFolderOption" class="text-center"
                                    style="background:#0D9C1E;color:#fff;">+ Add Folder</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">File Expiry Date</label>
                            <input type="text" class="form-control datepicker" name="expiry_date" placeholder="Select date">
                            <input type="hidden" name="type" id="type">
                        </div>
                    </div>

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

    <div class="modal fade" id="createPartyModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Party</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="partyForm">
                        <div class="mb-3">
                            <label class="form-label">Party Name</label>
                            <input type="text" class="form-control" name="name">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Company Name</label>
                            <input type="text" class="form-control" name="company_name">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Contact Person</label>
                            <input type="text" class="form-control" name="contact_person">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" class="form-control" name="phone">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <textarea class="form-control" name="address"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary" id="savePartyBtn">Save</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        Dropzone.autoDiscover = false;
        var myDropzone = new Dropzone("#documentDropzone", {
            url: "{{ route('documents.upload') }}",
            maxFilesize: 10,
            acceptedFiles: ".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png",
            success: function (file, response) {
                document.getElementById('file_path').value = response.path;
            }
        });

        var modalElement = document.getElementById('largemodal');
        modalElement.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var type = button.getAttribute('data-type');
            if (type) {
                document.getElementById('type').value = type;
            }
        });

        function submitForm() {
            let agreementId = document.getElementById('agreement_id').value;
            let url = agreementId ?
                "{{ route('agreements.update', ':id') }}".replace(':id', agreementId) :
                "{{ route('documents.store') }}";

            let data = {
                name: document.querySelector('[name="name"]').value,
                description: document.querySelector('textarea[name="description"]').value,
                folder: document.querySelector('[name="folder"]').value,
                share_with: document.querySelector('[name="share_with"]').value,
                expiry_date: document.querySelector('[name="expiry_date"]').value,
                type: document.getElementById('type').value,
                party_id: document.getElementById('agreementSelect').value
            };

            if (!agreementId) {
                data.file_path = document.getElementById('file_path').value;
            }

            axios.post(url, data).then(response => {
                bootstrap.Modal.getInstance(modalElement).hide();
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: agreementId ? 'Agreement updated successfully' : 'Agreement added successfully',
                    showConfirmButton: false,
                    timer: 1500
                });
                location.reload();
            }).catch(error => {
                Swal.fire('Error', 'Something went wrong', 'error');
            });
        }

        $('.edit-agreement').on('click', function () {
            let id = $(this).data('id');
            let url = "{{ route('agreements.show', ':id') }}".replace(':id', id);

            axios.get(url).then(response => {
                let data = response.data;
                $('#agreement_id').val(data.id);
                $('[name="name"]').val(data.name);
                $('textarea[name="description"]').val(data.description);
                $('[name="folder"]').val(data.folder);
                $('[name="share_with"]').val(data.share_with);
                $('[name="expiry_date"]').val(data.expiry_date);
                $('#agreementSelect').val(data.party_id);
                $('#type').val(data.type);

                $('#modalTitle').text('Edit Agreement');
                $('#upload_section').hide();

                let modal = new bootstrap.Modal(modalElement);
                modal.show();
            });
        });

        $('.delete-agreement').on('click', function () {
            let id = $(this).data('id');
            let url = "{{ route('agreements.destroy', ':id') }}".replace(':id', id);

            Swal.fire({
                title: "Are you sure?",
                text: "This agreement will be deleted!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#e9e9f1",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete(url, {
                        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                    }).then(response => {
                        Swal.fire('Deleted!', 'Agreement has been deleted.', 'success');
                        location.reload();
                    });
                }
            });
        });

        $('#largemodal').on('hidden.bs.modal', function () {
            $('#agreement_id').val('');
            $('#modalTitle').text('Add Agreement Files');
            $('#upload_section').show();
            $('[name="name"]').val('');
            $('textarea[name="description"]').val('');
            $('[name="folder"]').val('');
            $('[name="share_with"]').val('');
            $('[name="expiry_date"]').val('');
            $('#agreementSelect').val('');
        });

        $('#folderSelect').on('change', function () {
            if ($(this).val() === '__new__') {
                new bootstrap.Modal(document.getElementById('createFolderModal')).show();
            }
        });

        $('#saveFolderBtn').click(function () {
            let folderName = $('#newFolderName').val();
            if (!folderName) return;
            let newOption = `<option value="${folderName}">${folderName}</option>`;
            $('#addFolderOption').before(newOption);
            $('#folderSelect').val(folderName);
            $('#newFolderName').val('');
            bootstrap.Modal.getInstance(document.getElementById('createFolderModal')).hide();
        });

        $('#agreementSelect').on('change', function () {
            if ($(this).val() === '__party__') {
                new bootstrap.Modal(document.getElementById('createPartyModal')).show();
            }
        });

        $('#savePartyBtn').click(function () {
            let formData = new FormData(document.getElementById('partyForm'));
            axios.post("{{ route('parties.store') }}", formData).then(function (response) {
                Swal.fire("Success", response.data.message, "success");
                let party = response.data.data;
                let newOption = `<option value="${party.id}">${party.name}</option>`;
                $('#addPartyOption').before(newOption);
                $('#agreementSelect').val(party.id);
                bootstrap.Modal.getInstance(document.getElementById('createPartyModal')).hide();
                document.getElementById('partyForm').reset();
            });
        });
    </script>
@endsection