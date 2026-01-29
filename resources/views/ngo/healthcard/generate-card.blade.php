@extends('ngo.layout.master')
@section('content')
    <style>
        .print-red-bg {
            background-color: red !important;
            /* Bootstrap 'bg-danger' color */
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
            color: white !important;

        }

        .print-h4 {
            background-color: red !important;
            color: white !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
            font-size: 28px;
            word-spacing: 20px;
            text-align: center;
        }

        .flag-border {
            border: 8px solid;
            border-image: linear-gradient(to right, #FF9933 33%, , #138808 66%) 1;
            padding: 15px;
            border-radius: 10px;
            text-align: center;
        }

        @media print {
            body * {
                visibility: hidden;
                font-size: 12px;

            }

            .print-card,
            .print-card * {
                visibility: visible;
            }

            .print-card {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                max-width: 510mm;
                /* A4 width */
                padding: 10mm;
                /* Print-friendly padding */
                box-sizing: border-box;
            }

            html,
            body {
                width: 510mm;
                height: auto;
                margin: 0;
                padding: 0;
                overflow: hidden;
            }

            .print-red-bg {
                background-color: red !important;
                /* Bootstrap 'bg-danger' color */
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
                color: white !important;

            }

            .print-h4 {
                background-color: red !important;
                color: white !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
                font-size: 28px;
                word-spacing: 20px;
                text-align: center;
            }

            .flag-border {
                border: 8px solid;
                border-image: linear-gradient(to right, #FF9933 33%, #138808 66%) 1;
                padding: 15px;
                border-radius: 10px;
                text-align: center;
            }

            @page {
                size: A4;
                margin: 15mm;
            }


            /* Optional: Hide any interactive or irrelevant UI */
            button,
            .btn,
            .no-print {
                display: none !important;
            }
        }
    </style>
    <div class="wrapper">
                    <div class="row mb-3 mt-4">
                @php
                    $user = auth()->user();
                    $isStaff = $user && $user->user_type === 'staff';
                @endphp
                <div class="col-12">
                    <div class="d-flex flex-wrap gap-1">

                        @if (!$isStaff || $user->hasPermission('healthfacility_add_disease'))
                            <a href="{{ route('add.disease') }}" class="btn btn-sm btn-primary">
                                Add Disease
                            </a>
                        @endif

                        @if (!$isStaff || $user->hasPermission('healthfacility_hospital_list'))
                            <a href="{{ route('list.hospital') }}" class="btn btn-sm btn-primary">
                                Hospital List
                            </a>
                        @endif

                        @if (!$isStaff || $user->hasPermission('healthfacility_healthcard_generate'))
                            <a href="{{ route('generatelist.healthcard') }}" class="btn btn-sm btn-primary">
                                Health Card Generate
                            </a>
                        @endif

                        @if (!$isStaff || $user->hasPermission('healthfacility_healthcard_list'))
                            <a href="{{ route('list.healthcard') }}" class="btn btn-sm btn-primary">
                                Health Card List
                            </a>
                        @endif

                        @if (!$isStaff || $user->hasPermission('healthfacility_demand'))
                            <a href="{{ route('list.demandfacility') }}" class="btn btn-sm btn-warning text-dark">
                                Demand Facility
                            </a>
                        @endif

                        @if (!$isStaff || $user->hasPermission('healthfacility_pending'))
                            <a href="{{ route('list.pendingfacility') }}" class="btn btn-sm btn-info text-white">
                                Facility Pending
                            </a>
                        @endif

                        @if (!$isStaff || $user->hasPermission('healthfacility_bill_investigation'))
                            <a href="{{ route('list.Investigationfacility') }}" class="btn btn-sm btn-secondary">
                                Bill Investigation
                            </a>
                        @endif

                        @if (!$isStaff || $user->hasPermission('healthfacility_bill_verify'))
                            <a href="{{ route('list.Verifyhealthfacility') }}" class="btn btn-sm btn-secondary">
                                Bill Verify
                            </a>
                        @endif

                        @if (!$isStaff || $user->hasPermission('healthfacility_demand_approve'))
                            <a href="{{ route('list.Approvalhealthfacility') }}" class="btn btn-sm btn-success">
                                Demand Approve
                            </a>
                        @endif

                        @if (!$isStaff || $user->hasPermission('healthfacility_final_approve'))
                            <a href="{{ route('list.Approvehealthfacility') }}" class="btn btn-sm btn-success">
                                Final Approve
                            </a>
                        @endif

                        @if (!$isStaff || $user->hasPermission('healthfacility_reject'))
                            <a href="{{ route('list.Rejecthealthfacility') }}" class="btn btn-sm btn-danger">
                                Reject Facility
                            </a>
                        @endif

                        @if (!$isStaff || $user->hasPermission('healthfacility_pending_demand'))
                            <a href="{{ route('list.DemandPendinghealthfacility') }}"
                                class="btn btn-sm btn-warning text-dark">
                                Pending Demand
                            </a>
                        @endif

                        @if (!$isStaff || $user->hasPermission('healthfacility_non_budget'))
                            <a href="{{ route('list.NonBudgethealthfacility') }}" class="btn btn-sm btn-dark">
                                Non-Budget
                            </a>
                        @endif

                    </div>
                </div>
            </div>
        <div class="d-flex justify-content-between align-record-centre mb-0 mt-4">
            <h5 class="mb-0">Generate Health Card</h5>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                    <li class="breadcrumb-record"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-record active" aria-current="page">Health Card</li>
                </ol>
            </nav>
        </div>
        @if (session('success'))
            <div id="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <div class="container-fluid mt-3">
            <div class=" rounded print-card">
                <div class="">
                    <div>
                        <div class="p-2">
                            <div class="row mb-3">
                                <div class="col-sm-4 mb-3">
                                    <strong>Registraition No:</strong> {{ $record->registration_no }}
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <strong>Registraition Date:</strong>
                                    {{ \Carbon\Carbon::parse($record->registraition_date)->format('d-m-Y') }}
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <strong>Registraition Type:</strong> {{ $record->reg_type }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="row">
                                        <div class="col-sm-6 mb-3">
                                            <strong>Name:</strong> {{ $record->name }}
                                        </div>
                                        <div class="col-sm-6 mb-3">
                                            <strong>Father / Husband's Name:</strong> {{ $record->gurdian_name }}
                                        </div>
                                        <div class="col-sm-6 mb-3">
                                            <strong>Gender:</strong> {{ $record->gender }}
                                        </div>
                                        <div class="col-sm-6 mb-3">
                                            <strong>Date of Birth:</strong>
                                            {{ \Carbon\Carbon::parse($record->dob)->format('d-m-Y') }}
                                        </div>
                                        <div class="col-sm-12 mb-3">
                                            <strong>Address: </strong>
                                            {{ $record->village }},
                                            {{ $record->post }},
                                            {{ $record->block }},
                                            {{ $record->district }},
                                            {{ $record->state }} - {{ $record->pincode }},({{ $record->area_type }})
                                        </div>
                                        <div class="col-sm-6 mb-3">
                                            <strong>Phone:</strong> {{ $record->phone }}
                                        </div>
                                        <div class="col-sm-6 mb-3">
                                            <strong>Marital Status:</strong> {{ $record->marital_status }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    @php
                                        $imagePath =
                                            $record->reg_type === 'Member' ? 'member_images/' : 'benefries_images/';
                                    @endphp
                                    {{-- @if ($record->image) --}}
                                    <div class=" mb-3">
                                        <img src="{{ asset($imagePath . $record->image) }}" alt="Image"
                                            class="img-thumbnail" width="150" style="max-width: 250">
                                        {{-- <br>
                                    <strong class="text-center"> Image:</strong> --}}
                                    </div>
                                    {{-- @endif --}}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4 mb-3">
                                    <strong>Caste:</strong> {{ $record->caste }}
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <strong>Caste Category:</strong> {{ $record->religion_category }}
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <strong>Religion:</strong> {{ $record->religion }}
                                </div>

                                <div class="col-sm-4 mb-3">
                                    <strong>Occupation:</strong> {{ $record->occupation }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="conatiner mt-2">
                <div class="card-body shadow-sm">
                    <div class="row">
                        <div class="col">
                            <form method="POST" action="{{ route('healthcard.store') }}">
                                @csrf
                                <div class="row">

                                    <input type="text" class="form-control" value="{{ $record->id }}" name="reg_id"
                                        hidden>

                                    <div class="col-md-6 mb-2">
                                        <label>Health Card No</label>
                                        <input type="text" class="form-control"
                                            value="{{ $healthcard->healthcard_no ?? $nextCard }}" name="healthcard_no"
                                            readonly>
                                    </div>

                                    <div class="col-md-6 mb-2">
                                        <label>Health Card Registration Date</label>
                                        <input type="date" name="Health_registration_date" class="form-control">
                                    </div>

                                    <div class="col-md-6 mb-2">
                                        <label>Hospital</label>
                                        <select id="hospitalSelect" class="form-control">
                                            <option value="">Select Hospital</option>
                                            @foreach ($hospitals as $hospital)
                                                <option value="{{ $hospital->hospital_code }}">
                                                    {{ $hospital->hospital_name }} ({{ $hospital->hospital_code }}), {{ $hospital->operator_name }}, {{ $hospital->address }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6 mt-3">
                                        <div id="selectedHospitals" class="d-flex flex-wrap gap-2"></div>
                                    </div>


                                    <div class="col-md-6 mb-2">
                                        <label>Disease</label>
                                        <select id="diseaseSelect" class="form-control">
                                            <option value="">Select Disease</option>
                                            @foreach ($diseases as $d)
                                                <option value="{{ $d->disease }}">{{ $d->disease }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6 mt-3">
                                        <div id="selectedDiseases" class="d-flex flex-wrap gap-2"></div>
                                    </div>

                                    <div class="col-md-12 mt-3">
                                        <button class="btn btn-success">
                                            Save
                                        </button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            /* ---------- Initial Data (Edit Mode Support) ---------- */
            let selectedDiseases = @json($healthcard->diseases ?? []);
            let selectedHospitals = @json($healthcard->hospital_name ?? []);

            /* ---------- Generic Render Function ---------- */
            function renderTags(containerId, items, inputName, removeFn) {
                const box = document.getElementById(containerId);
                box.innerHTML = '';

                items.forEach(val => {
                    const tag = document.createElement('div');
                    tag.className = 'badge bg-primary d-flex align-items-center me-2 mb-2';

                    tag.innerHTML = `
                <span class="me-2">${val}</span>
                <button type="button" class="btn btn-sm btn-light"
                    onclick="${removeFn}('${val}')">&times;</button>
                <input type="hidden" name="${inputName}[]" value="${val}">
            `;

                    box.appendChild(tag);
                });
            }

            /* ---------- Disease ---------- */
            document.getElementById('diseaseSelect').addEventListener('change', function() {
                if (this.value && !selectedDiseases.includes(this.value)) {
                    selectedDiseases.push(this.value);
                    renderTags('selectedDiseases', selectedDiseases, 'diseases', 'removeDisease');
                }
                this.value = '';
            });

            function removeDisease(val) {
                selectedDiseases = selectedDiseases.filter(v => v !== val);
                renderTags('selectedDiseases', selectedDiseases, 'diseases', 'removeDisease');
            }

            /* ---------- Hospital ---------- */
            document.getElementById('hospitalSelect').addEventListener('change', function() {
                if (this.value && !selectedHospitals.includes(this.value)) {
                    selectedHospitals.push(this.value);
                    renderTags('selectedHospitals', selectedHospitals, 'hospital_name', 'removeHospital');
                }
                this.value = '';
            });

            function removeHospital(val) {
                selectedHospitals = selectedHospitals.filter(v => v !== val);
                renderTags('selectedHospitals', selectedHospitals, 'hospital_name', 'removeHospital');
            }

            /* ---------- Initial Render ---------- */
            renderTags('selectedDiseases', selectedDiseases, 'diseases', 'removeDisease');
            renderTags('selectedHospitals', selectedHospitals, 'hospital_name', 'removeHospital');
        </script>
    @endsection
