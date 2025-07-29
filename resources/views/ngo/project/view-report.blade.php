@extends('ngo.layout.master') {{-- Adjust as per your layout --}}
@section('content')
    <style>
        .print-h4 {
            background-color: red !important;
            color: white !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
            font-size: 28px;
            word-spacing: 8px;
            text-align: center;
        }

        /* Container styling */
        .project-container {
            background: #f9fbfd;
            padding: 25px;
            border-radius: 12px;
            font-family: 'Poppins', sans-serif;
            color: #2d3436;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
        }

        /* Header (top block) */
        .project-header {
            background: linear-gradient(135deg, #4e73df, #224abe);
            color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        /* Project Image */
        .project-image {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            border: 3px solid #fff;
            object-fit: cover;
        }

        /* Titles & Subtitles */
        .project-title {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 8px;
            text-transform: uppercase;
        }

        .project-sub-title {
            font-size: 1rem;
            font-weight: 500;
            line-height: 1.4;
        }

        .project-info {
            font-size: 0.95rem;
            margin-top: 8px;
        }

        /* Section Titles (Mission, Conclusion) */
        .section-title {
            font-weight: 600;
            font-size: 1.2rem;
            margin-top: 20px;
            margin-bottom: 8px;
            border-left: 4px solid #4e73df;
            padding-left: 10px;
            color: #2c3e50;
        }

        /* Section Content */
        .section-text {
            font-size: 1rem;
            background: #ffffff;
            padding: 12px;
            border-radius: 6px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
            margin-bottom: 15px;
        }

        /* Table Styling */
        .budget-table {
            background: #ffffff;
            border-radius: 8px;
            over;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .budget-table thead {
            background: #4e73df;
            color: #fff;
        }

        .budget-table thead th {
            text-align: center;
            font-weight: 600;
            padding: 10px;
        }

        .budget-table tbody td {
            padding: 8px 10px;
            font-size: 0.95rem;
            vertical-align: middle;
        }

        .budget-table tbody tr:nth-child(even) {
            background: #f8f9fc;
        }

        .budget-table .total-row {
            background: #e3e6f0;
            font-weight: bold;
            color: #2c3e50;
        }

        .certificate-card {
            border: 1px solid #d4af37;
            padding: 10px;
            background: #fff;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            text-align: center;
        }

        .certificate-title {
            font-weight: bolder;
            margin-bottom: 10px;
        }

        /* Ensure images are equal size */
        .certificate-card img {
            width: 100%;
            height: 200px;
            /* Keep fixed height */
            object-fit: contain;
            /* Show full image without cropping */
            background: #f8f8f8;
            /* Optional: add background for empty space */
            border-radius: 5px;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .certificate-card img {
                height: 180px;
                /* slightly smaller on mobile */
            }
        }


        /* Hide everything except the printable area when printing */
        @media print {
            body * {
                visibility: hidden;
            }

            #printable-area,
            #printable-area * {
                visibility: visible;
            }

            #printable-area {
                position: absolute;
                left: 0;
                top: 0;
                width: 210mm;
                /* A4 width */
                min-height: 297mm;
                /* A4 height */
                padding: 8mm;
                box-sizing: border-box;
                background: #fff;
            }

            /* Page break handling */
            .page-break {
                page-break-before: always;
            }

            /* Ensure background colors print correctly */
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            /* Font adjustments for print */
            .print-h4 {
                background-color: red !important;
                color: white !important;
                font-size: 24px;
                text-align: center;
                padding: 5px 0;
            }

            /* Remove shadows and rounded corners for cleaner print */
            .project-container,
            .section-text,
            .budget-table {
                box-shadow: none !important;
                border-radius: 0 !important;
            }

            /* Table print adjustments */
            .budget-table {
                width: 100%;
                border-collapse: collapse;
            }

            .budget-table thead th,
            .budget-table tbody td {
                border: 1px solid #444;
            }
        }

        /* Normal screen styles remain as you already defined */
    </style>
    <div class="wrapper">
        <div class="d-flex justify-content-between align-items-center mb-3 mt-2">
            <h5 class="mb-0">Project Report</h5>

            <!-- Breadcrumb aligned to right -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Project Report</li>
                </ol>
            </nav>
        </div>
        @if (session('success'))
            <div id="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <div class="container mt-2 mb-3">
            <div class="row">
                <div class="col-sm-6"><label>
                        <input type="checkbox" id="toggleCert">
                        <b>Show Certificate Page</b>
                    </label></div>
                <div class="col-sm-6 text-end mb-3 no-print">
                    <button class="btn btn-primary btn-sm" onclick="toggleLanguage('en')">English</button>
                    <button class="btn btn-success btn-sm" onclick="toggleLanguage('hi')">हिन्दी</button>
                    <button class="btn btn-danger btn-sm" onclick="window.print()">🖨 Print</button>
                </div>
            </div>

        </div>

        <div class="container-fluid my-4" id="printable-area">
            <div class="page-break project-container mb-2">
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
                <!-- Sub Header -->
                <div class="text-center mb-4 pb-3 border-bottom project-header">
                    @php
                        $total = $budgetItems->sum('expense');
                    @endphp
                    <div class="row align-items-center">
                        <div class="col-sm-12 text-center">
                            <h4 class="project-title">
                                <span>Legal Status of Organization</span>
                            </h4>
                            <p class="project-info">
                                <b>Session:</b> {{ $report->academic_session ?? 'N\A' }} &nbsp; | &nbsp;
                                <b>Project Cost:</b> ₹{{ number_format($total, 2) }}
                            </p>
                        </div>
                    </div>
                </div>
                <table class="table table-bordered table-sm">
                    <tbody>
                        <tr>
                            <th class="w-25"><span class="lang-en">Name of Oraganization</span> <span class="lang-hi ">
                                    नाम</span></th>
                            <td>GYAN BHARTI SANSTHA</td>
                        </tr>
                        <tr>
                            <th><span class="lang-en">Registered Address</span> <span class="lang-hi ">Registered
                                    Address</span></th>
                            <td> <span class="lang-en">Village - Kainchu Tanda, Post - Amaria, District - Pilibhit, UP -
                                    262121</span>
                                <span class="lang-hi ">ग्राम - कैंचू टांडा, पोस्ट - अमरिया, जिला - पीलीभीत, उत्तर
                                    प्रदेश - 262121</span>
                            </td>
                        </tr>
                        <tr>
                            <th><span>Contact Number</span></th>
                            <td>9411484111, 9719735760</td>
                        </tr>
                        <tr>
                            <th><span>Email:</span></th>
                            <td>gyanbhartingo600@gmail.com</td>
                        </tr>
                        <tr>
                            <th><span>Website:</span></th>
                            <td>www.gyanbhartingo.org</td>
                        </tr>
                        <tr>
                            <th><span class="lang-en">PAN Number</span> <span class="lang-hi ">पैन नंबर</span></th>
                            <td>AAEAG7650B</td>
                        </tr>
                        {{-- <tr>
                        <th><span class="lang-en">Aadhaar Number</span> <span class="lang-hi ">आधार नंबर</span>
                        </th>
                        <td>1234 5678 9123</td>
                    </tr> --}}
                        <tr>
                            <th><span>80G Registration:</span></th>
                            <td>AAEAG7650BF20231</td>
                        </tr>
                        <tr>
                            <th><span>12A Registration:</span></th>
                            <td>AAEAG7650BF20231</td>
                        </tr>
                        <tr>
                            <th><span>NGO ID:</span></th>
                            <td>UP/00033062</td>
                        </tr>
                        <tr>
                            <th><span>NGO DARPAN UNIQUE ID NO:</span></th>
                            <td>UP/2023/0360430</td>
                        </tr>
                        <tr>
                            <th><span>S.R.N. NUMBER:</span></th>
                            <td>F65124000</td>
                        </tr>
                        <tr>
                            <th><span>CSR NO:</span></th>
                            <td>CSR00059991</td>
                        </tr>
                        <tr>
                            <th><span>Sanstha Registration Register:</span></th>
                            <td>219/2009</td>
                        </tr>
                        <tr>
                            <th><span>Bank Details</span></th>
                            <td>
                                <div style="display: flex; align-items: center; justify-content: space-between;">
                                    <!-- Left Side: Bank Details -->
                                    <div style="width: 50%; padding-right: 10px;">
                                        GYAN BHARTI SANSTHA <br>
                                        Bank Name: Bank Of Baroda <br>
                                        Branch: Ameria <br>
                                        Account no: 08310200000368 <br>
                                        IFSC Code: BARB0AMERIA
                                    </div>

                                    <!-- Right Side: QR Code -->
                                    <div style="width: 50%; text-align: center;">
                                        <img src="{{ asset('images/qr2.jpeg') }}" alt="QR Code" style="max-width: 120px;">
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="page-break project-container mt-2 mb-2">
                <div class="text-center mb-4 pb-3 border-bottom project-header">
                    @php
                        $total = $budgetItems->sum('expense');
                    @endphp
                    <div class="row align-items-center">
                        <div class="col-sm-2 text-center">
                            <img src="{{ asset($project->image) }}" alt="image" class="project-image">
                        </div>
                        <div class="col-sm-10 text-center">
                            <h4 class="project-title">
                                <span>Project Proposal</span>
                            </h4>
                            <h5 class="project-sub-title">
                                <span>
                                    Project Code: {{ $project->code }} &nbsp; | &nbsp;
                                    Project Name: {{ $project->name }} &nbsp; | &nbsp;
                                    Project Category: {{ $project->category }} &nbsp; | &nbsp;
                                    {{-- Project Sub-Category: {{ $project->sub_category }} --}}
                                </span>
                            </h5>
                            <p class="project-info">
                                <b>Session:</b> {{ $report->academic_session ?? 'N\A' }} &nbsp; | &nbsp;
                                <b>Project Cost:</b> ₹{{ number_format($total, 2) }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="project-card">
                    <div class="row align-items-stretch">
                        <div class="col-sm-6 d-flex justify-content-center">
                            <div class="image-container">
                                <img src="{{ asset($project->image) }}" alt="Project Image" class="img-fluid"
                                    style="max-height: 250px;">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="">
                                <table class="table table-bordered table-info table-sm h-100 mb-0">
                                    <tr>
                                        <th>
                                            <span class="lang-en">Project Code</span>
                                            <span class="lang-hi">परियोजना कोड</span>
                                        </th>
                                        <td>{{ $project->code }}</td>
                                    </tr>
                                    <tr>
                                        <th>
                                            <span class="lang-en">Project Name</span>
                                            <span class="lang-hi">परियोजना का नाम</span>
                                        </th>
                                        <td>{{ $project->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>
                                            <span class="lang-en">Category</span>
                                            <span class="lang-hi">श्रेणी</span>
                                        </th>
                                        <td>{{ $project->category }}</td>
                                    </tr>
                                    <tr>
                                        <th>
                                            <span class="lang-en">Sub Category</span>
                                            <span class="lang-hi">उप-श्रेणी</span>
                                        </th>
                                        <td>{{ $project->sub_category }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <h5 class="section-title">
                    <span>Project Report</span>
                </h5>
                <p class="section-text">{{ $report->report ?? 'N/A' }}</p>
            </div>


            <div class="page-break project-container mt-2 mb-2">
                <div class="text-center mb-4 pb-3 border-bottom project-header">
                    @php
                        $total = $budgetItems->sum('expense');
                    @endphp
                    <div class="row align-items-center">
                        <div class="col-sm-2 text-center">
                            <img src="{{ asset($project->image) }}" alt="image" class="project-image">
                        </div>
                        <div class="col-sm-10 text-center">
                            <h4 class="project-title">
                                <span>Project Proposal</span>
                            </h4>
                            <h5 class="project-sub-title">
                                <span>
                                    Project Code: {{ $project->code }} &nbsp; | &nbsp;
                                    Project Name: {{ $project->name }} &nbsp; | &nbsp;
                                    Project Category: {{ $project->category }} &nbsp; | &nbsp;
                                    {{-- Project Sub-Category: {{ $project->sub_category }} --}}
                                </span>
                            </h5>
                            <p class="project-info">
                                <b>Session:</b> {{ $report->academic_session ?? 'N\A' }} &nbsp; | &nbsp;
                                <b>Project Cost:</b> ₹{{ number_format($total, 2) }}
                            </p>
                        </div>
                    </div>
                </div>

                <h5 class="section-title">
                    <span class="lang-en">Project Mission</span>
                    <span class="lang-hi ">परियोजना का उद्देश्य</span>
                </h5>
                <p class="section-text">{{ $report->mission ?? 'N/A' }}</p>

                <h5 class="section-title">
                    <span class="lang-en">Project Conclusion</span>
                    <span class="lang-hi ">परियोजना निष्कर्ष</span>
                </h5>
                <p class="section-text">{{ $report->conclusion ?? 'N/A' }}</p>
            </div>


            <!-- BUDGET -->
            <div class="page-break project-container mt-2 mb-2">
                <div class="text-center mb-4 pb-3 border-bottom project-header">
                    @php
                        $total = $budgetItems->sum('expense');
                    @endphp
                    <div class="row align-items-center">
                        <div class="col-sm-2 text-center">
                            <img src="{{ asset($project->image) }}" alt="image" class="project-image">
                        </div>
                        <div class="col-sm-10 text-center">
                            <!-- Main Header -->
                            <h4 class="project-title">
                                <span>Project Proposal</span>
                            </h4>
                            <h5 class="project-sub-title">
                                <span>
                                    Project Code: {{ $project->code }} &nbsp; | &nbsp;
                                    Project Name: {{ $project->name }} &nbsp; | &nbsp;
                                    Project Category: {{ $project->category }} &nbsp; | &nbsp;
                                    {{-- Project Sub-Category: {{ $project->sub_category }} --}}
                                </span>
                            </h5>
                            <p class="project-info">
                                <b>Session:</b> {{ $report->academic_session ?? 'N\A' }} &nbsp; | &nbsp;
                                <b>Project Cost:</b> ₹{{ number_format($total, 2) }}
                            </p>
                        </div>
                    </div>
                </div>

                <h5 class="section-title">
                    <span class="lang-en">Project Budget</span>
                    <span class="lang-hi ">परियोजना बजट</span>
                </h5>

                <table class="table table-bordered budget-table">
                    <thead>
                        <tr>
                            <th>Sr. No.</th>
                            <th>Category</th>
                            <th>Expense (INR)</th>
                            <th>Details & Allocation</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $total = 0; @endphp
                        @foreach ($budgetItems as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->category }}</td>
                                <td>₹{{ number_format($item->expense, 2) }}</td>
                                <td>{{ $item->details }}</td>
                            </tr>
                            @php $total += $item->expense; @endphp
                        @endforeach
                        <tr class="total-row">
                            <th colspan="2" class="text-end">Total</th>
                            <th colspan="2">₹{{ number_format($total, 2) }}</th>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="page-break project-container mt-2 mb-2" id="certificated" style="display: none;">

                <div class="text-center mb-4 pb-3 border-bottom project-header">
                    @php
                        $total = $budgetItems->sum('expense');
                    @endphp
                    <div class="row align-items-center">
                        <div class="col-sm-2 text-center">
                            <img src="{{ asset($project->image) }}" alt="image" class="project-image">
                        </div>
                        <div class="col-sm-10 text-center">
                            <h4 class="project-title">
                                <span>Project Proposal</span>
                            </h4>
                            <h5 class="project-sub-title">
                                <span>
                                    Project Code: {{ $project->code }} &nbsp; | &nbsp;
                                    Project Name: {{ $project->name }} &nbsp; | &nbsp;
                                    Project Category: {{ $project->category }} &nbsp; | &nbsp;
                                    {{-- Project Sub-Category: {{ $project->sub_category }} --}}
                                </span>
                            </h5>
                            <p class="project-info">
                                <b>Session:</b> {{ $report->academic_session ?? 'N\A' }} &nbsp; | &nbsp;
                                <b>Project Cost:</b> ₹{{ number_format($total, 2) }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="row d-flex justify-content-around">
                    <div class="col-md-4 col-sm-6 col-12 mb-3">
                        <div class="certificate-card">
                            <h5 class="certificate-title">Ngo Darpan Certificate</h5>
                            <img src="{{ asset('images/certtt.jpeg') }}" class="img-fluid" alt="Certificate 1">
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12 mb-3">
                        <div class="certificate-card">
                            <h5 class="certificate-title">ISO Sanstha Certificate</h5>
                            <img src="{{ asset('images/cert7.jpg') }}" class="img-fluid" alt="Certificate 7">
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-6 col-12 mb-3">
                        <div class="certificate-card">
                            <h5 class="certificate-title">E-Anudhan Certificate</h5>
                            <img src="{{ asset('images/cert2.jpeg') }}" class="img-fluid" alt="Certificate 2">
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12 mb-3">
                        <div class="certificate-card">
                            <h5 class="certificate-title">Sanstha Pan Card</h5>
                            <img src="{{ asset('images/cert3.jpg') }}" class="img-fluid" alt="Certificate 3">
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-6 col-12 mb-3">
                        <div class="certificate-card">
                            <h5 class="certificate-title">CSR-1 Certificate</h5>
                            <img src="{{ asset('images/cert4.jpg') }}" class="img-fluid" alt="Certificate 4">
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12 mb-3">
                        <div class="certificate-card">
                            <h5 class="certificate-title">Sanstha Information Certificate</h5>
                            <img src="{{ asset('images/cert5.jpg') }}" class="img-fluid" alt="Certificate 5">
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>

    <script>
        function toggleLanguage(lang) {
            // Hide/show English
            document.querySelectorAll('.lang-en').forEach(el => {
                el.style.display = (lang === 'en') ? '' : 'none';
            });

            // Hide/show Hindi
            document.querySelectorAll('.lang-hi').forEach(el => {
                el.style.display = (lang === 'hi') ? '' : 'none';
            });
        }

        // Default: Show English only on page load
        toggleLanguage('en');
    </script>
    <script>
        const toggleCheckbox = document.getElementById('toggleCert');
        const certSection = document.getElementById('certificated');

        // Initially hidden because checkbox is unchecked by default
        toggleCheckbox.addEventListener('change', function() {
            if (this.checked) {
                certSection.style.display = 'block'; // Show when checked
            } else {
                certSection.style.display = 'none'; // Hide when unchecked
            }
        });
    </script>
@endsection
