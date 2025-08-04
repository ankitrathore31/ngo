@extends('ngo.layout.master')
@section('content')
    <style>
        .letter-container {
            width: 210mm;
            min-height: 297mm;
            padding: 20mm;
            margin: 0 auto;
            background: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            box-sizing: border-box;
            position: relative;
            overflow: hidden;
        }

        /* Optional: If you want a subtle border */
        .letter-container.border {
            border: 1px solid #ccc;
        }

        /* Force consistent font scaling on screen */
        body {
            background: #f2f2f2;
            font-size: 14px;
            line-height: 1.4;
        }

        /* PRINT STYLES */
        @media print {
            @page {
                size: A4 portrait;
                margin: 0;
            }

            body {
                background: white !important;
            }

            body * {
                visibility: hidden;
            }

            .letter-container,
            .letter-container * {
                visibility: visible;
            }

            .letter-container {
                margin: 0;
                padding: 20mm;
                width: 210mm;
                min-height: 297mm;
                box-shadow: none;
                position: absolute;
                left: 0;
                top: 0;
            }

            .print-red-bg {
                background-color: red !important;
                /* Bootstrap 'bg-danger' color */
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
                color: white !important;
            }

            .print-h4 {
                background-color: red !important;
                color: white !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
                font-size: 28px;
                word-spacing: 8px;
                text-align: center;
            }

            .no-print {
                display: none !important;
            }
        }

        .print-red-bg {
            background-color: red !important;
            /* Bootstrap 'bg-danger' color */
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
            color: white !important;
        }

        .print-h4 {
            background-color: red !important;
            color: white !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
            font-size: 28px;
            word-spacing: 8px;
            text-align: center;
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
            <div class="letter-container border print-area">
                <div class="p-4">

                    <div class="text-center mb-4 border-bottom pb-3 mb-2">
                        <!-- Header -->
                        <div class="row">
                            <div class="col-sm-2 text-center text-md-start">
                                <img src="{{ asset('images/LOGO.png') }}" alt="Logo" width="80" height="80">
                            </div>
                            <div class="col-sm-10">
                                <p class="d-flex justify-content-between w-100" style="margin: 0; font-weight: bold;">
                                    <span>CSR NO. CSR00059991</span>
                                    <span>12A AAEAG7650BE20231</span>
                                    <span>80G AAEAG7650BF20231</span>
                                </p>

                                <p class="d-flex justify-content-between w-100" style="margin: 0; font-weight: bold;">
                                    <span>NEETI AYOG ID NO. UP/2023/0360430</span>
                                    <span>NGO NO. UP/00033062</span>
                                    <span>PAN: AAEAG7650B</span>
                                </p>

                                <h4 class="text-center print-h4" style="margin: 0;">
                                    <span data-lang="hi" style="font-size: inherit; font-weight: inherit;">ज्ञान भारती
                                        संस्था</span>
                                    <span data-lang="en" style="font-size: inherit; font-weight: inherit;">GYAN BHARTI
                                        SANSTHA</span>
                                </h4>

                                <h6 class="w-100" style="color: blue; font-weight: bold; margin: 0;">
                                    <span data-lang="hi">ग्राम - कैंचू टांडा, पोस्ट - अमरिया, जिला - पीलीभीत, उत्तर प्रदेश -
                                        262121</span><br>
                                    <span data-lang="en">Village - Kainchu Tanda, Post - Amaria, District - Pilibhit, UP -
                                        262121</span>
                                </h6>

                                <p class="w-100" style="font-size: 14px; margin: 0; font-weight: bold;">
                                    Website: www.gyanbhartingo.org | Email: gyanbhartingo600@gmail.com | Mob: 9411484111
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

                            <div class="col-sm-5 text-center">
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
                                <strong>Digitally Signed By <br>
                                    MANOJ KUMAR RATHOR <br>
                                    DIRECTOR
                                </strong><br>
                            </div>
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
