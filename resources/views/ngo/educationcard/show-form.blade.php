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
            <h5 class="mb-0">Education Facility Form</h5>
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
                    <span> Education Facility Form</span>
                </h5>
                <div>
                    <button onclick="window.print()" class="btn btn-primary">Print </button>
                    {{-- <button class="btn btn-sm btn-outline-primary" onclick="setLanguage('en')">English</button>
                    <button class="btn btn-sm btn-outline-success" onclick="setLanguage('hi')">हिंदी</button> --}}
                </div>
            </div>
            <div class=" rounded print-card">
                <div class="card-body m-1 shadow-sm">
                    <div>
                        <div class="p-2">
                            <div class="text-center mb-4 border-bottom pb-2">
                                {{-- <div class="row mb-2">
                                    <div class="col-sm-12">
                                        <h3><b>EDUCATION CARD</b></h3>
                                    </div>
                                </div> --}}
                                <div class="row">
                                    <div class="col-sm-2 text-center text-md-start">
                                        <img src="{{ asset('images/LOGO.png') }}" alt="Logo" width="150"
                                            height="140">
                                    </div>
                                    <div class="col-sm-10">
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
                                                <span data-lang="hi">ग्राम - कैंचू टांडा, पोस्ट - अमरिया, जिला - पीलीभीत,
                                                    उत्तर प्रदेश -
                                                    262121</span>
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
                                        {{-- 
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
                            <div class="row">
                                <div>
                                    <h5>Education Demand Facility Details</h5>
                                </div>

                                <div class="col-sm-12 mb-3">
                                    <strong>School / Institution / Tuition / Teacher Name:</strong>
                                    @php
                                        $school = \App\Models\School::getByCode($facility->school);
                                    @endphp
                                    @if ($school)
                                        {{ $school->school_name }},
                                        {{ $school->address }},
                                        {{ $school->principal_name }},
                                        {{ $school->contact_number }}
                                    @else
                                        No school assigned
                                    @endif
                                </div>


                                <div class="col-sm-4 mb-3">
                                    <strong>Fees Type:</strong> {{ $facility->fees_type }}
                                </div>

                                <div class="col-sm-4 mb-3">
                                    <strong>Registration / SR No:</strong> {{ $facility->registration_no }}
                                </div>

                                <div class="col-sm-4 mb-3">
                                    <strong>Fees Slip No:</strong> {{ $facility->fees_slip_no }}
                                </div>

                                <div class="col-sm-4 mb-3">
                                    <strong>Fees Submit Date:</strong>
                                    {{ \Carbon\Carbon::parse($facility->fees_submit_date)->format('d-m-Y') }}
                                </div>

                                <div class="col-sm-4 mb-3">
                                    <strong>Total Fees Amount:</strong> ₹{{ number_format($facility->fees_amount, 2) }}
                                </div>

                                {{-- <div class="col-sm-4 mb-3">
                                    <strong>Facility Status:</strong>
                                    <span class="badge bg-warning">{{ $facility->status }}</span>
                                </div> --}}

                                <div class="col-sm-4 mb-3">
                                    <strong>Slip Document:</strong>
                                    @if ($facility->slip)
                                        <a href="{{ asset('documents/' . $facility->slip) }}" target="_blank">
                                            View
                                        </a>
                                    @else
                                        N/A
                                    @endif
                                </div>

                                <div class="col-sm-6 mb-3">
                                    <b>Investigation Officer</b> @php
                                        $staff = staffByEmail($facility->investigation_officer);
                                    @endphp

                                    @if ($staff)
                                        {{ $staff->name }} ({{ $staff->staff_code }}) - {{ $staff->position }}
                                    @endif
                                </div>

                                <div class="col-sm-6 mb-3">
                                    <b>Person Paying Fees Name</b>
                                    {{ $facility->person_paying_amount ?? '—' }}
                                </div>

                                <div class="col-sm-4 mb-3">
                                    <b>Account No.</b>
                                    {{ $facility->account_no ?? '—' }}
                                </div>

                                <div class="col-sm-4 mb-3">
                                    <b>Account Holder Name</b>
                                    {{ $facility->account_holder_name ?? '—' }}
                                </div>

                                <div class="col-sm-4 mb-3">
                                    <b>Bank IFSC Code</b>
                                    {{ $facility->ifsc_code ?? '—' }}
                                </div>

                                <div class="col-sm-4 mb-3">
                                    <b>Bank Name</b>
                                    {{ $facility->bank_name ?? '—' }}
                                </div>

                                <div class="col-sm-4 mb-3">
                                    <b>Bank Branch</b>
                                    {{ $facility->bank_branch ?? '—' }}
                                </div>

                                <div class="col-sm-6 mb-3">
                                    <b>Account Holder Address</b>
                                    {{ $facility->account_holder_address ?? '—' }}
                                </div>

                                <div class="col-sm-6 mb-3">
                                    <b>Verify Officer</b>
                                    @php
                                        $verifyStaff = staffByEmail($facility->verify_officer);
                                    @endphp

                                    @if ($verifyStaff)
                                        {{ $verifyStaff->name }} ({{ $verifyStaff->staff_code }}) -
                                        {{ $verifyStaff->position }}
                                    @else
                                        <span class="text-muted">Not Assigned</span>
                                    @endif
                                </div>

                                <div class="col-sm-6 mb-3">
                                    <b>Investigation Proof</b>
                                    @if ($facility->investigation_proof)
                                        <a href="{{ asset($facility->investigation_proof) }}" target="_blank">
                                            View Uploaded Proof
                                        </a>
                                    @else
                                        <span class="text-muted">No file uploaded</span>
                                    @endif
                                </div>
                                @if ($facility->verify_proof)
                                    <div class="mb-3 col-sm-6 no-print">
                                        <b>Verify Proof:</b>
                                        <a href="{{ asset('images/' . $facility->verify_proof) }}" target="_blank">
                                            View Proof
                                        </a>
                                    </div>
                                @endif
                            </div>
                            <div class="row d-flex mt-4 justify-content-between">
                                @if ($facility->investigation_officer)
                                    <div class="col-sm-6 mb-3">
                                        @php
                                            $investigationStaff = staffByEmail($facility->investigation_officer);
                                        @endphp
                                        <b>Investigation Officer Sign</b> <br>
                                        @if ($investigationStaff)
                                            {{ $investigationStaff->name }}
                                        @endif
                                    </div>
                                @endif
                                <div class="col-sm-6 mb-3">
                                    @if ($facility->verify_proof)
                                        @php
                                            $verifyStaff = staffByEmail($facility->verify_officer);
                                        @endphp
                                        <b>Verify Officer Sign</b> <br>
                                        @if ($verifyStaff)
                                            {{ $verifyStaff->name }}
                                        @endif
                                    @endif
                                </div>

                            </div>
                            <div class="row mt-2 no-print text-center">
                                <div class="col">
                                    <!-- Approve Button -->
                                    @if ($facility->status == 'Verify')
                                        <button type="button" class="btn btn-sm btn-success mb-1" data-bs-toggle="modal"
                                            data-bs-target="#approveModal">
                                            Approve Verify
                                        </button>
                                    @endif
                                    @if ($facility->status == 'Approval')
                                        <button type="button" class="btn btn-sm btn-success mb-1" data-bs-toggle="modal"
                                            data-bs-target="#approvalModal">
                                            Approve Facility
                                        </button>
                                    @endif
                                    @if (in_array($facility->status, ['Verify', 'Approval']))
                                        <!-- Reject Button -->
                                        <button type="button" class="btn btn-sm btn-danger mb-1" data-bs-toggle="modal"
                                            data-bs-target="#rejectModal">
                                            Reject
                                        </button>
                                    @endif

                                    {{-- @if ($facility->status == 'Approve')
                                        <button type="button" class="btn btn-sm btn-success mb-1" data-bs-toggle="modal"
                                            data-bs-target="#approvalModal">
                                            Update Status
                                        </button>
                                    @endif --}}
                                </div>
                            </div>
                            <div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <form method="POST"
                                        action="{{ route('education.investigation.form.verify', $facility->id) }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="approveModalLabel">Confirm Verification</h5>
                                                <button type="button" class="btn-close"
                                                    data-bs-dismiss="modal"></button>
                                            </div>

                                            <div class="modal-body">
                                                <p>Do you want to verify this facility?</p>

                                                <div class="mb-3">
                                                    <label for="verify_proof" class="form-label">Upload Verification
                                                        Proof</label>
                                                    <input type="file" name="verify_proof" id="verify_proof"
                                                        class="form-control" required>
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                    Cancel
                                                </button>
                                                <button type="submit" class="btn btn-success">
                                                    Verify
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="modal fade" id="approvalModal" tabindex="-1"
                                aria-labelledby="approvalModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form method="POST"
                                        action="{{ route('education.facility.status.store', $facility->id) }}">
                                        @csrf

                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="rejectModalLabel">Confirm Approve</h5>
                                                <button type="button" class="btn-close"
                                                    data-bs-dismiss="modal"></button>
                                            </div>

                                            <div class="modal-body">
                                                <p>Do you want to Approve this facility?</p>

                                                <div class="row">
                                                    <div class="col-sm-12 mb-3">
                                                        <strong>Total Fees Amount:</strong> <br>
                                                        <span id="billAmountText">
                                                            <b>{{ number_format($facility->fees_amount ?? 0, 2) }}</b>
                                                        </span>

                                                        <input type="hidden" id="fees_amount"
                                                            value="{{ $facility->fees_amount ?? 0 }}">
                                                    </div>

                                                    <div class="col-sm-12 mb-3">
                                                        <label><strong> Clearness Claim(%)</strong></label>
                                                        <input type="number" id="percentage" class="form-control"
                                                            step="0.01" min="0" max="100"
                                                            placeholder="Enter percentage"
                                                            oninput="calculateClearingAmount()">
                                                    </div>

                                                    <div class="col-sm-12 mb-3">
                                                        <label><strong>Clearness Amount</strong></label>
                                                        <input type="text" id="clearing_amount"
                                                            name="clearness_amount" class="form-control" readonly>
                                                    </div>

                                                    <div class="col-sm-12 mb-3">
                                                        <label class="form-label">Project / Work Category <span
                                                                class="text-danger">*</span></label>
                                                        <select name="work_category" id="work_category"
                                                            class="form-control" required>
                                                            <option value="">Select Category</option>
                                                            @foreach ($categories as $category)
                                                                <option value="{{ $category }}">{{ $category }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="col-sm-12 mb-3 no-print">
                                                        <b>Status</b>
                                                        <select name="status" class="form-control" id="status"
                                                            required onchange="toggleReasonField()">
                                                            <option value="">Select Status</option>
                                                            <option value="Approve">Approve</option>
                                                            <option value="Non-Budget">Non-Budget</option>
                                                            <option value="Demand-Pending">Demand-Pending</option>
                                                            <option value="Reject">Reject</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-sm-12 mb-3 no-print" id="reason_field"
                                                        style="display:none;">
                                                        <b>Reason</b>
                                                        <textarea name="reason" class="form-control" rows="3" placeholder="Enter reason"></textarea>
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                    Cancel
                                                </button>
                                                <button type="submit" class="btn btn-danger">
                                                    Approve
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <form method="POST"
                                        action="{{ route('investigation.education.facility.reject', $facility->id) }}">
                                        @csrf

                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="rejectModalLabel">Confirm Rejection</h5>
                                                <button type="button" class="btn-close"
                                                    data-bs-dismiss="modal"></button>
                                            </div>

                                            <div class="modal-body">
                                                <p>Do you want to reject this facility?</p>

                                                <div class="mb-3">
                                                    <label for="reason" class="form-label">Reason for rejection</label>
                                                    <textarea name="remark" id="reason" class="form-control" rows="3" required></textarea>
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                    Cancel
                                                </button>
                                                <button type="submit" class="btn btn-danger">
                                                    Reject
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
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
        function calculateClearingAmount() {
            const billAmount = parseFloat(document.getElementById('fees_amount').value) || 0;
            const percentage = parseFloat(document.getElementById('percentage').value) || 0;

            // Clearing amount is the percentage value
            const clearingAmount = (billAmount * percentage) / 100;

            document.getElementById('clearing_amount').value = clearingAmount.toFixed(2);
        }
    </script>
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
        function toggleReasonField() {
            const status = document.getElementById('status').value;
            const reasonField = document.getElementById('reason_field');

            if (status === 'Reject' || status === 'Non-Budget' || status === 'Demand-Pending') {
                reasonField.style.display = 'block';
            } else {
                reasonField.style.display = 'none';
            }
        }
    </script>
@endsection
