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
                Distribute Selected
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
                                        <span data-lang="en">Village - Kainchu Tanda, Post - Amaria, District - Pilibhit, UP
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

            <div class="modal fade" id="bulkDistributeModal" tabindex="-1" aria-hidden="true"
                data-bs-backdrop="static" data-bs-keyboard="false">

                <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">

                        <form action="{{ route('store-bulk-distribute') }}" method="POST">
                            @csrf

                            <!-- IMPORTANT: single hidden input ONLY -->
                            <input type="hidden" name="distribute_items" id="distribute_items">

                            <div class="modal-header bg-success text-white">
                                <h5 class="modal-title">
                                    Distribute Beneficiarie Facilities
                                    (<span id="modalDistributeCount">0</span> Selected)
                                </h5>
                                <button type="button" class="btn-close btn-close-white"
                                    data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">

                                <div class="mb-3">
                                    <label class="form-label">
                                        Distribute Date <span class="text-danger">*</span>
                                    </label>
                                    <input type="date" name="distribute_date" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Distribute Place</label>
                                    <textarea name="distribute_place" class="form-control"></textarea>
                                </div>

                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">
                                    Distribute Facilities
                                </button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
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
        function printTable() {
            window.print();
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const selectAll = document.getElementById('select_all_distribute');
            const items = document.querySelectorAll('.select_distribute_item');
            const openBtn = document.getElementById('openDistributeModal');
            const modalCount = document.getElementById('modalDistributeCount');
            const hiddenInput = document.getElementById('distribute_items');
            const modalEl = document.getElementById('bulkDistributeModal');

            let modalInstance = null;

            function updateSelection() {
                const selected = Array.from(items).filter(i => i.checked);
                const count = selected.length;

                openBtn.disabled = count === 0;
                modalCount.textContent = count;
                hiddenInput.value = selected.map(i => i.value).join(',');

                if (selectAll) {
                    selectAll.checked = count === items.length && items.length > 0;
                    selectAll.indeterminate = count > 0 && count < items.length;
                }
            }

            /* Individual checkbox */
            items.forEach(item => {
                item.addEventListener('change', updateSelection);
            });

            /* Select all checkbox */
            if (selectAll) {
                selectAll.addEventListener('change', function() {
                    items.forEach(i => i.checked = this.checked);
                    updateSelection();
                });
            }

            /* Open modal ONLY on button click */
            openBtn.addEventListener('click', function() {

                if (!hiddenInput.value) return;

                if (!modalInstance) {
                    modalInstance = new bootstrap.Modal(modalEl, {
                        backdrop: 'static',
                        keyboard: false
                    });
                }

                modalInstance.show();
            });

        });
    </script>
@endsection
