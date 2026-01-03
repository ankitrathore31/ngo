@extends('ngo.layout.master')
@section('content')
    <div class="wrapper">
        <div class="d-flex justify-content-between align-record-centre mb-0 mt-4">
            <h5 class="mb-0">Add Hospital</h5>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                    <li class="breadcrumb-record"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-record active" aria-current="page">Health Card</li>
                </ol>
            </nav>
        </div>
        @if (session('success'))
            <div id="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <div class="container mt-3">
            <div class="card shadow-sm p-3">

                <form method="POST" action="{{ route('store.hospital') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">

                        <div class="col-md-4 mb-2">
                            <label>Hospital / Clinic / Medical Code</label>
                            <input type="text" class="form-control" value="{{ $nextCode }}" readonly>
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Registration Date</label>
                            <input type="date" name="registration_date" class="form-control">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Hospital / Clinic / Medical Name</label>
                            <input type="text" name="hospital_name" class="form-control" required>
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Contact Number</label>
                            <input type="text" name="contact_number" class="form-control">
                        </div>

                         <div class="col-md-4 mb-2">
                            <label>Hospital / Clinic / Medical Address</label>
                            <textarea type="text" name="address" class="form-control"></textarea>
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Operator / Doctor Name</label>
                            <input type="text" name="operator_name" class="form-control">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>GST No</label>
                            <input type="text" name="gst_no" class="form-control">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>License No</label>
                            <input type="text" name="license_no" class="form-control">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Operator Aadhar</label>
                            <input type="text" name="operator_aadhar" class="form-control">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Upload GST Document</label>
                            <input type="file" name="gst_document" class="form-control">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Upload License</label>
                            <input type="file" name="license_document" class="form-control">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Upload Operator Degree</label>
                            <input type="file" name="operator_degree_document" class="form-control">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Upload Operator Aadhaar</label>
                            <input type="file" name="operator_aadhar_document" class="form-control">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>

                        <div class="col-md-12 mt-3">
                            <button class="btn btn-success">Save</button>
                        </div>
                    </div>
                </form>


            </div>
        </div>

    </div>
@endsection
