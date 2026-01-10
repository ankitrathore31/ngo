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
            <h5 class="mb-0">Generate Education Card</h5>
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
                            <form method="POST" action="{{ route('educationcard.store') }}">
                                @csrf

                                <input type="hidden" name="reg_id" value="{{ $record->id }}">

                                <div class="row">

                                    <div class="col-md-6 mb-2">
                                        <label>Education Card No</label>
                                        <input type="text" class="form-control" value="{{ $educationcard_no }}"
                                            name="educationcard_no" readonly>
                                    </div>

                                    <div class="col-md-6 mb-2">
                                        <label>Education Card Registration Date</label>
                                        <input type="date" name="education_registration_date" class="form-control">
                                    </div>

                                    <!-- School Select -->
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

                                    <div class="col-md-6 mt-3">
                                        <div id="selectedSchools" class="d-flex flex-wrap gap-2"></div>
                                    </div>

                                    <div class="col-md-6 mb-2">
                                        <label>Student</label>
                                        <select id="studentSelect" class="form-control">
                                            <option value="">Select Student</option>
                                            @foreach ($students as $student)
                                                <option value="{{ $student->student_name }}">
                                                    {{ $student->student_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6 mt-3">
                                        <div id="selectedStudents" class="d-flex flex-wrap gap-2"></div>
                                    </div>


                                    <div class="col-md-12 mt-3">
                                        <button class="btn btn-success">Save</button>
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
            let selectedStudents = @json($educationCard->students ?? []);
            let selectedSchools = @json($educationCard->school_name ?? []);

            /* ---------- Generic Render Function ---------- */
            function renderTags(containerId, items, inputName, removeFn) {
                const box = document.getElementById(containerId);
                box.innerHTML = '';

                items.forEach(val => {
                    const tag = document.createElement('div');
                    tag.className = 'badge bg-primary d-flex align-items-center me-2 mb-2';

                    tag.innerHTML = `
                <span class="me-2">${val}</span>
                <button type="button"
                        class="btn btn-sm btn-light"
                        onclick="${removeFn}('${val}')">&times;</button>
                <input type="hidden" name="${inputName}[]" value="${val}">
            `;

                    box.appendChild(tag);
                });
            }

            /* ---------- Student ---------- */
            document.getElementById('studentSelect').addEventListener('change', function() {
                if (this.value && !selectedStudents.includes(this.value)) {
                    selectedStudents.push(this.value);
                    renderTags('selectedStudents', selectedStudents, 'students', 'removeStudent');
                }
                this.value = '';
            });

            function removeStudent(val) {
                selectedStudents = selectedStudents.filter(v => v !== val);
                renderTags('selectedStudents', selectedStudents, 'students', 'removeStudent');
            }

            /* ---------- School ---------- */
            document.getElementById('schoolSelect').addEventListener('change', function() {
                if (this.value && !selectedSchools.includes(this.value)) {
                    selectedSchools.push(this.value);
                    renderTags('selectedSchools', selectedSchools, 'school_name', 'removeSchool');
                }
                this.value = '';
            });

            function removeSchool(val) {
                selectedSchools = selectedSchools.filter(v => v !== val);
                renderTags('selectedSchools', selectedSchools, 'school_name', 'removeSchool');
            }

            /* ---------- Initial Render ---------- */
            renderTags('selectedStudents', selectedStudents, 'students', 'removeStudent');
            renderTags('selectedSchools', selectedSchools, 'school_name', 'removeSchool');
        </script>
    @endsection
