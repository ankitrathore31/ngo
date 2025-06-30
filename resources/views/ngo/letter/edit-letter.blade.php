@extends('ngo.layout.master')
@section('content')
    <style>
        #recordTableDiv {
            transition: opacity 0.3s ease;
        }

        @media print {
            @page {
                size: A4 portrait;
                margin: 8mm;
            }

            body {
                margin: 0;
                padding: 0;
                /* font-family: 'Noto Sans Devanagari', 'Arial', sans-serif; */
            }

            body * {
                visibility: hidden;
            }

            .print-area,
            .print-area * {
                visibility: visible;
            }

            .print-area {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                max-width: 210mm;
                padding: 5mm;
                box-sizing: border-box;
                color: #000;
                font-size: 14px;
                line-height: 1.1;
            }

            .print-area strong {
                font-weight: 300;
            }

            .bg-danger {
                background-color: #d9534f !important;
                color: #fff !important;
            }

            .no-print {
                display: none !important;
            }
        }
    </style>


    <div class="wrapper">
        <div class="d-flex justify-content-between align-item-centre mb-0 mt-4">
            <h5 class="mb-0">Experience Letter</h5>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Letter</li>
                </ol>
            </nav>
        </div>
        @if (session('success'))
            <div id="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <!-- Language Toggle -->
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-3 mt-4">
                <h5 class="mb-0">
                    {{-- <span data-lang="hi">दान रसीद</span> --}}
                    <span>Experience Letter</span>
                </h5>
                <div>
                    <button onclick="window.print()" class="btn btn-primary">Print / Download</button>
                    <button class="btn btn-sm btn-outline-primary" onclick="setLanguage('en')">English</button>
                    <button class="btn btn-sm btn-outline-success" onclick="setLanguage('hi')">हिंदी</button>
                </div>
            </div>
            <div class="letterhead print-area">
                <div class="card shadow rounded p-4 my-4 border border-dark">
                    <div class="text-center mb-4 border-bottom pb-3 mb-2">
                        <!-- Header -->
                        {{-- <div class="row">
                            <div class="col-sm-2 text-center text-md-start">
                                <img src="{{ asset('images/LOGO.png') }}" alt="Logo" width="80" height="80">
                            </div>
                            <div class="col-sm-10">
                                <p style="margin: 0;" class="d-flex justify-content-around"><b>
                                        <span>CSR NO. CSR00059991</span>&nbsp;
                                        &nbsp; &nbsp;<span>12A AAEAG7650BE20231</span>&nbsp; &nbsp;
                                        &nbsp; &nbsp;<span>80G AAEAG7650BF20231</span>&nbsp;
                                    </b></p>
                                <p style="margin: 0;" class="d-flex justify-content-around"><b>
                                        <span>NEETI AYOG ID NO. UP/2023/0360430</span>&nbsp;
                                        &nbsp; &nbsp;<span>NGO NO. UP/00033062</span>&nbsp; &nbsp;
                                        &nbsp; &nbsp;<span>PAN: AAEAG7650B</span>&nbsp;
                                    </b></p>
                                <h4 style="color: red;"><b>
                                        <span data-lang="hi">ज्ञान भारती संस्था</span>
                                        <span data-lang="en">GYAN BHARTI SANSTHA</span>
                                    </b></h4>
                                <h6 style="color: blue;"><b>
                                        <span data-lang="hi">ग्राम - कैंचू टांडा, पोस्ट - अमरिया, जिला - पीलीभीत, उत्तर
                                            प्रदेश -
                                            262121</span>
                                        <span data-lang="en">Village - Kainchu Tanda, Post - Amaria, District - Pilibhit, UP
                                            -
                                            262121</span>
                                    </b></h6>
                                <p style="font-size: 14px; margin: 0;">
                                    <b>
                                        <span>Website: www.gyanbhartingo.org | Email: gyanbhartingo600@gmail.com
                                            | Mob:
                                            9411484111</span>
                                    </b>
                                </p>
                            </div>
                        </div> --}}
                    </div>
                    <form action="{{ route('update-letter', $letter->id) }}" method="post">
                        @csrf
                        <div class=" p-4 lh-lg" style="font-size: 16px;">
                            <div class="row justify-content-between mb-3">
                                <div class="col-sm-4">
                                    <strong><span data-lang="hi">पत्र सं.</span> <span data-lang="en">Letter
                                            No.:</span></strong>
                                    <span id=""><input id="letterNo" class="form-control" type="text"
                                            name="letterNo" value="{{ $letter->letterNo }}"></span>
                                </div>
                                <div class="col-sm-4">
                                    <strong><span data-lang="hi">पत्र तारीख:</span> <span data-lang="en">Letter
                                            Date:</span></strong>
                                    <span id="certDate"><input type="date" class="form-control" name="date"
                                            value="{{ $letter->date }}" id="date">
                                    </span>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">
                                        <span data-lang="hi">सेशन</span>
                                        <span data-lang="en">Session</span>
                                    </label>
                                    <select class="form-control @error('session') is-invalid @enderror" name="session"
                                        required>
                                        <option value="">Select Session</option>
                                        @foreach ($data as $session)
                                            <option value="{{ $session->session_date }}"
                                                {{ old('session', $letter->academic_session) == $session->session_date ? 'selected' : '' }}>
                                                {{ $session->session_date }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('session')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="to">To</label>
                                    <input type="text" name="to" id="to" class="form-control mb-2"
                                        value="{{ $letter->to }}" placeholder="Name">

                                    <input type="text" name="toaddress" id="toaddress" class="form-control"
                                        value="{{ $letter->toaddress }}" placeholder="Address">
                                    @error('toaddress')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <label for="subject">Subject</label>
                                    <input type="text" name="subject" class="form-control"
                                        value="{{ $letter->subject }}">
                                    @error('subject')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <label for="letter">Write Letter</label>
                                    <textarea name="letter" id="letter" cols="30" rows="10" class="form-control">{{ old('letter', $letter->letter) }}</textarea>
                                    @error('letter')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <input type="submit" class="btn btn-success p-2 mt-2" value="Update">
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
     <script>
        function setLanguage(lang) {
            document.querySelectorAll('[data-lang]').forEach(el => {
                el.style.display = el.getAttribute('data-lang') === lang ? 'inline' : 'none';
            });
        }
        window.onload = () => setLanguage('en'); // Set Hindi as default
    </script>
@endsection
