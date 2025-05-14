@extends('home.layout.MasterLayout')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3 m-2">
        <h5 class="mb-0">Activity Report</h5>

        <!-- Breadcrumb aligned to right -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                <li class="breadcrumb-item"><a href="{{ route('activity') }}">Activity List</a></li>
                <li class="breadcrumb-item active" aria-current="page">Activity Report</li>
            </ol>
        </nav>
    </div>

    <div class="container my-5">
        <div class="card shadow-lg p-4 print-area">
            <!-- Report Header -->
            <div class="text-center mb-4 border-bottom">
                <div class="row align-items-center">
                    <div class="col-md-2 text-center text-md-start">
                        <a href="https://gyanbhartingo.org">
                            <img src="{{ asset('images/LOGO.png') }}" alt="Logo" width="80" height="80"
                                class="">
                        </a>
                    </div>
                    <div class="col-md-6 text-center">
                        <h4 style="color: red; font-weight:500; font-size:25px;"><b>GYAN BHARTI SANSTHA (NGO)</b></h4>
                        <h6 style="color: blue;"><b>Head Office: Kainchu Tanda Amaria Pilibhit UP 262121</b></h6>
                    </div>
                    <div class="col-md-4 text-center">
                        <h4 style=" font-size:20px; color:brown;"><b>Session: {{ $activity->academic_session }}</b></h4>
                        <p style=""><b>Activity Report</b></p>
                    </div>
                </div>
            </div>


            @if ($activity->program_image)
                <div class="mb-4">
                    <div class="card border-1 rounded shadow-sm mx-auto d-flex align-items-center justify-content-center"
                        style="width: 100%; height: 350px; background-color: #f8f9fa; overflow: hidden;">
                        <img src="{{ asset('program_images/' . $activity->program_image) }}" alt="Program Image"
                            style="max-width: 100%; max-height: 100%; object-fit: contain;" class="rounded">
                    </div>
                </div>
            @endif



            <!-- Details Section -->
            <div class="row g-4">

                <div class="col-sm-6 mb-2">
                    <div class="bg-light p-3 rounded border h-100">
                        <small class="text-muted">Program Name</small>
                        <div class="fw-bold text-dark"><strong>{{ $activity->program_name }}</strong></div>
                    </div>
                </div>

                <div class="col-sm-6 mb-2">
                    <div class="bg-light p-3 rounded border h-100">
                        <small class="text-muted">Program Session</small>
                        <div class="fw-bold text-dark"><strong>{{ $activity->academic_session }}</strong></div>
                    </div>
                </div>

                <div class="col-sm-6 mb-2">
                    <div class="bg-light p-3 rounded border h-100">
                        <small class="text-muted">Program Category</small>
                        <div class="fw-bold text-dark"><strong>{{ $activity->program_category }}</strong></div>
                    </div>
                </div>

                <div class="col-sm-6 mb-2">
                    <div class="bg-light p-3 rounded border h-100">
                        <small class="text-muted">Date & Time</small>
                        <div class="fw-bold text-dark">
                            <strong>
                                {{ \Carbon\Carbon::parse($activity->program_date)->format('F d, Y') }} at
                                {{ \Carbon\Carbon::parse($activity->program_time)->format('g:i A') }}
                            </strong>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12 mb-2">
                    <div class="bg-light p-3 rounded border h-100">
                        <small class="text-muted">Program Address</small>
                        <div class="fw-bold text-dark"><b>{{ $activity->program_address }}</b></div>
                    </div>
                </div>

                <div class="col-sm-12 mb-2">
                    <div class="bg-light p-3 rounded border h-100">
                        <small class="text-muted">Report Summary</small>
                        <div class="fw-bold text-dark"><b>{{ $activity->program_report }}</b></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="text-center mt-5 no-print">
            <button class="btn btn-primary me-2" onclick="window.print()">🖨️ Print Report</button>
            <button class="btn btn-outline-secondary" onclick="shareReport()">📤 Share</button>
        </div>
    </div>

    <!-- Share Script -->
    {{-- <script>
        function shareReport() {
            if (navigator.share) {
                navigator.share({
                    title: '{{ $activity->program_name }}',
                    text: 'Check out this NGO activity report!',
                    url: window.location.href
                }).then(() => {
                    console.log('Report shared');
                }).catch(console.error);
            } else {
                alert('Sharing not supported. Please copy the link manually.');
            }
        }
    </script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script>
        function shareReport() {
            const card = document.querySelector('.print-area');
            html2canvas(card).then(canvas => {
                canvas.toBlob(blob => {
                    const file = new File([blob], 'report.png', {
                        type: 'image/png'
                    });

                    if (navigator.canShare && navigator.canShare({
                            files: [file]
                        })) {
                        navigator.share({
                            title: 'Activity Report',
                            text: 'Check out this NGO activity report!',
                            files: [file],
                            url: window.location.href,
                        }).catch(console.error);
                    } else {
                        alert('Image sharing is not supported on your device/browser.');
                    }
                });
            });
        }
    </script>

    <!-- Print Styles -->
    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            .print-area,
            .print-area * {
                visibility: visible;
            }

            .print-area {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                padding: 0;
                box-shadow: none;
            }

            .no-print {
                display: none !important;
            }

            .print-img {
                width: 100%;
                height: 100%;
            }
        }
    </style>
@endsection
