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
            <h5 class="mb-0">Edit Education Card</h5>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                    <li class="breadcrumb-person"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-person active" aria-current="page">Education Card</li>
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
                                    <strong>Registraition No:</strong> {{ $person->registration_no }}
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <strong>Registraition Date:</strong>
                                    {{ \Carbon\Carbon::parse($person->registraition_date)->format('d-m-Y') }}
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

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container mt-2">
                <div class="card-body shadow-sm">
                    <div class="row">
                        <div class="col">
                            <form method="POST" action="{{ route('educationcard.upate', $educationCard->id) }}">
                                @csrf

                                <input type="hidden" name="reg_id" value="{{ $educationCard->reg_id }}">

                                <div class="row">

                                    {{-- Education Card No --}}
                                    <div class="col-md-6 mb-2">
                                        <label>Education Card No</label>
                                        <input type="text" class="form-control"
                                            value="{{ $educationCard->educationcard_no }}" name="educationcard_no"
                                            readonly>
                                    </div>

                                    {{-- Registration Date --}}
                                    <div class="col-md-6 mb-2">
                                        <label>Education Card Registration Date</label>
                                        <input type="date" name="education_registration_date"
                                            class="form-control @error('education_registration_date') is-invalid @enderror"
                                            value="{{ old('education_registration_date', $educationCard->education_registration_date) }}">
                                        @error('education_registration_date')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    {{-- School Select --}}
                                    <div class="col-md-6 mb-2">
                                        <label>School</label>
                                        <select id="schoolSelect" class="form-control">
                                            <option value="">Select School</option>
                                            @foreach ($schools as $school)
                                                <option value="{{ $school->school_code }}">
                                                    {{ $school->school_name }} ({{ $school->school_code }})
                                                </option>
                                            @endforeach
                                        </select>

                                    </div>

                                    {{-- Selected Schools --}}
                                    <div class="col-md-6 mt-3">
                                        <div id="selectedSchools" class="d-flex flex-wrap gap-2">
                                            @foreach ($educationCard->school_name ?? [] as $schoolCode)
                                                <span class="badge bg-primary">
                                                    {{ $schoolCode }}
                                                    <input type="hidden" name="school_name[]" value="{{ $schoolCode }}">
                                                </span>
                                            @endforeach
                                        </div>

                                    </div>

                                    <div class="col-md-6 mb-2">
                                        <label>Student</label>
                                        <input type="text" id="studentInput" class="form-control"
                                            placeholder="Type student name and press Enter">
                                    </div>


                                    <div class="col-md-6 mt-3">
                                        <div id="selectedStudents" class="d-flex flex-wrap gap-2">
                                            @foreach ($educationCard->students ?? [] as $studentName)
                                                <span class="badge bg-success d-flex align-items-center me-2 mb-2"
                                                    data-value="{{ $studentName }}">
                                                    <span class="me-2">{{ $studentName }}</span>
                                                    <button type="button" class="btn btn-sm btn-light"
                                                        onclick="removeStudent('{{ $studentName }}')">&times;</button>
                                                    <input type="hidden" name="students[]" value="{{ $studentName }}">
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>


                                    <div class="col-md-12 mt-3">
                                        <button class="btn btn-success">
                                            Update
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
            /* ---------- Initial Data (Edit Mode) ---------- */
            let selectedStudents = @json($educationCard->students ?? []);
            let selectedSchools = @json($educationCard->school_name ?? []);

            /* ---------- Generic Render Function ---------- */
            function renderTags(containerId, items, inputName, removeFn, badgeClass = 'bg-primary') {
                const box = document.getElementById(containerId);
                box.innerHTML = '';

                items.forEach(val => {
                    const tag = document.createElement('div');
                    tag.className = `badge ${badgeClass} d-flex align-items-center me-2 mb-2`;

                    tag.innerHTML = `
                <span class="me-2">${val}</span>
                <button type="button"
                        class="btn btn-sm btn-light"
                        onclick="${removeFn}('${val.replace(/'/g, "\\'")}')">&times;</button>
                <input type="hidden" name="${inputName}[]" value="${val}">
            `;

                    box.appendChild(tag);
                });
            }

            /* ---------- STUDENT HANDLING (TEXT INPUT) ---------- */
            const studentInput = document.getElementById('studentInput');

            studentInput.addEventListener('keydown', function(e) {
                if (e.key !== 'Enter') return;

                e.preventDefault();
                const value = this.value.trim();
                if (!value) return;

                // Case-insensitive duplicate check
                const exists = selectedStudents.some(
                    v => v.toLowerCase() === value.toLowerCase()
                );

                if (!exists) {
                    selectedStudents.push(value);
                    renderTags(
                        'selectedStudents',
                        selectedStudents,
                        'students',
                        'removeStudent',
                        'bg-success'
                    );
                }

                this.value = '';
            });

            function removeStudent(val) {
                selectedStudents = selectedStudents.filter(
                    v => v.toLowerCase() !== val.toLowerCase()
                );

                renderTags(
                    'selectedStudents',
                    selectedStudents,
                    'students',
                    'removeStudent',
                    'bg-success'
                );
            }

            /* ---------- SCHOOL HANDLING (SELECT - UNCHANGED) ---------- */
            document.getElementById('schoolSelect').addEventListener('change', function() {
                if (this.value && !selectedSchools.includes(this.value)) {
                    selectedSchools.push(this.value);
                    renderTags(
                        'selectedSchools',
                        selectedSchools,
                        'schools',
                        'removeSchool'
                    );
                }
                this.value = '';
            });

            function removeSchool(val) {
                selectedSchools = selectedSchools.filter(v => v !== val);
                renderTags(
                    'selectedSchools',
                    selectedSchools,
                    'schools',
                    'removeSchool'
                );
            }

            /* ---------- Initial Render ---------- */
            renderTags(
                'selectedStudents',
                selectedStudents,
                'students',
                'removeStudent',
                'bg-success'
            );

            renderTags(
                'selectedSchools',
                selectedSchools,
                'schools',
                'removeSchool'
            );
        </script>
    @endsection
