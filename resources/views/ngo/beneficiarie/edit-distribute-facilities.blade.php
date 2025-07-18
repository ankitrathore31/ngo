@extends('ngo.layout.master')
@section('content')
    <style>
        .upload-container {
            text-align: center;
            margin-top: 15px;
            padding: 10px 20px;
            margin-left: 50px;
        }

        .image-placeholder {
            width: 150px;
            height: 150px;
            /* border: 2px dashed #ccc; */
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
            background-color: rgb(223, 226, 228);
        }

        .image-placeholder img {
            max-width: 100%;
            max-height: 100%;
            display: none;
        }

        .upload-btn {
            display: inline-block;
            background-color: #343a40;
            color: #fff;
            padding: 10px 15px;
            margin-right: 180px;
            font-size: 16px;
            width: auto;
            border-radius: 5px;
            cursor: pointer;
            border: none;
        }

        .upload-btn:hover {
            background-color: #495057;
        }

        #uploadInput {
            display: none;
        }
    </style>

    <div class="wrapper">
        {{-- <div class="main-content"> --}}
        <!-- Breadcrumb -->
        <div class="row d-flex justify-content-end mt-2">
            <div class="col-auto">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('ngo') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Distribute Facilities</li>
                    </ol>
                </nav>
            </div>
        </div>
        @if (session('success'))
            <div id="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <div class="container-fluide m-3">
            <div class="card bg-white p-2 shadow rounded">
                <div class="text-black text-center border-bottom pb-3">
                    <h4 class=" p-3 bg-info rounded"><b>BENEFICIARIE </b></h4>
                </div>
                <div class="card-body m-1">
                    <div class="border-bottom pb-3 mb-4">
                        <h5 class="text-black"><b>Information</b></h5>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="row d-flex justify-content-between">
                                    <!-- Application Date -->
                                    <div class="col-md-5 col-sm-6 form-group mb-3 bg-light">
                                        <label class="form-label">Application Date:</label>
                                        <p class="form-control-plaintext">{{ $beneficiarie->application_date }}</p>
                                    </div>

                                    <div class="col-md-5 col-sm-6 form-group mb-3 bg-light">
                                        <label class="form-label">Application No:</label>
                                        <p class="form-control-plaintext">{{ $beneficiarie->application_no }}</p>
                                    </div>

                                    <div class="col-md-5 col-sm-6 form-group mb-3 bg-light">
                                        <label class="form-label">Registration Date:</label>
                                        <p class="form-control-plaintext">{{ $beneficiarie->registration_date }}</p>
                                    </div>

                                    <div class="col-md-5 col-sm-6 form-group mb-3 bg-light">
                                        <label class="form-label">Registration No:</label>
                                        <p class="form-control-plaintext">{{ $beneficiarie->registration_no }}</p>
                                    </div>

                                    <!-- Full Name -->
                                    <div class="col-md-5 col-sm-6 form-group mb-3 bg-light">
                                        <label class="form-label">Full Name:</label>
                                        <p class="form-control-plaintext">{{ $beneficiarie->name }}</p>
                                    </div>

                                    <!-- Date of Birth -->
                                    <div class="col-md-5 col-sm-6 form-group mb-3 bg-light">
                                        <label class="form-label">Date of Birth:</label>
                                        <p class="form-control-plaintext">{{ $beneficiarie->dob }}</p>
                                    </div>
                                </div>

                                <div class="row d-flex justify-content-between">
                                    <!-- Gender -->
                                    <div class="col-md-5 col-sm-6 form-group mb-3 bg-light">
                                        <label class="form-label">Gender:</label>
                                        <p class="form-control-plaintext">{{ $beneficiarie->gender }}</p>
                                    </div>
                                     <div class="col-md-5 mb-3 bg-light">
                                <label class="form-label">Father/Husband Name:</label>
                                <p class="form-control-plaintext">{{ $beneficiarie->gurdian_name }}</p>
                            </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <div class="upload-container">
                                    @if (!empty($beneficiarie->image))
                                        <img id="previewImage"
                                            src="{{ asset('benefries_images/' . $beneficiarie->image) }}" alt="Preview"
                                            width="160">
                                    @endif
                                </div>
                            </div>

                        </div>
                        <div class="row d-flex justify-content-between">
                            <div class="col-md-3 form-group mb-3 bg-light">
                                <label class="form-label">Village/Locality:</label>
                                <p class="form-control-plaintext">{{ $beneficiarie->village }}</p>
                            </div>

                            <div class="col-md-3 form-group mb-3 bg-light">
                                <label class="form-label">Post/Town:</label>
                                <p class="form-control-plaintext">{{ $beneficiarie->post }}</p>
                            </div>

                            <div class="col-md-3 form-group mb-3 bg-light">
                                <label class="form-label">Area Type:</label>
                                <p class="form-control-plaintext">{{ $beneficiarie->area_type }}</p>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-between">
                            <div class="col-md-3 form-group mb-3 bg-light">
                                <label class="form-label">Block:</label>
                                <p class="form-control-plaintext">{{ $beneficiarie->block }}</p>
                            </div>

                            <div class="col-md-3 form-group mb-3 bg-light">
                                <label class="form-label">State:</label>
                                <p class="form-control-plaintext">{{ $beneficiarie->state }}</p>
                            </div>

                            <div class="col-md-3 form-group mb-3 bg-light">
                                <label class="form-label">District:</label>
                                <p class="form-control-plaintext">{{ $beneficiarie->district }}</p>
                            </div>
                        </div>
                        {{-- <div class="row d-flex justify-content-between">
                            <div class="col-md-3 form-group mb-3 bg-light">
                                <label class="form-label">Pincode:</label>
                                <p class="form-control-plaintext">{{ $beneficiarie->pincode }}</p>
                            </div>
                        </div> --}}
                    </div>

                </div>
            </div>
            <div class="card mt-4 p-3 border border-success rounded">
                <h5 class="text-success text-center">About Beneficiarie Survey & Facilities</h5>

                <div class="row">
                    @if ($beneficiarie->surveys)
                        {{-- @foreach ($beneficiarie->surveys as $survey) --}}
                        <div class="col-md-4 mb-3">
                            <div class="bg-light border rounded p-3 h-100">
                                <label class="form-label fw-bold">Survey Date:</label>
                                <p>{{ \Carbon\Carbon::parse($survey->survey_date)->format('d-m-Y') }}</p>
                            </div>
                        </div>
                        <div class="col-md-8 mb-3">

                            <div class="bg-light border rounded p-3 h-100">
                                <label class="form-label fw-bold">Survey Details:</label>
                                <p><strong>Details:</strong> {{ $survey->survey_details ?? 'Not Found' }}</p>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="bg-light border rounded p-3 h-100">
                                <label class="form-label fw-bold">Facilities Category:</label>
                                <p class="card-text"><strong>Category:</strong>
                                    {{ $survey->facilities_category ?? 'Not Found' }}</p>
                            </div>
                        </div>
                        <div class="col-md-8 mb-3">
                            <div class="bg-light border rounded p-3 h-100">
                                <label class="form-label fw-bold">Facilities Details:</label>
                                <p class="card-text"><strong>Facilities:</strong> {{ $survey->facilities ?? 'Not Found' }}
                                </p>
                            </div>
                        </div>

                        {{-- @endforeach --}}
                    @else
                        <div class="col-12">
                            <div class="alert alert-warning">No survey data available for this beneficiary.</div>
                        </div>
                </div>
                @endif
            </div>
            <div class="card mt-4 p-3 border border-success rounded">
                <form
                    action="{{ route('update-distribute-facilities', ['beneficiarie_id' => $beneficiarie->id, 'survey_id' => $survey->id]) }}"
                    method="POST">
                    @csrf
                    <h5 class="text-success text-center">Edit Distributed Beneficiary Facilities</h5>

                    <div class="mb-3">
                        <label for="distribute_date" class="form-label">
                            Distribute Date<span class="text-danger">*</span>
                        </label>
                        <input type="date" name="distribute_date" class="form-control"
                            value="{{ $survey->distribute_date }}">
                        @error('distribute_date')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="distribute_place" class="form-label">Distribute Place</label>
                        <textarea name="distribute_place" class="form-control">{{ $survey->distribute_place }}</textarea>
                        @error('distribute_place')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3 mt-1">
                        <label for="status" class="form-label">
                            Status <span class="text-danger">*</span>
                        </label>
                        <select name="status" id="status" class="form-control">
                            <option value="Pending" {{ $survey->status === 'Pending' ? 'selected' : '' }}>
                                Pending</option>
                            <option value="Distributed"
                                {{ $survey->status === 'Distributed' ? 'selected' : '' }}>Distributed</option>
                        </select>
                        @error('status')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3 mt-1" id="pendingDiv"
                        style="display: {{ $survey->status === 'Pending' ? 'block' : 'none' }}">
                        <label for="pending_reason" class="form-label">
                            Pending Reason: <span class="text-danger"></span>
                        </label>
                        <textarea name="pending_reason" id="pending_reason" class="form-control">{{ $survey->pending_reason }}</textarea>
                        @error('pending_reason')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-success">Update Beneficiary Facilities</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const statusSelect = document.getElementById('status');
            const PendingDiv = document.getElementById('pendingDiv');

            function togglePendingReason() {
                if (statusSelect.value === 'Pending') {
                    PendingDiv.style.display = 'block';
                } else {
                    PendingDiv.style.display = 'none';
                }
            }

            togglePendingReason();

            statusSelect.addEventListener('change', togglePendingReason);
        })
    </script>
@endsection
