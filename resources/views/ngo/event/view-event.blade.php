@extends('ngo.layout.master')
@Section('content')
    <div class="d-flex justify-content-between align-items-center mb-3 m-2">
        <h5 class="mb-0">Event Report</h5>

        <!-- Breadcrumb aligned to right -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                <li class="breadcrumb-item"><a href="{{ route('event-list') }}">Event List</a></li>
                <li class="breadcrumb-item active" aria-current="page">Event Report</li>
            </ol>
        </nav>
    </div>
    <div class="container my-5">

        <div class="card shadow-lg p-4 print-area">
            <!-- Report Header -->
            <div class="text-center mb-4 border-bottom">
                <h2 class="fw-bold text-primary">Event Report</h2>
            </div>

            @if ($event->event_image)
                <div class="mb-4">
                    <div class="card border-1 rounded shadow-sm mx-auto d-flex align-items-center justify-content-center"
                        style="width: 100%; height: 350px; background-color: #f8f9fa; overflow: hidden;">
                        <img src="{{ asset('program_images/' . $event->event_image) }}" alt="Program Image"
                            style="max-width: 100%; max-height: 100%; object-fit: contain;" class="rounded">
                    </div>
                </div>
            @endif

            <!-- Details Section -->
            <div class="row g-4">

                <div class="col-sm-6 mb-2">
                    <div class="bg-light p-3 rounded border h-100">
                        <small class="text-muted">Event Name</small>
                        <div class="fw-bold text-dark"><strong>{{ $event->event }}</strong></div>
                    </div>
                </div>

                <div class="col-sm-6 mb-2">
                    <div class="bg-light p-3 rounded border h-100">
                        <small class="text-muted">Event Session</small>
                        <div class="fw-bold text-dark"><strong>{{ $event->academic_session }}</strong></div>
                    </div>
                </div>

                <div class="col-sm-6 mb-2">
                    <div class="bg-light p-3 rounded border h-100">
                        <small class="text-muted">Event Category</small>
                        <div class="fw-bold text-dark"><strong>{{ $event->event_category }}</strong></div>
                    </div>
                </div>

                <div class="col-sm-6 mb-2">
                    <div class="bg-light p-3 rounded border h-100">
                        <small class="text-muted">Date & Time</small>
                        <div class="fw-bold text-dark">
                            <strong>
                                {{ \Carbon\Carbon::parse($event->event_date)->format('F d, Y') }} at
                                {{ \Carbon\Carbon::parse($event->event_time)->format('h:i A') }}
                            </strong>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12 mb-2">
                    <div class="bg-light p-3 rounded border h-100">
                        <small class="text-muted">Event Address</small>
                        <div class="fw-bold text-dark"><b>{{ $event->event_address }}</b></div>
                    </div>
                </div>

                <div class="col-sm-12 mb-2">
                    <div class="bg-light p-3 rounded border h-100">
                        <small class="text-muted">Event Summary</small>
                        <div class="fw-bold text-dark"><b>{{ $event->event_report }}</b></div>
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
                    title: '{{ $event->program_name }}',
                    text: 'Check out this NGO event report!',
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
