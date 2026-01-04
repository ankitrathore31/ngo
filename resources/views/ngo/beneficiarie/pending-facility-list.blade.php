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
            <div class="row">
                <div class="col-md-12">
                    <form method="GET" action="{{ route('distributed-list') }}" class="row g-3 mb-4">
                        <div class="row">
                            <div class="col-md-4 mb-3">
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

                            <div class="col-md-4 mb-3">
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

                            <div class=" col-md-4">
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


                            <div class="col-md-4 form-group mb-3">
                                <input type="date" id="distribute_date" name="distribute_date" class="form-control"
                                    value="{{ old('distribute_date') }}">
                                <small class="form-text text-muted"><b>Select Distribute Date</b></small>
                                @error('distribute_date')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                        </div>
                        <div class="row">

                            @php
                                $districtsByState = config('districts');
                            @endphp
                            <div class="col-md-4 col-sm-6 form-group mb-3">
                                {{-- <label for="stateSelect" class="form-label">State: <span class="text-danger">*</span></label> --}}
                                <select class="form-control @error('state') is-invalid @enderror" name="state"
                                    id="stateSelect">
                                    <option value="">Select State</option>
                                    @foreach ($districtsByState as $state => $districts)
                                        <option value="{{ $state }}"
                                            {{ old('state') == $state ? 'selected' : '' }}>
                                            {{ $state }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('state')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror

                            </div>
                            <div class="col-md-4 col-sm-6 form-group mb-3">
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
                            <div class="col-md-4 col-sm-6 form-group mb-3">
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
                                <a href="{{ route('distributed-list') }}" class="btn btn-info text-white me-1">Reset</a>
                            </div>
                        </div>
                    </form>
                    <button onclick="printTable()" class="btn btn-primary mb-3">Print Table</button>
                </div>
            </div>
            <button type="button" id="openDistributeModal" class="btn btn-success" disabled>
                Distribute Selected (<span id="selectedDistributeCount">0</span>)
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
                                <th>Name</th>
                                <th>Father/Husband Name</th>
                                <th>Address</th>
                                <th>Identity No.</th>
                                <th>Identity Type</th>
                                <th>Mobile no.</th>
                                <th>Caste</th>
                                <th>Caste Category</th>
                                <th>Religion</th>
                                <th>Age</th>
                                <th>Distribute Date</th>
                                <th>Distribute Place</th>
                                <th>Facilities Category</th>
                                <th>Facilities</th>
                                <th>Signature/
                                    Thumb Impression of the Recipient
                                </th>
                                <th>Beneficiarie Eligibility category</th>
                                <th>Session</th>
                                <th class="no-print">Action</th>
                                <th class="no-print">Token No.</th>
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
                                            {{ $survey->distribute_date ? \Carbon\Carbon::parse($survey->distribute_date)->format('d-m-Y') : 'No Found' }}
                                        </td>
                                        <td>{{ $survey->distribute_place ?? 'No Found' }}</td>
                                        <td>{{ $survey->facilities_category ?? 'No Found' }}</td>
                                        <td>{{ $survey->facilities ?? 'No Found' }}</td>
                                        <td></td>
                                        <td>{{ $survey->bene_category ?? 'No Found' }}</td>
                                        <td>{{ $survey->academic_session }}</td>
                                        <td class="no-print">
                                            <div class="d-flex justify-content-center align-items-center gap-3 flex-wrap">

                                                <a href="{{ route('distribute-facilities-status', [$item->id, $survey->id]) }}"
                                                    class="btn btn-success px-4 py-2" title="Approve">
                                                    Approve
                                                </a>

                                               <a href="{{ route('delete-distribute-facilities', [$item->id, $survey->id]) }}" onclick="return confirm('Are you sure want to delete Distribute Facilities')" class="btn btn-danger btn-sm px-3"
                                                    title="Delete">
                                                    <i class="fa-regular fa-trash"></i>
                                                </a>

                                            </div>
                                        </td>
                                        <td class="no-print">
                                            <div class="d-flex justify-content-center gap-2 flex-wrap">
                                                <a href="{{ route('show-beneficiarie-token', [$item->id, $survey->id]) }}"
                                                    class="btn btn-success btn-sm px-3 d-flex align-items-center justify-content-center"
                                                    title="View">
                                                    Token
                                                </a>
                                            </div>
                                        </td>
                                        <td class="no-print">
                                            <div class="d-flex justify-content-center gap-2 flex-wrap">
                                                <a href="{{-- route('show-beneficiarie-report', [$item->id, $survey->id]) --}}"
                                                    class="btn btn-success btn-sm px-3 d-flex align-items-center justify-content-center"
                                                    title="View">
                                                    Recipt
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Modal (Place at the end, before closing </div></div>) -->
            <div class="modal fade" id="bulkDistributeModal" tabindex="-1" aria-labelledby="bulkDistributeModalLabel"
                aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <form action="{{ route('store-bulk-distribute-status') }}" method="POST"
                            id="bulkDistributeForm">
                            @csrf

                            <!-- Hidden input to store selected items -->
                            <input type="hidden" name="distribute_items" id="distribute_items">

                            <div class="modal-header bg-success text-white">
                                <h5 class="modal-title" id="bulkDistributeModalLabel">
                                    Distribute Beneficiarie Facilities
                                    (<span id="modalDistributeCount">0</span> Selected)
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>

                            <div class="modal-body">
                                <div class="alert alert-info">
                                    <i class="fa fa-info-circle"></i>
                                    You are about to distribute facilities to <strong><span
                                            id="modalDistributeCountText">0</span></strong> beneficiaries.
                                </div>

                                <!-- Approve Officer -->
                                <div class="mb-3">
                                    <label for="officer" class="form-label">Approve Officer:</label>
                                    <select name="officer" id="officer"
                                        class="form-control @error('officer') is-invalid @enderror">
                                        <option value="">Select Approve Officer</option>
                                        @foreach ($staff as $person)
                                            <option
                                                value="{{ $person->name }} ( {{ $person->staff_code }} ) ( {{ $person->position }} )"
                                                {{ old('officer') == $person->name . ' ( ' . $person->staff_code . ' ) ( ' . $person->position . ' )' ? 'selected' : '' }}>
                                                {{ $person->name }} ({{ $person->staff_code }}) ({{ $person->position }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('officer')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Status -->
                                <div class="mb-3">
                                    <label for="status" class="form-label">
                                        Status <span class="text-danger">*</span>
                                    </label>
                                    <select name="status" id="status"
                                        class="form-control @error('status') is-invalid @enderror" required>
                                        <option value="">Select Status</option>
                                        <option value="Pending">Pending</option>
                                        <option value="Distributed">Distributed</option>
                                        <option value="Reject">Reject</option>
                                    </select>
                                    @error('status')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Pending/Reject Reason (Hidden by default) -->
                                <div class="mb-3" id="pendingDiv" style="display: none;">
                                    <label for="pending_reason" class="form-label">
                                        Reason: <span class="text-danger">*</span>
                                    </label>
                                    <textarea name="pending_reason" id="pending_reason" class="form-control" rows="3"
                                        placeholder="Enter reason for pending or rejection..."></textarea>
                                    @error('pending_reason')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    <i class="fa fa-times"></i> Cancel
                                </button>
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-check"></i> Distribute Facilities
                                </button>
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const selectAll = document.getElementById('select_all_distribute');
            const items = document.querySelectorAll('.select_distribute_item');
            const openBtn = document.getElementById('openDistributeModal');
            const tableCount = document.getElementById('selectedDistributeCount');
            const modalCount = document.getElementById('modalDistributeCount');
            const hiddenInput = document.getElementById('distribute_items');
            const modalEl = document.getElementById('bulkDistributeModal');

            // Initialize Bootstrap modal instance
            const modal = new bootstrap.Modal(modalEl, {
                backdrop: 'static',
                keyboard: false
            });

            // Force hide modal and clean up any artifacts on page load
            function cleanupModal() {
                modalEl.classList.remove('show', 'fade');
                modalEl.style.display = 'none';
                modalEl.setAttribute('aria-hidden', 'true');
                modalEl.removeAttribute('aria-modal');
                modalEl.removeAttribute('role');
                document.body.classList.remove('modal-open');
                document.body.style.removeProperty('overflow');
                document.body.style.removeProperty('padding-right');

                // Remove any existing backdrops
                const backdrops = document.querySelectorAll('.modal-backdrop');
                backdrops.forEach(backdrop => backdrop.remove());

                // Re-add fade class for animation
                setTimeout(() => {
                    modalEl.classList.add('fade');
                }, 50);
            }

            // Clean up on initial load
            cleanupModal();

            // Update selection state and UI
            function updateState() {
                const selected = Array.from(items).filter(cb => cb.checked);
                const count = selected.length;

                // Update all count displays
                if (tableCount) tableCount.textContent = count;
                if (modalCount) modalCount.textContent = count;

                // Update third count in modal alert (if exists)
                const modalCountText = document.getElementById('modalDistributeCountText');
                if (modalCountText) modalCountText.textContent = count;

                // Enable/disable distribute button
                openBtn.disabled = count === 0;

                // Update hidden input with selected values
                hiddenInput.value = selected.map(cb => cb.value).join(',');

                // Update select all checkbox state
                if (selectAll) {
                    const allChecked = count === items.length && items.length > 0;
                    const someChecked = count > 0 && count < items.length;

                    selectAll.checked = allChecked;
                    selectAll.indeterminate = someChecked;
                }
            }

            // Select/Deselect all functionality
            if (selectAll) {
                selectAll.addEventListener('change', function() {
                    const isChecked = this.checked;
                    items.forEach(cb => {
                        cb.checked = isChecked;
                    });
                    updateState();
                });
            }

            // Individual checkbox change
            items.forEach(cb => {
                cb.addEventListener('change', updateState);
            });

            // Open modal button click
            openBtn.addEventListener('click', function(e) {
                e.preventDefault();

                // Double check we have selections
                if (!hiddenInput.value || hiddenInput.value.trim() === '') {
                    alert('Please select at least one beneficiary to distribute facilities.');
                    return;
                }

                // Update modal count one more time before showing
                const selectedCount = hiddenInput.value.split(',').filter(v => v.trim()).length;
                if (modalCount) modalCount.textContent = selectedCount;

                // Show the modal
                modal.show();
            });

            // Clean up when modal is hidden
            modalEl.addEventListener('hidden.bs.modal', function() {
                cleanupModal();
            });

            // Initialize state on page load
            updateState();

            // ========================================
            // Status Change - Show/Hide Pending Reason
            // ========================================
            const statusSelect = document.getElementById('status');
            const pendingDiv = document.getElementById('pendingDiv');
            const pendingReasonTextarea = document.getElementById('pending_reason');

            function togglePendingReason() {
                if (statusSelect && pendingDiv) {
                    const statusValue = statusSelect.value;

                    if (statusValue === 'Pending' || statusValue === 'Reject') {
                        pendingDiv.style.display = 'block';
                        if (pendingReasonTextarea) {
                            pendingReasonTextarea.setAttribute('required', 'required');
                        }
                    } else {
                        pendingDiv.style.display = 'none';
                        if (pendingReasonTextarea) {
                            pendingReasonTextarea.removeAttribute('required');
                            pendingReasonTextarea.value = ''; // Clear value when hidden
                        }
                    }
                }
            }

            // Run on page load
            if (statusSelect) {
                togglePendingReason();

                // Run on status change
                statusSelect.addEventListener('change', togglePendingReason);
            }

            // Reset form when modal is closed
            modalEl.addEventListener('hidden.bs.modal', function() {
                const form = document.getElementById('bulkDistributeForm');
                if (form) {
                    form.reset();
                    togglePendingReason(); // Hide pending div after reset
                }
                cleanupModal();
            });

        });
    </script>
@endsection
