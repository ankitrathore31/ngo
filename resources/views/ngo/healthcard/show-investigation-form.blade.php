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
        <div class="d-flex justify-content-between align-person-centre mb-0 mt-4">
            <h5 class="mb-0">Verify Health Facilities Bill</h5>
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
            <!-- Language Toggle -->
            <div class="d-flex justify-content-between align-persons-center mb-3 mt-4">
                <h5 class="mb-0">
                    <span>Verify Health Facilities Bill</span>
                </h5>
                <div>
                    <button onclick="window.print()" class="btn btn-primary">Print </button>
                    {{-- <button class="btn btn-sm btn-outline-primary" onclick="setLanguage('en')">English</button>
                    <button class="btn btn-sm btn-outline-success" onclick="setLanguage('hi')">हिंदी</button> --}}
                </div>
            </div>
            <div class=" rounded print-card">
                <div class="" style="border: 9px solid red;">
                    <div>
                        <div class="p-2" style="border: 9px solid #138808;">
                            <div class="text-center mb-4 border-bottom pb-2">
                                <div class="row mb-2">
                                    <div class="col-sm-12">
                                        <h3><b>Verify Health Facilities Bill</b></h3>
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
                                    <div class="col-sm-2 text-center text-md-start">
                                        <img src="{{ asset('images/plu.png') }}" alt="Logo" width="120"
                                            height="130">
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
                                    <h4><b>Health Card No:</b> <b>{{ $card->healthcard_no }}</b></h4>
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <strong>Health Card Registraition Date:</strong>
                                    {{ \Carbon\Carbon::parse($card->registraition_date)->format('d-m-Y') }}
                                </div>
                            </div>
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

                                <div class="col-sm-4 mb-3">
                                    <strong>Beneficiaries ID No:</strong> {{ $person->identity_no }}
                                </div>

                                {{-- <div class="col-sm-12 mb-3">
                                    <strong>Hospital / Clinic / Medical Name:</strong>
                                    {{ \App\Models\HealthCard::hospital($card->hospital_name)->hospital_name }},
                                    {{ $card->hospital_name }}
                                    ,{{ \App\Models\HealthCard::hospital($card->hospital_name)->address }},{{ \App\Models\HealthCard::hospital($card->hospital_name)->operator_name }},
                                    {{ \App\Models\HealthCard::hospital($card->hospital_name)->contact_number }}
                                </div> --}}
                                <div class="col-sm-12 mb-3">
                                    <strong>Health Facility/Disease Name:</strong>
                                    @if (!empty($card->diseases))
                                        @foreach ($card->diseases as $disease)
                                            {{ $loop->iteration }}. {{ $disease }}@if (!$loop->last)
                                                ,
                                            @endif
                                        @endforeach
                                    @endif
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
                                <div class="row">
                                    <h5 class="mb-2"><b>HEALTH FACILITY</b></h5>
                                    <div class="col-sm-4 mb-3">
                                        <strong>Treatment Type:</strong> {{ $facility->treatment_type ?? '-' }}
                                    </div>
                                    <div class="col-sm-6 mb-3">
                                        <strong>Hospital/Clinic/Medical/Doctor Name:</strong>
                                        {{ $facility->hospital_name ?? '-' }}
                                    </div>
                                    <div class="col-sm-4 mb-3">
                                        <strong>Bill No:</strong> {{ $facility->bill_no ?? '-' }}
                                    </div>
                                    <div class="col-sm-4 mb-3">
                                        <strong>Bill Date:</strong>
                                        {{ $facility->bill_date ? \Carbon\Carbon::parse($facility->bill_date)->format('d-m-Y') : '-' }}
                                    </div>
                                    <div class="col-sm-4 mb-3">
                                        <strong>GST:</strong> {{ $facility->bill_gst ?? '0' }}
                                    </div>
                                    <div class="col-sm-4 mb-3">
                                        <strong>Bill Amount:</strong> {{ number_format($facility->bill_amount ?? 0, 2) }}
                                    </div>
                                    <div class="col-sm-4 mb-3 no-print">
                                        <strong>Bill Uploaded:</strong>
                                        @if ($facility->bill_upload)
                                            <a href="{{ asset($facility->bill_upload) }}" target="_blank">View</a>
                                        @else
                                            -
                                        @endif
                                    </div>
                                    <div class="col-sm-4 mb-3">
                                        <b>Investigation Officer:</b> {{ $facility->investigation_officer ?? 'Not Found' }}
                                    </div>

                                    <div class="col-sm-4 mb-3">
                                        <b>Person Paying Bill Name:</b>
                                        {{ $facility->person_paying_bill ?? 'Not Found' }}
                                    </div>

                                    <div class="col-sm-4 mb-3">
                                        <b>Account No:</b>
                                        {{ $facility->investigation_officer ?? 'Not Found' }}
                                    </div>

                                    <div class="col-sm-4 mb-3">
                                        <b>Account Holder Name:</b>
                                        {{ $facility->account_holder_name ?? 'Not Found' }}
                                    </div>

                                    <div class="col-sm-4 mb-3">
                                        <b>Bank IFSC Code:</b>
                                        {{ $facility->ifsc_code ?? 'Not Found' }}
                                    </div>

                                    <div class="col-sm-4 mb-3">
                                        <b>Bank Name:</b>
                                        {{ $facility->bank_name ?? 'Not Found' }}
                                    </div>

                                    <div class="col-sm-4 mb-3">
                                        <b>Bank Branch:</b>
                                        {{ $facility->bank_branch ?? 'Not Found' }}
                                    </div>

                                    <div class="col-sm-6 mb-3">
                                        <b>Account Holder Address:</b>
                                        {{ $facility->account_holder_address ?? 'Not Found' }}
                                    </div>
                                    <div class="col-sm-6 mb-3">
                                        <b>Verify Officer:</b>
                                        {{ $facility->verify_officer ?? 'Not Found' }}
                                    </div>
                                    @if ($facility->investigation_proof)
                                        <div class="mb-3 col-sm-6 no-print">
                                            <b>Investigation Proof:</b>
                                            <a href="{{ asset('images/' . $facility->investigation_proof) }}"
                                                target="_blank">
                                                View Proof
                                            </a>
                                        </div>
                                    @endif

                                    <form action="{{ route('verify.healthfacility.store', $facility->id) }}"
                                        method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">

                                            <div class="col-sm-6 mb-3 no-print">
                                                <b>Verify Proof <small>(Upload Photo)</small></b>
                                                <input type="file" name="verify_proof" class="form-control">
                                            </div>

                                            <div class="col-sm-3 mb-3 no-print">
                                                <input type="submit" value="Send To Director"
                                                    class="btn btn-success mt-4 no-print">
                                            </div>

                                            <div class="col-sm-3 mb-3 text-start no-print">
                                                <a href="{{ route('healthfacility.investigation.form.reject', $facility->id) }}"
                                                    class="btn mt-4 btn-danger">Reject Investigation</a>
                                            </div>

                                        </div>

                                    </form>

                                    <div class="col-sm-12 mb-4 text-end mb-3">
                                        <b>Verify Officer Sign</b>
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
            function togglePM(show) {
                document.getElementById('pmSignatureBox').classList.toggle('d-none', !show);
                document.getElementById('pmShowBtnBox').classList.toggle('d-none', show);
            }

            function toggleDirector(show) {
                document.getElementById('directorSignatureBox').classList.toggle('d-none', !show);
                document.getElementById('directorShowBtnBox').classList.toggle('d-none', show);
            }
        </script>
    @endsection
