@extends('home.layout.MasterLayout')
@section('content')
    <!-- Include html2canvas if using download functionality -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <style>
        .certificate {
            background: #fff;
            padding: 50px;
            border: 8px double #4CAF50;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            max-width: 800px;
            width: 100%;
            text-align: center;
            border-radius: 12px;
            position: relative;
            margin: auto;
        }

        .print-h4,
        .print-red-bg {
            background-color: red !important;
            color: white !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .print-h4 {
            font-size: 28px;
            word-spacing: 8px;
            text-align: center;
        }

        .certificate h1 {
            font-family: 'Georgia', serif;
            font-size: 48px;
            color: #2e7d32;
            margin-bottom: 20px;
        }

        .certificate h2 {
            font-family: 'Arial', sans-serif;
            font-size: 28px;
            margin-bottom: 20px;
        }

        .certificate p {
            font-size: 18px;
            margin-bottom: 30px;
        }

        .signatures {
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
        }

        .signature-block {
            text-align: center;
            width: 45%;
        }

        .signature-block hr {
            border: 1px solid #4CAF50;
            margin-bottom: 5px;
        }

        .logo {
            position: absolute;
            top: 20px;
            left: 20px;
            width: 80px;
        }

        .action-buttons {
            margin-top: 30px;
            text-align: center;
        }

        .action-buttons button,
        .action-buttons .btn-group {
            margin: 5px;
        }

        @media print {
            body * {
                visibility: hidden;
                font-size: 12px;
            }

            .printable,
            .printable * {
                visibility: visible;
            }

            html,
            body {
                width: 210mm;
                height: 297mm;
                margin: 0;
                padding: 0;
                overflow: hidden;
            }

            @page {
                size: A4;
                margin: 20mm;
            }

            button,
            .btn,
            .no-print {
                display: none !important;
            }
        }
    </style>

    <div class="wrapper">
        <div class="container mt-5">
            <div class="printable">
                <!-- Header -->
                <div class="text-center mb-4 border-bottom pb-2">
                    <div class="row">
                        <div class="col-sm-2 text-center text-md-start">
                            <img src="{{ asset('images/LOGO.png') }}" alt="Logo" class="img-fluid" width="100" height="100">
                        </div>
                        <div class="col-sm-10">
                            <p style="margin: 0;"  class="mb-0">
                                <b>Registered under Societies Registration Act 1860</b>
                            </p>
                            <h4 style="margin: 0;" class="print-h4"><b>GYAN BHARTI SANSTHA</b></h4>
                            <h6 style="color: blue;"><b>Village - Kainchu Tanda, Post - Amaria, District - Pilibhit, UP -
                                    262121</b></h6>
                            <p class="mb-0"><b>Registered under Income Tax Act 80G, 12A</b></p>
                            <p class="mb-0"><b>
                                    Reg. No: 80G-AAEAG7650BF20231 | 12A: AAEAG7650BE20231 | Date: 02-10-2023 | PAN:
                                    AAEAG7650B
                                </b></p>
                        </div>
                    </div>
                </div>

                <!-- Certificate -->
                <div id="certificate" class="certificate">
                    <h1>Certificate of Appreciation</h1>
                    <h2>This Certificate is Proudly Presented To</h2>
                    <h2><b id="donorName">{{ $donor->name }}</b></h2>

                    <p><strong>Donation Amount:</strong> <span id="donationAmount">{{ $donor->amount }}</span></p>

                    <p>
                        In recognition of your generous contribution and support towards our cause.
                        Your donation makes a significant impact and helps us continue our mission.
                    </p>
                    <p><i>Thank you for making a difference!</i></p>

                    <div class="signatures">
                        <div class="signature-block">
                            {{-- <hr> --}}
                            <p>{{ $donor->date }}</p>
                        </div>
                        <div class="signature-block">
                            <hr>
                            <p>Authorized Signatory</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="action-buttons">
                <button class="btn btn-success" onclick="printCertificate()">Print Certificate</button>
                <button class="btn btn-primary" onclick="downloadCertificate()">Download as Image</button>

                {{-- <div class="btn-group">
                <button type="button" class="btn btn-info dropdown-toggle" data-bs-toggle="dropdown">
                    Share
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#" id="shareWhatsapp" target="_blank">WhatsApp</a></li>
                    <li><a class="dropdown-item" href="#" id="shareFacebook" target="_blank">Facebook</a></li>
                    <li><a class="dropdown-item" href="#" id="shareTwitter" target="_blank">Twitter</a></li>
                </ul>
            </div> --}}
            </div>
        </div>
    </div>

    <script>
        function printCertificate() {
            window.print();
        }

        function downloadCertificate() {
            html2canvas(document.querySelector("#certificate")).then(canvas => {
                const link = document.createElement('a');
                link.download = 'donation_certificate.png';
                link.href = canvas.toDataURL("image/png");
                link.click();
            });
        }
    </script>
@endsection
