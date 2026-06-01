@extends('ngo.layout.master')
@Section('content')
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
    <style>
        @keyframes spinIn {
            from {
                transform: rotate(-180deg) scale(.4);
                opacity: 0
            }

            to {
                transform: rotate(0) scale(1);
                opacity: 1
            }
        }

        @keyframes popIn {
            from {
                transform: scale(.4);
                opacity: 0
            }

            to {
                transform: scale(1);
                opacity: 1
            }
        }

        @keyframes slideDown {
            from {
                transform: translateY(-10px);
                opacity: 0
            }

            to {
                transform: translateY(0);
                opacity: 1
            }
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0)
            }

            20% {
                transform: translateX(-6px)
            }

            40% {
                transform: translateX(6px)
            }

            60% {
                transform: translateX(-4px)
            }

            80% {
                transform: translateX(4px)
            }
        }

        .shake {
            animation: shake .4s ease;
        }
    </style>
    <div class="wrapper">
        <div class="container-fluid mt-4">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Approval Demand Beneficiarie Facilities List</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                        <li class="breadcrumb-item"><a href="{{ url('ngo') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Demand Approval Facilities List</li>
                    </ol>
                </nav>
            </div>
            @if (session('success'))
                <div id="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <div class="row">
                <div class="col-md-12">
                    <form method="GET" action="{{ route('beneficiarie-facilities-list') }}" class="row g-3 mb-4">
                        <div class="col-md-3 mb-2">
                            {{-- <label for="session_filter" class="form-label">Select Session</label> --}}
                            <select name="session_filter" id="session_filter" class="form-control">
                                <option value="">All Sessions</option> <!-- Default option to show all -->
                                @foreach ($data as $session)
                                    <option value="{{ $session->session_date }}"
                                        {{ request('session_filter') == $session->session_date ? 'selected' : '' }}>
                                        {{ $session->session_date }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3 col-sm-4 mb-3">
                            <input type="number" class="form-control" name="application_no"
                                placeholder="Search By Application/Registration No.">
                        </div>
                        <div class="col-md-3 col-sm-4 mb-3">
                            <input type="number" class="form-control" name="registration_no"
                                placeholder="Search By Mobile/Idtinty No.">
                        </div>
                        <div class="col-md-3 col-sm-4 mb-3">
                            <input type="text" class="form-control" name="name"
                                placeholder="Search By Person/Guardian's Name">
                        </div>

                        <div class="col-md-3 mb-3">
                            <select id="category_filter" name="category_filter"
                                class="form-control @error('category_filter') is-invalid @enderror">
                                <option value="">-- Select Facilities Category --</option>
                                @foreach ($category as $cat)
                                    <option value="{{ $cat->category }}"
                                        {{ request('category_filter') == $cat->category ? 'selected' : '' }}>
                                        {{ $cat->category }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_filter')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class=" col-md-3 mb-2">
                            {{-- <label for="bene_category">Beneficiarie Eligibility Category</label> --}}
                            <select id="bene_category" name="bene_category" class="form-control">
                                <option value="">-- Select Beneficiarie Eligibility Category --</option>
                                <option value="Homeless Families">1. Homeless Families</option>
                                <option value="People living in kutcha or one-room houses">2. People living in kutcha or
                                    one-room houses</option>
                                <option value="Widows">3. Widows</option>
                                <option value="Elderly Women">4. Elderly Women</option>
                                <option value="Persons with Disabilities">5. Persons with Disabilities</option>
                                <option value="Landless">6. Landless</option>
                                <option value="Economically Weaker Section">7. Economically Weaker Section</option>
                                <option value="Laborers">8. Laborers</option>
                                <option value="Scheduled Tribes">9. Scheduled Tribes</option>
                                <option value="Scheduled Castes">10. Scheduled Castes</option>
                                <option value="Based on Low Income">11. Based on Low Income</option>
                                <option value="Affected People">12. Affected People</option>
                                <option value="Marginal Farmers">13. Marginal Farmers</option>
                                <option value="Small Farmers">14. Small Farmers</option>
                                <option value="Large Farmers">15. Large Farmers</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary me-2">Search</button>
                            <a href="{{ route('beneficiarie-facilities-list') }}"
                                class="btn btn-info text-white me-2">Reset</a>
                        </div>
                    </form>
                    <button onclick="printTable()" class="btn btn-primary mb-3">Print Table</button>
                </div>
            </div>
            <button type="button" id="openDistributeModal" class="btn btn-success mb-2" disabled>
                <i class="fa-solid fa-share-from-square me-1"></i> Distribute Selected
                <span class="badge bg-dark ms-1" id="distributeCountBadge">0</span>
            </button>
            <button type="button" id="openReturnModal" class="btn btn-warning mb-2 ms-2" disabled>
                <i class="fa-solid fa-rotate-left me-1"></i> Return Selected
                <span class="badge bg-dark ms-1" id="returnCountBadge">0</span>
            </button>
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
                    <table class="table table-bordered table-hover align-middle text-center">
                        <thead class="table-primary">
                            <tr>
                                <th class="no-print">
                                    <input type="checkbox" id="select_all_distribute">
                                </th>
                                <th>Sr. No.</th>
                                <th>Registration No.</th>
                                <th>Beneficiarie Name</th>
                                <th>Father/Husband Name</th>
                                <th>Address</th>
                                <th>Identity No.</th>
                                <th>Identity Type</th>
                                <th>Mobile No.</th>
                                <th>Caste</th>
                                <th>Caste Category</th>
                                <th>Religion</th>
                                <th>Age</th>
                                <th>Survey Date</th>
                                <th>Facilities Category</th>
                                <th>Facilities</th>
                                <th>Beneficiarie Eligibility category</th>
                                <th>Session</th>
                                <th class="no-print">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @php $serial = 1; @endphp
                            @foreach ($beneficiarie as $item)
                                @foreach ($item->surveys as $survey)
                                    <tr>
                                        <td class="no-print">
                                            <input type="checkbox" class="select_distribute_item"
                                                value="{{ $item->id }}|{{ $survey->id }}">
                                        </td>

                                        <td>{{ $serial++ }}</td>
                                        <td>{{ $item->registration_no }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->gurdian_name }}</td>
                                        <td>{{ $item->village }},
                                            {{ $item->post }},
                                            {{ $item->block }},
                                            {{ $item->district }},
                                            {{ $item->state }} - {{ $item->pincode }},
                                            ({{ $item->area_type }})
                                        </td>
                                        <td>{{ $item->identity_no }}</td>
                                        <td>{{ $item->identity_type }}</td>
                                        <td>{{ $item->phone }}</td>
                                        <td>{{ $item->caste }}</td>
                                        <td>{{ $item->religion_category }}</td>
                                        <td>{{ $item->religion }}</td>
                                        <td>
                                            {{ $item->dob ? \Carbon\Carbon::parse($item->dob)->age . ' years' : 'Not Found' }}
                                        </td>
                                        <td>
                                            {{ $survey->survey_date ? \Carbon\Carbon::parse($survey->survey_date)->format('d-m-Y') : 'No Found' }}
                                        </td>
                                        <td>{{ $survey->facilities_category ?? 'No Found' }}</td>
                                        <td>{{ $survey->facilities ?? 'No Found' }}</td>
                                        <td>{{ $survey->bene_category ?? 'No Found' }}</td>
                                        <td>{{ $survey->academic_session }}</td>
                                        <td class="no-print">
                                            <div class="d-flex justify-content-center gap-2 flex-wrap">
                                                <a href="{{ route('distribute-beneficiarie-facilities', [$item->id, $survey->id]) }}"
                                                    class="btn btn-primary btn-sm px-3 d-flex align-items-center justify-content-center"
                                                    title="Distribute" style="min-width: 38px; height: auto;">
                                                    Distribute
                                                </a>

                                                <a href="{{ route('show-beneficiarie-facilities', [$item->id, $survey->id]) }}"
                                                    class="btn btn-success btn-sm px-3 d-flex align-items-center justify-content-center"
                                                    title="View" style="min-width: 38px; height: auto;">
                                                    <i class="fa-regular fa-eye"></i> Facilities
                                                </a>

                                                <a href="{{ route('delete.beneficiarie.facilities', $survey->id) }}"
                                                    onclick="return confirm('Are you sure want to return  Facilities')"
                                                    class="btn btn-warning btn-sm px-3" title="Delete">
                                                    Return
                                                </a>

                                                <a href="{{ route('edit-facilities', [$item->id, $survey->id]) }}"
                                                    class="btn btn-primary btn-sm px-3 d-flex align-items-center justify-content-center"
                                                    title="View" style="min-width: 38px; height: auto;">
                                                    <i class="fa-regular fa-edit me-1"></i> Edit
                                                </a>
                                                @php
                                                    $user = auth()->user();
                                                @endphp

                                                @if ($user && $user->user_type === 'ngo')
                                                    <a href="{{ route('delete-distribute-facilities-all', [$item->id, $survey->id]) }}"
                                                        class="btn btn-danger btn-sm px-3"
                                                        onclick="return confirm('Are you sure you want to delete forever beneficiary distribute facilities?')">
                                                        Delete
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- ===== BULK DISTRIBUTE MODAL — two-panel layout ===== --}}
            <div class="modal fade" id="bulkDistributeModal" tabindex="-1" aria-hidden="true"
                data-bs-backdrop="static" data-bs-keyboard="false">
                <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content"
                        style="border-radius:14px; overflow:hidden; border:none; box-shadow:0 20px 60px rgba(0,0,0,.18);">

                        <form action="{{ route('store-bulk-distribute') }}" method="POST">
                            @csrf
                            <input type="hidden" name="distribute_items" id="distribute_items">

                            {{-- ── Header ── --}}
                            <div class="modal-header text-white"
                                style="background: linear-gradient(135deg,#16a34a,#15803d); border:none; padding:18px 24px;">
                                <div class="d-flex align-items-center gap-3">
                                    <div id="distIconWrap"
                                        style="
                            width:42px; height:42px; border-radius:50%;
                            background:rgba(255,255,255,.18);
                            display:flex; align-items:center; justify-content:center;">
                                        <i class="fa-solid fa-share-from-square" style="font-size:17px;"></i>
                                    </div>
                                    <div>
                                        <h5 class="modal-title mb-0"
                                            style="font-weight:700; font-size:1.1rem; letter-spacing:.2px;">
                                            Distribute Beneficiarie Facilities
                                        </h5>
                                        <small style="opacity:.85;">
                                            <span id="modalDistributeCount"
                                                style="font-weight:800; font-size:1.05em;">0</span>
                                            &nbsp;record(s) selected for distribution
                                        </small>
                                    </div>
                                </div>
                                <button type="button" class="btn-close btn-close-white ms-auto"
                                    data-bs-dismiss="modal"></button>
                            </div>

                            {{-- ── Two-panel body ── --}}
                            <div class="modal-body p-0" style="min-height:420px;">
                                <div class="row g-0" style="min-height:420px;">

                                    {{-- LEFT — Form ── --}}
                                    <div class="col-md-6 p-4" style="border-right:1px solid #e5e7eb;">

                                        <p class="fw-semibold mb-3"
                                            style="color:#15803d; font-size:.95rem; letter-spacing:.3px;">
                                            <i class="fa-solid fa-clipboard-list me-2"></i>Distribution Details
                                        </p>

                                        {{-- Distribute Date --}}
                                        <div class="mb-4">
                                            <label class="form-label fw-semibold"
                                                style="font-size:.85rem; color:#374151;">
                                                Distribute Date <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text"
                                                    style="background:#f0fdf4; border-color:#bbf7d0;">
                                                    <i class="fa-regular fa-calendar" style="color:#16a34a;"></i>
                                                </span>
                                                <input type="date" name="distribute_date" class="form-control"
                                                    style="border-color:#bbf7d0; border-left:none;" required>
                                            </div>
                                        </div>

                                        {{-- Distribute Place --}}
                                        <div class="mb-4">
                                            <label class="form-label fw-semibold"
                                                style="font-size:.85rem; color:#374151;">
                                                Distribute Place
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text"
                                                    style="background:#f0fdf4; border-color:#bbf7d0;">
                                                    <i class="fa-solid fa-location-dot" style="color:#16a34a;"></i>
                                                </span>
                                                <textarea name="distribute_place" class="form-control" rows="3"
                                                    placeholder="Enter distribution location / camp name..."
                                                    style="border-color:#bbf7d0; border-left:none; resize:none;"></textarea>
                                            </div>
                                        </div>

                                        {{-- Note --}}
                                        {{-- <div class="mb-2">
                                            <label class="form-label fw-semibold"
                                                style="font-size:.85rem; color:#374151;">
                                                Note <span class="text-muted fw-normal">(optional)</span>
                                            </label>
                                            <textarea name="distribute_note" class="form-control" rows="2" placeholder="Any remarks or instructions..."
                                                style="border-color:#d1d5db; resize:none; font-size:.88rem;"></textarea>
                                        </div> --}}

                                        {{-- Summary pill --}}
                                        <div class="mt-4 p-3 rounded-3 d-flex align-items-center gap-3"
                                            style="background:#f0fdf4; border:1px solid #bbf7d0;">
                                            <div style="
                                    width:48px; height:48px; border-radius:50%;
                                    background:#16a34a; color:#fff;
                                    display:flex; align-items:center; justify-content:center;
                                    font-size:1.3rem; font-weight:700; flex-shrink:0;"
                                                id="distSummaryCount">0</div>
                                            <div>
                                                <div class="fw-semibold" style="color:#14532d; font-size:.9rem;">
                                                    Beneficiaries selected
                                                </div>
                                                <div style="color:#16a34a; font-size:.8rem;">
                                                    Ready to distribute facilities
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    {{-- RIGHT — Selected persons list ── --}}
                                    <div class="col-md-6 p-4" style="background:#fafafa;">

                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                            <p class="fw-semibold mb-0"
                                                style="color:#374151; font-size:.95rem; letter-spacing:.3px;">
                                                <i class="fa-solid fa-users me-2" style="color:#16a34a;"></i>Selected
                                                Persons
                                            </p>
                                            <span class="badge" id="distListBadge"
                                                style="background:#dcfce7; color:#15803d; font-size:.78rem; border-radius:20px; padding:5px 12px; font-weight:600;">
                                                0 selected
                                            </span>
                                        </div>

                                        {{-- Scrollable person cards --}}
                                        <div id="distributePersonList"
                                            style="max-height:360px; overflow-y:auto; display:flex; flex-direction:column; gap:8px;
                                       scrollbar-width:thin; scrollbar-color:#bbf7d0 transparent;">
                                            {{-- Cards injected by JS --}}
                                            <div id="distEmptyState" class="text-center py-5" style="color:#9ca3af;">
                                                <i class="fa-solid fa-inbox"
                                                    style="font-size:2rem; display:block; margin-bottom:8px;"></i>
                                                <span style="font-size:.88rem;">No beneficiaries selected yet</span>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            {{-- ── Footer ── --}}
                            <div class="modal-footer"
                                style="border-top:1px solid #d1fae5; background:#f0fdf4; padding:14px 24px;">
                                <button type="submit" class="btn btn-success fw-bold px-5"
                                    style="
                        border-radius:8px; letter-spacing:.3px;
                        background: linear-gradient(135deg,#16a34a,#15803d); border:none;">
                                    <i class="fa-solid fa-share-from-square me-2"></i>Confirm Distribution
                                </button>
                                <button type="button" class="btn btn-light fw-semibold px-4" data-bs-dismiss="modal"
                                    style="border-radius:8px;">
                                    Cancel
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="bulkReturnModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
                data-bs-keyboard="false">
                <div class="modal-dialog modal-md modal-dialog-centered">
                    <div class="modal-content" style="border-radius:12px; overflow:hidden; border:none;">

                        <form action="{{ route('bulk-return-facilities') }}" method="POST">
                            @csrf
                            <input type="hidden" name="return_items" id="return_items">

                            <div class="modal-header text-white"
                                style="background: linear-gradient(135deg,#f59e0b,#d97706); border:none;">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="return-icon-wrap"
                                        style="
                            width:38px; height:38px; border-radius:50%;
                            background:rgba(255,255,255,.2);
                            display:flex; align-items:center; justify-content:center;
                            animation: spinIn .5s cubic-bezier(.34,1.56,.64,1) both;">
                                        <i class="fa-solid fa-rotate-left" style="font-size:16px;"></i>
                                    </div>
                                    <div>
                                        <h5 class="modal-title mb-0" style="font-weight:700;">Return Facilities</h5>
                                        <small style="opacity:.85;">
                                            <span id="modalReturnCount"
                                                style="
                                    font-weight:800; font-size:1.1em;
                                    animation: popIn .4s .15s cubic-bezier(.34,1.56,.64,1) both;
                                    display:inline-block;">0</span>
                                            record(s) selected
                                        </small>
                                    </div>
                                </div>
                                <button type="button" class="btn-close btn-close-white ms-auto"
                                    data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body p-4">

                                {{-- Animated warning card --}}
                                <div class="alert mb-3 d-flex align-items-start gap-3"
                                    style="
                        background:#fff8ed; border:1.5px solid #f59e0b;
                        border-radius:10px; padding:14px 16px;
                        animation: slideDown .4s .1s ease both;">
                                    <i class="fa-solid fa-triangle-exclamation text-warning mt-1"
                                        style="font-size:20px; flex-shrink:0;"></i>
                                    <div>
                                        <strong style="color:#92400e;">Are you sure?</strong>
                                        <p class="mb-0 mt-1" style="color:#78350f; font-size:.88rem; line-height:1.5;">
                                            This will <strong>clear</strong> the facilities category, facilities, session,
                                            and status for all selected records. This action cannot be undone automatically.
                                        </p>
                                    </div>
                                </div>

                                {{-- Optional reason --}}
                                {{-- <div
                                    style="animation: slideDown .4s .2s ease both; opacity:0; animation-fill-mode:forwards;">
                                    <label class="form-label fw-semibold" style="font-size:.9rem; color:#374151;">
                                        Return Reason <span class="text-muted fw-normal">(optional)</span>
                                    </label>
                                    <textarea name="return_reason" class="form-control" rows="2"
                                        placeholder="e.g. Duplicate entry, Incorrect facility assigned..."
                                        style="border-radius:8px; font-size:.9rem; resize:none;"></textarea>
                                </div> --}}

                                {{-- Selected count chips preview --}}
                                <div class="mt-3"
                                    style="animation: slideDown .4s .3s ease both; opacity:0; animation-fill-mode:forwards;">
                                    <span class="text-muted" style="font-size:.8rem;">Selected IDs:</span>
                                    <div id="returnChipsWrap" class="d-flex flex-wrap gap-1 mt-1"
                                        style="max-height:72px; overflow:auto;"></div>
                                </div>

                            </div>

                            <div class="modal-footer" style="border-top:1px solid #fde68a; background:#fffbeb;">
                                <button type="submit" class="btn btn-warning text-white fw-bold px-4"
                                    style="
                        border-radius:8px;
                        background: linear-gradient(135deg,#f59e0b,#d97706);
                        border:none; letter-spacing:.3px;">
                                    <i class="fa-solid fa-rotate-left me-2"></i>Confirm Return
                                </button>
                                <button type="button" class="btn btn-light fw-semibold" data-bs-dismiss="modal"
                                    style="border-radius:8px;">Cancel</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>



        </div>
    </div>
    <script>
        function printTable() {
            window.print();
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const selectAll = document.getElementById('select_all_distribute');
            const items = document.querySelectorAll('.select_distribute_item');

            /* Distribute */
            const openDistBtn = document.getElementById('openDistributeModal');
            const distributeBadge = document.getElementById('distributeCountBadge');
            const modalDistCount = document.getElementById('modalDistributeCount');
            const distSummaryCount = document.getElementById('distSummaryCount');
            const distListBadge = document.getElementById('distListBadge');
            const distributeInput = document.getElementById('distribute_items');
            const personList = document.getElementById('distributePersonList');
            const distEmptyState = document.getElementById('distEmptyState');
            const distributeModalEl = document.getElementById('bulkDistributeModal');

            /* Return */
            const openReturnBtn = document.getElementById('openReturnModal');
            const returnBadge = document.getElementById('returnCountBadge');
            const modalReturnCount = document.getElementById('modalReturnCount');
            const returnInput = document.getElementById('return_items');
            const returnChips = document.getElementById('returnChipsWrap');
            const returnModalEl = document.getElementById('bulkReturnModal');

            let distributeModalInstance = null;
            let returnModalInstance = null;

            /* ── Badge bounce ── */
            function bounceBadge(badge, count) {
                badge.textContent = count;
                badge.style.transform = 'scale(1.5)';
                badge.style.transition = 'transform .2s cubic-bezier(.34,1.56,.64,1)';
                setTimeout(() => badge.style.transform = 'scale(1)', 220);
            }

            /* ── Build distribute person cards ── */
            function renderPersonCards(selected) {
                personList.innerHTML = '';

                if (selected.length === 0) {
                    personList.appendChild(distEmptyState);
                    return;
                }

                selected.forEach((item, idx) => {
                    const row = item.closest('tr');
                    const cells = row.querySelectorAll('td');
                    const regNo = cells[2] ? cells[2].textContent.trim() : '—';
                    const name = cells[3] ? cells[3].textContent.trim() : '—';
                    const father = cells[4] ? cells[4].textContent.trim() : '—';
                    const mobile = cells[8] ? cells[8].textContent.trim() : '—';
                    const facilities = cells[15] ? cells[15].textContent.trim() : '—';

                    const initials = name.split(' ').slice(0, 2).map(w => w[0] || '').join('')
                .toUpperCase();
                    const colors = ['#16a34a', '#0891b2', '#7c3aed', '#db2777', '#d97706', '#dc2626'];
                    const bg = colors[idx % colors.length];

                    const card = document.createElement('div');
                    card.style.cssText = `
                background:#fff; border:1px solid #e5e7eb; border-radius:10px;
                padding:10px 14px; display:flex; align-items:center; gap:12px;
                animation: cardIn .3s ${idx * 0.06}s ease both;
            `;
                    card.innerHTML = `
                <div style="
                    width:40px; height:40px; border-radius:50%;
                    background:${bg}; color:#fff; flex-shrink:0;
                    display:flex; align-items:center; justify-content:center;
                    font-weight:700; font-size:.85rem; letter-spacing:.5px;">
                    ${initials}
                </div>
                <div style="flex:1; min-width:0;">
                    <div style="font-weight:600; font-size:.88rem; color:#111827; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                        ${name}
                    </div>
                    <div style="font-size:.75rem; color:#6b7280; margin-top:1px;">
                        Reg: <strong style="color:#374151;">${regNo}</strong>
                        &nbsp;·&nbsp; <i class="fa-solid fa-phone" style="font-size:.65rem;"></i> ${mobile}
                    </div>
                    <div style="font-size:.72rem; color:#9ca3af; margin-top:1px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                        F/H: ${father} &nbsp;·&nbsp; ${facilities}
                    </div>
                </div>
                <span style="
                    background:#dcfce7; color:#15803d;
                    font-size:.7rem; font-weight:600;
                    padding:3px 8px; border-radius:20px; flex-shrink:0;">
                    #${idx+1}
                </span>
            `;
                    personList.appendChild(card);
                });
            }

            /* ── Return chips ── */
            function renderReturnChips(selected) {
                returnChips.innerHTML = '';
                selected.forEach(i => {
                    const row = i.closest('tr');
                    const cells = row.querySelectorAll('td');
                    const regNo = cells[2] ? cells[2].textContent.trim() : '—';
                    const name = cells[3] ? cells[3].textContent.trim() : '—';
                    const chip = document.createElement('span');
                    chip.className = 'badge bg-warning text-dark';
                    chip.style.cssText =
                        'font-size:.75rem; border-radius:6px; padding:4px 10px; display:inline-flex; align-items:center; gap:5px;';
                    chip.innerHTML =
                        `<i class="fa-solid fa-user" style="font-size:.65rem;opacity:.7;"></i><strong>${regNo}</strong> — ${name}`;
                    returnChips.appendChild(chip);
                });
            }

            /* ── Master update ── */
            function updateSelection() {
                const selected = Array.from(items).filter(i => i.checked);
                const count = selected.length;
                const value = selected.map(i => i.value).join(',');

                /* Distribute */
                openDistBtn.disabled = count === 0;
                distributeInput.value = value;
                modalDistCount.textContent = count;
                distSummaryCount.textContent = count;
                distListBadge.textContent = count + ' selected';
                bounceBadge(distributeBadge, count);

                /* Return */
                openReturnBtn.disabled = count === 0;
                returnInput.value = value;
                modalReturnCount.textContent = count;
                bounceBadge(returnBadge, count);

                /* Select-all */
                if (selectAll) {
                    selectAll.checked = count === items.length && items.length > 0;
                    selectAll.indeterminate = count > 0 && count < items.length;
                }
            }

            items.forEach(item => item.addEventListener('change', updateSelection));
            if (selectAll) {
                selectAll.addEventListener('change', function() {
                    items.forEach(i => i.checked = this.checked);
                    updateSelection();
                });
            }

            /* ── Open Distribute ── */
            openDistBtn.addEventListener('click', function() {
                const selected = Array.from(items).filter(i => i.checked);
                if (selected.length === 0) {
                    openDistBtn.classList.add('shake');
                    setTimeout(() => openDistBtn.classList.remove('shake'), 450);
                    return;
                }
                renderPersonCards(selected);
                if (!distributeModalInstance) {
                    distributeModalInstance = new bootstrap.Modal(distributeModalEl, {
                        backdrop: 'static',
                        keyboard: false
                    });
                }
                distributeModalInstance.show();
            });

            /* ── Open Return ── */
            openReturnBtn.addEventListener('click', function() {
                const selected = Array.from(items).filter(i => i.checked);
                if (selected.length === 0) {
                    openReturnBtn.classList.add('shake');
                    setTimeout(() => openReturnBtn.classList.remove('shake'), 450);
                    return;
                }
                renderReturnChips(selected);
                if (!returnModalInstance) {
                    returnModalInstance = new bootstrap.Modal(returnModalEl, {
                        backdrop: 'static',
                        keyboard: false
                    });
                }
                returnModalInstance.show();
            });

        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const openReturnBtn = document.getElementById('openReturnModal');
            const returnBadge = document.getElementById('returnCountBadge');
            const modalReturnCount = document.getElementById('modalReturnCount');
            const returnInput = document.getElementById('return_items');
            const chipsWrap = document.getElementById('returnChipsWrap');
            const modalEl = document.getElementById('bulkReturnModal');
            const items = document.querySelectorAll('.select_distribute_item');

            let returnModalInstance = null;

            // Extend the existing updateSelection to also update Return button
            function syncReturnButton() {
                const selected = Array.from(items).filter(i => i.checked);
                const count = selected.length;

                openReturnBtn.disabled = count === 0;
                returnBadge.textContent = count;
                returnBadge.style.transform = 'scale(1.4)';
                setTimeout(() => returnBadge.style.transform = 'scale(1)', 200);

                returnInput.value = selected.map(i => i.value).join(',');
                modalReturnCount.textContent = count;

                // Render chips
                // Render chips with Registration No. + Name from table row
                chipsWrap.innerHTML = '';
                selected.forEach(i => {
                    const row = i.closest('tr');
                    const cells = row.querySelectorAll('td');
                    // td index: 0=checkbox, 1=Sr, 2=Reg No, 3=Name
                    const regNo = cells[2] ? cells[2].textContent.trim() : '—';
                    const name = cells[3] ? cells[3].textContent.trim() : '—';

                    const chip = document.createElement('span');
                    chip.className = 'badge bg-warning text-dark';
                    chip.style.cssText =
                        'font-size:.75rem; border-radius:6px; padding:4px 10px; display:inline-flex; align-items:center; gap:5px;';
                    chip.innerHTML =
                        `<i class="fa-solid fa-user" style="font-size:.65rem;opacity:.7;"></i><strong>${regNo}</strong> &mdash; ${name}`;
                    chipsWrap.appendChild(chip);
                });
            }

            // Attach extra listener to existing checkboxes
            items.forEach(item => item.addEventListener('change', syncReturnButton));

            const existingSelectAll = document.getElementById('select_all_distribute');
            if (existingSelectAll) {
                existingSelectAll.addEventListener('change', syncReturnButton);
            }

            // Open modal
            openReturnBtn.addEventListener('click', function() {
                const selected = Array.from(items).filter(i => i.checked);
                if (selected.length === 0) {
                    openReturnBtn.classList.add('shake');
                    setTimeout(() => openReturnBtn.classList.remove('shake'), 450);
                    return;
                }

                syncReturnButton(); // refresh count + chips

                if (!returnModalInstance) {
                    returnModalInstance = new bootstrap.Modal(modalEl, {
                        backdrop: 'static',
                        keyboard: false
                    });
                }
                returnModalInstance.show();
            });

        });
    </script>
@endsection
