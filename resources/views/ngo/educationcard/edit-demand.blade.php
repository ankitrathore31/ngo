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
            <h5 class="mb-0">Education Card</h5>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                    <li class="breadcrumb-record"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-record active" aria-current="page">Education Card</li>
                </ol>
            </nav>
        </div>

        @if (session('success'))
            <div id="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <div class="container-fluid mt-5">
            <!-- Language Toggle -->
            <div class="d-flex justify-content-between align-records-center mb-3 mt-4">
                <h5 class="mb-0">
                    <span>Edit Demand Education Card Facility </span>
                </h5>
                <div>
                    <button onclick="window.print()" class="btn btn-primary">Print </button>
                    {{-- <button class="btn btn-sm btn-outline-primary" onclick="setLanguage('en')">English</button>
                    <button class="btn btn-sm btn-outline-success" onclick="setLanguage('hi')">हिंदी</button> --}}
                </div>
            </div>
            <div class=" rounded print-card">
                <div class="">
                    <div>
                        <div class="p-2" s>
                            <div class="text-center mb-4 border-bottom pb-2">
                                <div class="row mb-2">
                                    <div class="col-sm-12">
                                        <h3><b>EDUCATION CARD</b></h3>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-2 text-center text-md-start">
                                        <img src="{{ asset('images/LOGO.png') }}" alt="Logo" width="150"
                                            height="140">
                                    </div>
                                    <div class="col-sm-8">
                                        <p style="margin: 0;" class="d-flex justify-content-around mb-2"><b>
                                                <span>NEETI AYOG ID NO. UP/2023/0360430</span>&nbsp;
                                                &nbsp; &nbsp;<span>NGO NO. UP/00033062</span>&nbsp; &nbsp;
                                                &nbsp; &nbsp;<span>PAN: AAEAG7650B</span>&nbsp;
                                            </b></p>
                                        <h3 class="P-2"><b>
                                                <span class="print-h4 p-2">GYAN BHARTI SANSTHA</span>
                                            </b></h3>
                                        <h5> <strong>
                                                <span>The Path To Peace And Development</span></strong></h5>
                                        <h6 style="color: blue;"><b>

                                                <span data-lang="en">Village - Kainchu Tanda, Post - Amaria, District -
                                                    Pilibhit, UP -
                                                    262121</span>
                                            </b></h6>
                                        <p style="font-size: 14px; margin: 0;">
                                            <b>
                                                <span>Website: www.gyanbhartingo.org | Email: gyanbhartingo600@gmail.com
                                                    | Mob:
                                                    9411484111</span>
                                            </b>
                                        </p>
                                    </div>
                                    <div class="col-sm-2 text-center text-md-start">
                                        {{-- <img src="{{ asset('images/plu.png') }}" alt="Logo" width="120"
                                            height="130"> --}}
                                    </div>
                                </div>
                            </div>
                            <div class="row d-flex justify-content-center">
                                <div class="col-sm-4 mb-2">
                                    <p class="text-center fw-bold p-2">

                                    </p>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-6 mb-3">
                                    <h4><b>Education Card No:</b> <b>{{ $card->card_no }}</b></h4>
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <strong>Education Card Registraition Date:</strong>
                                    {{ \Carbon\Carbon::parse($card->education_registration_date)->format('d-m-Y') }}
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

                                <div class="col-sm-6 mb-3">
                                    <strong>Beneficiaries ID No:</strong> {{ $record->identity_no }}
                                </div>

                                <div class="col-sm-12 mb-3">
                                    <strong>Student Name:</strong>
                                    @if (!empty($card->students))
                                        @foreach ($card->students as $student)
                                            {{ $loop->iteration }}. {{ $student }}@if (!$loop->last)
                                                ,
                                            @endif
                                        @endforeach
                                    @endif
                                </div>

                                <div class="col-sm-12 mb-3">
                                    <strong>School / Instituion / Tuition / Teacher Name:</strong>

                                    @if (!empty($card->school_name))
                                        @foreach ($card->school_name as $index => $SchoolCode)
                                            @php
                                                $school = \App\Models\School::getByCode($SchoolCode);
                                            @endphp

                                            @if ($school)
                                                <div class="col-12 mt-1">
                                                    {{ $index + 1 }}.
                                                    {{ $school->school_name }},
                                                    {{ $school->address }},
                                                    {{ $school->principle_name }},
                                                    {{ $school->contact_number }}
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
            <div class="card">
                <div class="card-header">
                    <h5>Edit Education Demand Facility</h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('demand.education.facility.update', $facility->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="card_id" value="{{ $card->id }}">
                        <input type="hidden" name="reg_id" value="{{ $record->id }}">

                        <div class="row">

                            <!-- Fees Type -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Type Of Student Fees</label>
                                <select name="fees_type" class="form-control" required>
                                    <option value="">-- Select Type --</option>
                                    <option value="School" {{ $facility->fees_type == 'School' ? 'selected' : '' }}>School
                                    </option>
                                    <option value="Coaching" {{ $facility->fees_type == 'Coaching' ? 'selected' : '' }}>
                                        Coaching</option>
                                    <option value="Book Shop"{{ $facility->fees_type == 'Book Shop' ? 'selected' : '' }}>
                                        Book Shop</option>
                                    <option value="Teacher" {{ $facility->fees_type == 'Teacher' ? 'selected' : '' }}>
                                        Teacher</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label for="school">School / Coaching / Bookshop / Teacher</label>
                                <select name="school" id="school" class="form-control">
                                    <option value="">Select School</option>
                                    @foreach ($schools as $school)
                                        <option value="{{ $school->school_code }}"
                                            {{ isset($facility) && $facility->school == $school->school_code ? 'selected' : '' }}>
                                            {{ $school->school_name }} ({{ $school->school_code }}),
                                            {{ $school->principal_name }}, {{ $school->address }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>


                            <!-- Registration No -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Registration No / SR No</label>
                                <input type="text" name="registration_no" class="form-control"
                                    value="{{ $facility->registration_no }}" required>
                            </div>

                            <!-- Fees Slip No -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Fees Slip No</label>
                                <input type="text" name="fees_slip_no" class="form-control"
                                    value="{{ $facility->fees_slip_no }}" required>
                            </div>

                            <!-- Submit Date -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Fees Submit Date</label>
                                <input type="date" name="fees_submit_date" id="fees_submit_date" class="form-control"
                                    value="{{ $facility->fees_submit_date }}" required>
                                <small id="dateError" class="text-danger d-none">
                                    Warning - Please enter a date within the next 30 days.
                                </small>
                            </div>

                            <!-- Fees Amount -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Total Fees Amount</label>
                                <input type="number" name="fees_amount" class="form-control"
                                    value="{{ $facility->fees_amount }}" required>
                            </div>

                            <!-- Slip Upload -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Fees Slip Upload</label>
                                <input type="file" name="slip" class="form-control">

                                @if ($facility->slip)
                                    <small class="d-block mt-1">
                                        Current Slip:
                                        <a href="{{ asset($facility->slip) }}" target="_blank">
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

        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const dateInput = document.getElementById('fees_submit_date');
            const errorMsg = document.getElementById('dateError');
            const form = dateInput.closest('form');

            dateInput.addEventListener('change', validateDate);
            form.addEventListener('submit', function(e) {
                if (!validateDate()) {
                    e.preventDefault();
                }
            });

            function validateDate() {
                if (!dateInput.value) return false;

                const selectedDate = new Date(dateInput.value);
                const currentDate = new Date();

                // Remove time part
                selectedDate.setHours(0, 0, 0, 0);
                currentDate.setHours(0, 0, 0, 0);

                // Calculate date 30 days from now
                const maxDate = new Date(currentDate);
                maxDate.setDate(maxDate.getDate() + 30);

                if (selectedDate < currentDate || selectedDate > maxDate) {
                    errorMsg.classList.remove('d-none');
                    dateInput.classList.add('is-invalid');
                    return false;
                } else {
                    errorMsg.classList.add('d-none');
                    dateInput.classList.remove('is-invalid');
                    return true;
                }
            }
        });
    </script>
@endsection
