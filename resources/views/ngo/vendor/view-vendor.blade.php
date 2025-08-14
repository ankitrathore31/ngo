@extends('ngo.layout.master')
@Section('content')
    <div class="wrapper">
        <div class="container-fluid mt-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">View Vendor</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Vendor</li>
                    </ol>
                </nav>
            </div>

            @if (session('success'))
                <div id="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <div class="container mt-4">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-info text-white">
                        <h4 class="mb-0 text-center">Vendor Details</h4>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">

                            <!-- Vendor Basic Info -->
                            <div class="col-md-6">
                                <h5 class="fw-bold"> - Vendor Information</h5>
                                <p><strong>Registration No:</strong> {{ $vendor->registration_no }}</p>
                                <p><strong>Registration Date:</strong>
                                    {{ \Carbon\Carbon::parse($vendor->registration_date)->format('d M, Y') }}</p>
                                <p><strong>Vendor/Shop/Farm Name:</strong> {{ $vendor->shop }}</p>
                                <p><strong>Vendor Type:</strong> {{ $vendor->vendor_type }}</p>
                                <p><strong>Seller Name:</strong> {{ $vendor->name }}</p>
                            </div>

                            <!-- Contact Info -->
                            <div class="col-md-6">
                                <h5 class="fw-bold"> - Contact Details</h5>
                                <p><strong>Village/Locality:</strong> {{ $vendor->village }}</p>
                                <p><strong>Post/Town:</strong> {{ $vendor->post }}</p>
                                <p><strong>Block:</strong> {{ $vendor->block }}</p>
                                <p><strong>District:</strong> {{ $vendor->district }}</p>
                                <p><strong>State:</strong> {{ $vendor->state }}</p>
                                <p><strong>Mobile:</strong> {{ $vendor->mobile }}</p>
                                <p><strong>Email:</strong> {{ $vendor->email }}</p>
                            </div>

                            <!-- GST & PAN Details -->
                            <div class="col-md-6">
                                <h5 class="fw-bold"> - GST Details</h5>
                                <p><strong>Shop GST No:</strong> {{ $vendor->shop_gst_no }}</p>
                                <p>
                                    <strong>Shop GST File:</strong>
                                    @if ($vendor->shop_gst_file)
                                        <a href="{{ asset($vendor->shop_gst_file) }}" target="_blank"
                                            class="btn btn-outline-primary btn-sm">View File</a>
                                    @else
                                        <span class="text-muted">Not Uploaded</span>
                                    @endif
                                </p>
                                <p><strong>Operator GST No:</strong> {{ $vendor->operator_gst_no }}</p>
                                <p>
                                    <strong>Operator GST File:</strong>
                                    @if ($vendor->operator_gst_file)
                                        <a href="{{ asset($vendor->operator_gst_file) }}" target="_blank"
                                            class="btn btn-outline-primary btn-sm">View File</a>
                                    @else
                                        <span class="text-muted">Not Uploaded</span>
                                    @endif
                                </p>
                            </div>

                            <div class="col-md-6">
                                <h5 class="fw-bold"> - PAN Details</h5>
                                <p><strong>Vendor PAN No:</strong> {{ $vendor->vendor_pan_no }}</p>
                                <p>
                                    <strong>Vendor PAN File:</strong>
                                    @if ($vendor->shop_pan_file)
                                        <a href="{{ asset($vendor->shop_pan_file) }}" target="_blank"
                                            class="btn btn-outline-primary btn-sm">View File</a>
                                    @else
                                        <span class="text-muted">Not Uploaded</span>
                                    @endif
                                </p>
                                <p><strong>Operator PAN No:</strong> {{ $vendor->operator_pan_no }}</p>
                                <p>
                                    <strong>Operator PAN File:</strong>
                                    @if ($vendor->operator_pan_file)
                                        <a href="{{ asset($vendor->operator_pan_file) }}" target="_blank"
                                            class="btn btn-outline-primary btn-sm">View File</a>
                                    @else
                                        <span class="text-muted">Not Uploaded</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
