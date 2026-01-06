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
        <div class="d-flex justify-content-between align-record-centre mb-0 mt-4">
            <h5 class="mb-0">Demand Health Facility</h5>
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
        @if (session('warning'))
            <div class="alert alert-warning">
                {{ session('warning') }}
            </div>
        @endif

        <div class="container-fluid mt-5">
            <div class=" rounded print-card">
                <div>
                    <div>
                        <div class="p-2">
                            <div class="row mb-3">
                                <div class="col-sm-6 mb-3">
                                    <h4><b>Health Card No:</b> <b>{{ $healthCard->healthcard_no }}</b></h4>
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <strong>Beneficiaries ID No:</strong> {{ $record->identity_no }}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4 mb-3">
                                    <strong>Registraition No:</strong> {{ $record->registration_no }}
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <strong>Registraition Date:</strong>
                                    {{ \Carbon\Carbon::parse($record->registration_date)->format('d-m-Y') }}
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

                                @if ($record->reg_type == 'Beneficiaries')
                                    <div class="col-sm-4 mb-3">
                                        <strong>What do the beneficiaries need?:</strong> {{ $record->help_needed }}
                                    </div>
                                @endif

                                <div class="col-sm-12 mb-3">
                                    <strong>Health Facility/Disease Name:</strong>
                                    {{ implode(', ', $healthCard->diseases ?? []) }}
                                </div>

                                <div class="col-sm-12 mb-3">
                                    <strong>Hospital / Clinic / Medical / Doctor Name:</strong>

                                    @if (!empty($healthCard->hospital_name))
                                        @foreach ($healthCard->hospital_name as $index => $hospitalCode)
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
                <form action="{{ route('health.facility.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        {{-- Type of Treatment --}}
                        <input type="text" name="card_id" value="{{ $healthCard->id }}" hidden>
                        <input type="text"name="reg_id" value="{{ $record->id }}" hidden>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Type of Treatment</label>
                            <select name="treatment_type" class="form-control">
                                <option value="">Select</option>
                                <option value="treatment_start">Treatment Start</option>
                                <option value="treatment_end">Treatment End</option>
                            </select>
                        </div>

                        {{-- Hospital / Clinic / Medical Name --}}
                        <div class="col-md-6 mb-2">
                            <label>Hospital</label>
                            <select name="hospital_name" class="form-control" required>
                                <option value="">Select Hospital</option>
                                @foreach ($hospitals as $hospital)
                                    <option value="{{ $hospital->hospital_name }} ({{ $hospital->hospital_code }})"
                                        {{ isset($healthcard) && $healthcard->hospital_name == $hospital->hospital_name ? 'selected' : '' }}>
                                        {{ $hospital->hospital_name }}({{ $hospital->hospital_code }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Bill No --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Bill No</label>
                            <input type="text" name="bill_no" class="form-control">
                        </div>

                        {{-- Bill Date --}}
                        {{-- Bill Date --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Bill Date</label>
                            <input type="date" name="bill_date" class="form-control">

                            <small class="text-danger">
                                Please submit the bill for only one month with the current date.
                            </small>
                        </div>

                        {{-- Bill GST --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Bill GST</label>
                            <input type="text" name="bill_gst" class="form-control">
                        </div>

                        {{-- Bill Amount --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Bill Amount</label>
                            <input type="text" name="bill_amount" class="form-control">
                        </div>

                        {{-- Bill Upload --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Bill Upload</label>
                            <input type="file" name="bill_upload" class="form-control">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        Submit
                    </button>

                </form>
            </div>
        </div>
    @endsection
