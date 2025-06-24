@extends('ngo.layout.master')
@section('content')
    <style>
        @media print {
            @page {
                size: A4 portrait;
                margin: 15mm;
            }

            body {
                margin: 0;
                padding: 0;
                font-family: 'Noto Sans Devanagari', 'Arial', sans-serif;
                font-size: 12pt;
                color: #000000;
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
                box-sizing: border-box;
            }

            h4,
            h5,
            h6 {
                font-size: 15pt !important;
                font-weight: 600 !important;
                margin: 4px 0;
            }

            p,
            span,
            b,
            strong {
                font-weight: 500 !important;
                font-size: 12pt !important;
                line-height: 1.5 !important;
            }

            .no-print {
                display: none !important;
            }

            img {
                max-height: 100px;
            }
        }
    </style>

    <div class="wrapper">
        <div class="d-flex justify-content-between align-item-centre mb-0 mt-4">
            <h5 class="mb-0"> Letter</h5>
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
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-3 mt-4">
                <h5 class="mb-0">
                    <span> Letter</span>
                </h5>
                <div>
                    <button onclick="window.print()" class="btn btn-primary">Print Letter</button>
                    <button class="btn btn-sm btn-outline-primary" onclick="setLanguage('en')">English</button>
                    <button class="btn btn-sm btn-outline-success" onclick="setLanguage('hi')">हिंदी</button>
                </div>
            </div>
            <div class="letterhead print-area">
                <div class="card shadow rounded p-4 my-4 border border-dark">
                    <div class="text-center mb-4 border-bottom pb-3 mb-2">
                        <!-- Header -->
                        <div class="row">
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
                                <h4 class="text-center"
                                    style="color: red; font-size: 26px; font-weight: 700; word-spacing: 7px; display: flex; justify-content: center; flex-wrap: wrap; gap: 20px;">
                                    <span data-lang="hi"
                                        style="font-size: inherit; font-weight: inherit; word-spacing: inherit;">ज्ञान भारती
                                        संस्था</span>
                                    <span data-lang="en"
                                        style="font-size: inherit; font-weight: inherit; word-spacing: inherit;">GYAN BHARTI
                                        SANSTHA</span>
                                </h4>
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
                        </div>
                    </div>
                    <div class="container py-4" style="font-size: 16px; line-height: 1.8;">
                        <div class=" d-flex justify-content-between mb-3">
                            <div>
                                <strong>
                                    <span data-lang="hi">पत्र सं.</span>
                                    <span data-lang="en">Letter No.:</span>
                                </strong>
                                {{ $record->letterNo }}
                            </div>

                            <div>
                                <strong>
                                    <span data-lang="hi">दिनांक</span>
                                    <span data-lang="en">Date:</span>
                                </strong>
                                {{ \Carbon\Carbon::parse($record->date)->format('d-m-Y') }}
                            </div>
                        </div>

                        <div class="mb-2">
                            <strong>
                                <span data-lang="hi">प्रति</span><br>
                                <span data-lang="en">To:</span>
                            </strong><br>
                            {{ $record->to }} <br>
                            {{ $record->toaddress }}
                        </div>

                        <div class="mb-2">
                            <strong>
                                <span data-lang="hi">विषय</span><br>
                                <span data-lang="en">Subject:</span>
                            </strong>
                            &nbsp; {{ $record->subject }}
                        </div>

                        <div class="mb-4">
                            {{-- <strong>
                                <span data-lang="hi">पत्र का विवरण</span><br>
                                <span data-lang="en">Letter Content:</span>
                            </strong><br> --}}
                            {!! nl2br(e($record->letter)) !!}
                        </div>

                        <div class="row d-flex justify-content-end mt-5">
                            {{-- <div class="col-sm-4 text-center">
                                @if (!empty($signatures['program_manager']) && file_exists(public_path($signatures['program_manager'])))
                                    <div id="pmSignatureBox" class="mt-2">
                                        <p class="text-success no-print">Attached</p> <!-- This line is hidden in print -->
                                        <img src="{{ asset($signatures['program_manager']) }}" alt="PM Signature"
                                            class="img" style="max-height: 100px;"> <!-- This will print -->
                                        <br>
                                        <button class="btn btn-danger btn-sm mt-2 no-print"
                                            onclick="togglePM(false)">Remove</button>
                                    </div>
                                @else
                                    <p class="text-muted mt-2 no-print">Not attached</p> <!-- Hidden only in print -->
                                @endif
                                <strong>Program Officer & Program Manager Signature with stamp</strong><br>
                            </div> --}}

                            <div class="col-sm-4 text-center">
                                @if (!empty($signatures['director']) && file_exists(public_path($signatures['director'])))
                                    <div id="directorSignatureBox" class="mt-2">
                                        <p class="text-success no-print">Attached</p>
                                        <img src="{{ asset($signatures['director']) }}" alt="Director Signature"
                                            class="img" style="max-height: 100px;">
                                        <br>
                                        <button class="btn btn-danger btn-sm mt-2 no-print"
                                            onclick="toggleDirector(false)">Remove</button>
                                    </div>

                                    <div id="directorShowBtnBox" class="mt-2 d-none no-print">
                                        <button class="btn btn-primary btn-sm" onclick="toggleDirector(true)">Attached
                                            Signature</button>
                                    </div>
                                @else
                                    <p class="text-muted mt-2 no-print">Not attached</p>
                                @endif
                                <strong>Director Signature with stamp</strong><br>
                            </div>
                        </div>
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
            window.onload = () => setLanguage('en'); // Set Eng as default
        </script>
        <script>
            // --- PM Logic ---
            const pmInput = document.getElementById('pmInput');
            const pmAttachBtn = document.getElementById('pmAttachBtn');
            const pmPreview = document.getElementById('pmPreview');
            const pmContainer = document.getElementById('pmPreviewContainer');
            const pmRemoveBtn = document.getElementById('pmRemoveBtn');

            pmAttachBtn.onclick = () => pmInput.click();

            pmInput.onchange = (e) => {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        pmPreview.src = e.target.result;
                        pmContainer.style.display = 'block';
                        pmRemoveBtn.classList.remove('d-none');
                    };
                    reader.readAsDataURL(file);
                }
            };

            pmRemoveBtn.onclick = () => {
                pmInput.value = '';
                pmContainer.style.display = 'none';
                pmRemoveBtn.classList.add('d-none');
            };

            // --- Director Logic ---
            const directorInput = document.getElementById('directorInput');
            const directorAttachBtn = document.getElementById('directorAttachBtn');
            const directorPreview = document.getElementById('directorPreview');
            const directorContainer = document.getElementById('directorPreviewContainer');
            const directorRemoveBtn = document.getElementById('directorRemoveBtn');

            directorAttachBtn.onclick = () => directorInput.click();

            directorInput.onchange = (e) => {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        directorPreview.src = e.target.result;
                        directorContainer.style.display = 'block';
                        directorRemoveBtn.classList.remove('d-none');
                    };
                    reader.readAsDataURL(file);
                }
            };

            directorRemoveBtn.onclick = () => {
                directorInput.value = '';
                directorContainer.style.display = 'none';
                directorRemoveBtn.classList.add('d-none');
            };
        </script>
        <script>
            function togglePM(show) {
                document.getElementById('pmSignatureBox').classList.toggle('d-none', !show);
                document.getElementById('pmShowBtnBox').classList.toggle('d-none', show);
            }

            function toggleDirector(show) {
                document.getElementById('directorSignatureBox').classList.toggle('d-none', !show);
                document.getElementById('directorShowBtnBox').classList.toggle('d-none', show);
            }
        </script>
    @endsection
