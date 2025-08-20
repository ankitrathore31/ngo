@extends('home.layout.MasterLayout')
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
        <div class="d-flex justify-content-between aligin-item-center mb-3 mt-2">
            <h5 class="mb-0">Sanstha Vacancies</h5>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                    <li class="breadcrumb-item"><a href="{{ url('welcome') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Vacancies</li>
                </ol>
            </nav>
        </div>
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <div class="container-fluid mt-5">
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
                                        <span data-lang="en">GYAN BHARTI SANSTHA</span>
                                    </b></h4>
                                <h6 style="color: blue;"><b>
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
                    <table
                        class="table table-striped table-hover align-middle shadow-sm rounded animate__animated animate__fadeIn">
                        <thead class="table-primary">
                            <tr>
                                <th>Sr. No.</th>
                                <th>Job Title</th>
                                <th>Position</th>
                                <th>Vacancies</th>
                                <th>Type</th>
                                <th>Location</th>
                                <th>Requirements</th>
                                <th>Deadline</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($jobs as $key => $job)
                                <tr class="animate__animated animate__fadeInUp">
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $job->job_title }}</td>
                                    <td>{{ $job->position->position ?? '-' }}</td>
                                    <td>{{ $job->vacancy }}</td>
                                    <td>{{ $job->job_type ?? '-' }}</td>
                                    <td>{{ $job->location ?? '-' }}</td>
                                    <td>{{ $job->requirements ?? '-' }}</td>
                                    <td>
                                        {{ $job->deadline ? \Carbon\Carbon::parse($job->deadline)->format('d M Y') : '-' }}
                                    </td>
                                    <td>
                                        @if ($job->status == 'active')
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Closed</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center text-muted">No jobs found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="conatiner mt-5">
            <!-- Footer Section -->
            <div class=" p-4 bg-light rounded shadow-sm text-center animate__animated animate__fadeInUp">
                <h4 class="mb-3">Looking to Join Our NGO?</h4>
                <p class="text-muted">
                    Be part of our mission to create a positive impact in the community.
                    Apply for the job above or connect with us for volunteering opportunities.
                </p>
                {{-- <a href="{{ url('apply-job') }}" class="btn btn-primary btn-lg">
                    <i class="bi bi-person-plus-fill"></i> Apply Now
                </a> --}}
                <a href="{{ route('contact') }}" class="btn btn-outline-secondary btn-lg ms-2">
                    <i class="bi bi-envelope-fill"></i> Contact NGO
                </a>
            </div>
        </div>
    </div>
    <script>
        function printTable() {
            window.print();
        }
    </script>
@endsection
