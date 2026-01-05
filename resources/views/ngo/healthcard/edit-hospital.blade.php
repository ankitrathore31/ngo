@extends('ngo.layout.master')

@section('content')
<div class="wrapper">
    <div class="d-flex justify-content-between align-items-center mt-4">
        <h5>Edit Hospital</h5>
    </div>

    @if (session('success'))
        <div class="alert alert-success mt-2">
            {{ session('success') }}
        </div>
    @endif

    <div class="container mt-3">
        <div class="card shadow-sm p-3">
            <form method="POST"
                  action="{{ route('update.hospital', $hospital->id) }}"
                  enctype="multipart/form-data">
                @csrf

                <div class="row">

                    <div class="col-md-4 mb-2">
                        <label>Hospital Code</label>
                        <input type="text" class="form-control"
                               value="{{ $hospital->hospital_code }}" readonly>
                    </div>

                    <div class="col-md-4 mb-2">
                        <label>Registration Date</label>
                        <input type="date" name="registration_date"
                               class="form-control"
                               value="{{ $hospital->registration_date }}">
                    </div>

                    <div class="col-md-4 mb-2">
                        <label>Hospital Name</label>
                        <input type="text" name="hospital_name"
                               class="form-control"
                               value="{{ $hospital->hospital_name }}" required>
                    </div>

                    <div class="col-md-4 mb-2">
                        <label>Contact Number</label>
                        <input type="text" name="contact_number"
                               class="form-control"
                               value="{{ $hospital->contact_number }}">
                    </div>

                    <div class="col-md-4 mb-2">
                        <label>Address</label>
                        <textarea name="address"
                                  class="form-control">{{ $hospital->address }}</textarea>
                    </div>

                    <div class="col-md-4 mb-2">
                        <label>Operator Name</label>
                        <input type="text" name="operator_name"
                               class="form-control"
                               value="{{ $hospital->operator_name }}">
                    </div>

                    <div class="col-md-4 mb-2">
                        <label>GST No</label>
                        <input type="text" name="gst_no"
                               class="form-control"
                               value="{{ $hospital->gst_no }}">
                    </div>

                    <div class="col-md-4 mb-2">
                        <label>License No</label>
                        <input type="text" name="license_no"
                               class="form-control"
                               value="{{ $hospital->license_no }}">
                    </div>

                    <div class="col-md-4 mb-2">
                        <label>Operator Aadhaar</label>
                        <input type="text" name="operator_aadhar"
                               class="form-control"
                               value="{{ $hospital->operator_aadhar }}">
                    </div>

                    @foreach([
                        'gst_document' => 'GST Document',
                        'license_document' => 'License Document',
                        'operator_degree_document' => 'Operator Degree',
                        'operator_aadhar_document' => 'Aadhaar Document'
                    ] as $field => $label)

                        <div class="col-md-4 mb-2">
                            <label>{{ $label }}</label>
                            <input type="file" name="{{ $field }}" class="form-control">
                            @if($hospital->$field)
                                <small>
                                    <a href="{{ asset($hospital->$field) }}" target="_blank">
                                        View Current
                                    </a>
                                </small>
                            @endif
                        </div>

                    @endforeach

                    <div class="col-md-4 mb-2">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="active" {{ $hospital->status == 'active' ? 'selected' : '' }}>
                                Active
                            </option>
                            <option value="inactive" {{ $hospital->status == 'inactive' ? 'selected' : '' }}>
                                Inactive
                            </option>
                        </select>
                    </div>

                    <div class="col-md-12 mt-3">
                        <button class="btn btn-primary">Update</button>
                        <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancel</a>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>
@endsection
