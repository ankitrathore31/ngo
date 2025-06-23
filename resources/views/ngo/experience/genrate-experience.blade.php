@extends('ngo.layout.master')
@section('content')
    <style>
        #recordTableDiv {
            transition: opacity 0.3s ease;
        }

        @media print {
            @page {
                size: A4 portrait;
                margin: 8mm;
            }

            body {
                margin: 0;
                padding: 0;
                /* font-family: 'Noto Sans Devanagari', 'Arial', sans-serif; */
            }

            body * {
                visibility: hidden;
            }

            .print-area,
            .print-area * {
                visibility: visible;
            }

            .print-area {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                max-width: 210mm;
                padding: 5mm;
                box-sizing: border-box;
                color: #000;
                font-size: 14px;
                line-height: 1.1;
            }

            .print-area strong {
                font-weight: 300;
            }

            .bg-danger {
                background-color: #d9534f !important;
                color: #fff !important;
            }

            .no-print {
                display: none !important;
            }
        }
    </style>


    <div class="wrapper">
        <div class="d-flex justify-content-between align-item-centre mb-0 mt-4">
            <h5 class="mb-0">Experience Letter</h5>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Letter</li>
                </ol>
            </nav>
        </div>
        @if (session('success'))
            <div id="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <!-- Language Toggle -->
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-3 mt-4">
                <h5 class="mb-0">
                    {{-- <span data-lang="hi">दान रसीद</span> --}}
                    <span>Experience Letter</span>
                </h5>
                <div>
                    <button onclick="window.print()" class="btn btn-primary">Print / Download</button>
                    <button class="btn btn-sm btn-outline-primary" onclick="setLanguage('en')">English</button>
                    <button class="btn btn-sm btn-outline-success" onclick="setLanguage('hi')">हिंदी</button>
                </div>
            </div>
            <div class="letterhead print-area">
                <div class="card shadow rounded p-4 my-4 border border-dark">
                    <div class="text-center mb-4 border-bottom pb-3 mb-2">
                        <!-- Header -->
                        <div class="row">
                            <div class="col-sm-2 text-center text-md-start">
                                <img src="{{ asset('images/LOGO.png') }}" alt="Logo" width="80" height="80">
                            </div>
                            <div class="col-sm-10">
                                <p style="margin: 0;" class="d-flex justify-content-around"><b>
                                        <span>CSR NO. CSR00059991</span>&nbsp;
                                        &nbsp; &nbsp;<span>12A AAEAG7650BE20231</span>&nbsp; &nbsp;
                                        &nbsp; &nbsp;<span>80G AAEAG7650BF20231</span>&nbsp;
                                    </b></p>
                                <p style="margin: 0;" class="d-flex justify-content-around"><b>
                                        <span>NEETI AYOG ID NO. UP/2023/0360430</span>&nbsp;
                                        &nbsp; &nbsp;<span>NGO NO. UP/00033062</span>&nbsp; &nbsp;
                                        &nbsp; &nbsp;<span>PAN: AAEAG7650B</span>&nbsp;
                                    </b></p>
                                <h4 style="color: red;"><b>
                                        <span data-lang="hi">ज्ञान भारती संस्था</span>
                                        <span data-lang="en">GYAN BHARTI SANSTHA</span>
                                    </b></h4>
                                <h6 style="color: blue;"><b>
                                        <span data-lang="hi">ग्राम - कैंचू टांडा, पोस्ट - अमरिया, जिला - पीलीभीत, उत्तर
                                            प्रदेश -
                                            262121</span>
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
                    <div class="row">
                        <!-- Search Input -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <input type="text" id="searchInput" class="form-control"
                                    placeholder="Search by Reg. No, Name, Phone, or ID No">
                            </div>
                        </div>

                        <!-- Results Table -->
                        <!-- Results Table -->
                        <div id="recordTableDiv" style="display: none;" class="table-responsive">
                            <table id="recordTable" class="table table-bordered table-striped table-hover"
                                style="border-collapse: collapse; width: 100%;">
                                <thead class="table-primary">
                                    <tr>
                                        <th>Type</th>
                                        <th>Registration No</th>
                                        <th>Name</th>
                                        <th>Father/Husband</th>
                                        <th>Phone</th>
                                        <th>Identity Type</th>
                                        <th>Identity No</th>
                                        <th>Session</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($record as $item)
                                        <tr class="record-row" data-id="{{ $item->id }}" data-name="{{ $item->name }}"
                                            data-phone="{{ $item->phone }}" data-gurdian="{{ $item->gurdian_name }}"
                                            data-registration="{{ $item->registration_no }}"
                                            data-registrationdate="{{ $item->registration_date }}"
                                            data-address="{{ $item->village }}, {{ $item->post }}, {{ $item->block }}, {{ $item->district }}, {{ $item->state }} - {{ $item->pincode }}"
                                            style="cursor: pointer;">

                                            <td>{{ get_class($item) === 'App\\Models\\beneficiarie' ? 'Beneficiary' : 'Member' }}
                                            </td>
                                            <td>{{ $item->registration_no ?? 'Not Found' }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->gurdian_name }}</td>
                                            <td>{{ $item->phone }}</td>
                                            <td>{{ $item->identity_type ?? '—' }}</td>
                                            <td>{{ $item->identity_no ?? '—' }}</td>
                                            <td>{{ $item->academic_session ?? '_' }}</td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>



                        <!-- Selected Record Info -->
                        <div id="selectedRecord" class="mt-3" style="display: none;">
                            <div class="card shadow-sm border rounded p-3 bg-light">
                                <h5 class="card-title text-primary">Selected Person Details</h5>
                                <div class="card-body">
                                    <ul class="list-unstyled mb-0" id="selectedInfo">
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <form action="{{ route('save-experience') }}" method="post">
                        @csrf
                        <input type="text" name="beneficiarie_id"
                            value="{{ old('beneficiarie_id', $experience->beneficiarie_id ?? '') }}" id="beneficiarie_id"
                            hidden>
                        <div class=" p-4 lh-lg" style="font-size: 16px;">
                            <div class="row justify-content-between mb-3">
                                <div class="col-sm-6">
                                    <strong><span data-lang="hi">प्रमाण-पत्र क्रमांक:</span> <span
                                            data-lang="en">Certificate
                                            No.:</span></strong>
                                    <span id=""><input id="certRegNo" type="text" name="certiNo"
                                            value=""></span>
                                </div>

                                <div class="col-sm-6 text-end">
                                    <strong><span data-lang="hi">तारीख:</span> <span data-lang="en">Date:</span></strong>
                                    <span id="certDate"><input type="date" name="date" id="date"
                                            >
                                    </span>
                                </div>
                            </div>

                            <span data-lang="hi">
                                यह प्रमाणित किया जाता है कि श्री/श्रीमती/कुमारी <strong id="certNameHi">__________</strong>,
                                पिता/पति <strong id="certGurdianHi">__________</strong>,
                                निवासी <strong id="certAddressHi">__________</strong>
                                भारत में दिनांक <span><input type="date" id="fromDate" name="fromDate"
                                        >
                                </span> से
                                <strong><input type="date" id="toDate" name="toDate"
                                       >
                                </strong>
                                तक समन्वयक के पद पर कार्यरत हैं। कार्य अवधि में मैंने पाया कि वे एक ईमानदार, मेहनती,
                                समर्पित,
                                पेशेवर दृष्टिकोण वाले तथा कार्यालय और क्षेत्र की नौकरी के बारे में बहुत अच्छे ज्ञान वाले
                                व्यक्ति
                                हैं। इस अवधि के दौरान उनका चरित्र और आचरण अनुकरणीय रहा है। मैं उन्हें भविष्य के करियर
                                प्रयासों
                                में शुभकामनाएं और सफलता की कामना करता हूं।
                            </span>

                            <span data-lang="en">
                                This is to certify that Mr./Ms./Mrs. <strong id="certNameEn">__________</strong>,
                                Son/Daughter/Wife of <strong id="certGurdianEn">__________</strong>,
                                resident of <strong id="certAddressEn">__________</strong> from
                                <span><input type="date" id="fromDate" name="fromDate"
                                        value="{{ old('fromDate', $experience->fromDate ?? '') }}"></span> to
                                <span><input type="date" id="toDate" name="toDate"
                                        value="{{ old('toDate', $experience->toDate ?? '') }}">
                                </span>as a
                                Coordinator.
                                In the working period I found him a since, honest, hardworking. Dedicated with
                                a professional attitude and very good office and field job knowledge. His
                                character and conduct during this period hasbeen exemplary.
                                I wish his all the best and success in future career endeavours.
                            </span>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <input type="submit" class="btn btn-success p-2 mt-2" value="Save">
                            </div>
                        </div>
                    </form>

                    <!-- Signature Section -->

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
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const tableDiv = document.getElementById('recordTableDiv');
            const tableRows = document.querySelectorAll('.record-row');
            const selectedRecord = document.getElementById('selectedRecord');
            const selectedInfo = document.getElementById('selectedInfo');

            // Filter on search input
            searchInput.addEventListener('input', function() {
                const query = this.value.toLowerCase();
                let match = false;

                tableRows.forEach(row => {
                    const text = row.innerText.toLowerCase();
                    if (text.includes(query)) {
                        row.style.display = '';
                        match = true;
                    } else {
                        row.style.display = 'none';
                    }
                });

                tableDiv.style.display = (query.trim() !== '' && match) ? 'block' : 'none';
            });

            // Fill fields when table row is clicked
            tableRows.forEach(row => {
                row.addEventListener('click', function() {
                    const id = this.dataset.id;
                    const name = this.dataset.name;
                    const phone = this.dataset.phone;
                    const gurdian = this.dataset.gurdian;
                    const address = this.dataset.address;
                    const registration = this.dataset.registration;
                    const registrationDate = this.dataset.registrationDate;

                    // Certificate section filling by ID
                    document.getElementById('beneficiarie_id').value = id;
                    document.getElementById('certNameHi').textContent = name;
                    document.getElementById('certGurdianHi').textContent = gurdian;
                    document.getElementById('certAddressHi').textContent = address;

                    document.getElementById('certNameEn').textContent = name;
                    document.getElementById('certGurdianEn').textContent = gurdian;
                    document.getElementById('certAddressEn').textContent = address;

                    document.getElementById('certRegNo').value = registration;
                    // document.getElementById('certDate').textContent = registrationDate;



                    // Show selected record summary
                    selectedInfo.innerHTML = `
        <div class="row">
            <div class="col-md-3"><strong>Name:</strong> ${name}</div>
            <div class="col-md-3"><strong>Mobile:</strong> ${phone}</div>
            <div class="col-md-3"><strong>Registration No.:</strong> ${registration}</div>
        </div>
    `;

                    selectedRecord.style.display = 'block'; // shows the selected record info
                    tableDiv.style.display = 'none'; // hides the table
                    searchInput.value = ''; // clears the search box

                });

                tableDiv.style.opacity = '0';
                setTimeout(() => {
                    tableDiv.style.display = 'none';
                    tableDiv.style.opacity = '1'; // reset for next time
                }, 300);

            });

        });
    </script>
@endsection
