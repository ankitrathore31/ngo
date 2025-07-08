@extends('ngo.layout.master')
@Section('content')
    <style>
        .id-card {
            width: 336px;
            height: auto;
            padding: 12px;
            margin: 10px auto;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.2);
            font-family: Arial, sans-serif;
            page-break-inside: avoid;
            background-color: #fff;
        }

        .logo-img {
            width: 60px;
            height: auto;
        }

        .photo-img {
            width: 85px;
            height: auto;
            border: 1px solid #ccc;
        }

        .id-header {
            text-align: center;
            border-bottom: 1px solid #ccc;
            padding-bottom: 8px;
            margin-bottom: 8px;
        }

        .id-header h4 {
            color: red;
            font-weight: bold;
            margin: 0;
        }

        .id-header small {
            font-weight: bold;
            color: #000;
        }

        .id-body {
            display: flex;
            gap: 10px;
        }

        .id-body .left {
            flex: 0 0 auto;
        }

        .id-body .right {
            flex: 1;
            font-size: 14px;
        }

        .id-body .right p {
            margin: 2px 0;
        }

        .id-footer {
            font-size: 14px;
            margin-top: 8px;
        }

        .id-footer small {
            font-weight: bold;
        }

        @media print {
            body * {
                visibility: hidden;
                /* font-size: 12px; */

            }

            .id-card,
            .id-card * {
                visibility: visible;
            }

            .no-print {
                display: none !important;
            }

            @page {
                size: A4;
                margin: 10mm;
            }
        }
    </style>
    <div class="wrapper">
        <div class="container-fluid mt-4">

            <div class="d-flex justify-content-between align-items-center mb-1">
                <h5 class="mb-0">Beneficiary Id Card List</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-light px-1 py-2 mb-0 rounded">
                        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Beneficiary</li>
                    </ol>
                </nav>
            </div>

            @if (session('success'))
                <div id="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <div class="row">
                <form method="GET" action="{{ route('beneficiary-idcard') }}" class="row g-3 mb-4">
                    <div class="row">
                        <div class="col-md-4 col-sm-4">
                            <select name="session_filter" id="session_filter" class="form-control">
                                <option value="">All Sessions</option>
                                @foreach ($data as $session)
                                    <option value="{{ $session->session_date }}"
                                        {{ request('session_filter') == $session->session_date ? 'selected' : '' }}>
                                        {{ $session->session_date }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 col-sm-4 mb-3">
                            <input type="number" class="form-control" name="application_no"
                                placeholder="Search By Application No.">
                        </div>
                        <div class="col-md-4 col-sm-4 mb-3">
                            <input type="text" class="form-control" name="name" placeholder="Search By Name">
                        </div>
                    </div>
                    <div class="row">

                        @php
                            $districtsByState = config('districts');
                        @endphp
                        <div class="col-md-3 col-sm-6 form-group mb-3">
                            {{-- <label for="stateSelect" class="form-label">State: <span class="text-danger">*</span></label> --}}
                            <select class="form-control @error('state') is-invalid @enderror" name="state"
                                id="stateSelect">
                                <option value="">Select State</option>
                                @foreach ($districtsByState as $state => $districts)
                                    <option value="{{ $state }}" {{ old('state') == $state ? 'selected' : '' }}>
                                        {{ $state }}
                                    </option>
                                @endforeach
                            </select>
                            @error('state')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                        </div>
                        <div class="col-md-3 col-sm-6 form-group mb-3">
                            {{-- <label for="districtSelect" class="form-label">District: <span
                                    class="text-danger">*</span></label> --}}
                            <select class="form-control @error('district') is-invalid @enderror" name="district"
                                id="districtSelect">
                                <option value="">Select District</option>
                            </select>
                            @error('district')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-3 col-sm-6 form-group mb-3">
                            {{-- <label for="block" class="form-label">Block: <span class="text-danger">*</span></label> --}}
                            <input type="text" name="block" id="block"
                                class="form-control @error('block') is-invalid @enderror" value="{{ old('block') }}"
                                placeholder="Search by Block">
                            @error('block')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary me-1">Search</button>
                            <a href="{{ route('beneficiary-idcard') }}" class="btn btn-info text-white me-1">Reset</a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="row">
                <div class="d-flex justify-content-end align-items-center mb-4">
                    {{-- <h2 class="fw-bold">Member</h2> --}}
                    <button onclick="window.print()" class="btn btn-primary">Print / Download</button>
                </div>
            </div>
            <div class="container d-flex flex-wrap justify-content-center">
                @foreach ($donations as $record)
                    <div class="id-card">
                        <div class="id-header">
                            <img src="{{ asset('images/LOGO.png') }}" class="logo-img" alt="Logo">
                            <h4>GYAN BHARTI SANSTHA</h4>
                            <small>Head Office: Kainchu Tanda, Amaria, Pilibhit (UP) Website:Gyanbhartingo.org</small>
                        </div>

                        <div class="id-body">
                            <div class="left">
                                <img src="" class="photo-img" alt="Photo">
                            </div>
                            <div class="right">
                                {{-- <p><strong>Registration No:</strong> {{ $record->registration_no }}</p> --}}
                                <p><strong>Name:</strong> {{ $record->name }}</p>
                                <p><strong>Father/Husband:</strong> {{ $record->gurdian_name ?? 'OnlineCashfree' }}</p>
                                <p><strong>Mobile No:</strong> {{ (string) $record->mobile }}</p>
                                <p><strong>Position:</strong> Donor</p>
                                <p><strong>Session:</strong>{{ $record->academic_session }}</p>
                            </div>
                        </div>

                        <div class="id-footer">
                            <p><strong>Address:</strong> {{ $record->address }},
                                {{ $record->block }},
                                {{ $record->district }}, {{ $record->state }}
                            </p>
                            <div class="text-end">
                                @if (!empty($signatures['director']) && file_exists(public_path($signatures['director'])))
                                    <div id="directorSignatureBox" class="mt-2">
                                        <p class="text-success no-print">Attached</p>
                                        <img src="{{ asset($signatures['director']) }}" alt="Director Signature"
                                            class="img" style="max-height: 100px;">
                                        <br>
                                        <button class="btn btn-danger btn-sm mt-2 no-print"
                                            onclick="toggleDirector(false)">Remove</button>
                                    </div>

                                    <div id="directorShowBtnBox" class="mt-2 d-none no-print">
                                        <button class="btn btn-primary btn-sm" onclick="toggleDirector(true)">Attached
                                            Signature</button>
                                    </div>
                                @else
                                    <p class="text-muted mt-2 no-print">Not attached</p>
                                @endif
                                Director Signature
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <script>
        function togglePM(show) {
            document.getElementById('pmSignatureBox').classList.toggle('d-none', !show);
            document.getElementById('pmShowBtnBox').classList.toggle('d-none', show);
        }

        function toggleDirector(show) {
            document.getElementById('directorSignatureBox').classList.toggle('d-none', !show);
            document.getElementById('directorShowBtnBox').classList.toggle('d-none', show);
        }
    </script>
    <script>
        const allDistricts = @json($districtsByState);
        const oldDistrict = "{{ old('district') }}";
        const oldState = "{{ old('state') }}";

        function populateDistricts(state) {
            const districtSelect = document.getElementById('districtSelect');
            districtSelect.innerHTML = '<option value="">Select District</option>';

            if (allDistricts[state]) {
                allDistricts[state].forEach(function(district) {
                    const selected = (district === oldDistrict) ? 'selected' : '';
                    districtSelect.innerHTML += `<option value="${district}" ${selected}>${district}</option>`;
                });
            }
        }

        // Initial load if editing or validation failed
        if (oldState) {
            populateDistricts(oldState);
        }

        // On state change
        document.getElementById('stateSelect').addEventListener('change', function() {
            populateDistricts(this.value);
        });
    </script>
@endsection
