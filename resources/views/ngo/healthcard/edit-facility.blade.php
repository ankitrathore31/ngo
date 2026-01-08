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
        <div class="d-flex justify-content-between align-person-centre mb-0 mt-4">
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
            <h5 class="mb-0">Edit Health Facility</h5>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                    <li class="breadcrumb-person"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-person active" aria-current="page">Health Card</li>
                </ol>
            </nav>
        </div>
        @if (session('success'))
            <div id="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <div class="container-fluid mt-5">
            <div class=" rounded print-card">
                <div>
                    <div>
                        <div class="p-2">
                            <div class="row mb-3">
                                <div class="col-sm-6 mb-3">
                                    <h4><b>Health Card No:</b> <b>{{ $card->healthcard_no }}</b></h4>
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <strong>Beneficiaries ID No:</strong> {{ $person->identity_no }}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4 mb-3">
                                    <strong>Registraition No:</strong> {{ $person->registration_no }}
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <strong>Registraition Date:</strong>
                                    {{ \Carbon\Carbon::parse($person->registration_date)->format('d-m-Y') }}
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <strong>Registraition Type:</strong> {{ $person->reg_type }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="row">
                                        <div class="col-sm-6 mb-3">
                                            <strong>Name:</strong> {{ $person->name }}
                                        </div>
                                        <div class="col-sm-6 mb-3">
                                            <strong>Father / Husband's Name:</strong> {{ $person->gurdian_name }}
                                        </div>
                                        <div class="col-sm-6 mb-3">
                                            <strong>Gender:</strong> {{ $person->gender }}
                                        </div>
                                        <div class="col-sm-6 mb-3">
                                            <strong>Date of Birth:</strong>
                                            {{ \Carbon\Carbon::parse($person->dob)->format('d-m-Y') }}
                                        </div>
                                        <div class="col-sm-12 mb-3">
                                            <strong>Address: </strong>
                                            {{ $person->village }},
                                            {{ $person->post }},
                                            {{ $person->block }},
                                            {{ $person->district }},
                                            {{ $person->state }} - {{ $person->pincode }},({{ $person->area_type }})
                                        </div>
                                        <div class="col-sm-6 mb-3">
                                            <strong>Phone:</strong> {{ $person->phone }}
                                        </div>
                                        <div class="col-sm-6 mb-3">
                                            <strong>Marital Status:</strong> {{ $person->marital_status }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    @php
                                        $imagePath =
                                            $person->reg_type === 'Member' ? 'member_images/' : 'benefries_images/';
                                    @endphp

                                    {{-- @if ($person->image) --}}
                                    <div class=" mb-3">
                                        <img src="{{ asset($imagePath . $person->image) }}" alt="Image"
                                            class="img-thumbnail" width="150" style="max-width: 250">
                                        {{-- <br>
                                    <strong class="text-center"> Image:</strong> --}}
                                    </div>
                                    {{-- @endif --}}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4 mb-3">
                                    <strong>Caste:</strong> {{ $person->caste }}
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <strong>Caste Category:</strong> {{ $person->religion_category }}
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <strong>Religion:</strong> {{ $person->religion }}
                                </div>

                                <div class="col-sm-4 mb-3">
                                    <strong>Occupation:</strong> {{ $person->occupation }}
                                </div>

                                @if ($person->reg_type == 'Beneficiaries')
                                    <div class="col-sm-4 mb-3">
                                        <strong>What do the beneficiaries need?:</strong> {{ $person->help_needed }}
                                    </div>
                                @endif

                                <div class="col-sm-12 mb-3">
                                    <strong>Health Facility/Disease Name:</strong>
                                    {{ implode(', ', $card->diseases ?? []) }}
                                </div>

                                <div class="col-sm-12 mb-3">
                                    <strong>Hospital / Clinic / Medical / Doctor Name:</strong>

                                    @if (!empty($card->hospital_name))
                                        @foreach ($card->hospital_name as $index => $hospitalCode)
                                            @php
                                                $hospital = \App\Models\HealthCard::hospital($hospitalCode);
                                            @endphp

                                            @if ($hospital)
                                                <div class="col-12 mt-1">
                                                    {{ $index + 1 }}.
                                                    {{ $hospital->hospital_name }}
                                                    {{ $hospital->address }}
                                                    {{ $hospital->operator_name }}
                                                    {{ $hospital->contact_number }}
                                                </div>
                                            @endif
                                        @endforeach
                                    @endif
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container mt-4">
            <div class="card-body">
                <form action="{{ route('health.facility.update', $facility->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="card_id" value="{{ $facility->card_id }}">
                    <input type="hidden" name="reg_id" value="{{ $facility->reg_id }}">

                    <div class="row">

                        {{-- Type of Treatment --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Type of Treatment</label>
                            <select name="treatment_type" class="form-control" required>
                                <option value="">Select</option>
                                <option value="treatment_start"
                                    {{ $facility->treatment_type === 'treatment_start' ? 'selected' : '' }}>
                                    Treatment Start
                                </option>
                                <option value="treatment_end"
                                    {{ $facility->treatment_type === 'treatment_end' ? 'selected' : '' }}>
                                    Treatment End
                                </option>
                            </select>
                        </div>

                        {{-- Hospital --}}
                        <div class="col-md-6 mb-3">
                            <label>Hospital</label>
                            <select name="hospital_name" class="form-control" required>
                                <option value="">Select Hospital</option>
                                @foreach ($hospitals as $hospital)
                                    <option value="{{ $hospital->hospital_name }} ({{ $hospital->hospital_code }})"
                                        {{ $facility->hospital_name === $hospital->hospital_name . ' (' . $hospital->hospital_code . ')' ? 'selected' : '' }}>
                                        {{ $hospital->hospital_name }} ({{ $hospital->hospital_code }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Bill No --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Bill No</label>
                            <input type="text" name="bill_no" value="{{ old('bill_no', $facility->bill_no) }}"
                                class="form-control" required>
                        </div>

                        {{-- Bill Date --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Bill Date</label>
                            <input type="date" name="bill_date" value="{{ old('bill_date', $facility->bill_date) }}"
                                class="form-control" required>
                        </div>

                        {{-- Bill GST --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Bill GST</label>
                            <input type="text" name="bill_gst" value="{{ old('bill_gst', $facility->bill_gst) }}"
                                class="form-control">
                        </div>

                        {{-- Bill Amount --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Bill Amount</label>
                            <input type="text" name="bill_amount"
                                value="{{ old('bill_amount', $facility->bill_amount) }}" class="form-control" required>
                        </div>

                        {{-- Bill Upload --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Bill Upload</label>
                            <input type="file" name="bill_upload" class="form-control">

                            @if ($facility->bill_upload)
                                <small class="d-block mt-1">
                                    Existing File:
                                    <a href="{{ asset($facility->bill_upload) }}" target="_blank">
                                        View
                                    </a>
                                </small>
                            @endif
                        </div>
                        

                    </div>

                    <button type="submit" class="btn btn-primary">
                        Update
                    </button>

                </form>
            </div>
        </div>

    @endsection
