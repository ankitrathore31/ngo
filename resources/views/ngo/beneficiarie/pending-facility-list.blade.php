@extends('ngo.layout.master')
@Section('content')
    <style>
        @page { size: auto; margin: 0; }
        .print-red-bg {
            background-color: red !important;
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
            html, body { margin: 0 !important; padding: 0 !important; height: 100% !important; width: 100% !important; }
            body * { visibility: hidden; }
            .printable, .printable * { visibility: visible; }
            .table th, .table td { padding: 4px !important; font-size: 9px !important; border: 1px solid #000 !important; }
            .card, .table-responsive { box-shadow: none !important; border: none !important; overflow: visible !important; }
            .btn, .navbar, .footer, .no-print { display: none !important; }
            table { page-break-inside: auto; }
            tr { page-break-inside: avoid; page-break-after: auto; }
            thead { display: table-header-group; }
            tfoot { display: table-footer-group; }
            .print-red-bg { background-color: red !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; color: white !important; font-size: 18px; }
            .print-h4 { background-color: red !important; color: white !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; font-size: 28px; word-spacing: 8px; text-align: center; }
        }

        /* ── Animations ── */
        @keyframes spinIn    { from{transform:rotate(-180deg) scale(.4);opacity:0} to{transform:rotate(0) scale(1);opacity:1} }
        @keyframes popIn     { from{transform:scale(.4);opacity:0} to{transform:scale(1);opacity:1} }
        @keyframes slideDown { from{transform:translateY(-10px);opacity:0} to{transform:translateY(0);opacity:1} }
        @keyframes cardIn    { from{transform:translateX(18px);opacity:0} to{transform:translateX(0);opacity:1} }
        @keyframes shake     { 0%,100%{transform:translateX(0)} 20%{transform:translateX(-6px)} 40%{transform:translateX(6px)} 60%{transform:translateX(-4px)} 80%{transform:translateX(4px)} }
        @keyframes badgePop  { 0%{transform:scale(1)} 40%{transform:scale(1.6)} 100%{transform:scale(1)} }

        .shake { animation: shake .4s ease; }
        .badge-pop { animation: badgePop .3s cubic-bezier(.34,1.56,.64,1); }

        .person-list-scroll::-webkit-scrollbar { width: 5px; }
        .person-list-scroll::-webkit-scrollbar-track { background: transparent; }
        .person-list-scroll::-webkit-scrollbar-thumb { background: #bbf7d0; border-radius: 10px; }

        .return-list-scroll::-webkit-scrollbar { width: 5px; }
        .return-list-scroll::-webkit-scrollbar-track { background: transparent; }
        .return-list-scroll::-webkit-scrollbar-thumb { background: #fde68a; border-radius: 10px; }

        .action-btn-group { display: flex; gap: 6px; flex-wrap: wrap; justify-content: center; align-items: center; }
    </style>

    <div class="wrapper">
        <div class="container-fluid mt-4">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Approval Distributed Facilities List</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Distributed Facilities List</li>
                    </ol>
                </nav>
            </div>

            @if (session('success'))
                <div id="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            {{-- ── Search Form ── --}}
            <div class="row">
                <div class="col-md-12">
                    <form method="GET" action="{{ route('distributed-list-for-approve') }}" class="row g-3 mb-4">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <select name="session_filter" id="session_filter" class="form-control">
                                    <option value="">All Sessions</option>
                                    @foreach ($data as $session)
                                        <option value="{{ $session->session_date }}" {{ request('session_filter') == $session->session_date ? 'selected' : '' }}>
                                            {{ $session->session_date }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 col-sm-4 mb-3">
                                <input type="number" class="form-control" name="application_no" placeholder="Search By Application/Registration No.">
                            </div>
                            <div class="col-md-3 col-sm-4 mb-3">
                                <input type="number" class="form-control" name="registration_no" placeholder="Search By Mobile/Identity No.">
                            </div>
                            <div class="col-md-3 col-sm-4 mb-3">
                                <input type="text" class="form-control" name="name" placeholder="Search By Person/Guardian's Name">
                            </div>
                            <div class="col-md-3 mb-3">
                                <select id="category_filter" name="category_filter" class="form-control @error('category_filter') is-invalid @enderror">
                                    <option value="">-- Select Facilities Category --</option>
                                    @foreach ($category as $cat)
                                        <option value="{{ $cat->category }}" {{ request('category_filter') == $cat->category ? 'selected' : '' }}>{{ $cat->category }}</option>
                                    @endforeach
                                </select>
                                @error('category_filter')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <select id="bene_category" name="bene_category" class="form-control">
                                    <option value="">-- Select Beneficiarie Eligibility Category --</option>
                                    <option value="Homeless Families">1. Homeless Families</option>
                                    <option value="People living in kutcha or one-room houses">2. People living in kutcha or one-room houses</option>
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
                            <div class="col-md-3 form-group mb-3">
                                <input type="date" id="distribute_date" name="distribute_date" class="form-control" value="{{ old('distribute_date') }}">
                                <small class="form-text text-muted"><b>Select Distribute Date</b></small>
                            </div>
                            @php $districtsByState = config('districts'); @endphp
                            <div class="col-md-3 col-sm-6 form-group mb-3">
                                <select class="form-control @error('state') is-invalid @enderror" name="state" id="stateSelect">
                                    <option value="">Select State</option>
                                    @foreach ($districtsByState as $state => $districts)
                                        <option value="{{ $state }}" {{ old('state') == $state ? 'selected' : '' }}>{{ $state }}</option>
                                    @endforeach
                                </select>
                                @error('state')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                            <div class="col-md-3 col-sm-6 form-group mb-3">
                                <select class="form-control @error('district') is-invalid @enderror" name="district" id="districtSelect">
                                    <option value="">Select District</option>
                                </select>
                                @error('district')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                            <div class="col-md-3 col-sm-6 form-group mb-3">
                                <input type="text" name="block" id="block" class="form-control @error('block') is-invalid @enderror" value="{{ old('block') }}" placeholder="Search by Block">
                                @error('block')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary me-1">Search</button>
                                <a href="{{ route('distributed-list-for-approve') }}" class="btn btn-info text-white me-1">Reset</a>
                            </div>
                        </div>
                    </form>
                    <button onclick="printTable()" class="btn btn-primary mb-3">Print Table</button>
                </div>
            </div>

            {{-- ── Action Buttons Row ── --}}
            <div class="row mb-3 align-items-center">
                <div class="col-md-8 d-flex gap-2 flex-wrap">

                    {{-- Approve Button --}}
                    <button type="button" id="openDistributeModal" class="btn btn-success mb-2" disabled
                        style="border-radius:8px; font-weight:600; letter-spacing:.2px;">
                        <i class="fa-solid fa-circle-check me-1"></i>
                        Approve Selected
                        <span class="badge bg-dark ms-1" id="approveBadge"
                            style="border-radius:20px; font-size:.75rem; padding:4px 8px; transition:transform .2s;">0</span>
                    </button>

                    {{-- Return Button --}}
                    <button type="button" id="openReturnModal" class="btn btn-warning mb-2 text-white" disabled
                        style="border-radius:8px; font-weight:600; letter-spacing:.2px;">
                        <i class="fa-solid fa-rotate-left me-1"></i>
                        Return Selected
                        <span class="badge bg-dark ms-1" id="returnBadge"
                            style="border-radius:20px; font-size:.75rem; padding:4px 8px; transition:transform .2s;">0</span>
                    </button>

                </div>
                <div class="col-md-4 text-end">
                    <a href="{{ route('show-beneficiarie-token') }}" class="btn btn-success btn-sm px-3">
                        <i class="fa-solid fa-ticket me-1"></i>Token
                    </a>
                </div>
            </div>

            {{-- ── Table ── --}}
            <div class="card shadow-sm printable">
                <div class="card-body table-responsive">
                    <div class="text-center mb-4 border-bottom pb-2">
                        <div class="row">
                            <div class="col-sm-2 text-center text-md-start">
                                <img src="{{ asset('images/LOGO.png') }}" alt="Logo" width="80" height="80">
                            </div>
                            <div class="col-sm-10">
                                <p style="margin:0;" class="d-flex justify-content-around"><b>
                                    <span>NEETI AYOG ID NO. UP/2023/0360430</span>&nbsp;&nbsp;&nbsp;
                                    <span>NGO NO. UP/00033062</span>&nbsp;&nbsp;&nbsp;
                                    <span>PAN: AAEAG7650B</span>
                                </b></p>
                                <h4 class="print-h4"><b><span data-lang="en">GYAN BHARTI SANSTHA</span></b></h4>
                                <h6 style="color:blue;"><b><span data-lang="en">Village - Kainchu Tanda, Post - Amaria, District - Pilibhit, UP - 262121</span></b></h6>
                                <p style="font-size:14px; margin:0;"><b><span>Website: www.gyanbhartingo.org | Email: gyanbhartingo600@gmail.com | Mob: 9411484111</span></b></p>
                            </div>
                        </div>
                    </div>

                    <table class="table table-bordered table-hover align-middle text-center">
                        <thead class="table-primary">
                            <tr>
                                <th class="no-print"><input type="checkbox" id="select_all_distribute"></th>
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
                                <th>Distribute Date</th>
                                <th>Distribute Place</th>
                                <th>Facilities Category</th>
                                <th>Facilities</th>
                                <th>Signature / Thumb Impression</th>
                                <th>Beneficiarie Eligibility Category</th>
                                <th>Session</th>
                                <th class="no-print">Action</th>
                                <th class="no-print">Receiving Receipt</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($beneficiarie as $item)
                                @foreach ($item->surveys as $survey)
                                    <tr>
                                        <td class="no-print">
                                            <input type="checkbox" class="select_distribute_item"
                                                value="{{ $item->id }}|{{ $survey->id }}">
                                        </td>
                                        <td>{{ $loop->parent->iteration }}</td>
                                        <td>{{ $item->registration_no }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->gurdian_name }}</td>
                                        <td>{{ $item->village }}, {{ $item->post }}, {{ $item->block }}, {{ $item->district }}, {{ $item->state }} - {{ $item->pincode }}, ({{ $item->area_type }})</td>
                                        <td>{{ $item->identity_no }}</td>
                                        <td>{{ $item->identity_type }}</td>
                                        <td>{{ $item->phone }}</td>
                                        <td>{{ $item->caste }}</td>
                                        <td>{{ $item->religion_category }}</td>
                                        <td>{{ $item->religion }}</td>
                                        <td>{{ $item->dob ? \Carbon\Carbon::parse($item->dob)->age . ' years' : 'Not Found' }}</td>
                                        <td>{{ $survey->distribute_date ? \Carbon\Carbon::parse($survey->distribute_date)->format('d-m-Y') : 'No Found' }}</td>
                                        <td>{{ $survey->distribute_place ?? 'No Found' }}</td>
                                        <td>{{ $survey->facilities_category ?? 'No Found' }}</td>
                                        <td>{{ $survey->facilities ?? 'No Found' }}</td>
                                        <td></td>
                                        <td>{{ $survey->bene_category ?? 'No Found' }}</td>
                                        <td>{{ $survey->academic_session }}</td>
                                        <td class="no-print">
                                            <div class="action-btn-group">
                                                <a href="{{ route('distribute-facilities-status', [$item->id, $survey->id]) }}" class="btn btn-success btn-sm px-3">Approve</a>
                                                <a href="{{ route('edit-distribute-facilities', [$item->id, $survey->id]) }}" class="btn btn-primary btn-sm px-3">Edit</a>
                                                <a href="{{ route('delete-distribute-facilities', [$item->id, $survey->id]) }}"
                                                    onclick="return confirm('Are you sure want to return Distribute Facilities')"
                                                    class="btn btn-warning btn-sm px-3">Return</a>
                                                @php $user = auth()->user(); @endphp
                                                @if ($user && $user->user_type === 'ngo')
                                                    <a href="{{ route('delete-distribute-facilities-all', [$item->id, $survey->id]) }}"
                                                        class="btn btn-danger btn-sm px-3"
                                                        onclick="return confirm('Are you sure you want to delete forever?')">Delete</a>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="no-print">
                                            <a href="{{ route('show-beneficiarie-receipt', [$item->id, $survey->id]) }}" class="btn btn-success btn-sm px-3">Receipt</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>


            {{-- ══════════════════════════════════════════
                 APPROVE MODAL — two-panel layout
            ══════════════════════════════════════════ --}}
            <div class="modal fade" id="bulkDistributeModal" tabindex="-1" aria-hidden="true"
                data-bs-backdrop="static" data-bs-keyboard="false">
                <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content" style="border-radius:14px; overflow:hidden; border:none; box-shadow:0 20px 60px rgba(0,0,0,.18);">
                        <form action="{{ route('store-bulk-distribute-status') }}" method="POST" id="bulkDistributeForm">
                            @csrf
                            <input type="hidden" name="distribute_items" id="distribute_items">

                            {{-- Header --}}
                            <div class="modal-header text-white"
                                style="background:linear-gradient(135deg,#16a34a,#15803d); border:none; padding:18px 24px;">
                                <div class="d-flex align-items-center gap-3">
                                    <div style="width:42px;height:42px;border-radius:50%;background:rgba(255,255,255,.18);
                                        display:flex;align-items:center;justify-content:center;
                                        animation:spinIn .5s cubic-bezier(.34,1.56,.64,1) both;">
                                        <i class="fa-solid fa-circle-check" style="font-size:18px;"></i>
                                    </div>
                                    <div>
                                        <h5 class="modal-title mb-0" style="font-weight:700; font-size:1.1rem;">Approve Distributed Facilities</h5>
                                        <small style="opacity:.85;">
                                            <span id="modalDistributeCount"
                                                style="font-weight:800;font-size:1.05em;display:inline-block;animation:popIn .4s .15s cubic-bezier(.34,1.56,.64,1) both;">0</span>
                                            &nbsp;record(s) selected
                                        </small>
                                    </div>
                                </div>
                                <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="modal"></button>
                            </div>

                            {{-- Two-panel body --}}
                            <div class="modal-body p-0" style="min-height:440px;">
                                <div class="row g-0" style="min-height:440px;">

                                    {{-- LEFT — Form --}}
                                    <div class="col-md-6 p-4" style="border-right:1px solid #e5e7eb;">

                                        <p class="fw-semibold mb-3" style="color:#15803d;font-size:.95rem;letter-spacing:.3px;">
                                            <i class="fa-solid fa-clipboard-check me-2"></i>Approval Details
                                        </p>

                                        {{-- Info alert --}}
                                        <div class="alert mb-3 d-flex align-items-center gap-2"
                                            style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:10px;padding:12px 14px;
                                            animation:slideDown .4s .1s ease both;">
                                            <i class="fa-solid fa-circle-info" style="color:#16a34a;font-size:16px;flex-shrink:0;"></i>
                                            <span style="font-size:.85rem;color:#14532d;">
                                                Approving facilities for
                                                <strong id="modalDistributeCountText">0</strong> beneficiar(ies).
                                            </span>
                                        </div>

                                        {{-- Approve Officer --}}
                                        <div class="mb-3" style="animation:slideDown .4s .15s ease both;opacity:0;animation-fill-mode:forwards;">
                                            <label class="form-label fw-semibold" style="font-size:.85rem;color:#374151;">
                                                Approve Officer
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text" style="background:#f0fdf4;border-color:#bbf7d0;">
                                                    <i class="fa-solid fa-user-tie" style="color:#16a34a;"></i>
                                                </span>
                                                <select name="officer" id="officer"
                                                    class="form-control @error('officer') is-invalid @enderror"
                                                    style="border-color:#bbf7d0;border-left:none;">
                                                    <option value="">Select Approve Officer</option>
                                                    @foreach ($staff as $person)
                                                        <option value="{{ $person->name }} ( {{ $person->staff_code }} ) ( {{ $person->position }} )"
                                                            {{ old('officer') == $person->name . ' ( ' . $person->staff_code . ' ) ( ' . $person->position . ' )' ? 'selected' : '' }}>
                                                            {{ $person->name }} ({{ $person->staff_code }}) ({{ $person->position }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @error('officer')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>

                                        {{-- Status --}}
                                        <div class="mb-3" style="animation:slideDown .4s .2s ease both;opacity:0;animation-fill-mode:forwards;">
                                            <label class="form-label fw-semibold" style="font-size:.85rem;color:#374151;">
                                                Status <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text" style="background:#f0fdf4;border-color:#bbf7d0;">
                                                    <i class="fa-solid fa-circle-half-stroke" style="color:#16a34a;"></i>
                                                </span>
                                                <select name="status" id="status"
                                                    class="form-control @error('status') is-invalid @enderror"
                                                    style="border-color:#bbf7d0;border-left:none;" required>
                                                    <option value="">Select Status</option>
                                                    <option value="Pending">Pending</option>
                                                    <option value="Distributed">Distributed</option>
                                                    <option value="Reject">Reject</option>
                                                </select>
                                            </div>
                                            @error('status')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>

                                        {{-- Pending/Reject Reason --}}
                                        <div class="mb-3" id="pendingDiv" style="display:none;animation:slideDown .3s ease both;">
                                            <label class="form-label fw-semibold" style="font-size:.85rem;color:#374151;">
                                                Reason <span class="text-danger">*</span>
                                            </label>
                                            <textarea name="pending_reason" id="pending_reason" class="form-control" rows="3"
                                                placeholder="Enter reason for pending or rejection..."
                                                style="border-color:#fca5a5;resize:none;font-size:.88rem;"></textarea>
                                            @error('pending_reason')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>

                                        {{-- Summary pill --}}
                                        <div class="mt-3 p-3 rounded-3 d-flex align-items-center gap-3"
                                            style="background:#f0fdf4;border:1px solid #bbf7d0;">
                                            <div id="approveSummaryCount" style="
                                                width:48px;height:48px;border-radius:50%;
                                                background:#16a34a;color:#fff;
                                                display:flex;align-items:center;justify-content:center;
                                                font-size:1.3rem;font-weight:700;flex-shrink:0;">0</div>
                                            <div>
                                                <div class="fw-semibold" style="color:#14532d;font-size:.9rem;">Beneficiaries selected</div>
                                                <div style="color:#16a34a;font-size:.8rem;">Ready for approval</div>
                                            </div>
                                        </div>

                                    </div>

                                    {{-- RIGHT — Selected persons --}}
                                    <div class="col-md-6 p-4" style="background:#fafafa;">
                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                            <p class="fw-semibold mb-0" style="color:#374151;font-size:.95rem;">
                                                <i class="fa-solid fa-users me-2" style="color:#16a34a;"></i>Selected Persons
                                            </p>
                                            <span id="approveListBadge" class="badge"
                                                style="background:#dcfce7;color:#15803d;font-size:.78rem;border-radius:20px;padding:5px 12px;font-weight:600;">
                                                0 selected
                                            </span>
                                        </div>
                                        <div id="approvePersonList" class="person-list-scroll"
                                            style="max-height:360px;overflow-y:auto;display:flex;flex-direction:column;gap:8px;">
                                            <div id="approveEmptyState" class="text-center py-5" style="color:#9ca3af;">
                                                <i class="fa-solid fa-inbox" style="font-size:2rem;display:block;margin-bottom:8px;"></i>
                                                <span style="font-size:.88rem;">No beneficiaries selected yet</span>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            {{-- Footer --}}
                            <div class="modal-footer" style="border-top:1px solid #d1fae5;background:#f0fdf4;padding:14px 24px;">
                                <button type="submit" class="btn btn-success fw-bold px-5"
                                    style="border-radius:8px;letter-spacing:.3px;background:linear-gradient(135deg,#16a34a,#15803d);border:none;">
                                    <i class="fa-solid fa-circle-check me-2"></i>Confirm Approval
                                </button>
                                <button type="button" class="btn btn-light fw-semibold px-4" data-bs-dismiss="modal" style="border-radius:8px;">
                                    Cancel
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>


            {{-- ══════════════════════════════════════════
                 BULK RETURN MODAL — two-panel layout
            ══════════════════════════════════════════ --}}
            <div class="modal fade" id="bulkReturnModal" tabindex="-1" aria-hidden="true"
                data-bs-backdrop="static" data-bs-keyboard="false">
                <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content" style="border-radius:14px;overflow:hidden;border:none;box-shadow:0 20px 60px rgba(0,0,0,.18);">
                        <form action="{{ route('bulk-return-distribute') }}" method="POST">
                            @csrf
                            <input type="hidden" name="return_items" id="return_items">

                            {{-- Header --}}
                            <div class="modal-header text-white"
                                style="background:linear-gradient(135deg,#f59e0b,#d97706);border:none;padding:18px 24px;">
                                <div class="d-flex align-items-center gap-3">
                                    <div style="width:42px;height:42px;border-radius:50%;background:rgba(255,255,255,.18);
                                        display:flex;align-items:center;justify-content:center;
                                        animation:spinIn .5s cubic-bezier(.34,1.56,.64,1) both;">
                                        <i class="fa-solid fa-rotate-left" style="font-size:17px;"></i>
                                    </div>
                                    <div>
                                        <h5 class="modal-title mb-0" style="font-weight:700;font-size:1.1rem;">Return Distributed Facilities</h5>
                                        <small style="opacity:.85;">
                                            <span id="modalReturnCount"
                                                style="font-weight:800;font-size:1.05em;display:inline-block;animation:popIn .4s .15s cubic-bezier(.34,1.56,.64,1) both;">0</span>
                                            &nbsp;record(s) selected
                                        </small>
                                    </div>
                                </div>
                                <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="modal"></button>
                            </div>

                            {{-- Two-panel body --}}
                            <div class="modal-body p-0" style="min-height:420px;">
                                <div class="row g-0" style="min-height:420px;">

                                    {{-- LEFT — Warning + Reason --}}
                                    <div class="col-md-6 p-4" style="border-right:1px solid #e5e7eb;">

                                        <p class="fw-semibold mb-3" style="color:#d97706;font-size:.95rem;letter-spacing:.3px;">
                                            <i class="fa-solid fa-triangle-exclamation me-2"></i>Return Details
                                        </p>

                                        {{-- Warning card --}}
                                        <div class="alert mb-4 d-flex align-items-start gap-3"
                                            style="background:#fff8ed;border:1.5px solid #f59e0b;border-radius:10px;padding:14px 16px;
                                            animation:slideDown .4s .1s ease both;">
                                            <i class="fa-solid fa-triangle-exclamation text-warning mt-1" style="font-size:20px;flex-shrink:0;"></i>
                                            <div>
                                                <strong style="color:#92400e;">Are you sure?</strong>
                                                <p class="mb-0 mt-1" style="color:#78350f;font-size:.88rem;line-height:1.5;">
                                                    This will <strong>clear</strong> the distribute date, place, and status
                                                    for all selected records. This cannot be undone automatically.
                                                </p>
                                            </div>
                                        </div>

                                        {{-- Reason --}}
                                        {{-- <div style="animation:slideDown .4s .2s ease both;opacity:0;animation-fill-mode:forwards;">
                                            <label class="form-label fw-semibold" style="font-size:.85rem;color:#374151;">
                                                Return Reason <span class="text-muted fw-normal">(optional)</span>
                                            </label>
                                            <textarea name="return_reason" class="form-control" rows="3"
                                                placeholder="e.g. Incorrect distribution, Data error..."
                                                style="border-color:#fde68a;resize:none;font-size:.88rem;"></textarea>
                                        </div> --}}

                                        {{-- Summary pill --}}
                                        <div class="mt-4 p-3 rounded-3 d-flex align-items-center gap-3"
                                            style="background:#fff8ed;border:1px solid #fde68a;">
                                            <div id="returnSummaryCount" style="
                                                width:48px;height:48px;border-radius:50%;
                                                background:#f59e0b;color:#fff;
                                                display:flex;align-items:center;justify-content:center;
                                                font-size:1.3rem;font-weight:700;flex-shrink:0;">0</div>
                                            <div>
                                                <div class="fw-semibold" style="color:#92400e;font-size:.9rem;">Beneficiaries selected</div>
                                                <div style="color:#d97706;font-size:.8rem;">Distribution will be reset</div>
                                            </div>
                                        </div>

                                    </div>

                                    {{-- RIGHT — Selected persons --}}
                                    <div class="col-md-6 p-4" style="background:#fafafa;">
                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                            <p class="fw-semibold mb-0" style="color:#374151;font-size:.95rem;">
                                                <i class="fa-solid fa-users me-2" style="color:#d97706;"></i>Selected Persons
                                            </p>
                                            <span id="returnListBadge" class="badge"
                                                style="background:#fef9c3;color:#a16207;font-size:.78rem;border-radius:20px;padding:5px 12px;font-weight:600;">
                                                0 selected
                                            </span>
                                        </div>
                                        <div id="returnPersonList" class="return-list-scroll"
                                            style="max-height:360px;overflow-y:auto;display:flex;flex-direction:column;gap:8px;">
                                            <div id="returnEmptyState" class="text-center py-5" style="color:#9ca3af;">
                                                <i class="fa-solid fa-inbox" style="font-size:2rem;display:block;margin-bottom:8px;"></i>
                                                <span style="font-size:.88rem;">No beneficiaries selected yet</span>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            {{-- Footer --}}
                            <div class="modal-footer" style="border-top:1px solid #fde68a;background:#fffbeb;padding:14px 24px;">
                                <button type="submit" class="btn fw-bold px-5 text-white"
                                    style="border-radius:8px;letter-spacing:.3px;background:linear-gradient(135deg,#f59e0b,#d97706);border:none;">
                                    <i class="fa-solid fa-rotate-left me-2"></i>Confirm Return
                                </button>
                                <button type="button" class="btn btn-light fw-semibold px-4" data-bs-dismiss="modal" style="border-radius:8px;">
                                    Cancel
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        function printTable() { window.print(); }
    </script>

    <script>
        const allDistricts = @json($districtsByState);
        const oldDistrict  = "{{ old('district') }}";
        const oldState     = "{{ old('state') }}";

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
        if (oldState) populateDistricts(oldState);
        document.getElementById('stateSelect').addEventListener('change', function() {
            populateDistricts(this.value);
        });
    </script>

    <script>
    document.addEventListener('DOMContentLoaded', function () {

        /* ── Shared ── */
        const selectAll = document.getElementById('select_all_distribute');
        const items     = document.querySelectorAll('.select_distribute_item');

        /* ── Approve elements ── */
        const openApproveBtn      = document.getElementById('openDistributeModal');
        const approveBadge        = document.getElementById('approveBadge');
        const modalApproveCount   = document.getElementById('modalDistributeCount');
        const modalApproveCountTxt= document.getElementById('modalDistributeCountText');
        const approveSummaryCount = document.getElementById('approveSummaryCount');
        const approveListBadge    = document.getElementById('approveListBadge');
        const approveInput        = document.getElementById('distribute_items');
        const approvePersonList   = document.getElementById('approvePersonList');
        const approveEmptyState   = document.getElementById('approveEmptyState');
        const approveModalEl      = document.getElementById('bulkDistributeModal');

        /* ── Return elements ── */
        const openReturnBtn     = document.getElementById('openReturnModal');
        const returnBadge       = document.getElementById('returnBadge');
        const modalReturnCount  = document.getElementById('modalReturnCount');
        const returnSummaryCount= document.getElementById('returnSummaryCount');
        const returnListBadge   = document.getElementById('returnListBadge');
        const returnInput       = document.getElementById('return_items');
        const returnPersonList  = document.getElementById('returnPersonList');
        const returnEmptyState  = document.getElementById('returnEmptyState');
        const returnModalEl     = document.getElementById('bulkReturnModal');

        /* ── Status/reason toggle ── */
        const statusSelect         = document.getElementById('status');
        const pendingDiv           = document.getElementById('pendingDiv');
        const pendingReasonTextarea= document.getElementById('pending_reason');

        let approveModalInstance = null;
        let returnModalInstance  = null;

        /* ── Badge bounce ── */
        function bounceBadge(badge, count) {
            badge.textContent = count;
            badge.classList.remove('badge-pop');
            void badge.offsetWidth;
            badge.classList.add('badge-pop');
            setTimeout(() => badge.classList.remove('badge-pop'), 350);
        }

        /* ── Person card builder ── */
        function buildCard(item, idx, accentColor) {
            const row    = item.closest('tr');
            const cells  = row.querySelectorAll('td');
            const regNo  = cells[2] ? cells[2].textContent.trim() : '—';
            const name   = cells[3] ? cells[3].textContent.trim() : '—';
            const father = cells[4] ? cells[4].textContent.trim() : '—';
            const mobile = cells[8] ? cells[8].textContent.trim() : '—';
            const facility= cells[16] ? cells[16].textContent.trim() : '—';

            const palette = ['#16a34a','#0891b2','#7c3aed','#db2777','#d97706','#dc2626'];
            const bg      = palette[idx % palette.length];
            const initials= name.split(' ').slice(0,2).map(w => w[0] || '').join('').toUpperCase();

            const card = document.createElement('div');
            card.style.cssText = `background:#fff;border:1px solid #e5e7eb;border-radius:10px;
                padding:10px 14px;display:flex;align-items:center;gap:12px;
                animation:cardIn .3s ${idx * 0.055}s ease both;`;
            card.innerHTML = `
                <div style="width:40px;height:40px;border-radius:50%;background:${bg};color:#fff;flex-shrink:0;
                    display:flex;align-items:center;justify-content:center;font-weight:700;font-size:.85rem;letter-spacing:.5px;">
                    ${initials}
                </div>
                <div style="flex:1;min-width:0;">
                    <div style="font-weight:600;font-size:.88rem;color:#111827;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">${name}</div>
                    <div style="font-size:.75rem;color:#6b7280;margin-top:1px;">
                        Reg: <strong style="color:#374151;">${regNo}</strong>
                        &nbsp;·&nbsp;<i class="fa-solid fa-phone" style="font-size:.65rem;"></i> ${mobile}
                    </div>
                    <div style="font-size:.72rem;color:#9ca3af;margin-top:1px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                        F/H: ${father} &nbsp;·&nbsp; ${facility}
                    </div>
                </div>
                <span style="background:${accentColor};color:#fff;font-size:.7rem;font-weight:600;
                    padding:3px 8px;border-radius:20px;flex-shrink:0;">#${idx+1}</span>
            `;
            return card;
        }

        /* ── Render person lists ── */
        function renderApproveList(selected) {
            approvePersonList.innerHTML = '';
            if (selected.length === 0) { approvePersonList.appendChild(approveEmptyState); return; }
            selected.forEach((item, idx) => approvePersonList.appendChild(buildCard(item, idx, '#16a34a')));
        }

        function renderReturnList(selected) {
            returnPersonList.innerHTML = '';
            if (selected.length === 0) { returnPersonList.appendChild(returnEmptyState); return; }
            selected.forEach((item, idx) => returnPersonList.appendChild(buildCard(item, idx, '#f59e0b')));
        }

        /* ── Master update ── */
        function updateSelection() {
            const selected = Array.from(items).filter(i => i.checked);
            const count    = selected.length;
            const value    = selected.map(i => i.value).join(',');

            /* Approve */
            openApproveBtn.disabled           = count === 0;
            approveInput.value                = value;
            modalApproveCount.textContent     = count;
            if (modalApproveCountTxt) modalApproveCountTxt.textContent = count;
            approveSummaryCount.textContent   = count;
            approveListBadge.textContent      = count + ' selected';
            bounceBadge(approveBadge, count);

            /* Return */
            openReturnBtn.disabled           = count === 0;
            returnInput.value                = value;
            modalReturnCount.textContent     = count;
            returnSummaryCount.textContent   = count;
            returnListBadge.textContent      = count + ' selected';
            bounceBadge(returnBadge, count);

            /* Select-all */
            if (selectAll) {
                selectAll.checked       = count === items.length && items.length > 0;
                selectAll.indeterminate = count > 0 && count < items.length;
            }
        }

        items.forEach(item => item.addEventListener('change', updateSelection));
        if (selectAll) {
            selectAll.addEventListener('change', function () {
                items.forEach(i => i.checked = this.checked);
                updateSelection();
            });
        }

        /* ── Open Approve Modal ── */
        openApproveBtn.addEventListener('click', function () {
            const selected = Array.from(items).filter(i => i.checked);
            if (selected.length === 0) {
                openApproveBtn.classList.add('shake');
                setTimeout(() => openApproveBtn.classList.remove('shake'), 450);
                return;
            }
            renderApproveList(selected);
            if (!approveModalInstance) {
                approveModalInstance = new bootstrap.Modal(approveModalEl, { backdrop: 'static', keyboard: false });
            }
            approveModalInstance.show();
        });

        /* ── Open Return Modal ── */
        openReturnBtn.addEventListener('click', function () {
            const selected = Array.from(items).filter(i => i.checked);
            if (selected.length === 0) {
                openReturnBtn.classList.add('shake');
                setTimeout(() => openReturnBtn.classList.remove('shake'), 450);
                return;
            }
            renderReturnList(selected);
            if (!returnModalInstance) {
                returnModalInstance = new bootstrap.Modal(returnModalEl, { backdrop: 'static', keyboard: false });
            }
            returnModalInstance.show();
        });

        /* ── Status toggle (Pending/Reject reason) ── */
        function togglePendingReason() {
            if (!statusSelect || !pendingDiv) return;
            const val = statusSelect.value;
            if (val === 'Pending' || val === 'Reject') {
                pendingDiv.style.display = 'block';
                if (pendingReasonTextarea) pendingReasonTextarea.setAttribute('required', 'required');
            } else {
                pendingDiv.style.display = 'none';
                if (pendingReasonTextarea) {
                    pendingReasonTextarea.removeAttribute('required');
                    pendingReasonTextarea.value = '';
                }
            }
        }

        if (statusSelect) {
            togglePendingReason();
            statusSelect.addEventListener('change', togglePendingReason);
        }

        /* ── Reset form on approve modal close ── */
        approveModalEl.addEventListener('hidden.bs.modal', function () {
            const form = document.getElementById('bulkDistributeForm');
            if (form) { form.reset(); togglePendingReason(); }
        });

        updateSelection();
    });
    </script>
@endsection