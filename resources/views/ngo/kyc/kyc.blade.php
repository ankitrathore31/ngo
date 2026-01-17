@extends('ngo.layout.master')
@Section('content')
    <style>
        .print-red-bg {
            background-color: red !important;
            /* Bootstrap 'bg-danger' color */
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
            color: white !important;
            font-size: 18px;
        }

        .print-h4 {
            background-color: red !important;
            color: white !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
            font-size: 28px;
            word-spacing: 8px;
            text-align: center;
        }

        /* Reset print layout */
        @media print {
            @page {
                size: A4;
                margin: 1cm;
            }

            body * {
                visibility: hidden;
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
                font-family: 'Arial', sans-serif;
                font-size: 12pt;
                color: #000;
                background: #fff;
            }

            img {
                max-width: 100px !important;
                height: auto !important;
            }

            .print-red-bg {
                background-color: red !important;
                /* Bootstrap 'bg-danger' color */
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
                color: white !important;
                font-size: 18px;
            }

            .print-h4 {
                background-color: red !important;
                color: white !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
                font-size: 28px;
                word-spacing: 8px;
                text-align: center;
            }

            h4,
            h6 {
                margin: 0;
                padding: 0;
            }

            .print-card .row {
                margin-bottom: 5px;
            }

            strong {
                font-weight: 600;
            }

            .mb-3,
            .mb-4,
            .mb-5 {
                margin-bottom: 10px !important;
            }

            .shadow,
            .rounded {
                box-shadow: none !important;
                border-radius: 0 !important;
            }

            .card {
                border: none;
                padding: 0;
            }

            .border-bottom {
                border-bottom: 1px solid #000 !important;
            }

            a[href]:after {
                content: "";
            }

            .img-thumbnail {
                border: 1px solid #999;
            }

            .text-center,
            .text-md-start {
                text-align: center !important;
            }

            label.from-label {
                font-weight: bold;
            }

        }
    </style>
    <div class="wrapper">
        <div class="container-fluid mt-4">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Kyc Form</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Kyc</li>
                    </ol>
                </nav>
            </div>
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            <div class="container my-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="fw-bold">Kyc Form</h2>
                    <button onclick="window.print()" class="btn btn-primary">Print / Download</button>
                </div>

                <div class="card p-4 shadow rounded print-card">

                    <div class="row mb-3">
                        <div class="col-sm-4 mb-3">
                            <strong>Registraition No:</strong> {{ $record->registration_no }}
                        </div>
                        <div class="col-sm-4 mb-3">
                            <strong>Registraition Date:</strong>
                            {{ \Carbon\Carbon::parse($record->registration_date)->format('d-m-Y') }}
                        </div>
                        <div class="col-sm-4 mb-3">
                            <strong>Session:</strong> {{ $record->academic_session }}
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="row">
                                <div class="col-sm-6 mb-3">
                                    <strong>Name:</strong> {{ $record->name }}
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <strong>Guardian's Name:</strong> {{ $record->gurdian_name }}
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <strong>Mother's Name:</strong> {{ $record->mother_name }}
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <strong>Area Type:</strong> {{ $record->area_type }}
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <strong>Village/Locality:</strong>{{ $record->village }}
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <strong>Post/Town:</strong> {{ $record->post }}
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <strong>Block:</strong> {{ $record->block }}
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <strong>District</strong> {{ $record->district }}
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <strong>State</strong> {{ $record->state }}
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <strong>Pincode:</strong> {{ $record->pincode }}
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            @php
                                $imagePath = $record->reg_type === 'Member' ? 'member_images/' : 'benefries_images/';
                            @endphp

                            {{-- @if ($record->image) --}}
                            <div class=" mb-3">
                                <img src="{{ asset($imagePath . $record->image) }}" alt="Image" class="img-thumbnail"
                                    width="150">
                                {{-- <br>
                                    <strong class="text-center"> Image:</strong> --}}
                            </div>
                            {{-- @endif --}}
                        </div>
                    </div>
                    <div class="row">


                        <div class="col-sm-4 mb-3">
                            <strong>Gender:</strong> {{ $record->gender }}
                        </div>
                        <div class="col-sm-4 mb-3">
                            <strong>Phone:</strong> {{ $record->phone }}
                        </div>
                        <div class="col-sm-4 mb-3">
                            <strong>Caste:</strong> {{ $record->caste }}
                        </div>
                        <div class="col-sm-4 mb-3">
                            <strong>Religion Category:</strong> {{ $record->religion_category }}
                        </div>

                    </div>
                </div>

                <div class="card p-4 shadow rounded mt-2">
                    <form action="{{ route('kyc.store', $record->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Aadhaar --}}
                        <label class="fw-bold">Aadhaar Number</label>
                        <input type="text" name="aadhaar_no" id="aadhaar" class="form-control" maxlength="14"
                            placeholder="XXXX XXXX XXXX" required>

                        {{-- Upload Front --}}
                        <label class="fw-bold mt-3">Aadhaar Front (Optional)</label>
                        <input type="file" name="aadhaar_front" class="form-control" accept="image/*,application/pdf"
                            capture="environment" onchange="previewFile(this, 'frontPreview')" >

                        <div id="frontPreview" class="mt-2"></div>


                        {{-- Upload Back / Combined --}}
                        <label class="fw-bold mt-3">Aadhaar Back / Combined PDF (Optional)</label>
                        <input type="file" name="aadhaar_back" class="form-control" accept="image/*,application/pdf"
                            capture="environment" onchange="previewFile(this, 'backPreview')">

                        <div id="backPreview" class="mt-2"></div>


                        {{-- Staff --}}
                        <label class="fw-bold mt-3">Verified By</label>
                        <select name="staff" class="form-select" required>
                            <option value="">-- Select Staff --</option>
                            @foreach ($staffs as $person)
                                <option value="{{ $person->name }} ({{ $person->staff_code }}) ({{ $person->position }})"
                                    {{ $person->name . ' (' . $person->staff_code . ') (' . $person->position . ')' }}>
                                    {{ $person->name }} ({{ $person->staff_code }})
                                    ({{ $person->position }})
                                </option>
                            @endforeach
                        </select>

                        <label class="fw-bold mt-3">Verified Date</label>
                        <input type="date" name="verified_at" class="form-control" value="{{ date('Y-m-d') }}" required>


                        <button class="btn btn-success mt-4">Submit KYC</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <script>
        function setLanguage(lang) {
            document.querySelectorAll('[data-lang]').forEach(el => {
                el.style.display = el.getAttribute('data-lang') === lang ? 'inline' : 'none';
            });
        }
        window.onload = () => setLanguage('en'); // Set Eng as default
    </script>
    <script>
        document.getElementById('aadhaar').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '').substring(0, 12);
            let formatted = value.replace(/(\d{4})(?=\d)/g, '$1 ');
            e.target.value = formatted;
        });

        function previewFile(input, previewId) {
            const preview = document.getElementById(previewId);
            preview.innerHTML = '';

            const file = input.files[0];
            if (!file) return;

            if (file.type === 'application/pdf') {
                preview.innerHTML = '<p class="text-muted">PDF uploaded: ' + file.name + '</p>';
                return;
            }

            const img = document.createElement('img');
            img.src = URL.createObjectURL(file);
            img.style.width = '120px';
            img.classList.add('border', 'p-1');
            preview.appendChild(img);
        }
    </script>
@endsection
