@extends('ngo.layout.master')
@Section('content')
    <div class="container my-5">
        <div class="card shadow-lg p-4 print-area">
            <!-- Report Header -->
            <div class="text-center mb-4 border-bottom">
                <h2 class="fw-bold text-primary"> Activity Report</h2>
            </div>

            <!-- Image Section -->
            @if ($activity->program_image)
                <div class="mb-4">
                    <div class="card border-1 rounded shadow-sm mx-auto" style="max-width: 100%;">
                        <img src="{{ asset('program_images/' . $activity->program_image) }}" class="img-fluid rounded"
                            alt="Program Image" style="max-height: 350px; object-fit: cover;">
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
    <script>
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
        }
    </style>
@endsection
