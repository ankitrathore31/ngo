@extends('ngo.layout.master')
@section('content')
    <style>
        .bill-container {
            background-color: white;
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

            .bill-container,
            .bill-container * {
                visibility: visible;
            }

            .bill-container {
                margin: 0;
                padding: 20mm;
                width: 250mm;
                min-height: auto;
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
            <h5 class="mb-0">View GBS Person Bill</h5>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">GBS Bill/Voucher</li>
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
                    <span>GBS Person Bill</span>
                </h5>
                <div>
                    <button onclick="window.print()" class="btn btn-primary">Print Bill</button>
                    <button class="btn btn-sm btn-outline-primary" onclick="setLanguage('en')">English</button>
                    <button class="btn btn-sm btn-outline-success" onclick="setLanguage('hi')">हिंदी</button>
                </div>
            </div>
            <div class="bill-container border print-area">
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
                    <div class="container-fluid py-4" style="font-size: 16px; line-height: 1.8;">
                        <div class="row">
                            <div class="col-sm-6 mb-2">
                                <div style="display: flex; align-items: center; width: 100%;">
                                    <strong style="white-space: nowrap; margin-right: 5px;">
                                        <span data-lang="hi">मैं</span>
                                        <span data-lang="en">I</span>
                                    </strong>
                                    <div
                                        style="flex-grow: 1; border-bottom: 1px dotted #000; white-space: nowrap; overflow: hidden;">
                                        &nbsp; {{ $bill->name }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 mb-2">
                                <div style="display: flex; align-items: center; width: 100%;">
                                    <strong style="white-space: nowrap; margin-right: 5px;">
                                        <span data-lang="hi">पिता/पति का नाम</span>
                                        <span data-lang="en">Father/Husband's Name</span>
                                    </strong>
                                    <div
                                        style="flex-grow: 1; border-bottom: 1px dotted #000; white-space: nowrap; overflow: hidden;">
                                        &nbsp;{{ $bill->guardian_name }}
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-sm-4 mb-2">
                                <div style="display: flex; align-items: center; width: 100%;">
                                    <strong style="white-space: nowrap; margin-right: 5px;">
                                        <span data-lang="hi">गांव/मोहल्ला</span>
                                        <span data-lang="en">Village/Locality</span>
                                    </strong>
                                    <div
                                        style="flex-grow: 1; border-bottom: 1px dotted #000; white-space: nowrap; overflow: hidden;">
                                        &nbsp;{{ $bill->village }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4 mb-2">
                                <div style="display: flex; align-items: center; width: 100%;">
                                    <strong style="white-space: nowrap; margin-right: 5px;">
                                        <span data-lang="hi">पोस्ट/कस्बा</span>
                                        <span data-lang="en">Post/Town</span>
                                    </strong>
                                    <div
                                        style="flex-grow: 1; border-bottom: 1px dotted #000; white-space: nowrap; overflow: hidden;">
                                        &nbsp;{{ $bill->post }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4 mb-2">
                                <div style="display: flex; align-items: center; width: 100%;">
                                    <strong style="white-space: nowrap; margin-right: 5px;">
                                        <span data-lang="hi">जिला</span>
                                        <span data-lang="en">District</span>
                                    </strong>
                                    <div
                                        style="flex-grow: 1; border-bottom: 1px dotted #000; white-space: nowrap; overflow: hidden;">
                                        &nbsp;{{ $bill->district }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 mb-2">
                                <div style="display: flex; align-items: center; width: 100%;">
                                    <strong style="white-space: nowrap; margin-right: 5px;">
                                        <span data-lang="hi">राज्य</span>
                                        <span data-lang="en">State</span>
                                    </strong>
                                    <div
                                        style="flex-grow: 1; border-bottom: 1px dotted #000; white-space: nowrap; overflow: hidden;">
                                        &nbsp;{{ $bill->state }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 mb-2">
                                <div style="display: flex; align-items: center; width: 100%;">
                                    <strong style="white-space: nowrap; margin-right: 5px;">
                                        <span data-lang="hi">रुपये</span>
                                        <span data-lang="en">Amount</span>
                                    </strong>
                                    <div
                                        style="flex-grow: 1; border-bottom: 1px dotted #000; white-space: nowrap; overflow: hidden;">
                                        &nbsp;{{ $bill->amount }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-8 mb-2">
                                <div style="display: flex; align-items: center; width: 100%;">
                                    <strong style="white-space: nowrap; margin-right: 5px;">
                                        <span data-lang="hi">ज्ञान भारती
                                            संस्था कैंचू टांडा, अमरिया, पीलीभीत, उत्तर प्रदेश -
                                        </span>
                                        <span data-lang="en">Gyan Bharti Sanstha Kainchu Tanda, Amaria,
                                            Pilibhit, Uttar Pradesh
                                        </span>
                                    </strong>
                                </div>
                            </div>

                            <div class="col-sm-4 mb-2">
                                <div style="display: flex; align-items: center; width: 100%;">
                                    <strong style="white-space: nowrap; margin-right: 5px;">
                                        <span data-lang="hi">शाखा</span>
                                        <span data-lang="en">Branch</span>
                                    </strong>
                                    <div
                                        style="flex-grow: 1; border-bottom: 1px dotted #000; white-space: nowrap; overflow: hidden;">
                                        &nbsp;{{ $bill->branch }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-8 mb-2">
                                <div style="display: flex; align-items: center; width: 100%;">
                                    <strong style="white-space: nowrap; margin-right: 5px;">
                                        <span data-lang="hi">केंद्र</span>
                                        <span data-lang="en">Center</span>
                                    </strong>
                                    <div
                                        style="flex-grow: 1; border-bottom: 1px dotted #000; white-space: nowrap; overflow: hidden;">
                                        &nbsp;{{ $bill->centre }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4 mb-2">
                                <div style="display: flex; align-items: center; width: 100%;">
                                    <strong style="white-space: nowrap; margin-right: 5px;">
                                        <span data-lang="hi">की तिथि से</span>
                                        <span data-lang="en">from date</span>
                                    </strong>
                                    <div
                                        style="flex-grow: 1; border-bottom: 1px dotted #000; white-space: nowrap; overflow: hidden;">
                                        &nbsp;{{ $bill->date }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 mb-2">
                                <div style="display: flex; align-items: center; width: 100%;">
                                    <strong style="white-space: nowrap; margin-right: 5px;">
                                        <span>Project / work category</span>
                                    </strong>
                                    <div
                                        style="flex-grow: 1; border-bottom: 1px dotted #000; white-space: nowrap; overflow: hidden;">
                                        &nbsp;{{ $bill->work_category }}
                                    </div>
                                </div>
                            </div>

                              <div class="col-sm-6 mb-2">
                                <div style="display: flex; align-items: center; width: 100%;">
                                    <strong style="white-space: nowrap; margin-right: 5px;">
                                        <span>Project / work Name</span>
                                    </strong>
                                    <div
                                        style="flex-grow: 1; border-bottom: 1px dotted #000; white-space: nowrap; overflow: hidden;">
                                        &nbsp;{{ $bill->work_name }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12 mb-2">
                                <div style="display: flex; align-items: center; width: 100%;">
                                    <strong style="white-space: nowrap; margin-right: 5px;">
                                        <span data-lang="hi"> को कार्य </span>
                                        <span data-lang="en">work to</span>
                                    </strong>
                                    <div
                                        style="flex-grow: 1; border-bottom: 1px dotted #000; white-space: nowrap; overflow: hidden;">
                                        &nbsp;{{ $bill->work }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 mb-2">
                                <div style="display: flex; align-items: center; width: 100%;">
                                    <strong style="white-space: nowrap; margin-right: 5px;">
                                        <span data-lang="hi">भुगतान का तरीका</span>
                                        <span data-lang="en">Payment Method</span>

                                    </strong>
                                    <div
                                        style="flex-grow: 1; border-bottom: 1px dotted #000; white-space: nowrap; overflow: hidden;">
                                        &nbsp;{{ $bill->payment_method }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 mb-2">
                                <div style="display: flex; align-items: center; width: 100%;">
                                    <strong style="white-space: nowrap; margin-right: 5px;">
                                        <span data-lang="hi"></span>
                                        <span data-lang="en">date</span>
                                    </strong>
                                    <div
                                        style="flex-grow: 1; border-bottom: 1px dotted #000; white-space: nowrap; overflow: hidden;">
                                        &nbsp;{{ $bill->transaction_date }}
                                    </div>
                                </div>
                            </div>

                            {{-- Show Account details --}}
                            @if ($bill->payment_method === 'Account')
                                <div class="col-sm-12 mb-2">
                                    <div style="display: flex; align-items: center; width: 100%;">
                                        <strong style="white-space: nowrap; margin-right: 5px;">
                                            <span data-lang="hi">खाता संख्या</span>
                                            <span data-lang="en">Account No</span>
                                        </strong>
                                        <div
                                            style="flex-grow: 1; border-bottom: 1px dotted #000; white-space: nowrap; overflow: hidden;">
                                            &nbsp;{{ $bill->account_number ?? 'N/A' }}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12 mb-2">
                                    <div style="display: flex; align-items: center; width: 100%;">
                                        <strong style="white-space: nowrap; margin-right: 5px;">
                                            <span data-lang="hi">बैंक का नाम</span>
                                            <span data-lang="en">Bank Name</span>
                                        </strong>
                                        <div
                                            style="flex-grow: 1; border-bottom: 1px dotted #000; white-space: nowrap; overflow: hidden;">
                                            &nbsp;{{ $bill->bank_name ?? 'N/A' }}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12 mb-2">
                                    <div style="display: flex; align-items: center; width: 100%;">
                                        <strong style="white-space: nowrap; margin-right: 5px;">
                                            <span data-lang="hi">बैंक शाखा</span>
                                            <span data-lang="en">Bank Branch</span>
                                        </strong>
                                        <div
                                            style="flex-grow: 1; border-bottom: 1px dotted #000; white-space: nowrap; overflow: hidden;">
                                            &nbsp;{{ $bill->bank_branch ?? 'N/A' }}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12 mb-2">
                                    <div style="display: flex; align-items: center; width: 100%;">
                                        <strong style="white-space: nowrap; margin-right: 5px;">
                                            <span data-lang="hi">आई.एफ.एस.सी. कोड</span>
                                            <span data-lang="en">IFSC Code</span>
                                        </strong>
                                        <div
                                            style="flex-grow: 1; border-bottom: 1px dotted #000; white-space: nowrap; overflow: hidden;">
                                            &nbsp;{{ $bill->ifsc_code ?? 'N/A' }}
                                        </div>
                                    </div>
                                </div>
                            @endif

                            {{-- Show Cheque No --}}
                            @if ($bill->payment_method === 'Cheque')
                                <div class="col-sm-12 mb-2">
                                    <div style="display: flex; align-items: center; width: 100%;">
                                        <strong style="white-space: nowrap; margin-right: 5px;">
                                            <span data-lang="hi">चेक संख्या</span>
                                            <span data-lang="en">Cheque No</span>
                                        </strong>
                                        <div
                                            style="flex-grow: 1; border-bottom: 1px dotted #000; white-space: nowrap; overflow: hidden;">
                                            &nbsp;{{ $bill->cheque_no ?? 'N/A' }}
                                        </div>
                                    </div>
                                </div>
                            @endif

                            {{-- Show Transaction No for UPI and Cashfree --}}
                            @if ($bill->payment_method === 'UPI' || $bill->payment_method === 'Cashfree')
                                <div class="col-sm-12 mb-2">
                                    <div style="display: flex; align-items: center; width: 100%;">
                                        <strong style="white-space: nowrap; margin-right: 5px;">
                                            <span data-lang="hi">लेन-देन संख्या</span>
                                            <span data-lang="en">Transaction No</span>
                                        </strong>
                                        <div
                                            style="flex-grow: 1; border-bottom: 1px dotted #000; white-space: nowrap; overflow: hidden;">
                                            &nbsp;{{ $bill->transaction_no ?? 'N/A' }}
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="col-sm-12 mb-2">
                                <div style="display: flex; align-items: center; width: 100%;">
                                    <strong style="white-space: nowrap; margin-right: 5px;">
                                        <span data-lang="hi">के द्वारा प्राप्त किये</span>
                                        <span data-lang="en">received by the.</span>
                                    </strong>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 mb-2 text-center">
                                    <strong>
                                        <span data-lang="hi">रसीद लिख दी ताकि समय पे काम आवे</span>
                                        <span data-lang="en">Write a receipt so that it can be used on time</span>
                                    </strong>
                                </div>
                            </div>

                            <div class="row d-flex justify-content-between mt-5 mb-3">
                                <div class="col-sm-6 text-start">
                                    <div class="row">
                                        <div class="col-sm-12 mb-2">
                                            <div style="display: flex; align-items: center; width: 100%;">
                                                <strong style="white-space: nowrap; margin-right: 5px;">
                                                    <span data-lang="hi">दिनांक</span>
                                                    <span data-lang="en">Date</span>
                                                </strong>
                                                <div
                                                    style="flex-grow: 1; border-bottom: 1px dotted #000; white-space: nowrap; overflow: hidden;">
                                                    &nbsp;{{ $bill->bill_date }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 mb-2">
                                            <div style="display: flex; align-items: center; width: 100%;">
                                                <strong style="white-space: nowrap; margin-right: 5px;">
                                                    <span data-lang="hi">स्थान</span>
                                                    <span data-lang="en">Place</span>
                                                </strong>
                                                <div
                                                    style="flex-grow: 1; border-bottom: 1px dotted #000; white-space: nowrap; overflow: hidden;">
                                                    &nbsp;{{ $bill->place }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 text-center">
                                    <strong>
                                        <span data-lang="hi">प्राप्तकर्ता के हस्ताक्षर</span>
                                        <span data-lang="en">Recipient's signature</span>
                                    </strong>
                                </div>
                            </div>
                            <div class="row mt-5 mb-2">
                                <div class="col-sm-6 text-center">
                                    <strong>
                                        <span data-lang="hi">केशियर</span>
                                        <span data-lang="en">Cashier</span>
                                    </strong>
                                </div>
                                <div class="col-sm-6 text-center">
                                    <strong>
                                        <span data-lang="hi">डाइरेक्टर/सचिव</span>
                                        <span data-lang="en">Director/Sachiv</span>
                                    </strong>
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
