@extends('ngo.layout.master')
@Section('content')
    <div class="d-flex justify-content-between align-items-center mb-3 m-2">
        <h5 class="mb-0">Project View</h5>

        <!-- Breadcrumb aligned to right -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                <li class="breadcrumb-item"><a href="{{ route('list.project') }}">Project List</a></li>
                <li class="breadcrumb-item active" aria-current="page">Project View</li>
            </ol>
        </nav>
    </div>
    <div class="container m-3">
        <button class="btn btn-primary me-2" onclick="window.print()">Print</button>
    </div>
    <div class="container my-5">
        <div class="card shadow-lg p-4 print-area">
            <!-- View Header -->
            <div class="text-center mb-4 border-bottom">
                <h2 class="fw-bold text-primary"> Project View</h2>
            </div>

            @if ($project->image)
                <div class="mb-4">
                    <div class="card border-1 rounded shadow-sm mx-auto d-flex align-items-center justify-content-center"
                        style="width: 100%; height: 350px; background-color: #f8f9fa; overflow: hidden;">
                        <img src="{{ asset($project->image) }}" alt="Project Image"
                            style="max-width: 100%; max-height: 100%; object-fit: contain;" class="rounded">
                    </div>
                </div>
            @endif

            <!-- Details Section -->
            <div class="row g-4">

                <div class="col-sm-6 mb-2">
                    <div class="bg-light p-3 rounded border h-100">
                        <small class="text-muted">Project Session</small>
                        <div class="fw-bold text-dark"><strong>{{ $project->academic_session }}</strong></div>
                    </div>
                </div>

                <div class="col-sm-6 mb-2">
                    <div class="bg-light p-3 rounded border h-100">
                        <small class="text-muted">Project Code</small>
                        <div class="fw-bold text-dark"><strong>{{ $project->code }}</strong></div>
                    </div>
                </div>

                <div class="col-sm-6 mb-2">
                    <div class="bg-light p-3 rounded border h-100">
                        <small class="text-muted">Project Name</small>
                        <div class="fw-bold text-dark"><strong>{{ $project->name }}</strong></div>
                    </div>
                </div>

                <div class="col-sm-6 mb-2">
                    <div class="bg-light p-3 rounded border h-100">
                        <small class="text-muted">Project Category</small>
                        <div class="fw-bold text-dark"><strong>{{ $project->category }}</strong></div>
                    </div>
                </div>

                <div class="col-sm-6 mb-2">
                    <div class="bg-light p-3 rounded border h-100">
                        <small class="text-muted">Project Sub Category</small>
                        <div class="fw-bold text-dark"><strong>{{ $project->sub_category }}</strong></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Share Script -->
    <script>
        function shareView() {
            if (navigator.share) {
                navigator.share({
                    title: '{{ $project->program_name }}',
                    text: 'Check out this NGO project View!',
                    url: window.location.href
                }).then(() => {
                    console.log('View shared');
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
