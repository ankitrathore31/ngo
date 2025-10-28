@extends('ngo.layout.master')
@section('content')
    <style>
        @page {
            size: auto;
            margin: 0;
            /* Remove all margins including top */
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

        @media print {

            html,
            body {
                margin: 0 !important;
                padding: 0 !important;
                height: 100% !important;
                width: 100% !important;
            }

            body * {
                visibility: hidden;
            }

            .printable,
            .printable * {
                visibility: visible;
            }

            .table th,
            .table td {
                padding: 4px !important;
                font-size: 9px !important;
                border: 1px solid #000 !important;
            }

            .card,
            .table-responsive {
                box-shadow: none !important;
                border: none !important;
                overflow: visible !important;
            }

            .btn,
            .navbar,
            .footer,
            .no-print {
                display: none !important;
            }

            table {
                page-break-inside: auto;
            }

            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }

            thead {
                display: table-header-group;
            }

            tfoot {
                display: table-footer-group;
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
        }
    </style>
    <div class="wrapper">
        <div class="d-flex justify-content-between align-items-center mb-1 mt-2">
            <h5 class="mb-0">Survey List</h5>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-light px-1 py-2 mb-0 rounded">
                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Survey</li>
                </ol>
            </nav>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('Survey.CheckDocument') }}" class="row g-3">
                    <div class="col-md-3 col-sm-6">
                        <select name="session_filter" id="session_filter" class="form-control">
                            <option value="">All Sessions</option>
                            @foreach ($session as $s)
                                <option value="{{ $s->session_date }}"
                                    {{ request('session_filter') == $s->session_date ? 'selected' : '' }}>
                                    {{ $s->session_date }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3 col-sm-6">
                        <input type="date" name="date_from" class="form-control"
                            value="{{ request('date_from', now()->toDateString()) }}">
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <input type="date" name="date_to" class="form-control"
                            value="{{ request('date_to', now()->toDateString()) }}">
                    </div>


                    {{-- 👇 Only visible for NGO users --}}
                    @if ($user->user_type == 'ngo')
                        <div class="col-md-3 col-sm-6">
                            <select name="user_filter" class="form-control">
                                <option value="">All Users</option>
                                <option value="ngo" {{ request('user_filter') == 'ngo' ? 'selected' : '' }}>NGO
                                </option>
                                <option value="staff" {{ request('user_filter') == 'staff' ? 'selected' : '' }}>Staff
                                </option>
                            </select>
                        </div>

                        <div class="col-md-3 col-sm-6">
                            <input type="text" name="name" class="form-control" value="{{ request('name') }}"
                                placeholder="Search by Staff Name">
                        </div>

                        <div class="col-md-3 col-sm-6">
                            <input type="text" name="code" class="form-control" value="{{ request('code') }}"
                                placeholder="Search by Staff Code">
                        </div>
                    @endif
                    {{-- Search by Name / Mobile / Father/Husband --}}
                    <div class="col-md-3">
                        <input type="text" name="search_text" class="form-control"
                            placeholder="Search by Name / Mobile / Father/Husband" value="{{ request('search_text') }}">
                    </div>

                    {{-- Search by Survey ID --}}
                    <div class="col-md-3">
                        <input type="text" name="survey_id" class="form-control" placeholder="Search by Survey ID"
                            value="{{ request('survey_id') }}">
                    </div>
                    @php
                        $districtsByState = config('districts');
                    @endphp
                    <div class="col-md-3 col-sm-6 form-group mb-3">
                        {{-- <label for="stateSelect" class="form-label">State: <span class="text-danger">*</span></label> --}}
                        <select class="form-control @error('state') is-invalid @enderror" name="state" id="stateSelect">
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

                    <div class="col-md-3 col-sm-6">
                        <button type="submit" class="btn btn-primary w-100">Search</button>
                    </div>

                    <div class="col-md-3 col-sm-6">
                        <a href="{{ route('Survey.CheckDocument') }}" class="btn btn-info text-white w-100">Reset</a>
                    </div>

                    <div class="col-md-3 col-sm-6">
                        <button onclick="printTable()" type="button" class="btn btn-danger text-white w-100">Download
                            PDF</button>
                    </div>
                </form>
            </div>
        </div>

        @if ($surveys->isEmpty())
            <div class="alert alert-info mt-5">No surveys found.</div>
        @else
            <div class="card shadow-sm printable">
                <div class="card-body table-responsive">
                    <div class="text-center mb-4 border-bottom pb-2">
                        <!-- Header -->
                        <div class="row">
                            <div class="col-sm-2 text-center text-md-start">
                                <img src="{{ asset('images/LOGO.png') }}" alt="Logo" width="80" height="80">
                            </div>
                            <div class="col-sm-10">
                                <p style="margin: 0;" class="d-flex justify-content-around"><b>
                                        <span>NEETI AYOG ID NO. UP/2023/0360430</span>&nbsp;
                                        &nbsp; &nbsp;<span>NGO NO. UP/00033062</span>&nbsp; &nbsp;
                                        &nbsp; &nbsp;<span>PAN: AAEAG7650B</span>&nbsp;
                                    </b></p>
                                <h4 class="print-h4"><b>
                                        {{-- <span data-lang="hi">ज्ञान भारती संस्था</span> --}}
                                        <span data-lang="en">GYAN BHARTI SANSTHA</span>
                                    </b></h4>
                                <h6 style="color: blue;"><b>
                                        {{-- <span data-lang="hi">ग्राम - कैंचू टांडा, पोस्ट - अमरिया, जिला - पीलीभीत, उत्तर
                                            प्रदेश -
                                            262121</span> --}}
                                        <span data-lang="en">Village - Kainchu Tanda, Post - Amaria, District - Pilibhit,
                                            UP
                                            -
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
                        </div>
                    </div>
                    <div class="table-responsive mt-5">
                        <table class="table table-bordered table-striped align-middle">
                            <thead class="table-light text-center">
                                <tr>
                                    <th>Sr No</th>
                                    <th>Survey ID</th>
                                    <th>Survey Date</th>
                                    <th>Animator Name (Code)</th>
                                    <th>Beneficiary Name</th>
                                    <th>Father/Husband Name</th>
                                    <th>Address</th>
                                    <th>Mobile No</th>
                                    <th>Scheme Type</th>
                                    <th>Session</th>
                                    <th>Aadhar Benefries father mother gurdian </th>
                                    <th>Account No. Benefries father mother gurdian </th>
                                    <th>Aay Jati Nivas father mother gurdian </th>
                                    <th>Aay Jati nivas Benefries </th>
                                    <th>Adhyan pramn patr Benefries father mother gurdian</th>
                                    <th>Ration Card Benefries father mother gurdian</th>
                                    <th>Color Photo Benefries father mother gurdian</th>
                                    <th>Mobile Aaadhar Link Benefries father mother gurdian</th>
                                    <th>Signature/Thumb Benefries father mother gurdian</th>
                                    <th>Remark</th>
                                    <th class="no-print">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($surveys as $key => $survey)
                                    <tr>
                                        <td class="text-center">{{ $key + 1 }}</td>
                                        <td>{{ $survey->survey_id }}</td>
                                        <td>{{ \Carbon\Carbon::parse($survey->date)->format('d-m-Y') }}</td>
                                        <td>{{ $survey->animator_name }} ({{ $survey->animator_code }})</td>
                                        <td>{{ $survey->name }}</td>
                                        <td>{{ $survey->father_husband_name }}</td>
                                        <td>{{ $survey->address }}, {{ $survey->post_town }},{{ $survey->block }},
                                            {{ $survey->state }}
                                            {{ $survey->district }}</td>
                                        <td>{{ $survey->mobile_no }}</td>
                                        <td>{{ $survey->beneficiaries_type }}</td>
                                        <td>{{ $survey->session }}</td>
                                        <td class="text-center">
                                            <input type="checkbox" class="form-check-input document-checkbox"
                                                data-field="aadhar_guardian" data-survey-id="{{ $survey->id }}"
                                                {{ $survey->surveyDocument?->aadhar_guardian ? 'checked' : '' }}>
                                        </td>
                                        <td class="text-center">
                                            <input type="checkbox" class="form-check-input document-checkbox"
                                                data-field="account_no_guardian" data-survey-id="{{ $survey->id }}"
                                                {{ $survey->surveyDocument?->account_no_guardian ? 'checked' : '' }}>
                                        </td>
                                        <td class="text-center">
                                            <input type="checkbox" class="form-check-input document-checkbox"
                                                data-field="aay_jati_nivas_guardian" data-survey-id="{{ $survey->id }}"
                                                {{ $survey->surveyDocument?->aay_jati_nivas_guardian ? 'checked' : '' }}>
                                        </td>
                                        <td class="text-center">
                                            <input type="checkbox" class="form-check-input document-checkbox"
                                                data-field="aay_jati_nivas_beneficiary"
                                                data-survey-id="{{ $survey->id }}"
                                                {{ $survey->surveyDocument?->aay_jati_nivas_beneficiary ? 'checked' : '' }}>
                                        </td>
                                        <td class="text-center">
                                            <input type="checkbox" class="form-check-input document-checkbox"
                                                data-field="adhyan_pramn_patr_guardian"
                                                data-survey-id="{{ $survey->id }}"
                                                {{ $survey->surveyDocument?->adhyan_pramn_patr_guardian ? 'checked' : '' }}>
                                        </td>
                                        <td class="text-center">
                                            <input type="checkbox" class="form-check-input document-checkbox"
                                                data-field="ration_card_guardian" data-survey-id="{{ $survey->id }}"
                                                {{ $survey->surveyDocument?->ration_card_guardian ? 'checked' : '' }}>
                                        </td>
                                        <td class="text-center">
                                            <input type="checkbox" class="form-check-input document-checkbox"
                                                data-field="color_photo_guardian" data-survey-id="{{ $survey->id }}"
                                                {{ $survey->surveyDocument?->color_photo_guardian ? 'checked' : '' }}>
                                        </td>
                                        <td class="text-center">
                                            <input type="checkbox" class="form-check-input document-checkbox"
                                                data-field="mobile_aadhar_link_guardian"
                                                data-survey-id="{{ $survey->id }}"
                                                {{ $survey->surveyDocument?->mobile_aadhar_link_guardian ? 'checked' : '' }}>
                                        </td>
                                        <td class="text-center">
                                            <input type="checkbox" class="form-check-input document-checkbox"
                                                data-field="signature_thumb_guardian"
                                                data-survey-id="{{ $survey->id }}"
                                                {{ $survey->surveyDocument?->signature_thumb_guardian ? 'checked' : '' }}>
                                        </td>

                                        <td>
                                            {{-- <textarea type="text" class="form-control form-control-sm remark-input" data-survey-id="{{ $survey->id }}"
                                             placeholder="Enter remark">{{ $survey->surveyDocument?->remark }}</textarea> --}}
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-sm btn-primary save-documents"
                                                data-survey-id="{{ $survey->id }}">
                                                Save
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </div>
    <script>
        function printTable() {
            window.print();
        }
    </script>
    <script>
        $(document).ready(function() {
            // CSRF Token setup
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Auto-save checkbox on change
            $('.document-checkbox').on('change', function() {
                const checkbox = $(this);
                const surveyId = checkbox.data('survey-id');
                const field = checkbox.data('field');
                const value = checkbox.is(':checked');

                // Visual feedback
                checkbox.prop('disabled', true);

                $.ajax({
                    url: '/survey-documents/update-document-checkbox',
                    method: 'POST',
                    data: {
                        benefres_survey_id: surveyId,
                        field: field,
                        value: value
                    },
                    success: function(response) {
                        checkbox.prop('disabled', false);
                        // Optional: Show brief success indicator
                        showToast('Updated successfully', 'success');
                    },
                    error: function(xhr) {
                        checkbox.prop('disabled', false);
                        checkbox.prop('checked', !value); // Revert on error
                        showToast('Error updating checkbox', 'error');
                    }
                });
            });

            // Save all documents for a row
            $('.save-documents').on('click', function() {
                const btn = $(this);
                const surveyId = btn.data('survey-id');
                const row = $(`tr[data-survey-id="${surveyId}"]`);

                // Collect all checkbox states
                const data = {};
                row.find('.document-checkbox').each(function() {
                    const checkbox = $(this);
                    data[checkbox.data('field')] = checkbox.is(':checked');
                });

                // Add remark
                data.remark = row.find('.remark-input').val();

                // Show loading
                btn.prop('disabled', true).text('Saving...');

                $.ajax({
                    url: `/survey-documents/${surveyId}/update-document`,
                    method: 'POST',
                    data: data,
                    success: function(response) {
                        btn.prop('disabled', false).text('Save');
                        showToast(response.message, 'success');
                    },
                    error: function(xhr) {
                        btn.prop('disabled', false).text('Save');
                        showToast('Error saving documents', 'error');
                    }
                });
            });

            // Toast notification function
            function showToast(message, type) {
                const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
                const toast = $(`
            <div class="alert ${alertClass} alert-dismissible fade show position-fixed top-0 end-0 m-3" role="alert" style="z-index: 9999;">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `);

                $('body').append(toast);

                setTimeout(function() {
                    toast.alert('close');
                }, 3000);
            }
        });
    </script>
@endsection
