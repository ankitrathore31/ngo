@extends('home.layout.MasterLayout')
@section('content')
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
            justify-content: center;
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
            color: #333;
            margin-bottom: 20px;
        }

        .certificate p {
            font-size: 18px;
            color: #555;
            margin-bottom: 30px;
        }

        .certificate .signatures {
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
    </style>

    <div class="wrapper">
        <div class="container mt-5">
            <div id="certificate" class="certificate">
                <img src="assets/images/logo.png" alt="Logo" class="logo">
                <h1>Certificate of Appreciation</h1>
                <h2>This Certificate is Proudly Presented To</h2>
                <h2><b id="donorName">[{{$donor->donor_name}}]</b></h2>
                <p><strong>Donation Amount:</strong> <span id="donationAmount">[{{$donor->donation_amount}}]</span></p>
                <p>
                    In recognition of your generous contribution and support towards our cause.
                    Your donation makes a significant impact and helps us continue our mission.
                </p>
                <p><i>Thank you for making a difference!</i></p>

                <div class="signatures">
                    <div class="signature-block">
                        <hr>
                        <p>Authorized Signatory</p>
                    </div>
                    <div class="signature-block">
                        <hr>
                        <p>{{$donor->donate_date}}</p>
                    </div>
                </div>
            </div>

            <div class="action-buttons">
                <button class="btn btn-success" onclick="printCertificate()">Print Certificate</button>
                <button class="btn btn-primary" onclick="downloadCertificate()">Download as Image</button>

                <!-- Share Button with Dropdown -->
                <div class="btn-group">
                    <button type="button" class="btn btn-info dropdown-toggle" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Share
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#" id="shareWhatsapp" target="_blank">WhatsApp</a></li>
                        <li><a class="dropdown-item" href="#" id="shareFacebook" target="_blank">Facebook</a></li>
                        <li><a class="dropdown-item" href="#" id="shareTwitter" target="_blank">Twitter</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('donorName').innerText = "John Doe";
        document.getElementById('donationAmount').innerText = "₹5,000";

        function printCertificate() {
            window.print();
        }

        function downloadCertificate() {
            html2canvas(document.querySelector("#certificate")).then(canvas => {
                var link = document.createElement('a');
                link.download = 'donation_certificate.png';
                link.href = canvas.toDataURL("image/png");
                link.click();
            });
        }


        const donor = encodeURIComponent("John Doe");
        const amount = encodeURIComponent("₹5,000");
        const textMessage = encodeURIComponent(`I proudly donated ${amount} to a great cause!`);
        const pageUrl = encodeURIComponent(window.location.href);

        document.getElementById('shareWhatsapp').href = `https://api.whatsapp.com/send?text=${textMessage} ${pageUrl}`;
        document.getElementById('shareFacebook').href = `https://www.facebook.com/sharer/sharer.php?u=${pageUrl}`;
        document.getElementById('shareTwitter').href =
        `https://twitter.com/intent/tweet?text=${textMessage}&url=${pageUrl}`;
    </script>
@endsection
