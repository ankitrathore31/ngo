@extends('ngo.layout.master')
@section('content')
    <style>
        .upload-container {
            text-align: center;
            margin-top: 15px;
            padding: 10px 20px;
            margin-left: 50px;
        }

        .image-placeholder {
            width: 150px;
            height: 150px;
            /* border: 2px dashed #ccc; */
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
            background-color: rgb(223, 226, 228);
        }

        .image-placeholder img {
            max-width: 100%;
            max-height: 100%;
            display: none;
        }

        .upload-btn {
            display: inline-block;
            background-color: #343a40;
            color: #fff;
            padding: 10px 15px;
            margin-right: 180px;
            font-size: 16px;
            width: auto;
            border-radius: 5px;
            cursor: pointer;
            border: none;
        }

        .upload-btn:hover {
            background-color: #495057;
        }

        #uploadInput {
            display: none;
        }
    </style>
    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            .print-card,
            .print-card * {
                visibility: visible;
            }

            .print-card {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
        }
    </style>

    <div class="wrapper">
        {{-- <div class="main-content"> --}}
        <!-- Breadcrumb -->
        <div class="row d-flex justify-content-end mt-2">
            <div class="col-auto">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('ngo') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">View Beneficiarie</li>
                    </ol>
                </nav>
            </div>
        </div>
        @if (session('success'))
            <div id="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <div class="container-fluide m-3">
            <div class="container my-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="fw-bold">Beneficiarie</h2>
                    <button onclick="window.print()" class="btn btn-primary">Print / Download</button>
                </div>

                <div class="card p-4 shadow rounded print-card">
                    <div class="text-center mb-4 border-bottom">
                        <div class="row align-items-center">
                            <div class="col-sm-2 text-center text-md-start">
                                <a href="https://gyanbhartingo.org">
                                    <img src="{{ asset('images/LOGO.png') }}" alt="Logo" width="80" height="80"
                                        class="">
                                </a>
                            </div>
                            <div class="col-sm-10 text-center">
                                <h4 style="color: red; font-weight:500; font-size:25px;"><b>GYAN BHARTI SANSTHA</b></h4>
                                <h6 style="color: blue;"><b>Head Office: Kainchu Tanda Amaria Pilibhit UP 262121</b></h6>
                                <p><b>Website : www.gyanbhartingo.org Email : gyanbhartingo600@gmail.com Mob- 9411484111</b>
                                </p>
                            </div>

                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 mb-3">
                            <strong>Application Date:</strong>
                            {{ \Carbon\Carbon::parse($beneficiarie->application_date)->format('d-m-Y') }}
                        </div>
                        <div class="col-sm-4 mb-3">
                            <strong>Application No:</strong> {{ $beneficiarie->application_no }}
                        </div>
                        <div class="col-sm-4 mb-3">
                            <strong>Registraition Type:</strong> {{ $beneficiarie->reg_type }}
                        </div>
                        <div class="col-sm-4 mb-3">
                            <strong>Registraition No:</strong> {{ $beneficiarie->registration_no }}
                        </div>
                        <div class="col-sm-4 mb-3">
                            <strong>Session:</strong> {{ $beneficiarie->academic_session }}
                        </div>
                    </div>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-sm-4 mb-3">
                            <strong>Name:</strong> {{ $beneficiarie->name }}
                        </div>
                        <div class="col-sm-4 mb-3">
                            <strong>Guardian's Name:</strong> {{ $beneficiarie->gurdian_name }}
                        </div>
                        <div class="col-sm-4 mb-3">
                            <strong>Mother's Name:</strong> {{ $beneficiarie->mother_name }}
                        </div>
                        <div class="col-sm-4 mb-3">
                            <strong>Area Type:</strong> {{ $beneficiarie->area_type }}
                        </div>
                        <div class="col-sm-4 mb-3">
                            <strong>Village/Locality:</strong>{{ $beneficiarie->village }}
                        </div>
                        <div class="col-sm-4 mb-3">
                            <strong>Post/Town:</strong> {{ $beneficiarie->post }}
                        </div>
                        <div class="col-sm-4 mb-3">
                            <strong>Block:</strong> {{ $beneficiarie->block }}
                        </div>
                        <div class="col-sm-4 mb-3">
                            <strong>District</strong> {{ $beneficiarie->district }}
                        </div>
                        <div class="col-sm-4 mb-3">
                            <strong>State</strong> {{ $beneficiarie->state }}
                        </div>
                        <div class="col-sm-4 mb-3">
                            <strong>Pincode:</strong> {{ $beneficiarie->pincode }}
                        </div>
                        <div class="col-sm-4 mb-3">
                            <strong>Country:</strong> {{ $beneficiarie->country }}
                        </div>

                        <div class="col-sm-4 mb-3">
                            <strong>Gender:</strong> {{ $beneficiarie->gender }}
                        </div>
                        <div class="col-sm-4 mb-3">
                            <strong>Phone:</strong> {{ $beneficiarie->phone }}
                        </div>
                        <div class="col-sm-4 mb-3">
                            <strong>Email:</strong> {{ $beneficiarie->email ?? 'N/A' }}
                        </div>


                        <div class="col-sm-4 mb-3">
                            <strong>Eligibility:</strong> {{ $beneficiarie->eligibility ?? 'N/A' }}
                        </div>
                        <div class="col-sm-4 mb-3">
                            <strong>Caste:</strong> {{ $beneficiarie->caste }}
                        </div>
                        <div class="col-sm-4 mb-3">
                            <strong>Religion:</strong> {{ $beneficiarie->religion }}
                        </div>
                        <div class="col-sm-4 mb-3">
                            <strong>Religion Category:</strong> {{ $beneficiarie->religion_category }}
                        </div>


                        <div class="col-sm-4 mb-3">
                            <strong>Date of Birth:</strong>
                            {{ \Carbon\Carbon::parse($beneficiarie->dob)->format('d-m-Y') }}
                        </div>
                        <div class="col-sm-4 mb-3">
                            <strong>Marital Status:</strong> {{ $beneficiarie->marital_status }}
                        </div>
                        <div class="col-sm-4 mb-3">
                            <strong>Occupation:</strong> {{ $beneficiarie->occupation }}
                        </div>

                        <div class="col-sm-4 mb-3">
                            <strong>Identity Type:</strong> {{ $beneficiarie->identity_type }}
                        </div>
                        <div class="col-sm-4 mb-3">
                            <strong>Identity Number:</strong> {{ $beneficiarie->identity_no }}
                        </div>
                        <div class="col-sm-10 mb-3">
                            <strong>Help Needed:</strong> {{ $beneficiarie->help_needed }}
                        </div>

                    </div>
                    <hr>
                    <b class="mb-3 text-center"><U>About Beneficiarie Survey & Facilities</U></b>
                    <div class="row">

                        <div class="col-sm-4 mb-3">
                            <strong>Survey Date:</strong>
                            {{ \Carbon\Carbon::parse($survey->survey_date)->format('d-m-Y') }}
                        </div>
                        <div class="col-sm-8 mb-3">
                            <strong>Survey Details:</strong> {{ $survey->survey_details }}
                        </div>
                        <div class="col-sm-4 mb-3">
                            <strong>Facilities Category:</strong> {{ $survey->facilities_category }}
                        </div>
                        <div class="col-sm-8 mb-3">
                            <strong>Facilities:</strong> {{ $survey->facilities }}
                        </div>
                        <div class="col-sm-4 mb-3">
                            <strong>Distribute Date:</strong>
                            {{ \Carbon\Carbon::parse($survey->distribute_date)->format('d-m-Y') }}
                        </div>
                        <div class="col-sm-8 mb-3">
                            <strong>Distribute Place:</strong> {{ $survey->distribute_place ?? 'No Found' }}
                        </div>
                        <div class="col-sm-4 mb-3">
                            <strong>Distribute Status:</strong> {{ $survey->status ?? 'No Found' }}
                        </div>
                    </div>
                    {{-- <div class="row">
                    @if ($beneficiarie->image)
                        <div class="row mb-3">
                            <div class="col-sm-4 mb-3">
                                <strong>Profile Image:</strong><br>
                                <img src="{{ asset('benefries_images/' . $beneficiarie->image) }}" alt="Profile Image"
                                    class="img-thumbnail" width="150">
                            </div>
                        </div>
                    @endif
                    <div class="col-sm-3 mb-3">
                        @if ($beneficiarie->id_document)
                            <strong>ID Document:</strong>
                            <a href="{{ asset('benefries_images/' . $beneficiarie->id_document) }}" target="_blank">View
                                Document</a>
                        @endif
                    </div>
                </div> --}}
                    <hr>
                    <div class="row d-flex justify-content-between mt-2">
                        <div class="col-sm-4 mb-5">
                            <label for="" class="from-label"><b>{{ $beneficiarie->reg_type }} Signature/Thumb
                                    Impression of the Recipient</b></label>
                        </div>
                        <div class="col-sm-4 mb-5">
                            <label for="" class="from-label"><b>Signature</b></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
