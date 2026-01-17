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

    <div class="wrapper">
        {{-- <div class="main-content"> --}}
        <!-- Breadcrumb -->
        <div class="row d-flex justify-content-end mt-2">
            <div class="col-auto">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('ngo') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Add Beneficiarie</li>
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
            <div class="container-fluide m-3">
                <div class="container my-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="fw-bold">Add Beneficiarie</h2>
                        {{-- <button onclick="window.print()" class="btn btn-primary">Print / Download</button> --}}
                    </div>

                    <div class="card p-4 shadow rounded print-card">
                        <div class="text-center mb-4 border-bottom">
                            <div class="row align-items-center">
                                <div class="col-sm-2 text-center text-md-start">
                                    <a href="https://gyanbhartingo.org">
                                        <img src="{{ asset('images/LOGO.png') }}" alt="Logo" width="80"
                                            height="80" class="">
                                    </a>
                                </div>
                                <div class="col-sm-10 text-center">
                                    <h4 style="color: red; font-weight:500; font-size:25px;"><b>GYAN BHARTI SANSTHA</b></h4>
                                    <h6 style="color: blue;"><b>Head Office: Kainchu Tanda Amaria Pilibhit UP 262121</b>
                                    </h6>
                                    <p><b>Website : www.gyanbhartingo.org Email : gyanbhartingo600@gmail.com Mob-
                                            9411484111</b>
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
                                <strong>Registration Type:</strong> {{ $beneficiarie->reg_type }}
                            </div>
                            <div class="col-sm-4 mb-3">
                                <strong>Registration Date:</strong>
                                {{ \Carbon\Carbon::parse($beneficiarie->registraition_date)->format('d-m-Y') }}
                            </div>
                            <div class="col-sm-4 mb-3">
                                <strong>Registration No:</strong> {{ $beneficiarie->registration_no }}
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
                            <div class="col-sm-8 mb-3">
                                <strong>Help Needed:</strong> {{ $beneficiarie->help_needed }}
                            </div>

                        </div>
                        <hr>
                    </div>
                </div>
            </div>
            <div class="card mt-4 p-3 border border-success rounded">
                <form action="{{ route('store-beneficiarie', $beneficiarie->id) }}" method="POST">
                    @csrf
                    <h5 class="text-success text-center">Survey Start Beneficiarie </h5>
                    <div class="row">
                        <div class="col">
                            @php
                                $facilities = [
                                    'Housing',
                                    'Toilet',
                                    'Ration Card',
                                    'Antyodaya Card',
                                    'Eligible Household APL Card',
                                    'Green Card',
                                    'MNREGA Card',
                                    'Shramik Card',
                                    'E-Shram Card',
                                    'Ayushman Card',
                                    'Pension in the family',
                                    'Loan',
                                    'Health Card',
                                    'Education Grant',
                                    'Tree Distribution',
                                    'Cleaning Kit',
                                    'Health Kit',
                                    'Nutrition Kit',
                                    'Ration Kit',
                                    'Festival Kit',
                                    'Awareness Meeting',
                                    'Gas Connection',
                                    'Electricity Connection',
                                    'Water Connection',
                                    'Water Supply',
                                    'Family Dispute',
                                    'Peace Dialogue Meeting',
                                    'Self Help Group',
                                    'Training',
                                    'Employment',
                                    'Cloth Distribution',
                                    'Blanket Distribution',
                                    'Gifts',
                                    'Travelling, Picnic or Tour',
                                    'Fruit Distribution',
                                    'Cultural Programme',
                                    'Animal Food',
                                    'Food',
                                    'Agriculture Grant',
                                    'Economic Help',
                                    'Marriage Grant',
                                    'children studying',
                                    'person seeking pension',
                                    'person getting married',
                                    'facility do you want',
                                    // 'Behavior of the survey family',
                                    'Occupation of head of the family',
                                    // 'Report of the survey employee',
                                ];
                            @endphp

                            <div class="mb-4">
                                <label><strong>Do you want to fill the survey?</strong></label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="start_survey" value="Yes"
                                        id="start_survey_yes">
                                    <label class="form-check-label" for="start_survey_yes">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="start_survey" value="No"
                                        id="start_survey_no">
                                    <label class="form-check-label" for="start_survey_no">No</label>
                                </div>
                            </div>

                            <div id="survey_section" style="display: none;">
                                @foreach ($facilities as $index => $facility)
                                    <div class="mb-4 p-2 rounded">
                                        <label><strong>{{ $index + 1 }}. {{ $facility }}:</strong></label>
                                        <div class="form-check form-check-inline ml-3">
                                            <input class="form-check-input" type="radio"
                                                name="surveyfacility_status[{{ $facility }}]" value="Yes"
                                                id="{{ Str::slug($facility) }}_yes">
                                            <label class="form-check-label"
                                                for="{{ Str::slug($facility) }}_yes">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio"
                                                name="surveyfacility_status[{{ $facility }}]" value="No"
                                                id="{{ Str::slug($facility) }}_no">
                                            <label class="form-check-label"
                                                for="{{ Str::slug($facility) }}_no">No</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Survey Details -->
                    <input type="text" name="beneficiarie_id" value="{{ $beneficiarie->id }}" hidden>
                    <div class="col-md-8 mb-3">
                        <label for="survey_details" class="form-label">
                            Survey Details<span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control @error('survey_details') is-invalid @enderror" id="survey_details"
                            name="survey_details" rows="3" required>{{ old('survey_details') }}</textarea>
                        @error('survey_details')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="row">
                        <!-- Survey Date -->
                        <div class=" col-md-4 mb-3">
                            <label for="survey_date" class="form-label">
                                Survey Date<span class="text-danger">*</span>
                            </label>
                            <input type="date" class="form-control @error('survey_date') is-invalid @enderror"
                                name="survey_date" value="{{ old('survey_date') }}" required>
                            @error('survey_date')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class=" col-md-4 form-group mb-3">
                            <label for="bene_category">Beneficiarie Eligibility Category</label>
                            <select id="bene_category" name="bene_category" class="form-control" required>
                                <option value="">-- Select Category --</option>
                                <option value="Homeless Families">1. Homeless Families</option>
                                <option value="People living in kutcha or one-room houses">2. People living in kutcha or
                                    one-room houses</option>
                                <option value="Widows">3. Widow</option>
                                <option value="Handicapped">4. Handicapped</option>
                                <option value="Divorced">5. Divorced</option>
                                <option value="Landless">6. Landless</option>
                                <option value="Economically Weaker Section">7. Economically Weaker Section</option>
                                <option value="Laborers">8. Laborers</option>
                                <option value="Scheduled Tribes">9. Scheduled Tribes</option>
                                <option value="Scheduled Castes">10. Scheduled Castes</option>
                                <option value="Based on Low Income">11. Based on Low Income</option>
                                <option value="Affected People">12. Affected People</option>
                                <option value="Marginal Farmers">13. Marginal Farmers</option>
                                <option value="Small Farmers">14. Small Farmers</option>
                                <option value="Large Farmers">15. Large Farmers</option>
                                <option value="Old Age Person">16. Old Age Person</option>
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="survey_officer" class="form-label">Survey Officer:</label>
                            <select name="survey_officer"
                                class="form-control @error('survey_officer') is-invalid @enderror">
                                <option value="">Select Survey Officer</option>
                                @foreach ($staff as $person)
                                    <option
                                        value="{{ $person->name }} ( {{ $person->staff_code }} ) ( {{ $person->position }} ) "
                                        {{ old('survey_officer') == $person->name . ' - ' . $person->staff_code . ' - ' . $person->position ? 'selected' : '' }}>
                                        {{ $person->name }} ({{ $person->staff_code }}) ({{ $person->position }})
                                    </option>
                                @endforeach
                            </select>
                            @error('survey_officer')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>

                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-success">Add Beneficiarie Survey</button>
                    </div>
                </form>
            </div>
            <div class="row">
                <div class="col-md-4 col-sm-6">
                    <a href="{{-- route('show-beneficiarie-survey', [$item->id, $survey->id]) --}}"
                        class="btn btn-primary btn-sm px-3 d-flex align-items-center justify-content-center"
                        title="View Survey">
                        <i class="fa-regular "></i> Survey Send
                    </a>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const yesRadio = document.getElementById('start_survey_yes');
            const noRadio = document.getElementById('start_survey_no');
            const surveySection = document.getElementById('survey_section');

            function toggleSurvey() {
                if (yesRadio.checked) {
                    surveySection.style.display = 'block';
                } else {
                    surveySection.style.display = 'none';
                }
            }

            yesRadio.addEventListener('change', toggleSurvey);
            noRadio.addEventListener('change', toggleSurvey);
        });
    </script>
@endsection
