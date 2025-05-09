@extends('ngo.layout.master')
@Section('content')
    <div class="container mt-5">    
        <div class="card m-1">
            <div class="card-header">
                <div class="card-title border-bottom p-2 bg-info text-center">
                    <h3><b>ADD ACTIVITY</b></h3>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('saveactivity') }}" method="POST" enctype="multipart/form-data" class="m-3">
                    @csrf
                    <div class="row">
                        <div class="col-md-4 col-sm-2 mb-3 text-start">
                           <span class="me-2">Activity Sr. No. </span><input type="number" name="activity_no" class="w-50 @error('activity_no') is-invalid @enderror">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3 form-group local-from">
                            {{-- <label for="">Program name <span class="login-danger">*</span></label> --}}
                            <input type="text" class="form-control @error('program_name') is-invalid @enderror"
                                name="program_name" placeholder="Program Name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            {{-- <label for="">Program Category <span class="login-danger">*</span></label> --}}
                            <select class="form-control select @error('program_category') is-invalid @enderror"
                                    name="program_category" required>
                                <option value="" selected>Select Category</option>
                                <option value="Public Program">Public Program</option>
                                <option value="Government Program">Government Program</option>
                                <!-- Add more options here as needed -->
                                <option value="Education">Education</option>
                                <option value="Environment">Environment</option>
                                <option value="Social Awareness Program">Social Awareness Program</option>
                                <option value="Cultural Program">Cultural Program</option>
                                <option value="Sanitation Program">Sanitation Program</option>
                                <option value="Health Program">Health Program</option>
                                <option value="Poor Alleviation">Poor Alleviation</option>
                                <option value="Women Empowerment">Women Empowerment</option>
                                <option value="Social Problem">Social Problem</option>
                                <option value="Peace Talks Program">Peace Talks Program</option>
                                <option value="Skill Development">Skill Development</option>
                                <option value="Religious Program">Religious Program</option>
                                <option value="Agriculture Program">Agriculture Program</option>
                                <option value="Other Activities">Other Activities</option>
                            </select>
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="" class="form-label bold">Program Date <span class="login-danger">*</span></label>
                            <input type="text" id="datepicker" class="datepicker form-control @error('program_date') is-invalid @enderror"
                                name="program_date" placeholder="Select Date" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="program_session" class="form-label bold">Program Session <span class="login-danger">*</span></label>
                            <select class="form-control @error('program_session') is-invalid @enderror" name="program_session" required>
                                <option value="">Select Session</option>
                                @php
                                    $currentYear = date('Y');
                                @endphp
                                @for ($year = $currentYear; $year >= 2000; $year--)
                                    @php
                                        $nextYear = $year + 1;
                                        $session = $year . '-' . $nextYear;
                                    @endphp
                                    <option value="{{ $session }}">{{ $session }}</option>
                                @endfor
                            </select>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label for="" class="form-label bold">Program Time <span class="login-danger">*</span></label>
                            <input type="time" class="form-control @error('program_time') is-invalid @enderror"
                                name="program_time" placeholder="Selcet Time" required>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                {{-- <label for="">Program Address <span class="login-danger">*</span></label> --}}
                                <textarea class="form-control @error('program_address') is-invalid @enderror" name="program_address" rows="3"
                                    placeholder="Address" required></textarea>
                            </div>
                            <div class="col-md-12 mb-3">
                                {{-- <label for="">Program Report <span class="login-danger">*</span></label> --}}
                                <textarea class="form-control @error('program_report') is-invalid @enderror" name="program_report" rows="3"
                                    placeholder="Program Report" required></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                {{-- <label for="">Program image <span class="login-danger">*</span></label> --}}
                                <input type="file" class="form-control @error('program_image') is-invalid @enderror"
                                    name="program_image" placeholder="Upload Program Images" required>
                            </div>
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
    
                </form>
            </div>
        </div>
    </div>
@endsection
